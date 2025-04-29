<header id="hero" style="background-image: linear-gradient(90deg, rgba(7, 11, 40, 0.8) 0%, rgba(7, 11, 40, 0.8) 100%), url({{isset($hero_section['single']['media']->image)? getFile($hero_section['single']['media']->image->driver,$hero_section['single']['media']->image->path):''}});">
    <div class="container">
        <div class="d-flex align-content-center justify-content-center">
            <div class="col-md-8">
                <div class="hero-content h-100 text-center">
                    <h1 class="h1 wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay="0.4s">{!! $hero_section['single']['heading']??'' !!}</h1>
                    <h1 class="h1 mt-10 mb-25 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                        {!! $hero_section['single']['sub_heading']??'' !!}
                    </h1>
                    <h6 class="h6 mb-20 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                        {!! $hero_section['single']['short_details']??'' !!}
                    </h6>
                    <a class="btn-hero mt-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.8s"
                       href="{{$hero_section['single']['media']->button_link??''}}">
                        <span>{{$hero_section['single']['button_name']??''}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
