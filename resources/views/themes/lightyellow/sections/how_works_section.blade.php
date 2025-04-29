<section class="how_we_work_area">
    <div class="container">
        <div class="row">
            <div class="section_header text-center mb-50">
                <span class="section_category">{!! $how_works_section['single']['title']??'' !!}</span>
                <h2 class="mb-10">{!! $how_works_section['single']['sub_title']??'' !!}</h2>
                <p>{!! $how_works_section['single']['short_details']??'' !!}</p>
            </div>
        </div>
        <div class="row gy-5">
            @foreach(collect($how_works_section['multiple'])->toArray() as $k =>  $item)
                <div class="col-md-3">
                    <div class="item text-center">
                        <div class="image_area">
                            <img src="{{$item['media']->icon?getFile($item['media']->icon->driver,$item['media']->icon->path):''}}" alt="@lang('how-it-work-image')">
                        </div>
                        <div class="text_area mt-30">
                            <h5>{!! $item['title']??'' !!}</h5>
                            <p>{!! $item['short_description']??'' !!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
