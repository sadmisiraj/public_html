<!-- BLOG -->
<section id="blog">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="heading-container">
                    <h6 class="topheading">{!! $blog_section['single']['heading']??'' !!}</h6>
                    <h3 class="heading">{!! $blog_section['single']['sub_heading']??'' !!}</h3>
                    <p class="slogan">{!! $blog_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>

        <div class="blog-wrapper">
            <div class="row">
                @foreach($blogs as $k => $data)
                    <div class="col-md-6 col-lg-4">
                        <a class="card-blog card wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.15s"
                           href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                            <div class="fig-container">
                                <img
                                    src="{{getFile($data->blog_image_driver ,$data->blog_image)}}"
                                    alt="Image Missing">
                            </div>
                            <h5 class="h5 mt-5 mb-5">{{\Illuminate\Support\Str::limit(optional($data->details)->title,40)}}</h5>
                            <p class="text">
                                @lang(\Illuminate\Support\Str::limit(strip_tags(optional($data->details)->description), 120))
                            </p>
                            <div class="date-wrapper colorbg-1">
                                <h4 class="font-weight-medium fontubonto">{{dateTime($data->created_at,'d')}}</h4>
                                <h4 class="font-weight-medium fontubonto">{{dateTime($data->created_at,'M')}}</h4>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- /BLOG -->

