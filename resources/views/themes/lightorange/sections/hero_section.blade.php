<section id="banner-section" class="wow">
    <div class="overlay bg_img">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9">
                    <h2 class="banner-text title text-center">
                        <span class="light">{!! $hero_section['single']['heading']??'' !!}</span>
                        <span class="medium">{!! $hero_section['single']['sub_heading']??'' !!}</span>
                        {{-- <span>TO THE NEXT LEVEL</span> --}}
                    </h2>
                    <div class="text-bottom text-center">
                        <p>{!! $hero_section['single']['short_details']??'' !!}</p>
                        <a class="linear-btn" href="{{$hero_section['single']['media']->button_url??''}}">{{$hero_section['single']['button_name']??''}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- calculator-section start -->
<section id="calculator-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10 wow fadeInLeft">
                <div class="calculate-left">
                    <div class="d-flex">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- calculator-section end -->
