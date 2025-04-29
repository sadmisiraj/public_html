@extends(template().'layouts.app')
@section('title',trans('Blog Details'))

@section('content')

    <!-- blog details section -->
    <section class="blog-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 pe-lg-5">
                    <div class="details-box">
                        <div class="img-box mb-4">
                            <img
                                src="{{getFile($blog->blog_image_driver,$blog->blog_image)}}" alt="@lang('blog details image')"
                                class="img-fluid rounded"
                            />
                        </div>
                        <div class="text-box">
                            <span class="date">{{dateTime($blog->created_at)}}</span>
                            <span class="author float-end">{{ucfirst(optional($blog->createdBy)->name??'Admin')}}</span>
                            <h4 class="title golden-text">
                                {!! $blogDetails->title !!}
                            </h4>
                            <p class="description">
                                {!! $blogDetails->description !!}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="recent-posts">
                        <h3 class="golden-text">{{trans('Recent Post')}}</h3>
                        @foreach($recentBlogs as $data)
                            <div class="recent-post-box d-flex align-items-center">
                                <div class="img-box">
                                    <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                        <img
                                            src="{{getFile($data->blog_image_driver,$data->blog_image)}}"
                                            alt="@lang('recenet blog img')"
                                            class="img-fluid rounded blog-img"
                                        />
                                    </a>
                                </div>
                                <div class="text-box">
                                    <h5 class="title golden-text">
                                        <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}"
                                        >{{\Str::limit(optional($data->details)->title,40)}}</a>
                                    </h5>
                                    <span class="date">{{dateTime($data->created_at)}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog details end -->

@endsection

@push('style')
    <style>
        .blog-img {
            margin-bottom: 11px;
            max-width: 120px;
            height: auto;
        }
        .text-box {
            margin-left: 17px;
        }

        .text-box .title a{
            font-size: 16px!important;
        }

    </style>
@endpush
