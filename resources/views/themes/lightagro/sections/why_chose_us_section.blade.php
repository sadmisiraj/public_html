<!-- feature section -->
<section class="feature-section">
    <div class="container">
        <div class="row">
            <div class="header-text text-center">
                <h5>{!! $why_chose_us_section['single']['heading']??'' !!}</h5>
                <h3>{!! $why_chose_us_section['single']['sub_heading']??'' !!}</h3>
                <p class="mx-auto">{!! $why_chose_us_section['single']['short_text']??'' !!}</p>
            </div>
        </div>

        <div class="row g-4 g-lg-5">
            @foreach(collect($why_chose_us_section['multiple'])->toArray() as $item)
                <div class="col-lg-6 col-md-6">
                    <div class="feature-box" >
                        <div class="icon-box">
                            <img src="{{$item['media']->image?getFile($item['media']->image->driver,$item['media']->image->path):''}}" alt=""/>
                        </div>
                        <div class="text-box">
                            <h4>{!! $item['title'] !!}</h4>
                            <p>
                                {!! $item['short_description'] !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
