<section class="how_it_work_area shape3">
    <div class="container">
        <div class="row">
            <div class="section_header mb-50 text-center">
                <h1>{!! $how_works_section['single']['heading']??'' !!}</h1>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-7 order-2 order-lg-1">
                <div class="seciton_right cmn_scroll">
                    @foreach(collect($how_works_section['multiple'])->toArray() as $k =>  $item)
                        <div class="cmn_box2 box1 d-flex shadow3 flex-column flex-sm-row">
                            <span class="number">{{++$k}}</span>
                            <div class="text_area">
                                <h5>{!! $item['title'] !!}</h5>
                                <p>{!! $item['short_description'] !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5 order-1 order-lg-2 flex-column flex-sm-row">
                <div class="section_left">
                    <div class="image_area">
                        <img
                            src="{{isset($how_works_section['single']['media']->image)? getFile($how_works_section['single']['media']->image->driver,$how_works_section['single']['media']->image->path):''}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
