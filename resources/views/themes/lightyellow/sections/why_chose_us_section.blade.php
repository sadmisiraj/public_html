<section class="service_area">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="section_header">
                    <span class="section_category">{!! $why_chose_us_section['single']['title']??'' !!}</span>
                    <h2 class="">{!! $why_chose_us_section['single']['sub_title']??'' !!}</h2>
                    <p class="mt-3">{!! $why_chose_us_section['single']['short_details']??'' !!}</p>
                    <a class="custom_btn mt-30"
                       href="{!! $why_chose_us_section['single']['media']->button_link??'' !!}">
                        {!! $why_chose_us_section['single']['button_name']??'' !!}
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-4">
                    <div class="col-sm-6">
                        @foreach(collect($why_chose_us_section['multiple'])->toArray() as $key => $item)
                            @if($key == 0)
                                <div class="single_card_area pt-100 pb-3">
                                    <div class="card shadow1">
                                        <div class="card_body">
                                            <div class="image_area mb-4">
                                                <img class="img-center" src="{{$item['media']->icon?getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('why-choose-us image')" />
                                            </div>
                                            <h5 class="card-title pb-3">{!! $item['title'] !!}</h5>
                                            <p class="card-text pb-2">{!! $item['information'] !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($key%2 == 0 && $key != 0 && $key < 4)
                                <div class="single_card_area pb-3">
                                    <div class="card shadow1">
                                        <div class="card_body">
                                            <div class="image_area mb-4">
                                                <img class="img-center" src="{{$item['media']->icon?getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('why-choose-us image')" />
                                            </div>
                                            <h5 class="card-title pb-3">{!! $item['title'] !!}</h5>
                                            <p class="card-text pb-2">{!! $item['information'] !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="col-sm-6">
                        @foreach(collect($why_chose_us_section['multiple'])->toArray() as $key => $item)
                            @if($key%2 != 0  && $key < 4)
                                <div class="single_card_area pb-3">
                                    <div class="card shadow1">
                                        <div class="card_body">
                                            <div class="image_area mb-4">
                                                <img class="img-center" src="{{$item['media']->icon?getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('why-choose-us image')" />
                                            </div>
                                            <h5 class="card-title pb-3">{!! $item['title'] !!}</h5>
                                            <p class="card-text pb-2">{!! $item['information'] !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
