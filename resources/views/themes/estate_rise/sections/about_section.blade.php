<!-- About section start -->
<section class="about-section">
    <div class="container">
        <div class="row g-4 g-sm-5 align-items-center">
            <div class="col-md-6">
                <div class="img-box" data-aos="fade-up" data-aos-duration="500">
                    <img src="{{isset($about_section['single']['media']->image)?getFile($about_section['single']['media']->image->driver,$about_section['single']['media']->image->path):''}}" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-content">
                    <div class="section-subtitle" data-aos="fade-up" data-aos-duration="700">{{$about_section['single']['heading']??''}}</div>
                    <h2 class="section-title" data-aos="fade-up" data-aos-duration="900">
                        {{$about_section['single']['sub_heading']??''}}
                    </h2>

                    <p data-aos="fade-up" data-aos-duration="1100">
                        {{strip_tags($about_section['single']['short_details_1']??'')}}
                    </p>
                    <p data-aos="fade-up" data-aos-duration="1300">
                        {{strip_tags($about_section['single']['short_details_2']??'')}}
                    </p>

                    <div class="btn-area mt-30" data-aos="fade-up" data-aos-duration="1500">
                        <a href="{{$about_section['single']['media']->button_link??''}}" class="cmn-btn"><span>{{$about_section['single']['button_name']??''}}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- About section end -->
