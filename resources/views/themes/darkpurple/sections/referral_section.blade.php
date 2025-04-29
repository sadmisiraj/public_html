<section class="referral-bonus">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-text text-center">
                    <h5>{!! $referral_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $referral_section['single']['sub_heading']??'' !!}</h2>
                    <p>{!! $referral_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            @if(isset($referralLevel))
            @foreach($referralLevel as $k => $data)
                <div class="col-lg-4 col-md-6">
                    <div class="box box{{$k+1}} {{(session()->get('rtl') == 1) ? 'isRtl': 'noRtl'}}" data-aos="fade-up" data-aos-duration="1000" data-aos-anchor-placement="center-bottom">
                        <div class="icon-box">
                            <img src="{{ asset(template(true).'img/icon-2.png') }}" alt="" />
                        </div>
                        <div class="text-box">
                            <h4>{{$data->percent}}%</h4>
                            <h5>@lang('level') {{$data->level}}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

