
<section class="faq_area">
    <div class="container">
        <div class="row">
            <div class="section_header text-center">
                <div class="section_subtitle faq_section_subtitle">{!! $faq_section['single']['heading']??'' !!}</div>
                <h1>{!! $faq_section['single']['sub_heading']??'' !!}</h1>
                <p class="m-auto para_text">{!! $faq_section['single']['short_details']??'' !!}</p>
            </div>
        </div>
        <div class="row">
            @foreach(collect($faq_section['multiple'])->toArray() as $k => $data)
                <div class="col-md-12" data-aos="fade-left">
                    <div class="accordion_area mt-45">
                        <div class="accordion_item shadow3">
                            <button class="accordion_title">{!! $data['title']??'' !!}<i
                                    class="{{($k == 0) ? 'fa fa-minus': 'fa fa-plus' }}"></i></button>
                            <p class="accordion_body {{($k == 0) ? 'show' : ''}}">
                                {{strip_tags($data['description']??'')}}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
