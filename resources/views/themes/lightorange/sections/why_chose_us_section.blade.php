<section id="choose-us-section">
    <img class="img img-4 zoomInOutInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-4.png')}}" alt="@lang('ellipse-4-image')">
    <img class="img img-5 zoomInOut2sInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-5.png')}}" alt="@lang('ellipse-5-image')">
    <img class="img img-6 zoomInOut2sInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-6.png')}}" alt="@lang('ellipse-6-image')">
    <img class="img img-7 zoomInOutInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-7.png')}}" alt="@lang('ellipse-7-image')">

    <div class="overlay pt-150 pb-150">
        <div class="container">

            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-10">
                    <div class="section-header">
                        <h4 class="sub-title">{!! $why_chose_us_section['single']['heading']??'' !!}</h4>
                        <h3 class="title">{!! $why_chose_us_section['single']['sub_heading']??'' !!}</h3>
                        <p class="area-para">{!! $why_chose_us_section['single']['short_details']??'' !!}</p>
                    </div>
                </div>
            </div>

            <div class=" {{(session()->get('rtl') == 1) ? 'choose-us-carousel-rtl': 'choose-us-carousel'}} wow fadeInUp" >
                @foreach(collect($why_chose_us_section['multiple'])->toArray() as $item)
                    <div class="col">
                        <div class="single-item d-flex">
                            <div class="left-area">
                                <div class="icon-box d-flex justify-content-center align-items-center">
                                    <img src="{{isset($item['media']->icon)?getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('why-choose-us image')">
                                </div>
                            </div>
                            <div class="right-area">
                                <h2>{!! $item['title']??'' !!}</h2>
                                <p>{!! $item['information']??'' !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
<!-- why choose us end -->
