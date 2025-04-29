@extends(template().'layouts.app')
@section('title',trans('Blog Details'))

@section('content')

    <!-- blog section  -->
    <section class="blog-page blog-details">
        <div class="container">
            <div class="row g-lg-5">
                <div class="col-lg-8">
                    <div class="blog-box">
                        <div class="img-box">
                            <img src="{{getFile($blog->blog_image_driver,$blog->blog_image)}}" alt="@lang('blog details image')" class="img-fluid" alt="" />
                        </div>
                        <div class="text-box">
                            <div class="date-author">
                                <span><i class="far fa-calendar-alt"></i> {{dateTime($blog->created_at)}} </span>
                                <span><i class="far fa-user-circle"></i> {{ucfirst(optional($blog->createdBy)->name??'Admin')}}</span>
                            </div>
                            <a class="title"> {!! $blogDetails->title !!}</a>
                            <p>
                                {!! $blogDetails->description !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="side-bar">
                        <div class="side-box">
                            <h4>{{trans('Recent Post')}}</h4>
                            @foreach($recentBlogs as $data)
                            <div class="blog-box">
                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                    <div class="img-box">
                                        <img class="img-fluid" src="{{getFile($data->blog_image_driver,$data->blog_image)}}"
                                             alt="@lang('recenet blog img')" />
                                    </div>
                                </a>

                                <div class="text-box">
                                    <span class="date">{{dateTime($data->created_at)}}</span>
                                    <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="title">{{\Str::limit($data->details->title,40)}}</a>
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

