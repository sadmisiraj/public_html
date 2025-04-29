<!-- Feature_area_start -->
<section class="feature_area mt-5 mt-lg-0">
    <div class="container">
        <div class="row g-5 justify-content-center">
            @foreach(collect($feature_section['multiple'])->toArray() as $feature)
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="cmn_box box1 text-center custom_zindex shadow2">
                        <div class="cmn_icon icon1">
                            <img src="{{isset($feature['media']->icon)?getFile($feature['media']->icon->driver,$feature['media']->icon->path):''}}" alt="@lang('feature image')">
                        </div>
                        <h4 class="pt-50">{!! $feature['information']??'' !!}</h4>
                        <h5 class="">{!! $feature['title']??'' !!}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
