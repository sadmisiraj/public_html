<!-- FEATURE -->
<section id="feature">
    <div class="feature-wrapper">
        <div class="container">
            <div class="row">
                @foreach(collect($feature_section['multiple'])->toArray() as $feature)

                    <div class="col-md-4">
                        <div class="card-type-1 card wow fadeInUp" data-wow-duration="1s" data-wow-dealy="0.1s">
                            <div class="card-icon">
                                <img class="card-img-top" src="{{$feature['media']->icon? getFile($feature['media']->icon->driver,$feature['media']->icon->path):''}}" alt="....">
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">{{$feature['information']??''}}</h3>
                                <h5 class="card-text">{!! $feature['title']??'' !!}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
<!-- /FEATURE -->
