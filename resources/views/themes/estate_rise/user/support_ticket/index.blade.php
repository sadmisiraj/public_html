@extends(template().'layouts.user')
@section('title')
    @lang('Support Ticket')
@endsection

@section('content')
    <div class="main-wrapper">
        <!-- Page title start -->
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Support Ticket')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Support Ticket')</li>
                </ol>
            </nav>
        </div>
        <!-- Page title end -->

        <div class="section dashboard">


            <!-- Chat section start -->
            <div class="message-container">
                <div class="row g-0">
                    <div class="col-md-4">
                        <div class="message-sidebar">
                            <div class="header-section">
                                <div class="section-title">@lang('Support Ticket')</div>
                                <div class="btn-area d-md-none">
                                    <button class="cmn-btn4" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#image-generator-offcanvas"
                                            aria-controls="offcanvasExample">
                                        <i class="fa-light fa-list"></i>
                                    </button>
                                </div>
                            </div>
                            <ul class="conversations-wrapper d-none d-md-block">
                                @forelse($tickets as $key => $SupportTicket)
                                    <li class="{{isset($conversation) && $conversation->id == $SupportTicket->id?'active':''}}">
                                        <a href="{{route('user.ticket.list',$SupportTicket->ticket)}}" class="item-link">
                                            <div class="item-header">
                                                <div class="chat-title">[{{ trans('Ticket#').$SupportTicket->ticket }}
                                                    ] {{ $SupportTicket->subject }}</div>
                                                <div class="chat-action">
                                                    <div class="chat-edit">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </div>
                                                </div>
                                            </div>

                                        </a>
                                    </li>
                                @empty
                                    <div class="text-center p-4">
                                        <p class="mb-0">@lang('No data to show')</p>
                                    </div>
                                @endforelse
                            </ul>
                            <div class="message-sidebar-bottom d-none d-md-block">

                                <a href="{{route('user.ticket.create')}}" class="cmn-btn w-100"> @lang('New Ticket') </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="chat-box">
                            @if(isset($conversation))
                                <div class="header-section">
                                    <div class="profile-info">
                                        <div class="thumbs-area">
                                            <img src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}"
                                                 alt="EstateRise">
                                        </div>
                                        <div class="content-area">
                                            <div class="title">{{auth()->user()->fullname}}</div>
                                            {!! $conversation->getTicketStatusBadgeEstateRise() !!}
                                        </div>
                                    </div>
                                    <div class="single-btn-box d-none d-sm-flex d-flex justify-content-sm-end ">

                                        <button type="button" data-bs-toggle="modal" data-bs-target="#CloseTicketmodal"
                                                class="cmn-btn"><i
                                                class="fas fa-times-circle"></i> @lang('Close')</button>
                                    </div>
                                </div>
                                <div class="chat-box-inner">
                                    @foreach($conversation->messages->reverse() as $item)
                                        @if($item->admin_id == null)
                                            <div class="message-bubble message-bubble-left">
                                                <div class="message-thumbs">
                                                    <img src="{{ getFile($user->image_driver, $user->image) }}"
                                                         alt="EstateRise">
                                                </div>
                                               <div class="d-flex flex-column">
                                                   <div class="message-text">{{$item->message}}</div>
                                                   @if(0 < count($item->attachments))
                                                       <div class="d-flex flex-row flex-wrap">
                                                           @foreach($item->attachments as $k=> $image)
                                                               <a href="{{route('user.ticket.download',encrypt($image->id))}}"
                                                                  class="ml-3 ms-2 nowrap ticket-file-icon"><i
                                                                       class="fa fa-file"></i> @lang('File') {{++$k}}
                                                               </a>
                                                           @endforeach
                                                       </div>
                                                   @endif
                                               </div>
                                            </div>
                                        @else
                                            <div class="message-bubble message-bubble-right">
                                                <div class="message-thumbs">
                                                    <img src="{{ getFile($item->image_driver, $item->image) }}"
                                                         alt="EstateRise">
                                                </div>
                                                <div class="message-text"> {{$item->message}}</div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <form action="{{ route('user.ticket.reply', $conversation->id)}}" method="post"  enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="chat-box-bottom">
                                        <div class="cmn-btn-group2">
                                            <div class="single-btn2 new-file-upload mr-2" title="Image Upload">
                                                <a href="#">
                                                    <i class="fa-light fa-image"></i>   </a>
                                                <input type="file" name="attachments[]" id="upload" class="upload-box" multiple="" placeholder="Upload File">
                                            </div>

                                        </div>

                                        <textarea class="form-control" name="message" id="exampleFormControlTextarea1"
                                                  rows="3"></textarea>
                                        <button type="submit" data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Send" class="message-send-btn" name="reply_ticket" value="1"><i
                                                class="fa-thin fa-paper-plane"></i></button>
                                    </div>
                                    <p class="text-danger select-files-count"></p>
                                    <!-- Modal section start -->
                                </form>
                                <div class="modal fade" id="CloseTicketmodal" data-bs-backdrop="static"
                                     data-bs-keyboard="false" tabindex="-1"
                                     aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title" id="staticBackdropLabel">@lang('Confirmation')
                                                    !</h1>
                                                <button type="button" class="cmn-btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    <i class="fa-light fa-xmark"></i>
                                                </button>
                                            </div>
                                            <form action="{{route('user.ticket.close',$conversation->id??'1')}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    @lang('Are you want to close this ticket')?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="cmn-btn">@lang('Yes')</button>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal section end -->
                            @else
                                <div class="empty-message d-flex align-items-center justify-content-center">
                                    <div class="text-center p-4">
                                        <img class="dataTables-image mb-3"
                                             src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description"
                                             data-hs-theme-appearance="default">
                                        <p class="mb-0">@lang('Select a Ticket to start messaging')</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Chat section end -->
        </div>
    </div>


    <!-- message offcanvas start-->
    <div class="offcanvas offcanvas-end message-offcanvas" tabindex="-1" id="image-generator-offcanvas"
         aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <a class="logo" href="{{route('page')}}"><img src="{{logo()}}" alt="EstateRise"></a>
            <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
                    class="fa-regular fa-arrow-right"></i></button>
        </div>
        <div class="offcanvas-body">
            <div class="message-sidebar">
                <div class="header-section">
                    <div class="section-title">@lang('Support Ticket')</div>
                </div>
                <ul class="conversations-wrapper">
                    @forelse($tickets as $key => $ticket)
                        <li class="{{isset($conversation) && $conversation->id == $ticket->id?'active':''}}">
                            <a href="{{route('user.ticket.list',$ticket->ticket)}}" class="item-link">
                                <div class="item-header">
                                    <div class="chat-title">[{{ trans('Ticket#').$ticket->ticket }}
                                        ] {{ $ticket->subject }}</div>
                                    <div class="chat-action">
                                        <div class="chat-edit">
                                            <i class="fa-regular fa-eye"></i>
                                        </div>
                                    </div>
                                </div>

                            </a>
                        </li>
                    @empty
                        <div class="text-center p-4">
                            <p class="mb-0">@lang('No data to show')</p>
                        </div>
                    @endforelse

                </ul>
                <div class="message-sidebar-bottom">
                    <a href="{{route('user.ticket.create')}}" class="cmn-btn w-100"> @lang('New Ticket')</a>
                </div>
            </div>
        </div>
    </div>
    <!-- message offcanvas end-->
@endsection

@push('script')
    <script>
        $(document).on('change', '#upload', function () {
            console.log('hello')
            var fileCount = $(this)[0].files.length;
            $('.select-files-count').text(fileCount + ' file(s) selected')
        })
    </script>
@endpush
@push('style')
    <style>
        .select-files-count {
            margin-left: 42px;
            margin-top: -9px;
        }
        .new-file-upload {
            position: relative;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: initial;
            overflow: hidden;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            cursor: pointer;
            margin-right: 20px;
        }
        #upload {
            opacity: 0;
            cursor: pointer;
        }
        .new-file-upload input[type=file] {
            position: absolute;
            top: 0;
            left: 0;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
@endpush
