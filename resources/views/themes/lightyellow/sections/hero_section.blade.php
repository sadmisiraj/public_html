<div id="header_area" class="header_area">
    <div class="hero_area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 order-2 order-md-1 pt-5 pt-md-0">
                    <div class="section_header">
                        <h1 class="mb-50">{!! $hero_section['single']['heading']??'' !!}</h1>
                        <p class="slider_subtitle mb-50">{!! $hero_section['single']['sub_heading']??'' !!}
                        </p>
                    </div>
                    <div class="btn_area mb-30">
                        <a href="{!! $hero_section['single']['media']->button_link??'' !!}" class="custom_btn">
                            {!! $hero_section['single']['button_name'] !!}
                        </a>
                    </div>
                </div>
                <div class="col-md-6 order-1 order-md-2">
                    <div class="image_area">
                        <img src="{{$hero_section['single']['media']->image?getFile($hero_section['single']['media']->image->driver,$hero_section['single']['media']->image->path):''}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
