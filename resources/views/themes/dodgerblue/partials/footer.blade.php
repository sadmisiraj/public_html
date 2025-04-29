<!-- footer section -->
<footer class="footer-section">
    <div class="overlay">
        <div class="container">
            <div class="row gy-5 gy-lg-0">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box">

                        <a class="navbar-brand" href="{{ route('page') }}"> <img
                                src="{{logo()}}" alt=""/></a>
                        <p class="company-bio">
                            {!! $footer['single']['short_description']??'' !!}                        </p>
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

                <div class="col-lg-3 col-md-6">
                    <div class="footer-box">
                        <h4>{{trans('get in touch')}}</h4>
                        <ul>
                            <li>
                                <a href="mailto:{{ $footer['single']['email']??'' }}"><span>{{ $footer['single']['email']??'' }}</span></a>
                            </li>

                            <li>
                                <a href="tel:{{ $footer['single']['telephone']??'' }}"><span>{{ $footer['single']['telephone'] ??'' }}</span></a>
                            </li>

                            <li>
                                <span>{!! $footer['single']['address']??'' !!}</span>
                            </li>
                        </ul>
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

                <div class="col-lg-3 col-md-6">
                    <div class="footer-box">
                        <h4>{!! $footer['single']['newsletter_title']??'' !!}</h4>
                        <form action="{{route('subscribe')}}" method="post">
                            @csrf
                            <div class="input-box">
                                <input type="email" name="email" class="form-control"
                                       placeholder="@lang('Email Address')" autocomplete="off"/>
                                <button type="submit" class="btn-action-icon"><i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                            <p class="mt-3"><i
                                    class="fa-duotone fa-circle-check"></i> @lang('I agree to all terms and policies')
                            </p>
                        </form>
                    </div>
                </div>
            </div>


            <div class="d-flex copyright justify-content-between align-items-center">
                <div>
                    <span> @lang('Copyright') &copy; {{date('Y')}} @lang(basicControl()->site_title??"HYIP PRO") @lang('All Rights Reserved') </span>
                </div>


                <div class="language-dropdown-items">
                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(session('language'))
                            <img src="{{getFile(session('language')->flag_driver,session('language')->flag)}}" alt="">
                            <span>{{session('language')->name}}</span>
                        @else
                            <img src="{{getFile($languages->first()->flag_driver,$languages->first()->flag)}}" alt="">
                            <span>{{$languages->first()->name}}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-start">
                        @foreach ($languages as $key => $language)
                        <li>
                            <a href="{{route('language',$language->short_name)}}" class="dropdown-item">
                                <span>{{$language->name}}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>
    </div>
</footer>

