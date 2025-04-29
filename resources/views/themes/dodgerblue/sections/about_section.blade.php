<!-- about section -->
<section class="about-section">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6">
                <div class="header-text mb-5">
                    <h5>{!! $about_section['single']['heading']??'' !!}</h5>
                    <h2 class="mb-4">{!! $about_section['single']['sub_heading']??'' !!}</span></h2>
                </div>
                <p>
                    {!! $about_section['single']['description']??'' !!}
                </p>
                <a href="{{ $about_section['single']['media']->button_link??'' }}" class="btn-custom mt-4">{!! $about_section['single']['button_name']??'' !!}</a>
            </div>
            <div class="col-lg-6" {{(session()->get('rtl') == 1) ? 'pe-md-5': 'ps-md-5'}}>
                <div class="img-box">
                    <img src="{{$about_section['single']['media']->image?getFile($about_section['single']['media']->image->driver,$about_section['single']['media']->image->path):''}}" alt="@lang('about image')" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
