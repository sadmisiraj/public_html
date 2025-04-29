<!-- blog section -->
<section class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-text text-center">
                    <h5>{!! $blog_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $blog_section['single']['sub_heading']??'' !!}</h2>
                    <p class="mx-auto">
                        {!! $blog_section['single']['short_text']??'' !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center g-4">
            @foreach($blogs->take(1) as $k => $data)
                <div class="col-lg-5 col-xl-6">
                    <div class="blog-box">
                        <div class="img-box">
                            <img src="{{getFile($data->blog_image_driver ,$data->blog_image)}}" class="img-fluid" alt="">
                        </div>
                        <div class="text-box">
                            <div class="date-author">
                                <span>{{optional($data->createdBy)->name??'Admin'}}</span>
                                <span>{{dateTime(@$data->created_at,'d M, Y')}}</span>
                            </div>
                            <h4>
                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="blog-title"
                                >{{\Illuminate\Support\Str::limit(optional($data->details)->title,60)}}</a
                                >
                            </h4>
                            <p>
                                @lang(\Illuminate\Support\Str::limit(strip_tags(optional($data->details)->description), 140))
                            </p>
                            <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="read-more"
                            >@lang('read more')
                                <i class="fal fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-lg-7 col-xl-6">
                @foreach($blogs->take(3)->sortDesc() as $k => $data)
                    <div class="blog-box d-flex">
                        <div class="img-box">
                            <img src="{{getFile($data->blog_image_driver ,$data->blog_image)}}" class="img-fluid"
                                 alt="">
                        </div>
                        <div class="text-box">
                            <div class="date-author">
                                <span>{{optional($data->createdBy)->name??'Admin'}}</span>
                                <span>{{dateTime(@$data->created_at,'d M, Y')}}</span>
                            </div>
                            <h4>
                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}"
                                   class="blog-title"
                                >{{\Illuminate\Support\Str::limit(optional($data->details)->title,60)}}</a
                                >
                            </h4>

                            <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="read-more"
                            >@lang('read more')
                                <i class="fal fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
