@extends(template().'layouts.app')
@section('title',trans('Blog Details'))

@section('content')
    <!-- blog details  -->
    <section class="blog-section blog-details">
        <div class="container">
            <div class="row g-lg-5 g-4">
                <div class="col-lg-8">
                    <div class="blog-box">
                        <div class="img-box">
                            <img src="{{getFile($blog->blog_image_driver,$blog->blog_image)}}" class="img-fluid" alt="">
                            <div class="date">
                                <span>{{dateTime($blog->created_at)}}</span>
                            </div>
                        </div>
                        <div class="text-box">
                            <div class="date-author">
                                <span><i class="fal fa-user-circle text-secondary"></i> {{optional($blog->createdBy)->name??'Admin'}} </span>
                            </div>
                            <h4 class="blog-title">{!! $blogDetails->title !!}</h4>

                            <p>
                                {!! $blogDetails->description !!}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="side-bar">
                        <div class="side-box">
                            <h4>@lang('Recent Blogs')</h4>
                            @foreach($recentBlogs as $data)
                                <div class="side-blog-box">
                                    <div class="img-box">
                                        <img class="img-fluid" src="{{getFile($data->blog_image_driver,$data->blog_image)}}" alt="">
                                    </div>
                                    <div class="text-box">
                                        <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="title"> {{\Str::limit(optional($data->details)->title,40)}} </a>
                                        <span class="date">{{dateTime($data->created_at)}}</span>
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
