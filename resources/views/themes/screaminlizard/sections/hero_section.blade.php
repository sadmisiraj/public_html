
<style>
    .home-section::before {
        content: "";
        width: 100%;
        height: 100%;
        position: absolute ;
        background: var(--black);
        background-image: url({{isset($hero_section['single']['media']->background_image)?getFile($hero_section['single']['media']->background_image->driver,$hero_section['single']['media']->background_image->path):''}}) !important;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -1;
    }

</style>
<!-- home section -->
<section class="home-section">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-lg-7">
                <div class="text-box">
                    <h5 class="text-white my-4">{!! $hero_section['single']['heading']??'' !!}</h5>
                    <h1>{!! styleSentence($hero_section['single']['sub_heading']??null,4) !!}</h1>
                    <div class="d-flex align-items-center mt-5">
                        <a class="btn-custom text-dark" href="{{$hero_section['single']['media']->button_link??''}}" target="_blank">{!! $hero_section['single']['button_name']??'' !!}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="countings">
                    @foreach(collect($hero_section['multiple']) as $feature)
                        <div class="box">
                            <h3>{!! $feature['information'] !!}</h3>
                            <h5>{!! $feature['title'] !!}</h5>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

