<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupportTicketResource;
use App\Models\SupportTicket;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use App\Models\SupportTicket as Ticket;
use App\Models\SupportTicketAttachment as TicketAttachment;
use App\Models\SupportTicketMessage as TicketMessage;
use App\Models\User;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Facades\App\Http\Controllers\User\SupportTicketController as SupportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Stevebauman\Purify\Facades\Purify;


class SupportTicketController extends Controller
{
    use ApiValidation, Notify ,Upload;

    public function ticketList()
    {
        if (auth()->id() == null) {
            return response()->json($this->withErrors('Something went wrong'));
        }
        try {
            $array = [];
            $tickets = tap(Ticket::where('user_id', auth()->id())->latest()
                ->paginate(basicControl()->paginate), function ($paginatedInstance) use ($array) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($array) {
                    $array['ticket'] = $query->ticket;
                    $array['subject'] = '[Ticket#' . $query->ticket . ']' . ucfirst($query->subject);
                    if ($query->status == 0) {
                        $array['status'] = 'Open';
                    } elseif ($query->status == 1) {
                        $array['status'] = 'Answered';
                    } elseif ($query->status == 2) {
                        $array['status'] = 'Replied';
                    } elseif ($query->status == 3) {
                        $array['status'] = 'Closed';
                    }
                    $array['lastReply'] = diffForHumans($query->last_reply);
                    return $array;
                });
            });

            if ($tickets) {
                return response()->json($this->withSuccess($tickets));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function ticketCreate(Request $request)
    {

        try {

            $validator = $this->newTicketValidation($request);
            if ($validator->fails()) {
                return response()->json($this->withErrors(collect($validator->errors())->collapse()));
            }
            $random = rand(100000, 999999);

            $ticket = SupportController::saveTicket($request);

            $message = SupportController::saveMsgTicket($request, $ticket);

            if (!empty($request->attachments)) {
                $numberOfAttachments = count($request->attachments);
                for ($i = 0; $i < $numberOfAttachments; $i++) {
                    if ($request->hasFile('attachments.' . $i)) {
                        $file = $request->file('attachments.' . $i);
                        $supportFile = $this->fileUpload($file, config('filelocation.ticket.path'), null,null,'webp',80);
                        if (empty($supportFile['path'])) {
                            return response()->json($this->withErrors('File could not be uploaded.'));
                        }
                        SupportController::saveAttachment($message, $supportFile['path'], $supportFile['driver']);
                    }
                }
            }

            $this->ticketCreateNotify($ticket);
            return response()->json($this->withSuccess('Your Ticket has been pending'));

        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function newTicketValidation(Request $request)
    {
        $images = $request->file('attachments');
        $allowedExtension = array('jpg', 'png', 'jpeg', 'pdf');

        $rules = [
            'attachments' => [
                'max:4096',
                'nullable',
                function ($attribute, $value, $fail) use ($images, $allowedExtension) {
                    foreach ($images as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            throw ValidationException::withMessages(['attachments'=>"Images MAX  2MB ALLOW!"]);
                        }
                        if (!in_array($ext, $allowedExtension)) {
                            throw ValidationException::withMessages(['attachments'=>"Only png, jpg, jpeg, pdf images are allowed"]);
                        }
                    }
                    if (count($images) > 5) {
                        throw ValidationException::withMessages(['attachments'=>"Maximum 5 images can be uploaded"]);
                    }
                },
            ],
            'subject' => 'required|max:100',
            'message' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    public function ticketCreateNotify($ticket)
    {
        try {

            $msg = [
                'username' => optional($ticket->user)->username,
                'ticket_id' => $ticket->ticket
            ];
            $action = [
                "name" => optional($ticket->user)->firstname . ' ' . optional($ticket->user)->lastname,
                "image" => getFile(optional($ticket->user)->image_driver, optional($ticket->user)->image),
                "link" => route('admin.ticket.view', $ticket->id),
                "icon" => "fas fa-ticket-alt text-white"
            ];
            $this->adminPushNotification('SUPPORT_TICKET_CREATE', $msg, $action);
            $this->adminFirebasePushNotification('SUPPORT_TICKET_CREATE',$msg,route('admin.ticket.view', $ticket->id));
            $this->adminMail('SUPPORT_TICKET_CREATE', $msg);
            return true;

        } catch (\Exception $e) {
            return true;
        }
    }

    public function ticketView($ticketId)
    {
        try {

            $ticket = SupportTicket::where('ticket', $ticketId)->where('user_id',Auth::id())->latest()->with(['messages','user'])
                ->first();
            if (!$ticket) {
                return response()->json($this->withErrors('Something went wrong'));
            }
            return response()->json($this->withSuccess(new SupportTicketResource($ticket)));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function ticketDownlaod($ticket_id)
    {
        $attachment = TicketAttachment::with('supportMessage', 'supportMessage.ticket')->where('id',$ticket_id)->first();
        if (!$attachment){
            return response()->json($this->withErrors('File not found'));
        }
        $file = $attachment->image;
        $full_path = getFile($attachment->driver, $file);

        try {
            $title = slug($attachment->supportMessage->ticket->subject??'support-ticket-file') . '-' . $file;
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
            header("Content-Type: " . $full_path);
            return readfile($full_path);
        }catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function ticketReply(Request $request)
    {
        $ticket = Ticket::find($request->id);
        if (!$ticket) {
            return response()->json($this->withErrors('No data found'));
        }
        if ($request->replayTicket != 2 && $request->message == null) {
            return response()->json($this->withErrors('Message Field is required'));
        }

        try {
            $message = new TicketMessage();

            if ($request->replayTicket == 1) {
                $purifiedData = $request->all();
                $imgs = $request->file('attachments');
                $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

                $this->validate($request, [
                    'attachments' => [
                        'max:4096',
                        function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                            foreach ($imgs as $img) {
                                $ext = strtolower($img->getClientOriginalExtension());
                                if (($img->getSize() / 1000000) > 2) {
                                    return response()->json($this->withErrors('Images MAX  2MB ALLOW!'));
                                }

                                if (!in_array($ext, $allowedExts)) {
                                    return response()->json($this->withErrors('Only png, jpg, jpeg, pdf images are allowed'));
                                }
                            }
                            if (count($imgs) > 5) {
                                return response()->json($this->withErrors('Maximum 5 images can be uploaded'));
                            }
                        }
                    ],
                    'message' => 'required',
                ]);

                $ticket->status = 2;
                $ticket->last_reply = Carbon::now();
                $ticket->save();

                $message->support_ticket_id = $ticket->id;
                $message->message = $purifiedData['message'] ?? null;
                $message->save();

                if (!empty($request->attachments)) {
                    $numberOfAttachments = count($request->attachments);
                    for ($i = 0; $i < $numberOfAttachments; $i++) {
                        if ($request->hasFile('attachments.' . $i)) {
                            $file = $request->file('attachments.' . $i);
                            $supportFile = $this->fileUpload($file, config('filelocation.ticket.path'),null, null, 'png', 60);
                            if (empty($supportFile['path'])) {
                                return response()->json($this->withErrors('File could not be uploaded.'));
                            }
                            $this->saveAttachment($message, $supportFile['path'], $supportFile['driver']);
                        }
                    }
                }

                return response()->json($this->withSuccess('Ticket has been replied'));

            } elseif ($request->replayTicket == 2) {
                $ticket->update([
                    'status' => 3
                ]);
                return response()->json($this->withSuccess('Ticket has been closed'));
            }
            return response()->json($this->withErrors('Something went wrong'));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }
}
