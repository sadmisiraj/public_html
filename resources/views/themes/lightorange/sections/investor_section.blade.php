<section id="top-investor-section">
    <div class="overlay pt-150 pb-150">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-10">
                    <div class="section-header">
                          <h4 class="sub-title">{!! $investor_section['single']['heading']??'' !!}</h4>
                         <h3 class="title">{!! $investor_section['single']['sub_heading']??'' !!}</h3>
                        <p class="area-para">{!! $investor_section['single']['short_details']??'' !!}</p>

                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-md-center">
                @foreach($investors as $user)
                    <div class="col-lg-3 col-md-6 justify-content-center wow fadeInLeft mb-3">
                        <div class="single-item text-center">
                            <img src="{{getFile($user->image_driver,$user->image) }}"
                                 alt="@lang('Investor Image Missing')" class="investor-img-circle">
                            <div class="text-area text-center">
                                <h2 class="title">{{$user->username}}</h2>
                                <p>@lang('Investor')</p>
                            </div>
                            <div class="icon-area">
                                @lang('Invest'): {{currencyPosition($user->total_invest+0)}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- INVESTOR -->
