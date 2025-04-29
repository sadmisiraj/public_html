<section class="statistics_area">
    <div class="container">
        <div class="col">
            <div class="header-text text-center">
                <h5>{!! $know_more_section['single']['title']??'' !!}</h5>
                <h2 class="mb-2">{!! $know_more_section['single']['sub_title']??'' !!}</h2>
                <p class="mb-5">{!! $know_more_section['single']['short_details']??'' !!}</p>
            </div>
        </div>
        <div class="row g-5">
            @foreach(collect($know_more_section['multiple'])->toArray() as $k =>  $item)
                <div class="col-lg-4 col-sm-6">
                    <div class="card statistics_card text-center shadow2">
                        <div class="image_area">
                            <img src="{{$item['media']->icon?getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('know-more-us-image')" />
                        </div>
                        <div class="text_area">
                            <h3 class="mt-40">{!! $item['title']??'' !!}</h3>
                            <h6>{!! $item['information'] !!}</h6>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
