<section class="investor-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-text text-center">
                    <h5>{!! $investor_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $investor_section['single']['sub_heading']??'' !!}</h2>
                    <p>{!! $investor_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="investors owl-carousel {{(session()->get('rtl') == 1) ? 'investors-rtl': 'investors'}}">
                    @foreach($investors->take(4) as $user)
                        <div class="investor-box">
                            <div class="img-box">
                                <img src="{{getFile($user->image_driver,$user->image) }}" alt="@lang('Investor Image Missing')" />
                            </div>
                            <div class="text-box">
                                <h5>@lang($user->username)</h5>
                                <span>@lang('Investor')</span>
                                <h4>@lang('Invest'): {{currencyPosition($user->total_invest+0)}}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
