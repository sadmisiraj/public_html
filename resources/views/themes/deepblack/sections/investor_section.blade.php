<section class="investor-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text text-center">
                    <h5>{!! $investor_section['single']['heading']??'' !!}</h5>
                    <h3>{!! $investor_section['single']['sub_heading']??'' !!}</h3>
                    <p>
                        {!! $investor_section['single']['short_text']??'' !!}
                    </p>
                </div>
            </div>
        </div>
        <div class="{{(session()->get('rtl') == 1) ? 'investors-rtl': 'investors'}} owl-carousel">
            @foreach($investors as $item)
                <div class="investor-box">
                    <div class="img-box">
                        <img class="img-fluid" src="{{getFile($item->image_driver,$item->image) }}" alt="@lang('Investor Image Missing')" />
                    </div>
                    <div class="text-box">
                        <h4 class="golden-text">@lang($item->username)</h4>
                        <span>@lang('Investor')</span>
                        <h3 class="amount golden-text">@lang('Invest'): {{currencyPosition($item->total_invest)}}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
