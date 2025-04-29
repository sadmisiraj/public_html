<section class="testimonial-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-text text-center">
                    <h5>{!! $testimonial_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $testimonial_section['single']['sub_heading']??'' !!}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="testimonials owl-carousel {{(session()->get('rtl') == 1) ? 'testimonial_carousel-rtl': 'testimonial_carousel'}}">
                    @foreach(collect($testimonial_section['multiple'])->toArray() as $key => $data)
                        <div class="review-box">
                            <div class="text">
                                <p>
                                    {!! $data['description'] !!}
                                </p>
                                <div class="quote">
                                    <img src="{{ asset(template(true).'img/icon/quote-2.png') }}"/>
                                </div>
                            </div>
                            <div class="top">
                                <img src="{{isset($data['media']->image)?getFile($data['media']->image->driver,$data['media']->image->path):''}}" alt="@lang('testimonial img')"/>
                                <div>
                                    <h4>{!! $data['name'] !!}</h4>
                                    <a class="organization" href="">{!! $data['designation'] !!}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
