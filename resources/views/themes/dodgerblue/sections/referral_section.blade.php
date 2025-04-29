<!-- referral section -->
<section class="referral-section">
    <div class="container">
        <div class="row ">
            <div class="header-text text-center">
                <h5>{!! $referral_section['single']['heading']??'' !!}</h5>
                <h3>{!! $referral_section['single']['sub_heading']??'' !!}</h3>
                <p class="mx-auto">{!! $referral_section['single']['short_text']??'' !!}</p>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($referralLevel as $k => $data)
                <div class="col-lg-4 col-md-6">
                    <div class="referral-box">
                        <h3 class="level">@lang('Level') <span class="text-stroke">{{ $data->level < 10 ? '0'.$data->level : $data->level}}</span></h3>
                        <h3 class="text-primary">{{$data->percent}}%</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
