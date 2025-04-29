<!-- why choose us start -->
<section class="feature-section">
    <div class="container">
        <div class="row">
            <div class="header-text text-center">
                <h5>{!! $why_chose_us_section['single']['heading']??'' !!}</h5>
                <h3>{!! styleSentence($why_chose_us_section['single']['sub_heading']??null,2) !!}  </h3>
                <p class="mx-auto">
                    {!! $why_chose_us_section['single']['short_details']??'' !!}
                </p>
            </div>
        </div>
        <div class="row g-4 g-lg-5">
            @foreach(collect($why_chose_us_section['multiple'])->toArray() as $item)
                <div class="col-lg-6 col-md-6">
                    <div class="feature-box">
                        <div class="icon-box">
                            <img src="{{isset($item['media']->icon)? getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('why-choose-us image')"/>
                        </div>
                        <div class="text-box">
                            <h4>{!! $item['title']??'' !!}</h4>
                            <p>
                                {!! $item['information']??'' !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- why choose us end -->
