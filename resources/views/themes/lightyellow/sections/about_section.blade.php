<section id="about_area" class="about_area">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="image_area">
                    <img class="img-fluid" src="{{$about_section['single']['media']->image?getFile($about_section['single']['media']->image->driver,$about_section['single']['media']->image->path):''}}" width="576px" height="384px" alt="@lang('about image')"/>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section_content">
                    <div class="section_header">
                        <span class="section_category">{!! $about_section['single']['title'] !!}</span>
                        <h2>{!! $about_section['single']['sub_title']??'' !!}</h2>
                        <p>{!! $about_section['single']['description']??'' !!}</p>
                    </div>
                    <div class="button_area">
                        <a class="custom_btn mt-30" href="{{ $about_section['single']['media']->button_link??'' }}">{!! $about_section['single']['button_name']??'' !!}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
