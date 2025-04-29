<!-- statistics_area_start -->
<section class="statistics_area">
    <div class="container">
        <div class="row g-5">
            @foreach(collect($feature_section['multiple'])->toArray() as $feature)

                <div class="col-lg-4 col-sm-6">
                    <div class="card statistics_card text-center shadow2">
                        <div class="image_area">
                            <img src="{{$feature['media']->icon?getFile($feature['media']->icon->driver,$feature['media']->icon->path):''}}" alt="@lang('feature image')" />
                        </div>
                        <div class="text_area">
                            <h3 class="mt-40">{!! $feature['information'] !!}</h3>
                            <h6>{!! $feature['title'] !!}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
