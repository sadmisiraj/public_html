<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text text-center">
                    <h5>{{$about_section['single']['heading']}}</h5>
                    <h2>{{$about_section['single']['sub_heading']}}</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="img-box">
                    <img class="img-fluid" src="{{$about_section['single']['media']->image?getFile($about_section['single']['media']->image->driver,$about_section['single']['media']->image->path):''}}" width="576px" height="384px" alt="@lang('about image')"/>
                </div>
            </div>
            <div class="col-md-6 {{(session()->get('rtl') == 1) ? 'pe-md-5': 'ps-md-5'}}">
                <div class="text-box">
                    <p>
                        {!! $about_section['single']['description'] !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
