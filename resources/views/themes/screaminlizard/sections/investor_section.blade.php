<section class="top-investor">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="header-text text-center">
                    <h5>{!! $investor_section['single']['heading']??'' !!}</h5>
                    <h3>{!! styleSentence($investor_section['single']['sub_heading']??null,3) !!}  </h3>
                    <p class="mx-auto">
                        {!! $investor_section['single']['short_details']??'' !!}
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div
                    class="investor-wrapper {{(session()->get('rtl') == 1) ? 'investors-rtl': 'investors'}} owl-carousel">
                    @foreach($investors->take(4) as $user)
                        <div class="investor-box">
                            <div class="img-box">
                                <img src="{{getFile($user->image_driver,$user->image) }}" class="img-fluid"
                                     alt="@lang('Investor Image Missing')"/>
                            </div>
                            <div class="text-box">
                                <h5>@lang($user->username)</h5>
                                <h6 class="title">@lang('Investor')</h6>
                                <h4>@lang('Invested'): {{currencyPosition($user->total_invest+0)}}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
