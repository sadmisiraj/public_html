<section class="feature-section">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach(collect($feature_section['multiple'])->toArray() as $feature)
                <div class="col-md-6 col-lg-3">
                    <div
                        class="feature-box"
                        data-aos="fade-up"
                        data-aos-duration="1000"
                        data-aos-anchor-placement="center-bottom"
                    >
                        <div class="d-flex">
                            <div class="icon-box">
                                <img src="{{isset($feature['media']->icon)?getFile($feature['media']->icon->driver,$feature['media']->icon->path):''}}" alt="@lang('feature image')"/>
                            </div>
                            <h2>{!! $feature['information'] !!}</h2>
                        </div>
                        <h4>{!! $feature['title'] !!}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
