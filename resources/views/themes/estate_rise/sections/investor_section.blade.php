<!-- Investor section start -->
<section class="investor-section">
    <div class="container">
        <div class="investor-section-top">
            <div class="row g-4 align-items-center text-center text-md-start">
                <div class="col-md-5">
                    <div class="section-subtitle" data-aos="fade-up" data-aos-duration="500">{{$investor_section['single']['heading']??''}}</div>
                    <h2 class="mb-10" data-aos="fade-up" data-aos-duration="700">{{$investor_section['single']['sub_heading']??''}}</h2>
                    <p class="mb-0" data-aos="fade-up" data-aos-duration="900">
                        {{$investor_section['single']['short_details']??''}}
                    </p>
                </div>
                <div class="col-md-7" data-aos="fade-up" data-aos-duration="1100">
                    <div class="img-box">
                        <img src="{{isset($investor_section['single']['media']->image)?getFile($investor_section['single']['media']->image->driver,$investor_section['single']['media']->image->path):''}}" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <div class="investor-bottom-section mt-md-5 mt-4">
            <div class="row g-4">
                @if(isset($investors))
                    @php($duration = 300)
                    @foreach($investors as $user)
                        @php($duration+= 200)
                        <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-duration="{{$duration}}">
                            <div class="investor-box">
                                <div class="img-box">
                                    <img src="{{getFile($user->image_driver,$user->image) }}" alt="" />
                                </div>
                                <div class="text-box">
                                    <h5 class="investor">@lang('investor')</h5>
                                    <h5>@lang($user->username)</h5>
                                    <hr class="cmn-hr" />
                                    <h4 class="mb-0">@lang('Invest'): {{currencyPosition($user->total_invest+0)}}</h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Investor section end -->
