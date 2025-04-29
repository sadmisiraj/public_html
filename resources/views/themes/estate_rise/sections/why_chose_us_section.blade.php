<!-- Why choose us section start -->
<section class="why-choose-us-section">
    <div class="container">
        <div class="row gx-4 gy-0 align-items-center text-center text-md-start">
            <div class="col-md-6">
                <div class="section-subtitle" data-aos="fade-up" data-aos-duration="500">{{$why_chose_us_section['single']['heading']??''}}</div>
                <h2 class="section-title" data-aos="fade-up" data-aos-duration="700">
                    {{$why_chose_us_section['single']['sub_heading']??''}}
                </h2>
            </div>
            <div class="col-md-6">
                <p class="mb-0" data-aos="fade-up" data-aos-duration="900">
                    {{$why_chose_us_section['single']['short_details']??''}}
                </p>
            </div>
        </div>
        <div class="mt-30">
            <div class="row g-4">
                <div class="col-12" data-aos="fade-up" data-aos-duration="900">
                    <div class="large-img-box">
                        <img src="{{isset($why_chose_us_section['single']['media']->image)?getFile($why_chose_us_section['single']['media']->image->driver,$why_chose_us_section['single']['media']->image->path):''}}" alt="">
                    </div>
                </div>
                <div class="col-12 mt-lg-5 mt-4">
                    <div class="row g-4">
                        @foreach(collect($why_chose_us_section['multiple'])->toArray() as $key => $item)
                            <div class="col-md-6" data-aos="fade-up" data-aos-duration="{{($key+1)%2 == 0?"900":"700"}}">
                                <div class="cmn-box">
                                    <div class="img-box">
                                        <img src="{{isset($item['media']->image)?getFile($item['media']->image->driver,$item['media']->image->path):''}}" alt="">
                                    </div>
                                    <div class="text-box">

                                        <h5 class="mb-2">{{$item['title']??''}}</h5>
                                        <p class="mb-0">
                                            {{$item['short_description']??''}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Why choose us section end -->
