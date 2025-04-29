<!-- why choose us start -->
<section class="choose-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text text-center">
                    <h5>{{$why_chose_us_section['single']['heading']??''}}</h5>
                    <h2>{{$why_chose_us_section['single']['sub_heading']??''}}</h2>
                    <p>
                        {{$why_chose_us_section['single']['short_text']??''}}
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach(collect($why_chose_us_section['multiple'])->toArray() as $item)
                <div class="col-md-6 mb-4">
                    <div
                        class="box"
                        data-aos="fade-up"
                        data-aos-duration="800"
                        data-aos-anchor-placement="center-bottom"
                    >
                        <div class="img">
                            <img class="img-center" src="{{$item['media']->image?getFile($item['media']->image->driver,$item['media']->image->path):''}}" alt="@lang('why-choose-us image')" />
                        </div>
                        <div class="text">
                            <h4 class="golden-text">{!! $item['title'] !!}</h4>
                            <p>{!! $item['short_description'] !!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- why choose us end -->
