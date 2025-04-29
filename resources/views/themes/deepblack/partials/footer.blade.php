<!-- footer -->
<footer class="footer">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-3">
                <div class="footer-box">
                    <a class="navbar-brand golden-text" href="{{route('page')}}">
                        {{basicControl()->site_title??"HYIP PRO"}}
                    </a>
                    <p>
                        {!! $footer['single']['short_description']??'' !!}
                    </p>
                    <div class="social-links">
                        @foreach(collect($footer['multiple'])->toArray() as $data)
                            <a href="{{$data['media']->social_link}}" class="facebook"
                               target="_blank">
                                {!! icon($data['media']->social_link) !!}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 {{(session()->get('rtl') == 1) ? 'pe-lg-5': 'ps-lg-5'}}">
                <div class="footer-box">
                    <h4 class="golden-text">{{trans('Useful Links')}}</h4>
                    <ul>
                        @if(getFooterMenuData('useful_link') != null)

                            @foreach(getFooterMenuData('useful_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 {{(session()->get('rtl') == 1) ? 'pe-lg-5': 'ps-lg-5'}}">
                <div class="footer-box">
                    <h4 class="golden-text">@lang('Our Services')</h4>
                    <ul>
                        @if(getFooterMenuData('support_link') != null)

                            @foreach(getFooterMenuData('support_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>


                <div class="col-md-6 col-lg-3">
                    <div class="footer-box">
                        <h4 class="golden-text">{{trans('Contact Us')}}</h4>
                        <ul>
                            <li>
                                <img src="{{asset(template(true).'img/icon/calling.png')}}" alt="@lang('phone')" />
                                <a href="tel:{{ $footer['single']['telephone']??'' }}"><span>{{ $footer['single']['telephone'] ??'' }}</span></a>
                            </li>
                            <li>
                                <img src="{{asset(template(true).'img/icon/email.png')}}" alt="@lang('email')" />
                                <a href="mailto:{{ $footer['single']['email']??'' }}"><span>{{ $footer['single']['email']??'' }}</span></a>
                            </li>
                            <li>
                                <img src="{{asset(template(true).'img/icon/location.png')}}" alt="@lang('address')" />
                                <span>{!! $footer['single']['address']??'' !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>

        </div>

        <div class="row copyright">
            <div class="col-md-6">
                <span>@lang('Copyright') &copy; {{date('Y')}} @lang(basicControl()->site_title??"HYIP PRO") @lang('All Rights Reserved')</span>
            </div>

            <div class="col-md-6 language {{(session()->get('rtl') == 1) ? 'text-md-start': 'text-md-end'}}">
                @foreach($languages as $language)
                    <a href="{{route('language',$language->short_name)}}">
                        <span class="flag-icon flag-icon-{{$language->short_name == 'en' ?'us':$language->short_name}}"></span> {{$language->name}}
                    </a>
                @endforeach


            </div>
        </div>
    </div>

</footer>
