<!-- statistics area start -->
<section class="achievement-section">
    <div class="container">
        <div class="row g-4 align-items-center justify-content-evenly">
            @foreach(collect($feature_section['multiple']) as $feature)

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="achievement-box" data-aos="fade-up" data-aos-duration="800"
                         data-aos-anchor-placement="center-bottom">
                        <div class="icon-box">
                            <img src="{{getFile($feature['media']->icon->driver,$feature['media']->icon->path)}}" alt="@lang('feature image')" />
                        </div>

                        <h4><span class="counter">{{$feature['media']->count}}</span></h4>
                        <h5>{{$feature['countable_item_name']}}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
