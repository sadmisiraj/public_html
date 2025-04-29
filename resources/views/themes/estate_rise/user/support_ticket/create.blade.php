@extends(template().'layouts.user')
@section('title',__('Create Ticket'))

@section('content')

    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Create New Ticket')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Create New Ticket')</li>
                </ol>
            </nav>
        </div>


        <!-- transactions section start -->
        <div class="transactions-section mt-50">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>@lang('Create New Ticket')</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('user.ticket.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div>
                                            <label for="Recipient-email-or-username"
                                                   class="form-label">@lang('Subject') </label>
                                            <input type="text" class="form-control"
                                                   id="Recipient-email-or-username" name="subject" value="{{old('subject')}}" required>
                                        </div>
                                        @error('subject')
                                        <div class="error text-danger">@lang($message) </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <label for="currency" class="form-label">@lang('Message')</label>
                                            <textarea name="message" id="" class="form-control" cols="10" rows="5">{{old('message')}}</textarea>
                                        </div>
                                        @error('message')
                                        <div class="error text-danger">@lang($message) </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <input type="file" name="attachments[]"
                                                   class="form-control"
                                                   multiple
                                                   placeholder="@lang('Upload File')">
                                        </div>
                                        @error('attachments.*')
                                        <div class="error text-danger">@lang($message) </div>
                                        @enderror
                                    </div>

                                    <div class="btn-area">
                                        <button type="submit" class="cmn-btn w-100">@lang('submit')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- transactions section end -->
    </div>
@endsection

