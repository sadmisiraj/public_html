<section class="testimonial_area shape1">
    <div class="container">
        <div class="row">
            <div class="section_header mb-30 text-center text-sm-start">
                <span class="section_subtitle">{!! $testimonial_section['single']['heading']??'' !!}</span>
                <h1 class="">{!! $testimonial_section['single']['sub_heading']??'' !!}</h1>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme testimonial_carousel {{(session()->get('rtl') == 1) ? 'testimonial_carousel-rtl': 'testimonial_carousel'}}">
                @foreach(collect($testimonial_section['multiple'])->toArray() as $key => $data)
                    <div class="item mt-70">
                        <div class="cmn_box box1 custom_zindex shadow2">
                            <div class="cmn_icon icon1">
                                <img src="{{isset($data['media']->image)?getFile($data['media']->image->driver,$data['media']->image->path):''}}" alt="@lang('testimonial img')">
                            </div>
                            <div class="text_area  mt-20">
                                <div class="quote_area">
                                    <i class="fas fa-quote-left fa-2x"></i>
                                </div>
                                <h4 class="mt-20">{!! $data['name'] !!}</h4>
                                <p>{!! $data['description'] !!}</p>
                                <div class="quote_area ms-auto">
                                    <i class="fas fa-quote-right fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
