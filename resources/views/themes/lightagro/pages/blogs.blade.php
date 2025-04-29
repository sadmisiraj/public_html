@extends(template().'layouts.app')
@section('title', trans('Blogs'))

@section('content')
    <!-- blog section  -->

            <section class="blog-section blog-details">
                <div class="container">
                    <div class="row g-lg-5 gy-5">
                        <div class="col-lg-8">
                            <div class="row g-4">
                                @foreach($blogs as $k => $data)
                                    <div class="col-12">
                                        <div class="blog-box">
                                            <div class="img-box">
                                                <img
                                                    src="{{getFile($data->blog_image_driver,$data->blog_image)}}"
                                                    class="img-fluid" alt="">
                                                <div class="date">
                                                    <span>{{dateTime(@$data->created_at,'d M, Y')}}</span>
                                                </div>
                                            </div>
                                            <div class="text-box">
                                                <div class="date-author">
                                                    <span><i class="fal fa-user-circle text-secondary"></i> {{optional($data->createdBy)->name??'Admin'}} </span>
                                                </div>
                                                <h4>
                                                    <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}"
                                                       class="blog-title"
                                                    >{{\Illuminate\Support\Str::limit(optional($data->details)->title,60)}}</a
                                                    >
                                                </h4>
                                                <p>
                                                    {{strip_tags(Illuminate\Support\Str::limit(strip_tags(optional($data->details)->description),220))}}
                                                </p>
                                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}"
                                                   class="btn-custom read-more"
                                                >@lang('read more')
                                                    <i class="fal fa-long-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="side-bar">
                                <div class="side-box">
                                    <h4>@lang('Recent Blogs')</h4>
                                    @foreach($blogs->take(3) as $key => $data)
                                        <div class="side-blog-box">
                                            <div class="img-box">
                                                <img class="img-fluid" src="{{getFile($data->blog_image_driver,$data->blog_image)}}" alt="">
                                            </div>
                                            <div class="text-box">
                                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="title">{{\Illuminate\Support\Str::limit(optional($data->details)->title,60)}} </a>
                                                <span class="date">{{dateTime($data->created_at,'d M, Y')}}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


@endsection
