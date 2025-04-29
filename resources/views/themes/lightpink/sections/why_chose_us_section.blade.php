<section class="why_choose_investment shape1">
    <div class="container">
        <div class="row">
            <div class="section_header mb-50 text-center text-sm-start">
                <div class="section_subtitle">{!! $why_chose_us_section['single']['heading']??'' !!}</div>
                <h1>{!! $why_chose_us_section['single']['sub_heading']??'' !!}</h1>
                <p class="para_text">{!! $why_chose_us_section['single']['short_details']??'' !!}</p>
            </div>
        </div>
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <div class="section_left">
                    <div class="image_area animation1">
                        <img src="{{ template(true).'img/why_choose_investment/img.jpg' }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="seciton_right cmn_scroll">
                    @foreach(collect($why_chose_us_section['multiple'])->toArray() as $key => $item)
                        <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                            <span class="number">{{ ++$key }}</span>
                            <div class="image_area border1">
                                <img src="{{isset($item['media']->icon)?getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('why-choose-us image')">
                            </div>
                            <div class="text_area">
                                <h5>{!! $item['title']??'' !!}</h5>
                                <p>{!! $item['information']??'' !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
