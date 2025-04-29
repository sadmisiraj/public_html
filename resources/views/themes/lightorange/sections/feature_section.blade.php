<section id="profit-deposited" class="pt-150 pb-150">
    <div class="container">
        <div class="row d-flex justify-content-md-center">
            @foreach(collect($feature_section['multiple'])->toArray() as $feature)
                <div class="col-lg-4 col-md-6 mb-md-4 wow fadeInLeft">
                    <div class="single-item text-center">
                        <div class="icon-area">
                            <img
                                src="{{$feature['media']->icon? getFile($feature['media']->icon->driver,$feature['media']->icon->path):''}}"
                                alt="@lang('feature image')">
                        </div>
                        <div class="number">
                            <span>{{$feature['information']??''}}</span>
                        </div>
                        <div class="title-area">
                            <h2 class="area-title">{{$feature['title']??''}}</h2>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
