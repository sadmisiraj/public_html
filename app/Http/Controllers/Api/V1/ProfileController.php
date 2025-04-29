<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Models\UserKyc;
use App\Models\Kyc;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    use ApiValidation, Notify, Upload;

    public function profile(Request $request)
    {
        try {
            $user = auth()->user();
            $data['userImage'] = getFile($user->image_driver,$user->image );
            $data['username'] = trans(ucfirst($user->username));
            $data['userLevel'] = optional($user->rank)->rank_lavel ?? null;
            $data['userRankName'] = optional($user->rank)->rank_name ?? null;
            $data['userJoinDate'] = $user->created_at->format('d M, Y g:i A') ?? null;
            $data['userFirstName'] = $user->firstname ?? null;
            $data['userLastName'] = $user->lastname ?? null;
            $data['userUsername'] = $user->username ?? null;
            $data['userEmail'] = $user->email ?? null;
            $data['userPhone'] = $user->phone ?? null;
            $data['userLanguageId'] = $user->language_id ?? null;
            $data['userAddress'] = $user->address ?? null;


            $data['languages'] = Language::all();
            $data['identityFormList'] = Kyc::where('status', 1)->get();
            return response()->json($this->withSuccess($data));

        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function profileImageUpload(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:png,jpg|max:3072',
            ]);
            $user = Auth::user();
            if ($request->hasFile('image')) {
                $image = $this->fileUpload($request->image, config('filelocation.userProfile.path'), null, null, 'avif', 60, $user->image, $user->image_driver);
                if ($image) {
                    $profileImage = $image['path'];
                    $ImageDriver = $image['driver'];
                }
            }
            $user->image = $profileImage ?? $user->image;
            $user->image_driver = $ImageDriver ?? $user->image_driver;
            $user->save();
            return response()->json($this->withSuccess('Updated Successfully.'));
        }catch (\Exception $exception){
            return response()->json(['err' => $exception->getMessage()],200);
        }
    }

    public function profileInfoUpdate(Request $request)
    {
        try {
            $languages = Language::all()->map(function ($item) {
                return $item->id;
            });
            $user = auth()->user();
            $validateUser = Validator::make($request->all(),
                [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'username' => "sometimes|required|alpha_dash|min:5|unique:users,username," . $user->id,
                    'address' => 'required',
                    'language_id' => Rule::in($languages),
                ]);

            if ($validateUser->fails()) {
                return response()->json($this->withErrors(collect($validateUser->errors())->collapse()[0]));
            }

            $user->language_id = $request['language_id'];
            $user->firstname = $request['firstname'];
            $user->lastname = $request['lastname'];
            $user->username = $request['username'];
            $user->address = $request['address'];
            $user->save();

            return response()->json($this->withSuccess('Updated Successfully.'));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function profilePassUpdate(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'current_password' => "required",
                'password' => "required|min:5|confirmed",
            ]);

        if ($validateUser->fails()) {
            return response()->json($this->withErrors(collect($validateUser->errors())->collapse()[0]));
        }

        $user = auth()->user();
        try {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();

                return response()->json($this->withSuccess('Password Changes successfully.'));
            } else {
                return response()->json($this->withErrors('Current password did not match'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function KycVerificationSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kyc_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->withErrors(collect($validator->errors())->collapse(),400);
        }
        $kyc = Kyc::where('id', $request->kyc_id)->where('status', 1)->first();
        if (!$kyc){
            return  $this->withErrors("KYC not found");
        }

        $params = $kyc->input_form;
        $reqData = $request->except('_token', '_method');
        $rules = [];
        if ($params !== null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation == 'required' ? $cus->validation : 'nullable'];
                if ($cus->type === 'file') {
                    $rules[$key][] = 'image';
                    $rules[$key][] = 'mimes:jpeg,jpg,png';
                    $rules[$key][] = 'max:2048';
                } elseif ($cus->type === 'text') {
                    $rules[$key][] = 'max:191';
                } elseif ($cus->type === 'number') {
                    $rules[$key][] = 'integer';
                } elseif ($cus->type === 'textarea') {
                    $rules[$key][] = 'min:3';
                    $rules[$key][] = 'max:300';
                }
            }
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()[0]));
        }

        $params = $kyc->input_form;
        $validator = Validator::make($reqData, $rules);
        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()[0]));
        }



        $reqField = [];
        foreach ($request->except('_token', '_method', 'type') as $k => $v) {
            foreach ($params as $inKey => $inVal) {
                if ($k == $inKey) {
                    if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                        try {
                            $file = $this->fileUpload($request[$inKey], config('filelocation.kyc.path'),null,null,'webp',60);
                            $reqField[$inKey] = [
                                'field_name' => $inVal->field_name,
                                'field_label' => $inVal->field_label,
                                'field_value' => $file['path'],
                                'field_driver' => $file['driver'],
                                'validation' => $inVal->validation,
                                'type' => $inVal->type,
                            ];
                        } catch (\Exception $exp) {
                            return $this->jsonError('Could not upload your ' . $inKey,400);
                        }
                    } else {
                        $reqField[$inKey] = [
                            'field_name' => $inVal->field_name,
                            'field_label' => $inVal->field_label,
                            'validation' => $inVal->validation,
                            'field_value' => $v,
                            'type' => $inVal->type,
                        ];
                    }
                }
            }
        }

        UserKyc::create([
            'user_id' => auth()->id(),
            'kyc_id' => $kyc->id,
            'kyc_type' => $kyc->name,
            'kyc_info' => $reqField
        ]);

        return $this->jsonSuccess("KYC submitted successfully");
    }
}
