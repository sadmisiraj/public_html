<!-- footer-section start -->
<footer id="inner-footer-section">
    <div class="wrapper-top">
        <div class="clip"></div>
        <div class="footer-top-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-top pt-150 pb-150">
                            <div class="row text-center">
                                <div class="col-lg-12">
                                    <div class="social-icon">
                                        <ul class="icon-area d-flex justify-content-center">
                                            @foreach(collect($footer['multiple'])->toArray() as $data)
                                                <li class="social-nav">
                                                    <a href="{{$data['media']->social_link}}">
                                                        {!! icon($data['media']->social_link) !!}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="footer-text">
                                        <h2 class="sub-title">{!! $footer['single']['heading']??'' !!}</h2>
                                        <h2 class="title">{!! $footer['single']['sub_heading']??'' !!}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-6 mt-2">
                                    <form action="{{route('subscribe')}}" method="post">
                                        <div class="subscribe d-flex">
                                            @csrf
                                            <input type="email" name="email" type="email" class="text-dark" placeholder="@lang('Email Address')">
                                            <button class="subscribe-btn" type="submit">{{trans('Subscribe')}}</button>

                                        </div>
                                    </form>
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-area">
        <div class="container">
            <div class="footer-bottom">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6 col-md-4 justify-cen d-flex justify-content-start">
                        <div class="left-area">
                            <a class="site-logo site-title" href="{{url('/')}}">
                                <img src="{{logo()}}"
                                     alt="{{basicControl()->site_title??"HYIP PRO"}}">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-8 justify-cen d-flex justify-content-end align-items-center">
                        <ul class="d-flex">

                            @if(getFooterMenuData('useful_link') != null)

                                @foreach(getFooterMenuData('useful_link') as $list)
                                    {!! $list !!}
                                @endforeach
                            @endif

                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bottom-area text-center">
                            <p>@lang('Copyright') &copy; {{date('Y')}} @lang(basicControl()->site_title??"HYIP PRO") @lang('All Rights Reserved')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer-section end -->


