

<!-- home section -->
<section class="home-section" style="background-image: url({{$hero_section['single']['media']->background_image?getFile($hero_section['single']['media']->background_image->driver,$hero_section['single']['media']->background_image->path):''}}) !important;">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-lg-8">
                <div class="text-box text-center">
                    <h5 class="my-4">{!! $hero_section['single']['heading']??'' !!}</h5>
                    <h1>{!! $hero_section['single']['sub_heading']??'' !!}</h1>
                    <div class="d-flex align-items-center justify-content-center mt-5">
                        <a class="btn-custom cursor-pointer" href="{{$hero_section['single']['media']->button_link??''}}">{!! $hero_section['single']['button_name']??'' !!}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
