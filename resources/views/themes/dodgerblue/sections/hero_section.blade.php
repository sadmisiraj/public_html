<!-- home section -->
<section class="home-section" style="background-image: url({{isset($hero_section['single']['media']->background_image)?getFile($hero_section['single']['media']->background_image->driver,$hero_section['single']['media']->background_image->path):''}}) !important;background-size: cover;background-position: center;background-repeat: no-repeat;">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-lg-7">
                <div class="text-box">
                    <h5 class="my-4">{!! $hero_section['single']['heading']??'' !!}</h5>
                    <h1>{!! $hero_section['single']['sub_heading']??'' !!}</h1>
                    <div class="d-flex align-items-center mt-5">
                        <a class="btn-custom text-white" href="{{$hero_section['single']['media']->button_link??''}}" target="_blank">{!! $hero_section['single']['button_name']??'' !!}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="countings">
                    @foreach(collect($hero_section['multiple'])->toArray() as $feature)
                        <div class="box">
                            <h3>{{$feature['item']}}</h3>
                            <h5>{{$feature['item_name']}}</h5>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
