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
                @if(isset($blogs))
                @foreach($blogs as $k => $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-box"
                             data-aos-anchor-placement="top-center">
                            <div class="img-box">
                                <img src="{{getFile($data->blog_image_driver ,$data->blog_image)}}" class="img-fluid" alt=""/>
                                <div class="date">
                                    <span>{{dateTime($data->created_at,'d M, Y')}}</span>
                                </div>
                            </div>
                            <div class="text-box">
                                <div class="date-author">
                                    <span><i class="fal fa-user-circle text-secondary"></i> {{optional($data->createdBy)->name??'Admin'}} </span>
                                </div>
                                <h4>
                                    <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="blog-title">{{\Illuminate\Support\Str::limit(optional($data->details)->title,60)}}</a>
                                </h4>
                                <p> @lang(\Illuminate\Support\Str::limit(strip_tags(optional($data->details)->description), 120))</p>
                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="read-more"
                                >@lang('Read More')
                                    <i class="fal fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
            </div>

    </div>
</section>
