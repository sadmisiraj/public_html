
<!-- INVESTMENT-PLAN -->
<section id="investment-plan">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="heading-container">
                    <h6 class="topheading">{!! $why_chose_us_section['single']['heading']??'' !!}</h6>
                    <h3 class="heading">{!! $why_chose_us_section['single']['sub_heading']??'' !!}</h3>
                    <p class="slogan">{!! $why_chose_us_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>

        <div class="investment-plan-wrapper">
            <div class="row">
                @foreach(collect($why_chose_us_section['multiple'])->toArray() as $item)
                    <div class="col-md-6">
                        <div class="card-type-1 card align-items-start wow fadeInLeft" data-wow-duration="1s"
                             data-wow-delay="0.15s">
                            <div class="media">
                                <div class="card-icon">
                                    <img
                                        src="{{isset($item['media']->icon)?getFile($item['media']->icon->driver,$item['media']->icon->path):''}}"
                                        alt="...">
                                </div>
                                <div class="media-body ml-20">
                                    <h5 class="mb-15">{!! $item['title'] !!}</h5>
                                    <p class="text">
                                        {!! $item['information'] !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- /INVESTMENT-PLAN -->
