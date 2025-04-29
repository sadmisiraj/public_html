<section class="investor_area">
    <div class="container">
        <div class="row">
            <div class="section_content">
                <div class="section_header text-start text-center">
                    <span class="section_category">{!! $investor_section['single']['title'] !!}</span>
                    <h2 class="cmn_title mb-30">{!! $investor_section['single']['sub_title'] !!}</h2>
                    <p>{!! $investor_section['single']['short_details'] !!}</p>
                </div>
            </div>
        </div>

        <div class="row  mt-50">
            <div
                class="owl-carousel owl-theme investor_carousel {{(session()->get('rtl') == 1) ? 'investors-rtl': 'investors'}}">
                @foreach($investors->take(4) as $user)
                    <div class="item">
                        <div class="single_card_area p-2">
                            <div class="card shadow1">
                                <div class="card_body text-center">
                                    <div class="image_area mb-2">
                                        <img
                                            src="{{getFile($user->image_driver,$user->image) }}"
                                            alt="@lang('Investor Image Missing')"/>
                                    </div>
                                    <h4 class="card-title">@lang($user->username)</h4>
                                    <h6>@lang('Investor')</h6>
                                    <h3 class="mb-2 mt-3">@lang('Invest')
                                        : {{currencyPosition($user->total_invest+0)}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
