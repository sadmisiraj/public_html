<!-- Testimonial section start -->
<section class="testimonial-section">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-4 d-none d-lg-block" data-aos="fade-up" data-aos-duration="500">
                <div class="left-side">
                    <div class="img-box">
                        <img src="{{isset($testimonial_section['single']['media']->image)?getFile($testimonial_section['single']['media']->image->driver,$testimonial_section['single']['media']->image->path):''}}" alt="testimonial section image">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="right-side">
                    <div class="text-center text-md-start">
                        <div class="section-subtitle" data-aos="fade-up" data-aos-duration="500">
                            {{$testimonial_section['single']['heading']??''}}
                        </div>
                        <h2 class="section-title" data-aos="fade-up" data-aos-duration="700">
                            {{$testimonial_section['single']['sub_heading']??''}}
                        </h2>
                        <p class="mt-10 mb-10 cmn-para-text" data-aos="fade-up" data-aos-duration="900">
                            {{$testimonial_section['single']['short_details']??''}}
                        </p>
                    </div>
                    <div class="owl-carousel owl-theme testimonial-carousel">
                        @foreach(collect($testimonial_section['multiple'])->toArray() as $item)
                            <div class="item" data-aos="fade-up" data-aos-duration="500">
                                <div class="testimonial-box">
                                    <ul class="reviews">
                                        <li>
                                            @if(isset($item['media']->rating) && $item['media']->rating)
                                                @for($i =1; $i <= $item['media']->rating; $i++)
                                                    <i class="active fa-solid fa-star"></i>
                                                @endfor

                                                @for($i =1; $i <= 5-$item['media']->rating; $i++)
                                                    <i class="fa-solid fa-star"></i>
                                                @endfor
                                            @endif
                                        </li>
                                    </ul>

                                    <div class="quote-area">
                                        <p>
                                            {!! strip_tags($item['description']??'') !!}
                                        </p>
                                    </div>
                                    <div class="profile-box">
                                        <div class="profile-thumbs">
                                            <img src="{{isset($item['media']->image)?getFile($item['media']->image->driver,$item['media']->image->path):''}}" alt="user image" />
                                        </div>
                                        <div class="profile-title">
                                            <h6 class="mb-0">{{$item['name']??''}}</h6>
                                            <p class="mb-0">{{$item['designation']??''}}</p>
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
<!-- Testimonial section end -->
