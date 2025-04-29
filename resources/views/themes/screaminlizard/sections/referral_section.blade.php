<!-- referral section -->
<section class="referral-section">
    <div class="container">
        <div class="row ">
            <div class="header-text text-center">
                <h5>{!! $referral_section['single']['heading']??null !!}</h5>
                <h2>{!! styleSentence($referral_section['single']['sub_heading']??null,0) !!}</h2>
                <p class="mx-auto">{!! $referral_section['single']['short_details']??null !!}</p>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($referralLevel as $k => $data)
                <div class="col-lg-4 col-md-6">
                    <div class="referral-box">
                        <h3 class="level">@lang('Level') <span class="text-stroke">{{$data->level}}</span></h3>
                        <h3 class="text-primary">{{$data->percent}}%</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
