@extends(template().'layouts.app')
@section('title',trans('Blog Details'))

@section('content')
    <!-- Blog details section start -->
    <section class="blog-details-section">
        <div class="container">
            <div class="row g-4 g-sm-5">
                <div class="col-lg-7 order-2 order-lg-1">
                    <div class="blog-box-large">
                        <div class="thumbs-area">
                            <img src="{{getFile($blog->blog_image_driver,$blog->blog_image)}}" alt="EstateRise">
                        </div>
                        <div class="content-area mt-20">
                            <ul class="meta mb-15">
                                <li class="item">
                                    <a href="javascript:void(0)"><span class="icon"><i class="fa-regular fa-user"></i></span>
                                        <span>@lang('by') {{optional($blog->createdBy)->name??trans('Admin')}}</span></a>
                                </li>
                            </ul>
                            <h3 class="blog-title">
                                {!! $blogDetails->title !!}
                            </h3>

                            <div class="para-text">
                                {!! $blogDetails->description !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2">
                    <div class="blog-sidebar">
                        <div class="sidebar-widget-area">
                            <div class="widget-title">
                                <h4>@lang('Search')</h4>
                            </div>
                            <form action="{{route('blogs')}}" method="get">
                                <div class="search-box">
                                    <input type="text" name="title" class="form-control" placeholder="@lang('Search here')">
                                    <button type="submit" class="search-btn"><i class="far fa-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="sidebar-widget-area">
                            <div class="sidebar-categories-area">
                                <div class="categories-header">
                                    <div class="widget-title">
                                        <h4>@lang('Categories')</h4>
                                    </div>
                                </div>
                                <ul class="categories-list">
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{route('category.blogs',$category->id)}}"><span>{{$category->name}}</span> <span class="highlight">({{count($category->blog??[])}})</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget-area">
                            <div class="widget-title">
                                <h4>@lang('Recent Post')</h4>
                            </div>
                            @foreach($recentBlogs as $data)
                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="sidebar-widget-item">
                                    <div class="image-area">
                                        <img src="{{getFile($data->blog_image_driver,$data->blog_image)}}" alt="EstateRise">
                                    </div>
                                    <div class="content-area">
                                        <div class="title">{{\Str::limit(optional($data->details)->title,40)}}</div>
                                        <div class="widget-date">
                                            <i class="fa-regular fa-calendar-days"></i> {{dateTime($data->created_at)}}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog details Section End -->
@endsection
