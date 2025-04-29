<!-- top investor section -->
<section class="top-investor">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-text text-center">
                    <h5>{!! $investor_section['single']['heading']??'' !!}</h5>
                    <h3>{!! $investor_section['single']['sub_heading']??'' !!}</h3>
                    <p class="mx-auto">
                        {!! $investor_section['single']['short_text']??'' !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div
                    class="investor-wrapper {{(session()->get('rtl') == 1) ? 'investors-rtl': 'investors'}} owl-carousel">
                    @if(isset($investors))
                    @foreach($investors as $user)
                        <div class="investor-box">
                            <div class="img-box">
                                <img src="{{getFile($user->image_driver,$user->image) }}" class="img-fluid" alt="@lang('Investor Image Missing')"/>
                                <h6 class="title">@lang('Investor')</h6>
                            </div>
                            <div class="text-box">
                                <h6>@lang($user->username)</h6>
                                <h5>@lang('Invested') {{currencyPosition($user->total_invest+0)}}</h5>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
