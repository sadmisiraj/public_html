<section id="investor-history-section">
    <div class="overlay pt-150 pb-150">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-7">
                    <div class="section-header">
                        <h4 class="sub-title">{!! $know_more_section['single']['heading']??'' !!}</h4>
                        <h3 class="title">{!! $know_more_section['single']['sub_heading']??'' !!}</h3>
                        <p class="area-para">{!! $know_more_section['single']['short_details']??'' !!}</p>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-md-center">
                @foreach(collect($know_more_section['multiple'])->toArray() as $k =>  $item)
                    <div class="col-lg-4 col-md-4 wow fadeInLeftBig">
                        <div class="single-item justify-content-center d-flex">
                            <div class="left-item">
                                <div class="icon-box">
                                    <img src="{{isset($item['media']->icon)? getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('know-more-us-image')">
                                </div>
                            </div>
                            <div class="right-area">
                                <span class="number">{{$item['information']??''}}</span>
                                <p>{!! $item['title']??'' !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
