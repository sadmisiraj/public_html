<!-- about section -->
<section class="about-section">
    <div class="container">
        <div class="row g-lg-5 justify-content-between">
            <div class="col-lg-6">
                <div class="img-box">
                    <img src="{{$about_section['single']['media']->image_1?getFile($about_section['single']['media']->image_1->driver,$about_section['single']['media']->image_1->path):''}}" alt="" class="img-fluid img-1" data-aos="fade-right" data-aos-duration="800" data-aos-anchor-placement="center-bottom" />
                    <img src="{{$about_section['single']['media']->image_2?getFile($about_section['single']['media']->image_2->driver,$about_section['single']['media']->image_2->path):''}}" alt="" class="img-fluid img-2" data-aos="fade-up" data-aos-duration="1000" data-aos-anchor-placement="center-bottom" />
                    <div class="icon">
                        <img src="{{$about_section['single']['media']->image_3?getFile($about_section['single']['media']->image_3->driver,$about_section['single']['media']->image_3->path):''}}" alt="" class="img-fluid" data-aos="fade-left" data-aos-duration="1200" data-aos-anchor-placement="center-bottom" />
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="header-text mb-4">
                    <h5>{!! $about_section['single']['heading']??'' !!}</h5>
                    <h2 class="mb-4">{!! $about_section['single']['sub_heading']??'' !!}</h2>
                </div>
                <p>
                    {!! $about_section['single']['description']??'' !!}
                </p>

                <a href="{{ $about_section['single']['media']->button_link??'' }}" class="btn-custom mt-4">{!! $about_section['single']['button_name']??'' !!}</a>
            </div>
        </div>
    </div>
</section>
