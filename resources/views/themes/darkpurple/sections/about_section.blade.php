<section class="about-section">
    <div class="container">
        <div class="row gy-5 align-items-center">
            <div class="col-lg-6">
                <div
                    class="img-box"
                    data-aos="fade-right"
                    data-aos-duration="1000"
                    data-aos-anchor-placement="center-bottom"
                >
                    <img src="{{isset($about_section['single']['media']->image)?getFile($about_section['single']['media']->image->driver,$about_section['single']['media']->image->path):''}}" class="img-fluid" alt="@lang('about image')" />
                </div>
            </div>
            <div class="col-lg-6">
                <div
                    class="text-box"
                    data-aos="fade-left"
                    data-aos-duration="1000"
                    data-aos-anchor-placement="center-bottom"
                >
                    <div class="header-text">
                        <h5>{!! $about_section['single']['heading']??'' !!}</h5>
                        <h2>{!! $about_section['single']['sub_heading']??'' !!}</h2>
                    </div>
                    <p>{!! $about_section['single']['description']??'' !!} </p>
                    <a class="btn-custom mt-4" href="{{ $about_section['single']['media']->button_url??'' }}">{!! $about_section['single']['button_name']??'' !!}</a>
                </div>
            </div>
        </div>
    </div>
</section>
