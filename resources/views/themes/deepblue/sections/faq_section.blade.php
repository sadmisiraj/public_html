<!-- FAQ -->
<section id="faq">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="heading-container">
                    <h6 class="topheading">{!! $faq_section['single']['heading']??'' !!}</h6>
                    <h3 class="heading">{!! $faq_section['single']['sub_heading']??'' !!}</h3>
                    <p class="slogan">{!! $faq_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>

        <div class="faq-wrapper">
            <div class="faq-accordion">
                @foreach(collect($faq_section['multiple'])->toArray() as $k => $data)
                    <div class="faq-card card">
                        <div class="card-header">
                            <button class="btn-faq rotate-icon">
                                {!! $data['title'] !!}
                            </button>
                        </div>
                        <div class="card-body {{($k == 0) ? 'preview' : ''}} ">
                            <div class="faq-content">
                                <p class="text">
                                    {{strip_tags($data['description'])}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- /FAQ -->

