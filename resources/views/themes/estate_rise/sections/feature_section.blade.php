<!-- Feature section start -->
<section class="feature-section">
    <div class="container">
        <div class="row gx-4 gy-0 align-items-center">
            <div class="col-md-6">
                <h2 class="section-title text-center text-md-start" data-aos="fade-up" data-aos-duration="500">
                    {{$feature_section['single']['title']??''}}
                </h2>
            </div>
            <div class="col-md-6">
                <p class="mb-0 text-center text-md-start" data-aos="fade-up" data-aos-duration="700">
                    {{$feature_section['single']['sub_title']??''}}
                </p>
            </div>
        </div>
        <div class="row g-4 mt-50">
            <div class="col-xl-6">
                <div class="row g-4">
                    @foreach(collect($feature_section['multiple'])->toArray() as $key => $feature)

                    <div class="col-sm-6">
                        <div class="feature-box" data-aos="fade-up" data-aos-duration="{{($key+1)%2 == 0?"700":"500"}}">
                            <div class="img-box">
                                <img src="{{isset($feature['media']->icon)?getFile($feature['media']->icon->driver,$feature['media']->icon->path):''}}" alt="">
                            </div>
                            <div class="text-box">
                                <h3 class="mb-0"><span class="all-members">{{$feature['media']->count??''}}</span>{{$feature['prefix']??''}}</h3>
                                <h5 class="mb-0 mt-2">{{$feature['countable_item_name']??''}}</h5>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            <div class="col-xl-6">
                <div class="right-side">
                    <div class="row g-4 h-md-100">
                        <div class="col-md-5 h-md-100 order-2 order-md-1">
                            <div class="d-flex flex-column h-md-100 gap-3">
                                <p class="mb-0" data-aos="fade-up" data-aos-duration="900">
                                    {{strip_tags($feature_section['single']['short_details']??'')}}
                                </p>
                                <div class="round-box-content mt-md-auto" data-aos="fade-up"
                                     data-aos-duration="900">
                                    <span class="curved-circle">{{$feature_section['single']['circle_title']??''}}</span>
                                    <div class="inner-icon">
                                        <i class="fa-light fa-arrow-up"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-7 h-md-100 order-1 order-md-2">
                            <div class="img-box h-md-100" data-aos="fade-up" data-aos-duration="1100">
                                <img class="h-md-100" src="{{isset($feature_section['single']['media']->image)?getFile($feature_section['single']['media']->image->driver,$feature_section['single']['media']->image->path):''}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Feature section end -->
