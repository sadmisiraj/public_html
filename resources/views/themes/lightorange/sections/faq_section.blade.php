<section id="faq-section">
    <div class="overlay pt-150 pb-150">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-10">
                    <div class="section-header">
                        <h4 class="sub-title">{!! $faq_section['single']['heading']??'' !!}</h4>
                        <h3 class="title">{!! $faq_section['single']['sub_heading']??'' !!}</h3>
                        <p class="area-para">{!! $faq_section['single']['short_details']??'' !!}</p>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content mb-30-none" id="myTabContentFaq">
                        <div class="tab-pane fade show active wow fadeInUp" id="basicarea" role="tabpanel"
                             aria-labelledby="basic-tab">
                            <div id="basic" class="accordion">
                                @foreach(collect($faq_section['multiple'])->toArray() as $k => $data)
                                    <div class="card card-rounded">
                                        <div class="card-header" id="faq{{$k}}">
                                            <a href="#"
                                               class="btn btn-header-link {{($k == 0) ? '' : 'collapsed'}}"
                                               data-toggle="collapse" data-target="#faq1{{$k}}"
                                               aria-expanded="true"
                                               aria-controls="faqbasic1{{$k}}">{!! $data['title']??'' !!}</a>
                                        </div>
                                        <div id="faq1{{$k}}" class="collapse {{($k == 0) ? 'show' : ''}}"
                                             aria-labelledby="faq{{$k}}" data-parent="#basic">
                                            <div class="card-body ">
                                                {{strip_tags($data['description']??'')}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
