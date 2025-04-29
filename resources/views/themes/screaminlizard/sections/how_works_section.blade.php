<section class="how-it-work @if(session()->get('rtl') == 1) rtl @endif">
    <div class="container">
        <div class="row">
            <div class="header-text text-center">
                <h5>{!! $how_works_section['single']['heading']??'' !!}</h5>
                <h2>{!! styleSentence($how_works_section['single']['sub_heading']??null,2) !!}</h2>
            </div>
        </div>
        <div class="row g-4 g-lg-5">
            <div class="col-lg-6">
                <div class="img-box">
                    <img src="{{isset($how_works_section['single']['media']->image)?getFile($how_works_section['single']['media']->image->driver,$how_works_section['single']['media']->image->path):''}}" alt="" class="img-fluid" />
                </div>
            </div>
            <div class="col-lg-6">
                @foreach(collect($how_works_section['multiple'])->toArray() as $k =>  $item)
                    <div class="process-box">
                        <h4>{!! $item['title'] !!}</h4>
                        <p>{!! $item['short_description'] !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

