@extends(template().'layouts.app')
@section('title',trans('Blog Details'))

@section('content')
    <!-- blog details start -->
    <section id="blog-details-section" class="blog-details">
        <div class="overlay pt-150 pb-150">
            <div class="container">
                <div class="row mb-30-none">
                    <div class="col-lg-8 wow fadeInLeftBig">
                        <div class="blog-item mb-30">
                            <div class="image-area d-flex justify-content-between align-items-center">
                                <img src="{{getFile($blog->blog_image_driver,$blog->blog_image)}}" width="730px" height="475px" alt="@lang('blog details image')">
                            </div>
                            <div class="post d-flex flex-wrap">
                                <div class="single">
                                    <a href="javascript:void(0)">
                                        <i class="icofont-user-alt-4"></i>
                                        <span>{{trans('Posted by - '.optional($blog->createdBy)->name??'Admin')}}</span>
                                    </a>
                                </div>
                                <div class="single">
                                    <a href="javascript:void(0)">
                                        <i class="icofont-calendar"></i>
                                        <span>{{dateTime($blog->created_at)}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="blog-content-style color-two">
                                <h2 class="title-area">{!! $blogDetails->title !!}</h2>
                                <p class="area-para">  {!! $blogDetails->description !!}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-8 wow fadeInRightBig">
                        <div class="sidebar">
                            <div class="widget-box mb-30">
                                <h2 class="area-title">{{trans('Recent Post')}}</h2>
                                @foreach($recentBlogs as $data)
                                    <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                        <div class="single-area d-flex align-items-center">
                                            <img src="{{getFile($data->blog_image_driver,$data->blog_image)}}" width="80px" height="80px"
                                                 alt="{{@$data->details->title}}">
                                            <div class="right-area">
                                                <p class="area-para">{{\Str::limit($data->details->title,40)}}</p>
                                                <span>{{dateTime($data->created_at)}}</span>
                                            </div>
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
    <!-- blog details end -->


@endsection
