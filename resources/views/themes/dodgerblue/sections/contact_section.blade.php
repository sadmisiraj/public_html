<!-- contact section -->
<div class="contact-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="form-box">
                    <form action="{{route('contact.send')}}" method="post">
                        @csrf
                        <div class="row g-4">
                            <div class="input-box col-md-12">
                                <input class="form-control" type="text" name="name" value="{{old('name')}}"
                                       placeholder="@lang('Full name')"/>
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="input-box col-md-12">
                                <input class="form-control" type="email" name="email" value="{{old('email')}}"
                                       placeholder="@lang('Email address')"/>
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="input-box col-12">
                                <input type="text" name="subject" value="{{old('subject')}}" class="form-control"
                                       placeholder="@lang('Subject')"/>
                                @error('subject')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="input-box col-12">
                                    <textarea class="form-control" name="message" cols="30" rows="3"
                                              placeholder="@lang('Your message')">{{old('message')}}</textarea>
                                @error('message')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="input-box col-12">
                                <button class="btn-custom w-100">@lang('Send Message')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-1"></div>
            <div class="col-lg-6">
                <div class="header-text">
                    <h5>{!! $contact_section['single']['heading']??'' !!}</h5>
                    <h3>{!! $contact_section['single']['sub_heading']??'' !!}</h3>
                    <p>
                        {!! $contact_section['single']['short_text']??'' !!}
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="icon"><img src="{{ asset(template(true).'img/icon/email.png') }}" alt=""></div>
                            <div class="text">
                                <h4>@lang('Email')</h4>
                                <p>{!! $contact_section['single']['email']??'' !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="icon"><img src="{{ asset(template(true).'img/icon/phone.png') }}" alt=""></div>
                            <div class="text">
                                <h4>@lang('Phone')</h4>
                                <p>{!! $contact_section['single']['telephone_number']??'' !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="icon"><img src="{{ asset(template(true).'img/icon/location.png') }}" alt="">
                            </div>
                            <div class="text">
                                <h4>@lang('Location')</h4>
                                <p>{!! $contact_section['single']['location']??'' !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($contentDetails['social']))
                    <div class="social-links">
                        <h5 class="">@lang('Follow our social media')</h5>
                        <div>
                            @foreach(collect($contact_section['multiple'])->toArray() as $data)
                                <a href="{{$data['media']->social_link}}" class="facebook">
                                    {!! icon($data['media']->social_link) !!}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
