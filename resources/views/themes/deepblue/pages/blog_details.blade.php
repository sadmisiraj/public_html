@extends(template().'layouts.app')
@section('title',trans('Blog Details'))

@section('content')

    <!-- BLOG -->
    <section id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card-blog card wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.35s">
                        <div class="fig-container">
                            <img class="br-4 w-fill" src="{{getFile($blog->blog_image_driver,$blog->blog_image)}}" alt="@lang('blog details image')">
                        </div>
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between w-fill mt-15 mb-15">
                                <p class="text">{{trans('Posted by - '.optional($blog->createdBy)->name??'Admin')}}</p>
                                <p class="text">{{dateTime($blog->created_at)}}</p>
                            </div>

                            <h5 class="h5 mb-15 mt-15">{!! $blogDetails->title !!}</h5>
                            <div class="paragraph mb-10">
                                {{strip_tags($blogDetails->description)}}
                            </div>


                        </div>
                    </div>


                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="sidebar-wrapper wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.7s">
                            <h6 class="h6 mb-20">{{trans('Recent Post')}}</h6>
                            <div class="recent-post">
                                @foreach($recentBlogs as $data)
                                    <a class="media align-items-center" href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                        <div class="media-img">
                                            <img class="br-4" src="{{getFile($data->blog_image_driver,$data->blog_image)}}"
                                                 alt="@lang('recenet blog img')">
                                        </div>
                                        <div class="media-body ml-15">
                                            <p class="text hover-text">{{\Str::limit(optional($data->details)->title,40)}}</p>
                                            <p class="text">{{dateTime($data->created_at)}}</p>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /BLOG -->

@endsection
