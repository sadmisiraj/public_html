<section id="blog-section">
    <div class="overlay pt-150 pb-150">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-10">
                    <div class="section-header">
                        <h4 class="sub-title">{!! $blog_section['single']['heading']??'' !!}</h4>
                        <h3 class="title">{!! $blog_section['single']['sub_heading']??'' !!}</h3>
                        <p class="area-para">{!! $blog_section['single']['short_details']??'' !!}</p>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-md-center">
                @foreach($blogs as $k => $data)
                    <div class="col-lg-4 col-md-6 wow fadeInUp">
                        <div class="single-item">
                            @if($k%2 !== 0)
                                <div class="img-area">
                                    <img
                                        src="{{getFile($data->blog_image_driver ,$data->blog_image)}}"
                                        alt="@lang('blog-image')" style="">
                                </div>
                            @endif
                            <div class="text-area">
                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                    <h2 class="font-weight-bold">{{\Illuminate\Support\Str::limit(@$data->details->title,40)}}</h2>
                                </a>
                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                    <p class="color-two">
                                        @lang(\Illuminate\Support\Str::limit(strip_tags(@$data->details->description), 120))
                                    </p>
                                </a>
                                <div class="icon-area d-flex justify-content-between">
                                    <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                        <i class="icofont-user-alt-4"></i> {{trans('Posted by - '.optional($data->createdBy)->name??'Admin')}}
                                    </a>
                                    <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                        <i class="icofont-calendar"></i>
                                        {{dateTime(@$data->created_at,'d M Y')}}
                                    </a>
                                </div>
                            </div>
                            @if($k%2 == 0)
                                <div class="img-area">
                                    <img
                                        src="{{getFile($data->blog_image_driver ,$data->blog_image)}}"
                                        alt="@lang('blog-image')" style="">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- blog end -->

