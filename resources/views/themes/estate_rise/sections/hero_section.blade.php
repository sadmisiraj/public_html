<!-- Hero section start -->
<div class="hero-section">
    <div class="container">
        <div class="hero-top">
            <div class="row g-4 align-items-center">
                <div class="col-md-2 d-none d-md-block">
                    <div class="left-img-box" data-aos="fade-up" data-aos-duration="500">
                        <img src="{{isset($hero_section['single']['media']->image_1)?getFile($hero_section['single']['media']->image_1->driver,$hero_section['single']['media']->image_1->path):''}}" alt="">
                        <a data-fancybox href="{{$hero_section['single']['media']->video_url??''}}"
                           class="video-play-btn"><i class="fa-solid fa-play"></i></a>
                        <svg class="star star1" xmlns="http://www.w3.org/2000/svg" version="1.1"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 500 500"
                             style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path
                                        d="m250 5 46.9 131.8 126.3-60-60 126.3L495 250l-131.8 46.9 60 126.3-126.3-60L250 495l-46.9-131.8-126.3 60 60-126.3L5 250l131.8-46.9-60-126.3 126.3 60z"
                                        opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="middle-text-box">
                        <h1 class="hero-title text-center mb-0" data-aos="fade-up" data-aos-duration="700">{{$hero_section['single']['heading']??''}}</h1>
                        <p class="hero-description mb-0" data-aos="fade-up" data-aos-duration="900">{{strip_tags($hero_section['single']['short_details']??'')}}</p>
                    </div>
                </div>
                <div class="col-md-2 d-none d-md-block">
                    <div class="right-img-box" data-aos="fade-up" data-aos-duration="1100">
                        <img src="{{isset($hero_section['single']['media']->image_2)?getFile($hero_section['single']['media']->image_2->driver,$hero_section['single']['media']->image_2->path):''}}" alt="">
                        <svg class="star star2" xmlns="http://www.w3.org/2000/svg" version="1.1"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 500 500"
                             style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                <g>
                                    <path
                                        d="m250 5 46.9 131.8 126.3-60-60 126.3L495 250l-131.8 46.9 60 126.3-126.3-60L250 495l-46.9-131.8-126.3 60 60-126.3L5 250l131.8-46.9-60-126.3 126.3 60z"
                                        opacity="1" data-original="#000000" class=""></path>
                                </g>
                            </svg>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-30">
                <a href="{{$hero_section['single']['media']->button_link??''}}" class="round-btn" data-aos="fade-up" data-aos-duration="1100">
                    <p class="mb-0">{{$hero_section['single']['button_name']??''}}</p>
                    <i class="fa-regular fa-arrow-up"></i>
                    <span></span>
                </a>
            </div>
        </div>
    </div>
    <div class="hero-bottom">
        <div class="img-box" data-aos="fade-up" data-aos-duration="500">
            <img src="{{isset($hero_section['single']['media']->image_3)?getFile($hero_section['single']['media']->image_3->driver,$hero_section['single']['media']->image_3->path):''}}" alt="">
        </div>
        <div class="img-box" data-aos="fade-up" data-aos-duration="700">
            <img src="{{isset($hero_section['single']['media']->image_4)?getFile($hero_section['single']['media']->image_4->driver,$hero_section['single']['media']->image_4->path):''}}" alt="">
        </div>
        <div class="img-box" data-aos="fade-up" data-aos-duration="900">
            <img src="{{isset($hero_section['single']['media']->image_5)?getFile($hero_section['single']['media']->image_5->driver,$hero_section['single']['media']->image_5->path):''}}" alt="">
        </div>
    </div>
</div>
<!-- Hero section end -->
