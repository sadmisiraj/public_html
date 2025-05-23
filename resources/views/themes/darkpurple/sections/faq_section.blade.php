<section class="faq-section faq-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="accordionExample">
                    @foreach(collect($faq_section['multiple'])->toArray() as $k => $data)
                        <div class="accordion-item">
                            <h5 class="accordion-header {{(session()->get('rtl') == 1) ? 'isRtl': ''}}" id="headingOne{{$k}}">
                                <button
                                    class="accordion-button {{($k != 0) ? 'collapsed': '' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne{{$k}}"
                                    aria-expanded="{{($k == 0) ? 'true' : 'false'}}"
                                    aria-controls="collapseOne{{$k}}">
                                    {!! $data['title']??'' !!}
                                </button>
                            </h5>
                            <div
                                id="collapseOne{{$k}}"
                                class="accordion-collapse collapse {{($k == 0) ? 'show' : ''}}"
                                aria-labelledby="headingOne{{$k}}"
                                data-bs-parent="#accordionExample"
                            >
                                <div class="accordion-body">
                                    {{strip_tags($data['description']??'')}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
