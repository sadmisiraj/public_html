<!-- Blog Section start -->
<section class="blog-section">
    <div class="container">
        <div class="row align-items-center text-center text-md-start">
            <div class="col-md-6">
                <div class="section-subtitle" data-aos="fade-up" data-aos-duration="500">{!! $blog_section['single']['heading']??'' !!}</div>
                <h2 data-aos="fade-up" data-aos-duration="700">{!! $blog_section['single']['sub_heading']??'' !!}</h2>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-duration="900">
                <p>
                    {!! $blog_section['single']['short_details']??'' !!}
                </p>
            </div>

        </div>
        <div class="mt-40">
            <div class="row g-4 g-lg-5">
                @foreach($blogs as $key => $data)
                    <div class="col-lg-6" data-aos="fade-up" data-aos-duration="{{($key+1)%2 == 0?"900":"700"}}">
                        <div class="blog-box">
                            <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                <div class="img-box">
                                    <img src="{{getFile($data->blog_image_driver ,$data->blog_image)}}" alt="">
                                </div>
                            </a>
                            <div class="text-box">
                                <h5 class="title">
                                    <a class="border-effect" href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                        {{\Illuminate\Support\Str::limit(optional($data->details)->title,80)}}
                                    </a>
                                </h5>
                                <ul class="meta">
                                    <li class="item">
                                        <a href="javascript:void(0)"><i class="fa-regular fa-user"></i> {{optional($data->createdBy)->name??trans('Admin')}}</a>
                                    </li>
                                    <li class="item">
                                        <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
                                        <span>{{dateTime($data->created_at,'d M, Y')}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Blog Section end -->
