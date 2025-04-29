<section class="why-choose-us">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-text text-center">
                    <h5>{!! $why_chose_us_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $why_chose_us_section['single']['sub_heading']??'' !!}</h2>
                    <p>{!! $why_chose_us_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach(collect($why_chose_us_section['multiple'])->toArray() as $key => $item)
                <div class="col-md-6">
                    <div
                        class="box"
                        data-aos="fade-up"
                        data-aos-duration="1000"
                        data-aos-anchor-placement="center-bottom"
                    >
                        <div class="icon-box">
                            <img src="{{isset($item['media']->icon)?getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('why-choose-us image')" />
                        </div>
                        <div class="text-box">
                            <h4>{!! $item['title'] !!}</h4>
                            <p>
                                {!! $item['information'] !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
