<!-- home banner -->
<section class="home-banner" style="background-image: url({{$hero_section['single']['media']->background_image?getFile($hero_section['single']['media']->background_image->driver,$hero_section['single']['media']->background_image->path):''}}) !important;">
    <div class="overlay h-100 pt-5">
        <div class="container h-100">
            <div class="row h-100 pt-5 align-items-center justify-content-around">
                <div class="col-lg-7">
                    <div class="text-box">
                        <h1>
                           {{$hero_section['single']['heading']??''}} <br />
                            <span>{{$hero_section['single']['sub_heading']??''}}</span>
                        </h1>
                        <p>{{$hero_section['single']['short_text']??''}}</p>
                        <a href="{{$hero_section['single']['media']->button_link??''}}" class="gold-btn">
                            {{$hero_section['single']['button_name']??''}}
                        </a>
                    </div>
                </div>
                <div
                    class="col-lg-5 text-right d-none d-lg-block animate__animated animate__bounce animate__delay-2s"
                >
                    <img src="{{$hero_section['single']['media']->image?getFile($hero_section['single']['media']->image->driver,$hero_section['single']['media']->image->path):''}}" alt="@lang('hero image')" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
</section>
