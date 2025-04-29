<!-- about_area_start -->
<section id="about_area" class="about_area">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6 order-2 order-lg-1">
                <div class="section_content">
                    <div class="section_header">
                        <div class="section_subtitle">{!! $about_section['single']['heading']??'' !!}</div>
                        <h1>{!! $about_section['single']['sub_heading']??'' !!}</h1>
                        <p>{!! $about_section['single']['description']??'' !!}</p>
                    </div>
                    <div class="button_area">
                        <a class="custom_btn mt-30 top-right-radius-0" href="{{ $about_section['single']['media']->button_url??'' }}">{!! $about_section['single']['button_name']??'' !!}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="image_area animation1">
                    <img class="img-fluid" src="{{isset($about_section['single']['media']->image)? getFile($about_section['single']['media']->image->driver,$about_section['single']['media']->image->path):''}}" width="576px" height="384px" alt="@lang('about image')">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about_area_end -->
