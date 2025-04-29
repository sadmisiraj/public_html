<!-- footer section -->
<footer class="footer-section">
    <div class="overlay">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-6">
                    <form action="{{route('subscribe')}}" method="post">
                        @csrf
                        <div class="newsletter text-center">
                            <h4>{!! $footer['single']['newsletter_title']??'' !!}</h4>
                            <div class="input-group">
                                <input type="email" class="form-control" name="email"
                                       placeholder="@lang('Email Address')"/>
                                <button class="btn-custom" type="submit">@lang('Subscribe')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row gy-5 gy-lg-0">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box">
                        <a class="navbar-brand" href="{{ route('page') }}"> <img
                                src="{{logo()}}" alt=""/></a>

                            <p class="company-bio">
                                {!! $footer['single']['short_description']??'' !!}
                            </p>

                            <div class="social-links">
                                @if(isset($footer['multiple']))
                                @foreach(collect($footer['multiple'])->toArray() as $data)
                                    <a href="{{$data['media']->social_link}}" class="facebook"
                                       target="_blank">
                                        {!! icon($data['media']->social_link) !!}
                                    </a>
                                @endforeach
                                @endif
                            </div>

                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-box">
                        <h5>{{trans('Useful Links')}}</h5>
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
                        <h5>@lang('OUR SERVICES')</h5>
                        <ul>
                            @if(getFooterMenuData('support_link') != null)

                                @foreach(getFooterMenuData('support_link') as $list)
                                    {!! $list !!}
                                @endforeach
                            @endif
                        </ul>
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

            </div>
            <div class="d-flex copyright justify-content-between align-items-center">
                <div>
                    <span> @lang('All rights reserved') &copy; {{date('Y')}} @lang('by') <a
                            href="{{ route('page') }}">@lang(basicControl()->site_title??"HYIP PRO")</a> </span>
                </div>

                <div class="language-dropdown-items">
                    <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(session('language'))
                            <span>{{session('language')->name??''}}</span>
                        @else
                            <span>{{$languages->first()->name}}</span>
                        @endif

                    </button>
                    <ul class="dropdown-menu dropdown-menu-start">
                        @if(isset($languages))
                        @foreach ($languages as $key => $language)
                            <li>
                                <a href="{{route('language',$language->short_name)}}" class="dropdown-item">
                                    <span> {{$language->name}}</span>
                                </a>
                            </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
