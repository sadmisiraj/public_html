

<!-- contact section -->
<div class="contact-section">
    <div class="container">
        <div class="row g-lg-5 gy-5">
            <div class="col-lg-4">
                <div class="contact-info">
                    <h4 class="mb-4">@lang('Our Office')</h4>
                    <div class="contact-map mb-5">
                        <img src="{{ isset($contact_section['single']['media']->image)? getFile($contact_section['single']['media']->image->driver,$contact_section['single']['media']->image->path):'' }}" class="img-fluid" alt="" />
                    </div>
                    <div class="info-box">
                        <div class="icon">
                            <img src="{{ asset(template(true).'img/location-2.png') }}" alt="" />
                        </div>
                        <div>
                            <h5>@lang('Our Location')</h5>
                            <p>{!! $contact_section['single']['location'] !!}</p>
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="icon">
                            <img src="{{ asset(template(true).'img/email-2.png') }}" alt="" />
                        </div>
                        <div>
                            <h5>@lang('email address')</h5>
                            <p>{!! $contact_section['single']['email'] !!}</p>
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="icon">
                            <img src="{{ asset(template(true).'img/phone-2.png') }}" alt="" />
                        </div>
                        <div>
                            <h5>@lang('company number')</h5>
                            <p>{!! $contact_section['single']['telephone'] !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <h3>{!! $contact_section['single']['heading']??'' !!}</h3>
                <p class="mb-4">{!! $contact_section['single']['sub_heading']??'' !!}</p>
                <form action="{{route('contact.send')}}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="input-box col-md-12">
                            <input type="text"
                                   name="name"
                                   value="{{old('name')}}"
                                   class="form-control"
                                   placeholder="@lang('Full name')" />
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="input-box col-md-12">
                            <input
                                type="email"
                                name="email"
                                value="{{old('email')}}"
                                class="form-control"
                                placeholder="@lang('Email Address')" />
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="input-box col-md-12">
                            <input
                                type="text"
                                name="subject"
                                value="{{old('subject')}}"
                                class="form-control"
                                placeholder="@lang('Subject')" />
                            @error('subject')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="input-box col-md-12">
                                <textarea
                                    class="form-control"
                                    name="message"
                                    cols="30"
                                    rows="10"
                                    placeholder="@lang('Your message')">{{old('message')}}</textarea>
                            @error('message')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="input-box col-md-12">
                            <button class="btn-custom">{{trans('Send Message')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

