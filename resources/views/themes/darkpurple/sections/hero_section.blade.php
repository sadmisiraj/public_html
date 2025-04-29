
<!-- home section -->
<section class="home-section">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-lg-7">
                <div class="text-box">
                    <h5 class="my-4">{!! $hero_section['single']['heading']??'' !!}</h5>
                    <h1>{!! $hero_section['single']['sub_heading']??'' !!}</h1>
                    <div class="d-flex align-items-center mt-5">
                        <a href="{!! $hero_section['single']['button_url']??'' !!}" class="btn-custom">{!! $hero_section['single']['button_name']??'' !!}</a>
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
