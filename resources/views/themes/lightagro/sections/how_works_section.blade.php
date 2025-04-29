<section class="how-it-works @if(session()->get('rtl') == 1) rtl @endif">
    <div class="container">
        <div class="row">
            <div class="col-lg-6"></div>

            <div class="col-lg-6">
                <div class="header-text">
                    <h5>{!! $how_works_section['single']['heading']??'' !!}</h5>
                    <h3>{!! $how_works_section['single']['sub_heading']??'' !!}</h3>
                </div>

                <div class="work-box-wrapper">
                    @foreach(collect($how_works_section['multiple'])->toArray() as $k =>  $item)
                        <div class="work-box" data-aos="fade-left" data-aos-duration="800"
                             data-aos-anchor-placement="center-bottom">
                            <div class="number">
                                <h3>0{{ ++$k }}</h3>
                            </div>
                            <div class="text">
                                <h4>{!! $item['title'] !!}</h4>
                                <p>{!! $item['short_description'] !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <div class="img-box-wrapper">
        <div class="img-box">
            <img src="{{$how_works_section['single']['media']->image_1?getFile($how_works_section['single']['media']->image_1->driver,$how_works_section['single']['media']->image_1->path):''}}" class="img-fluid" alt=""/>
            <div class="icon">
                <img src="{{$how_works_section['single']['media']->image_2?getFile($how_works_section['single']['media']->image_2->driver,$how_works_section['single']['media']->image_2->path):''}}" alt=""/>
            </div>
        </div>
    </div>
</section>
