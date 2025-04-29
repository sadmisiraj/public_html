<!-- How it works section start -->
<section class="how-it-works-section">
    <div class="container">
        <div class="row gx-4 gy-0 align-items-center text-center text-md-start">
            <div class="col-md-6">
                <div class="section-subtitle" data-aos="fade-up" data-aos-duration="500">{{$how_works_section['single']['heading']??''}}</div>
                <h2 class="section-title" data-aos="fade-up" data-aos-duration="700">
                    {{$how_works_section['single']['sub_heading']??''}}
                </h2>
            </div>
            <div class="col-md-6">
                <p class="mb-0" data-aos="fade-up" data-aos-duration="900">
                    {{$how_works_section['single']['short_details']??''}}
                </p>
            </div>
        </div>
        <div class="mt-30">
            <div class="row g-4">
                <div class="col-12" data-aos="fade-up" data-aos-duration="900">
                    <div class="large-img-box">
                        <img src="{{isset($how_works_section['single']['media']->image)?getFile($how_works_section['single']['media']->image->driver,$how_works_section['single']['media']->image->path):''}}" alt="how work section image" />
                    </div>
                </div>
                <div class="col-12 mt-50">
                    <div class="row g-4">
                        @foreach(collect($how_works_section['multiple'])->toArray() as $key=>$item)
                            <div class="col-md-6" data-aos="fade-up" data-aos-duration="{{($key+1)%2 == 0?"900":"700"}}">
                                <div class="cmn-box">
                                    <div class="img-box">
                                        <img src="{{isset($item['media']->image)?getFile($item['media']->image->driver,$item['media']->image->path):''}}" alt="" />
                                    </div>
                                    <div class="text-box">
                                        <h5 class="mb-2">{!! $item['title']??'' !!}</h5>
                                        <p class="mb-0">
                                            {!! $item['short_description']??'' !!}
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
<!-- How it works section end -->
