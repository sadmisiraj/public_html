<section id="faq_area" class="faq_area">
    <div class="container">
        <div class="section_header">
            <span class="section_category">{!! $faq_section['single']['title']??'' !!}</span>
            <h2>{!! $faq_section['single']['sub_title']??'' !!}</h2>
            <p>{!! $faq_section['single']['short_details']??'' !!}</p>
        </div>
        <div class="row pt-md-5">
            <div class="col-md-8 order-2 ">
                <div class="accordion_area">
                    <div class="accordion" id="accordionExample">
                        @foreach(collect($faq_section['multiple'])->toArray() as $k => $data)
                            <div class="accordion-item shadow1">
                                <h2 class="accordion-header {{(session()->get('rtl') == 1) ? 'isRtl': ''}}" id="headingOne{{$k}}">
                                    <button class="accordion-button {{($k != 0) ? 'collapsed': '' }}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne{{$k}}" aria-expanded="{{($k == 0) ? 'true' : 'false'}}" aria-controls="collapseOne{{$k}}">
                                        {!! $data['title']??'' !!}
                                    </button>
                                </h2>
                                <div id="collapseOne{{$k}}" class="accordion-collapse collapse {{($k == 0) ? 'show' : ''}}" aria-labelledby="headingOne{{$k}}"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!! $data['description']??''!!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
