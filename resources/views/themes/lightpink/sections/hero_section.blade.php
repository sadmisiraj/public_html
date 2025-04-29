<!-- Hero_area_start -->
<style>
    .hero_area {
        margin-top: -190px;
        background: linear-gradient(90deg,  {{hex2rgba(primaryColor(),0.8)}} 0, {{hex2rgba(secondaryColor(),0.9)}} 100%), url({{isset($hero_section['single']['media']->background_image)? getFile($hero_section['single']['media']->background_image->driver,$hero_section['single']['media']->background_image->path):''}});
        background-size: 100% 100%;
        background-position: center;
        position: relative;
    }
</style>
<div class="hero_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="hero_text_area">
                    <div class="section_header">
                        <h1>{!! $hero_section['single']['heading']??'' !!}</h1>
                        <p>{!! $hero_section['single']['sub_heading']??'' !!}</p>
                    </div>
                    <div class="btn_area mb-30">
                        <a href="{{$hero_section['single']['media']->button_url??''}}" class="custom_btn custom_btn2" target="_blank">{!! $hero_section['single']['button_name']??'' !!}
                            </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-lg-block d-none">
                <div class="hero_image_area animation1">
                    <img src="{{isset($hero_section['single']['media']->image)? getFile($hero_section['single']['media']->image->driver,$hero_section['single']['media']->image->path):''}}" alt="@lang('hero image')">
                </div>
            </div>
        </div>
    </div>
    <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ffffff" fill-opacity="1" d="M0,128L40,138.7C80,149,160,171,240,176C320,181,400,171,480,144C560,117,640,75,720,90.7C800,107,880,181,960,224C1040,267,1120,277,1200,256C1280,235,1360,181,1400,154.7L1440,128L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path>
    </svg>
</div>
<!-- Hero_area_end -->
