<section class="testimonial_area">
    <div class="container">
        <div class="row">
            <div class="section_content">
                <div class="section_header cmn_title text-start ">
                    <span class="section_category">{!! $testimonial_section['single']['title']??'' !!}</span>
                    <h2>{!! $testimonial_section['single']['sub_title']??'' !!}</h2>
                </div>
            </div>
            <div class="col-md-9 mx-auto d-flex justify-content-center">

            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme {{(session()->get('rtl') == 1) ? 'testimonial_carousel-rtl': 'testimonial_carousel'}}">
                @foreach(collect($testimonial_section['multiple'])->toArray() as $key => $data)
                    <div class="item">
                        <div class="card shadow1 mt-50 mb-50 ">
                            <p>{!! $data['description'] !!}</p>
                            <div class="client_comment d-flex align-items-center mt-20">
                                <div class="image_area">
                                    <img class="img-fluid" src="{{isset($data['media']->image)?getFile($data['media']->image->driver,$data['media']->image->path):''}}" alt="@lang('testimonial img')" />
                                </div>
                                <div class="text_area">
                                    <h5>{!! $data['name'] !!}</h5>
                                    <span>{!! $data['designation'] !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
