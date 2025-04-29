
<section class="faq-section">
    <div class="container">
        <div class="row g-4 g-lg-5 justify-content-center">
            <div class="col-lg-4">
                <div class="header-text">
                    <h3>{!! $faq_section['single']['heading']??'' !!}</h3>
                    <p class="mt-4 mb-5">
                        {!! $faq_section['single']['sub_heading']??'' !!}
                    </p>
                    <div class="mail-to">
                        {!! $faq_section['single']['short_text']??'' !!} <br>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="accordion" id="accordionExample">
                    @foreach(collect($faq_section['multiple'])->toArray() as $k => $data)
                        <div class="accordion-item">
                            <h5 class="accordion-header {{(session()->get('rtl') == 1) ? 'isRtl': ''}}" id="heading{{$k++}}">
                                <button
                                    class="accordion-button {{($k != 1) ? 'collapsed': '' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$k}}"
                                    aria-expanded="{{($k == 1) ? 'true' : 'false'}}"
                                    aria-controls="collapse{{$k}}"
                                >
                                    <span class="index">{{ $k < 10 ? '0'.$k : $k}}</span>
                                    {!! $data['question'] !!}
                                </button>
                            </h5>
                            <div
                                id="collapse{{$k}}"
                                class="accordion-collapse collapse {{($k == 1) ? 'show' : ''}}"
                                aria-labelledby="heading{{$k}}"
                                data-bs-parent="#accordionExample"
                            >
                                <div class="accordion-body">
                                    {!! $data['answer'] !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
