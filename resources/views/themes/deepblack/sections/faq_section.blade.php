<section class="faq-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text text-center">
                    <h5>{!! $faq_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $faq_section['single']['sub_heading']??'' !!}</h2>
                    <p>{!! $faq_section['single']['short_text']??'' !!}</p>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="accordion" id="accordionExample">
                    @foreach(collect($faq_section['multiple'])->toArray() as $k => $data)
                        <div class="accordion-item mb-4">
                            <h4 class="accordion-header mb-0 {{(session()->get('rtl') == 1) ? 'isRtl': ''}}"
                                id="heading{{$k}}">
                                <button
                                    class="accordion-button {{($k != 0) ? 'collapsed': '' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$k}}"
                                    aria-expanded="{{($k == 0) ? 'true' : 'false'}}"
                                    aria-controls="collapse{{$k}}"
                                >
                                    {!! $data['question'] !!}
                                </button>
                            </h4>
                            <div id="collapse{{$k}}"
                                 class="accordion-collapse collapse {{($k == 0) ? 'show' : ''}}"
                                 aria-labelledby="heading{{$k}}"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>
                                        {!! $data['answer'] !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
