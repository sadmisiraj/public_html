<!-- testimonial section -->
<section class="testimonial-section">
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-text text-center">
                        <h5>{!! $testimonial_section['single']['heading']??'' !!}</h5>
                        <h2>{!! $testimonial_section['single']['sub_heading']??'' !!}</h2>
                        <p class="mx-auto">{!! $testimonial_section['single']['short_text']??'' !!}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="testimonial-wrapper">
                        <div
                            class="testimonials {{(session()->get('rtl') == 1) ? 'client-testimonials-rtl': 'client-testimonials'}} owl-carousel">
                            @foreach(collect($testimonial_section['multiple'])->toArray() as $key => $data)
                                <div class="review-box">
                                    <div class="img-box">
                                        <img src="{{isset($data['media']->image)?getFile($data['media']->image->driver,$data['media']->image->path):''}}" alt=""/>
                                    </div>
                                    <div class="text">
                                        <img class="quote" src="{{ asset(template(true).'img/icon/quote.png') }}" alt=""/>
                                        <p>
                                            {!! $data['description'] !!}
                                        </p>
                                        <h4>{!! $data['name'] !!}</h4>
                                        <span class="title">{!! $data['designation'] !!}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
