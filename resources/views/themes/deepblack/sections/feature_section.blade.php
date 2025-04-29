<section class="feature-section">
    <div class="container">
        <div class="row">
            @foreach(collect($feature_section['multiple'])->toArray() as $feature)
                <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div
                        class="box"
                        data-aos="fade-up"
                        data-aos-duration="800"
                        data-aos-anchor-placement="center-bottom"
                    >
                        <div class="img-box">
                            <img src="{{getFile($feature['media']->icon->driver,$feature['media']->icon->path)}}" alt="@lang('feature image')" />
                        </div>
                        <h2>{{$feature['information']}}</h2>
                        <h4>{{$feature['title']}}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
