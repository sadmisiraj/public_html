<!-- ABOUT-US -->
<section id="about-us">
    <div class="container">
        <div class="heading-container">
            <h6 class="topheading">{!! $about_section['single']['heading']??'' !!}</h6>
            <h3 class="heading">{!! $about_section['single']['sub_heading']??'' !!}</h3>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="wrapper d-flex justify-content-center justify-content-xl-start  wow fadeInLeft"
                     data-wow-duration="1s" data-wow-delay="0.35s">
                    <div class="d-flex position-relative">
                        <div class="about-fig">
                            <img src="{{isset($about_section['single']['media']->image)? getFile($about_section['single']['media']->image->driver,$about_section['single']['media']->image->path):''}}" alt="Image Missing">
                        </div>
                        <div class="about-overlay-fig">
                            <img class="img-fill" src="{{isset($about_section['single']['media']->image)? getFile($about_section['single']['media']->image->driver,$about_section['single']['media']->image->path):''}}" alt="Image Missing">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="d-flex align-items-center h-fill">
                    <div class="text-wrapper wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.35s">
                        <div class="about-feature mt-30 d-flex flex-column align-items-center align-items-l-start">
                            {!! $about_section['single']['description'] !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /ABOUT-US -->
