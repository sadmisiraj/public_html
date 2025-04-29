<section class="affiliate_area">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="section_left">
                    <div class="image_area">
                        <img src="{{ $referral_section['single']['media']->image?getFile($referral_section['single']['media']->image->driver,$referral_section['single']['media']->image->path):'' }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section_right">
                    <div class="section_header">
                        <span class="section_category">{!! $referral_section['single']['title']??'' !!}</span>
                        <h2>{!! $referral_section['single']['sub_title']??'' !!}</h2>
                        <p>{!! $referral_section['single']['short_description']??'' !!}</p>
                    </div>
                    <ul class="refarel_list d-flex text-center justify-content-around mt-30 {{(session()->get('rtl') == 1) ? 'isRtl': 'noRtl'}}">
                        @foreach($referralLevel as $k => $data)
                            <li>
                                <div class="image_area">
                                    <img src="{{ asset(template(true).'img/profile.png') }}" alt="">
                                </div>
                                <div class="text_area mt-20">
                                    <h2 class="mb-0"><span class="affiliate_counter">{{$data->percent}}</span>%</h2>
                                    <h6>@lang('level') {{$data->level}}</h6>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{$referral_section['single']['media']->button_link??''}}"
                       class="custom_btn mt-30">{!! $referral_section['single']['button_name']??'' !!}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
