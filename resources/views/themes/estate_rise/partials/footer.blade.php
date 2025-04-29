<!-- Footer Section start -->
<section class="footer-section">
    <div class="container">
        <div class="row gy-4 gy-sm-5">
            <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="500">
                <div class="footer-widget">
                    <div class="widget-logo">
                        <a href="{{route('page')}}"><img class="logo" src="{{logo()}}"
                                                 alt="EstateRise"></a>
                    </div>
                    <p>
                        {!! $footer['single']['short_description']??'' !!}
                    </p>

                    <ul class="social-box mt-30">
                        @if(isset($footer['multiple']))
                            @foreach(collect($footer['multiple'])->toArray() as $data)
                                <li><a href="{{$data['media']->social_link}}" target="_blank">{!! icon($data['media']->social_link) !!}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6" data-aos="fade-up" data-aos-duration="700">
                <div class="footer-widget">
                    <h5 class="widget-title">@lang('Quick Links')</h5>
                    <ul>
                        @if(getFooterMenuData('useful_link') != null)

                            @foreach(getFooterMenuData('useful_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 pt-sm-0 pt-3 ps-lg-5" data-aos="fade-up" data-aos-duration="900">
                <div class="footer-widget">
                    <h5 class="widget-title">@lang('Company Policy')</h5>
                    <ul>
                        @if(getFooterMenuData('support_link') != null)

                            @foreach(getFooterMenuData('support_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 pt-sm-0 pt-3" data-aos="fade-up" data-aos-duration="1100">
                <div class="footer-widget">
                    <h5 class="widget-title">@lang('Newsletter')</h5>
                    <p>{!! $footer['single']['newsletter_title']??'' !!}</p>
                    <form class="newsletter-form" action="{{route('subscribe')}}" method="post">
                        @csrf
                        <input type="text" name="email" class="form-control" placeholder="@lang('Your email')">
                        <button type="submit" class="subscribe-btn"><i
                                class="fa-regular fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <hr class="cmn-hr">
        <!-- Copyright-area-start -->
        <div class="copyright-area">
            <div class="row gy-4">
                <div class="col-sm-6">
                    <p>@lang('Copyright') ©{{date('Y')}} <a class="highlight" href="{{ route('page') }}">@lang(basicControl()->site_title??"HYIP PRO")</a> @lang('All Rights Reserved')
                    </p>
                </div>
                <div class="col-sm-6">
                    <div class="language">
                        @if(isset($languages))
                            @foreach ($languages as $key => $language)
                                <a href="{{route('language',$language->short_name)}}" class="language">{{$language->name}}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright-area-end -->
    </div>
</section>
<!-- Footer Section end -->
