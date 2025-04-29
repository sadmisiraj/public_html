<!-- footer_area_start -->
<section class="footer_area">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-sm-6">
                <div class="footer_widget">
                    <div class="widget_logo">
                        <h5><a href="{{route('page')}}" class="site_logo"><img src="{{logo()}}" alt="{{basicControl()->site_title??"HYIP PRO"}}"></a></h5>
                        <p class="">{!! $footer['single']['short_description'] !!}</p>
                    </div>
                    <div class="social_area mt-50">
                        <ul class="">
                            @foreach(collect($footer['multiple'])->toArray() as $data)
                                <li><a href="{{$data['media']->social_link??''}}" target="_blank">{!! icon($data['media']->social_link) !!}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6 {{(session()->get('rtl') == 1) ? 'pe-lg-5': 'ps-lg-5'}}">
                <div class="footer_widget ps-lg-5">
                    <h5>@lang('Links') <span class="highlight"></span></h5>
                    <ul>
                        @if(getFooterMenuData('useful_link') != null)

                            @foreach(getFooterMenuData('useful_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 pt-sm-0 pt-3 ps-lg-5 {{(session()->get('rtl') == 1) ? 'pe-lg-5': 'ps-lg-5'}}">
                <div class="footer_widget">
                    <h5>@lang('Our Services') <span class="highlight"></span></h5>
                    <ul>
                        @if(getFooterMenuData('support_link') != null)

                            @foreach(getFooterMenuData('support_link') as $list)
                                {!! $list !!}
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 pt-sm-0 pt-3">
                <div class="footer_widget">
                    <h5>@lang('Contact Us') <span class="highlight"></span></h5>
                    <p>{!! $footer['single']['location']??'' !!}</p>
                    <p>{!! $footer['single']['email']??'' !!}</p>
                    <p>{!! $footer['single']['telephone']??'' !!}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- footer_area_end -->

<!-- copy_right_area_start -->
<div class="copy_right_area text-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p>@lang('Copyright') &copy; {{date('Y')}} @lang(basicControl()->site_title??"HYIP PRO") @lang('All Rights Reserved') </p>
            </div>
        </div>
    </div>
</div>
<!-- copy_right_area_end -->
