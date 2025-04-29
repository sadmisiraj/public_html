<!-- Faq section start -->
<section class="faq-section">
    <div class="container">
        <div class="row g-4 g-sm-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-up" data-aos-duration="500">
                <div class="left-side">
                    <div class="img-box">
                        <img src="{{isset($faq_section['single']['media']->image)?getFile($faq_section['single']['media']->image->driver,$faq_section['single']['media']->image->path):''}}" alt="">
                    </div>
                    <div class="section-header mt-lg-5 mt-4 text-center text-lg-start">
                        <div class="section-subtitle" data-aos="fade-up" data-aos-duration="500">
                            {{$faq_section['single']['heading']??''}}
                        </div>
                        <h2 data-aos="fade-up" data-aos-duration="900">
                            {{$faq_section['single']['sub_heading']??''}}
                        </h2>
                        <p class="mb-0 cmn-para-text" data-aos="fade-up" data-aos-duration="1100">
                            {{$faq_section['single']['short_details']??''}}
                        </p>
                    </div>
                    <div class="d-flex justify-content-lg-start justify-content-center">
                        <a href="{{$faq_section['single']['media']->button_url??''}}" class="round-btn" data-aos="fade-up" data-aos-duration="1300">
                            <p class="mb-0">{{$faq_section['single']['button_name']??''}}</p>
                            <i class="fa-regular fa-arrow-up"></i>
                            <span></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faq-content">
                    <div class="accordion" id="accordionExample3">
                        @php($faq_duration=300)
                        @foreach(collect($faq_section['multiple'])->toArray() as $key=>$item)
                            @php($faq_duration+=200)
                            <div class="accordion-item" data-aos="fade-up" data-aos-duration="{{$faq_duration}}">
                                <h2 class="accordion-header" id="headin{{$key}}">
                                    <button class="accordion-button {{$key!=0?'collapsed':''}}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{$key}}" aria-expanded="true"
                                            aria-controls="collapse{{$key}}">
                                        {!! $item['question']??'' !!}
                                    </button>
                                </h2>
                                <div id="collapse{{$key}}" class="accordion-collapse collapse {{$key==0?'show':''}}"
                                     aria-labelledby="headin{{$key}}" data-bs-parent="#accordionExample3">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <p>
                                                {!! strip_tags($item['answer']??'') !!}
                                            </p>
                                        </div>
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
<!-- Faq section end -->
