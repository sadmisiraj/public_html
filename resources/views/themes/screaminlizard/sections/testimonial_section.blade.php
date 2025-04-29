<!-- testimonial section -->
<section class="testimonial-section">
    <div class="overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="header-text">
                        <h5>{!! $testimonial_section['single']['heading']??'' !!}</h5>
                        <h3> {!! styleSentence($testimonial_section['single']['sub_heading']??null,3) !!} </h3>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="testimonial-wrapper">
                        <div
                            class="testimonials {{(session()->get('rtl') == 1) ? 'client-testimonials-rtl': 'client-testimonials'}} owl-carousel">
                            @foreach(collect($testimonial_section['multiple'])->toArray() as $key => $data)
                                <div class="review-box">
                                    <div class="text">
                                        <img class="quote" src="{{ asset(template(true).'img/icon/quote.png') }}"
                                             alt=""/>
                                        <p>
                                            {!! $data['description'] !!}
                                        </p>
                                        <div class="user-box">
                                            <div class="img">
                                                <img src="{{isset($data['media']->image)?getFile($data['media']->image->driver,$data['media']->image->path):''}}"
                                                     alt="@lang('testimonial img')"/>
                                            </div>
                                            <div class="text">
                                                <h5>{!! $data['name'] !!}</h5>
                                                <h6 class="title">{!! $data['designation'] !!}</h6>
                                            </div>
                                        </div>
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
