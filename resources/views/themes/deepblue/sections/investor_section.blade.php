<!-- INVESTOR -->
<section id="investor">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="heading-container">
                    <h6 class="topheading">{!! $investor_section['single']['heading']??'' !!}</h6>
                    <h3 class="heading">{!! $investor_section['single']['sub_heading']??'' !!}</h3>
                    <p class="slogan">{!! $investor_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>

        <div class="carousel-container wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.15s">
            <div class="{{(session()->get('rtl') == 1) ? 'carousel-investor-rtl': 'carousel-investor'}} owl-carousel owl-theme">
                @foreach($investors as $user)
                    <div class="item-carousel">
                        <div class="card align-items-center">
                            <div class="investor-fig">
                                <div class="img-container">
                                    <img class="img-circle" src="{{getFile($user->image_driver,$user->image) }}"
                                         alt="@lang('Investor Image Missing')">
                                </div>
                            </div>
                            <h5 class="h5 font-weight-medium mt-25">{!! $user->username !!}</h5>
                            <p class="text">@lang('Investor') </p>
                            <hr class="hr mt-20 mb-20">
                            <p class="text themecolor text-uppercase mb-10">@lang('Invest'): {{currencyPosition($user->total_invest+0)}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- /INVESTOR -->
