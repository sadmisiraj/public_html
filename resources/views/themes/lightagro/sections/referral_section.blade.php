<section class="referral-section">
    <div class="container">
        <div class="row">
            <div class="header-text text-center">
                <h5>{!! $referral_section['single']['heading']??'' !!}</h5>
                <h3>{!! $referral_section['single']['sub_heading']??'' !!}</h3>
                <p class="mx-auto">{!! $referral_section['single']['short_text']??'' !!}</p>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            @if(isset($referralLevel))
            @foreach($referralLevel as $k => $data)
                <div class="col-lg-4 col-md-6 box">
                    <div class="referral-box" data-aos="fade-up" data-aos-duration="800"
                         data-aos-anchor-placement="center-bottom">
                        <h4 class="level">@lang('Level') <span class="text-secondary">{{ $data->level < 10 ? '0'.$data->level : $data->level}}</span></h4>
                        <h4 class="percentage"><span class="counter">{{$data->percent}}</span>%</h4>
                    </div>
                </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
