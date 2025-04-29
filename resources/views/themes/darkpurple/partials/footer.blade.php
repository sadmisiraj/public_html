<!-- footer section -->
<footer class="footer-section">
    <div class="overlay">
        <div class="container">
            <div class="row gy-5 gy-lg-0">
                <div class="col-lg-3 col-md-6 pe-lg-5">
                    <div class="footer-box">
                        <a class="navbar-brand" href="{{route('page')}}"> <img src="{{logo()}}" alt="{{basicControl()->site_title??"HYIP PRO"}}" /></a>
                        <p class="company-bio">
                            {!! $footer['single']['short_description']??'' !!}
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 {{(session()->get('rtl') == 1) ? 'pe-lg-5': 'ps-lg-5'}}">
                    <div class="footer-box">
                        <h4>{{trans('Useful Links')}}</h4>
                        <ul>
                            @if(getFooterMenuData('useful_link') != null)

                                @foreach(getFooterMenuData('useful_link') as $list)
                                    {!! $list !!}
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 {{(session()->get('rtl') == 1) ? 'pe-lg-5': 'ps-lg-5'}}">
                    <div class="footer-box">
                        <h4>{{trans('Contact Us')}}</h4>
                        <ul>
                            <li>@lang('Address'): <span>{!! $footer['single']['address']??'' !!}</li>
                            <li>@lang('Email'): <span>{{ $footer['single']['email']??'' }}</span></li>
                            <li>@lang('Phone'): <span>{{ $footer['single']['telephone']??'' }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box">
                        <h4>@lang('Follow us on')</h4>
                        <div class="social-links">
                            @foreach(collect($footer['multiple'])->toArray() as $data)
                                <a href="{{$data['media']->social_link}}" target="_blank" class="facebook">
                                    {!! icon($data['media']->social_link) !!}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex copyright justify-content-between">
                <div>
                    <span> @lang('Copyright') &copy; {{date('Y')}} @lang(basicControl()->site_title??"HYIP PRO") @lang('All Rights Reserved') </span>
                </div>
                <div class="{{(session()->get('rtl') == 1) ? 'text-md-start': 'text-md-end'}}">
                    @foreach($languages as $language)
                        <a href="{{route('language',$language->short_name)}}" class="language">{{$language->name}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</footer>
