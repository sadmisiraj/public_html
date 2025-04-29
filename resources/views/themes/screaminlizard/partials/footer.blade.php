<!-- footer section -->
<footer class="footer-section">
    <div class="overlay">
        <div class="container">
            <div class="row gy-5 gy-lg-0">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box">
                        <a class="navbar-brand" href="{{ route('page') }}"> <img src="{{logo()}}" alt="" /></a>
                        <p class="company-bio">
                            {!! $footer['single']['short_description']??'' !!}
                        </p>

                        <div class="social-links">
                            @foreach(collect($footer['multiple'])->toArray() as $data)
                                <a href="{{$data['media']->social_link}}" target="_blank">
                                    {!! icon($data['media']->social_link) !!}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-lg-3">
                    <div class="footer-box">
                        <h4>{{trans('get in touch')}}</h4>
                        <ul>
                            <li>
                                <span>{{ $footer['single']['email']??'' }}</span>
                            </li>

                            <li>
                                <span>{{ $footer['single']['telephone']??'' }}</span>
                            </li>

                            <li>
                                <span>{!! $footer['single']['address']??'' !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 {{(session()->get('rtl') == 1) ? 'pe-lg-5': 'ps-lg-5'}}">
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

                <div class="col-lg-3 col-md-6">
                    <div class="footer-box">
                        <h4>{!! $footer['single']['newsletter_title']??'' !!}</h4>
                        <form action="{{route('subscribe')}}" method="post">
                            @csrf
                            <div class="input-box">
                                <input type="email" name="email" class="form-control" placeholder="@lang('Email Address')" autocomplete="off"/>
                                <button type="submit" class="btn-action-icon"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row copyright">
                <div class="col-md-6">
                    <span>@lang('Copyright') &copy; {{date('Y')}} @lang(basicControl()->site_title??"HYIP PRO") @lang('All Rights Reserved')</span>
                </div>

                <div class="col-md-6 language {{(session()->get('rtl') == 1) ? 'text-md-start': 'text-md-end'}}">
                    @foreach($languages as $language)
                        <a href="{{route('language',$language->short_name)}}"><span class="flag-icon flag-icon-en"></span>
                            {{$language->name}} </a>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</footer>
