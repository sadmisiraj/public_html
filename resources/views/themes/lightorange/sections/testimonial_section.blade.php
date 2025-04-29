

<section id="testmonial-section">
    <div class="overlay pt-150 pb-150">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-10">
                    <div class="section-header">
                        <h4 class="sub-title">{!! $testimonial_section['single']['heading']??'' !!}</h4>
                        <h3 class="title">{!! $testimonial_section['single']['sub_heading']??'' !!}</h3>
                        <p class="area-para">{!! $testimonial_section['single']['short_details']??'' !!}</p>
                    </div>
                </div>
            </div>
            <div class=" {{(session()->get('rtl') == 1) ? 'testmonial-carousel-rtl': 'testmonial-carousel'}} wow fadeInUp">
                @foreach(collect($testimonial_section['multiple'])->toArray() as $key => $data)
                    <div class="col">
                        <div class="single-item">
                            <div class="top-area d-flex align-items-center">
                                <img
                                    src="{{isset($data['media']->image)?getFile($data['media']->image->driver,$data['media']->image->path):''}}"
                                    class="testmonial-img-circle" alt="@lang('testimonial image')">
                                <div class="text-area">
                                    <h2>{!! $data['name']??'' !!}</h2>
                                    <p>{!! $data['designation']??'' !!}</p>
                                </div>
                            </div>
                            <div class="bottom-area">
                                <p><span>“</span>{!! $data['description']??'' !!}<span>”</span></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
