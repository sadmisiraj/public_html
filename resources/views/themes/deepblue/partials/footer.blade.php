<!-- FOOTER -->
<footer id="footer">
    <div class="container">
        <div class="row responsive-footer">
            <div class="col-sm-6 col-lg-4">
                <div class="footer-links wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.15s">
                    <div class="footer-brand">
                        <img src="{{logo()}}" alt="{{basicControl()->site_title??"HYIP PRO"}}">

                        <p class="text mt-30 mb-30">
                            {!! $footer['single']['short_description']??'' !!}
                        </p>
                    </div>
                    <div class="footer-social mt-5">
                        @foreach(collect($footer['multiple'])->toArray() as $data)
                            <a class="social-icon facebook" href="{{$data['media']->social_link}}">
                                {!! icon($data['media']->social_link) !!}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="footer-links  wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                    <h5 class="h5">{{trans('Useful Links')}}</h5>
                    <ul class="">
                        @if(getFooterMenuData('useful_link') != null)

                            @foreach(getFooterMenuData('useful_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif


                        @if(getFooterMenuData('support_link') != null)

                            @foreach(getFooterMenuData('support_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>


            <div class="col-sm-6 col-lg-4">
                <div class="footer-address  wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.45s">
                    <h5 class="h5">{{trans('Contact')}}</h5>
                    <ul>
                        <li class="d-flex align-items-center mb-10">
                            <i class="icofont-android-tablet"></i>
                            <span class="ml-10">{{$footer['single']['telephone']??''}}</span>
                        </li>
                        <li class="d-flex align-items-center mb-10">
                            <i class="icofont-envelope"></i>
                            <span class="ml-10">{{$footer['single']['email']??''}}</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="icofont-map-pins"></i>
                            <span class="ml-10">{{$footer['single']['location']??''}}</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>


    <div class="copy-rights">
        <div class="container">
            <p class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.35s">
                @lang('Copyright') &copy; {{date('Y')}} @lang(basicControl()->site_title??"HYIP PRO") @lang('All Rights Reserved')</p>
        </div>
    </div>

</footer>
<!-- /FOOTER -->


