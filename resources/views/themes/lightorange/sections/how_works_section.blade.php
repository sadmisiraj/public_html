<section id="about-us-section" class="pt-150 pb-150">
    <img class="img-1 zoomInOutInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-1.png')}}" alt="@lang('ellipse-1-image')">
    <img class="img-2 zoomInOutInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-2.png')}}" alt="@lang('ellipse-2-image')">
    <img class="img-3 zoomInOut2sInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-3.png')}}" alt="@lang('ellipse-3-image')">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6 d-flex align-items-center justify-content-md-center wow fadeInLeftBig">
                <div class="video-area">
                    <div class="content d-flex justify-content-center align-items-center">
                        <img src="{{isset($how_works_section['single']['media']->image)? getFile($how_works_section['single']['media']->image->driver,$how_works_section['single']['media']->image->path):''}}" alt="@lang('how-it-work-image')">
                    </div>
                </div>
            </div>
            <div class="col-lg-5 wow fadeInRightBig">
                <div class="right-area">
                    <div class="section-head">
                        <h3 class="title font-weight-bold">{!! $how_works_section['single']['heading']??'' !!}</h3>
                    </div>
                    <div class="single-item">
                        @foreach(collect($how_works_section['multiple'])->toArray()??[] as $k =>  $item)
                            <div class="btn-top d-flex">
                                <div class="icon-area">
                                    <img src="{{isset($item['media']->icon)? getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('how-it-work-image')">
                                </div>
                                <div class="text-area">
                                    <h5 class="font-weight-bold" style="color:#33406A">{!! $item['title'] !!}</h5>
                                    <div style="color:#526288">{!! $item['short_description'] !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
