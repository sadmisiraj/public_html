<section class="statistic-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text text-center">
                    <h5>{!! $know_more_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $know_more_section['single']['sub_heading']??'' !!}</h2>
                    <p>{!! $know_more_section['single']['short_text']??'' !!}</p>
                </div>
            </div>
        </div>
        <div class="row statistic-section">
            @foreach(collect($know_more_section['multiple'])->toArray() as $k =>  $item)
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                    <div
                        class="box"
                        data-aos="fade-up"
                        data-aos-duration="800"
                        data-aos-anchor-placement="center-bottom"
                    >
                        <div class="img-box">
                            <img src="{{getFile($item['media']->icon->driver,$item['media']->icon->path)}}" alt="@lang('know-more-us-image')">
                        </div>
                        <h4>{!! $item['title'] !!}</h4>
                        <h2><span class="counter">{{$item['media']->count}}</span></h2>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
