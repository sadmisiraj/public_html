<!-- Contact section start -->
<section class="contact-section">
    <div class="container">
        <div class="contact-inner">
            <div class="row g-4">
                <div class="col-xl-5 col-lg-6">
                    <div class="contact-area">
                        <div class="section-header mb-0">
                            <h3>{{$contact_section['single']['heading_1']??''}}</h3>
                        </div>
                        <p class="para_text">
                            {{$contact_section['single']['short_details_1']??''}}
                        </p>
                        <div class="contact-item-list">
                            <div class="item">
                                <div class="icon-area">
                                    <i class="fa-light fa-phone"></i>
                                </div>
                                <div class="content-area">
                                    <h6 class="mb-0">@lang('Phone'):</h6>
                                    <p class="mb-0">{{$contact_section['single']['telephone']??''}}</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="icon-area">
                                    <i class="fa-light fa-envelope"></i>
                                </div>
                                <div class="content-area">
                                    <h6 class="mb-0">@lang('Email'):</h6>
                                    <p class="mb-0">{{$contact_section['single']['email']??''}}</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="icon-area">
                                    <i class="fa-light fa-location-dot"></i>
                                </div>
                                <div class="content-area">
                                    <h6 class="mb-0">@lang('Address'):</h6>
                                    <p class="mb-0">{{$contact_section['single']['address']??''}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-30">
                            <h5>@lang('Socials')</h5>
                            <ul class="social-box mt-10">
                                @foreach(collect($contact_section['multiple'])->toArray() as $data)
                                    <li><a href="{{$data['media']->social_link}}" target="_blank">{!! icon($data['media']->social_link) !!}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="contact-message-area">
                        <div class="contact-header">
                            <h3 class="section-title">{{$contact_section['single']['heading_2']??''}}</h3>
                            <p>
                                {{$contact_section['single']['short_details_2']??''}}

                            </p>
                        </div>
                        <form action="{{route('contact.send')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="@lang('Your Name')">
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="@lang('E-mail Address')">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <input type="text" name="subject" value="{{old('subject')}}" class="form-control" placeholder="@lang('Your Subject')">
                                    @error('subject')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb  -3 col-12">
                                    <textarea class="form-control" name="message"  id="exampleFormControlTextarea1" rows="5"
                                                  placeholder="@lang('Your Massage')">{{old('message')}}</textarea>
                                    @error('message')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="btn-area d-flex justify-content-end">
                                <button type="submit" class="cmn-btn w-100"><span>@lang('Send a massage')</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact section end -->

<!-- Map section start -->
<div class="map-section">
    <iframe class="shadow-none p-0"
            src="{{$contact_section['single']['media']->map_url??''}}"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<!-- Map section end -->
