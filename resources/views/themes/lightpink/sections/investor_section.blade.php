<section class="investor_area">
    <div class="container">
        <div class="row">
            <div class="section_header mb-50 text-center text-sm-start">
                <div class="section_subtitle">{!! $investor_section['single']['heading']??'' !!}</div>
                <h1>{!! $investor_section['single']['sub_heading']??'' !!}</h1>
                <p class="para_text">{!! $investor_section['single']['short_details']??'' !!}</p>
            </div>
        </div>
        <div class="row {{(session()->get('rtl') == 1) ? 'investors-rtl': 'investors'}}">
            @foreach($investors->take(4) as $user)
                <div class="col-lg-3 col-sm-6">
                    <div class="cmn_box3 box1">
                        <div class="cmn_icon3 icon1">
                            <img src="{{getFile($user->image_driver,$user->image) }}"
                                 alt="@lang('Investor Image Missing')">
                        </div>
                        <div class="team_details mt-40 text-center pb-15 ">
                            <h5 class="">@lang($user->username)</h5>
                            <p>@lang('Invest')
                                : {{currencyPosition($user->total_invest+0)}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
