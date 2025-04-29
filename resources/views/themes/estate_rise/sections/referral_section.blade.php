<!-- Referral section start -->
<section class="referral-section">
    <div class="container">
        <div class="referral-section-top text-center text-md-start">
            <div class="row g-4 align-items-center">
                <div class="col-md-5">
                    <div class="section-subtitle" data-aos="fade-up" data-aos-duration="500">{{$referral_section['single']['heading']??''}}</div>
                    <h2 class="mb-10" data-aos="fade-up" data-aos-duration="700">
                        {{$referral_section['single']['sub_heading']??''}}
                    </h2>
                    <p class="mb-0" data-aos="fade-up" data-aos-duration="900">
                        {{$referral_section['single']['short_details']??''}}
                    </p>
                </div>
                <div class="col-md-7" data-aos="fade-up" data-aos-duration="1100">
                    <div class="img-box">
                        <img src="{{isset($referral_section['single']['media']->image)?getFile($referral_section['single']['media']->image->driver,$referral_section['single']['media']->image->path):''}}" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mt-lg-5 mt-4 justify-content-center">
            @if(isset($referralLevel))
                @php($aos_durration=300)
                @foreach($referralLevel as $k => $data)
                    @php($aos_durration+=200)
                    <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-duration="{{$aos_durration}}">
                <div class="referral-box">
                    <div class="img-box">
                        <img src="{{template(true).'img/referral/save-money.png'}}" alt="" />
                    </div>
                    <div class="text-box">
                        <h5>@lang('level') {{ $data->level < 10 ? '0'.$data->level : $data->level}}</h5>
                        <h3 class="mb-0"><span class="level1">{{$data->percent}}</span>%</h3>
                    </div>
                </div>
            </div>
                @endforeach
            @endif

        </div>
    </div>
</section>
<!-- Referral section end -->
