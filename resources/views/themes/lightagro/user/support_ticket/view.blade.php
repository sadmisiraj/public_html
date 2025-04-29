@extends(template().'layouts.user')
@section('title',trans('Ticket').': #'.$ticket->ticket)
@section('content')

    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h4 class="mb-0">@lang('Support Ticket')</h4>
                </div>

                <div class="message-wrapper">
                    <div class="row g-lg-0">
                        <div class="col-lg-12">
                            <form class="form-row mt-4" action="{{ route('user.ticket.reply', $ticket->id)}}"
                                  method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="inbox-wrapper">
                                    <!-- top bar -->
                                    <div class="top-bar">
                                        <div class="d-flex align-items-center">
                                            <img class="user img-fluid"
                                                 src="{{ getFile($user->image_driver, $user->image) }}" alt=""/>
                                            <div class="name">
                                                <a href="#">{{ $user->firstname . ' ' . $user->lastname }}</a>
                                                {!! $ticket->getTicketStatusBadge() !!}
                                            </div>
                                        </div>
                                        <div>
                                            <button type="button" id="infoBtn" data-bs-toggle="modal" data-bs-target="#closeTicketModal" class="btn btn-primary"><i class="fa-sharp fa-thin fa-xmark"></i> @lang('Close') <span></span></button>
                                        </div>
                                    </div>
                                    <!-- chats -->
                                    @if(count($ticket->messages) > 0)
                                        <div class="chats">
                                            @foreach($ticket->messages->reverse() as $item)
                                                @if($item->admin_id == null)
                                                    <div class="chat-box this-side">
                                                        <div class="chat-box this-side">
                                                            <div class="text-wrapper">
                                                                <div class="text">
                                                                    <p>
                                                                        {{$item->message}}
                                                                    </p>
                                                                </div>
                                                                @if(0 < count($item->attachments))
                                                                <div class="attachment-wrapper">
                                                                    @foreach($item->attachments as $k=> $file)
                                                                    <a
                                                                        class="attachment"
                                                                        href="{{route('user.ticket.download',encrypt($file->id))}}"

                                                                        data-fancybox="gallery">
                                                                        <i class="fa fa-file"></i> @lang('File') {{++$k}}
                                                                    </a>
                                                                    @endforeach
                                                                </div>
                                                                @endif
                                                                <small class="time"> {{dateTime($item->created_at, 'd M, y h:i A')}}</small>
                                                            </div>
                                                            <div class="img">
                                                                <img class="img-fluid" src="{{ getFile($user->image_driver, $user->image) }}" alt="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="chat-box opposite-side">
                                                        <div class="img">
                                                            <img class="img-fluid" src="{{ getFile($item->image_driver, $item->image) }}" alt="" />
                                                        </div>
                                                        <div class="text-wrapper">
                                                            <div class="text">
                                                                <p>
                                                                    {{$item->message}}
                                                                </p>
                                                            </div>
                                                            <div class="attachment-wrapper">
                                                                @foreach($item->attachments as $k=> $file)
                                                                    <a
                                                                        class="attachment"
                                                                        href="{{route('user.ticket.download',encrypt($image->id))}}"
                                                                        data-fancybox="gallery">
                                                                        <i class="fa fa-file"></i> @lang('File') {{++$k}}
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                            <small class="time">{{dateTime($item->created_at, 'd M, y h:i A')}}</small>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="typing-area">
                                        <div class="img-preview">
                                            <button class="delete" type="button" id="deleteImage">
                                                <i class="fal fa-times"></i>
                                            </button>
                                            <img id="attachment" src="" alt="" class="img-fluid"/>
                                        </div>
                                        <div class="input-group">
                                            <div>
                                                <button class="upload-img send-file-btn" type="button">
                                                    <i class="fal fa-paperclip"></i>
                                                    <input class="form-control" id="ticketImage" name="attachments[]"
                                                        accept="image/*"
                                                        type="file"
                                                        onchange="previewTicketImage('attachment')"
                                                    />
                                                </button>
                                            </div>
                                            <input type="text" class="form-control" name="message"/>
                                            <button class="submit-btn" type="submit"  name="reply_ticket" value="1">
                                                <i class="fal fa-paper-plane"></i>
                                            </button>
                                        </div>
                                        @error('message')
                                            <span class="d-block text-danger"></span>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="closeTicketModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('Confirmation') !</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('user.ticket.close',$ticket->id)}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you want to close ticket')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm') <span></span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>

        $(document).on('click','#deleteImage',function (){
            $('.img-preview').hide();
            $('#attachment').attr('src','');
            $('#ticketImage').val('');
        })
        $(document).ready(function () {
            $('.img-preview').hide();
        })
        const previewTicketImage = (id) => {
            $('.img-preview').show();
            document.getElementById(id).src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endpush

