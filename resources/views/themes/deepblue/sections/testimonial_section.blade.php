<!-- TESTIMONIAL -->
<section id="testimonial">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="heading-container">
                    <h6 class="topheading">{!! $testimonial_section['single']['heading']??'' !!}</h6>
                    <h3 class="heading">{!! $testimonial_section['single']['sub_heading']??'' !!}</h3>
                    <p class="slogan">{!! $testimonial_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>

        <div class="slider-container wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.15s">
            <div class="d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="{{(session()->get('rtl') == 1) ? 'slider-testimonial-rtl': 'slider-testimonial'}}">
                        @foreach(collect($testimonial_section['multiple'])->toArray() as $key => $data)
                            <div class="slider-item">
                                <div class="testimonial-item">
                                    <div class="media align-items-center">
                                        <div class="client-fig">
                                            <img
                                                src="{{isset($data['media']->image)?getFile($data['media']->image->driver,$data['media']->image->path):''}}"
                                                alt="...">
                                        </div>
                                        <div class="media-body ml-20">
                                            <h6 class="h6 mb-5"> {!! $data['name'] !!}</h6>
                                            <p class="text">{!! $data['designation'] !!}</p>
                                        </div>
                                    </div>
                                    <p class="text fontubonto font-weight-medium mt-15">
                                        {!! $data['description'] !!}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="slider  {{(session()->get('rtl') == 1) ? 'slider-nav-rtl': 'slider-nav'}}">
                        @foreach(collect($testimonial_section['multiple'])->toArray() as $key => $data)
                            <div class="slider-nav-item">
                                <div class="testimonial-nav">
                                    <div class="slider-nav-center">
                                        <img
                                            src="{{isset($data['media']->image)?getFile($data['media']->image->driver,$data['media']->image->path):''}}"
                                            alt="...">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /TESTIMONIAL -->
