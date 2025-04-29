@extends(template().'layouts.app')
@section('title', trans('Blogs'))

@section('content')

    <!-- blog section  -->
    <section class="blog-section blog-details">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-text text-center">
                        <h5>{!! $blog['single']['heading']??'' !!}</h5>
                        <h2>{!! $blog['single']['sub_heading']??'' !!}</h2>
                        <p class="w-100"> {!! $blog['single']['short_details']??'' !!}</p>
                    </div>
                </div>
            </div>
            <div class="row g-lg-5 gy-5">
                <div class="col-lg-12">
                    <div class="row g-4 g-lg-5">
                        @foreach($blogs as $k => $data)
                            <div class="col-lg-4 col-md-4">
                                <div class="blog-box">
                                    <div class="img-box">
                                        <img src="{{getFile($data->blog_image_driver ,$data->blog_image)}}"
                                             class="img-fluid"
                                             alt="@lang('blog-image')"/>
                                    </div>
                                    <div class="text-box">
                                        <div class="date-author">
                                            <span>{{dateTime(@$data->created_at,'d M, Y')}}</span>
                                        </div>
                                        <h4>
                                            <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="text-white"
                                            >{{\Illuminate\Support\Str::limit(@$data->details->title,60)}}</a
                                            >
                                        </h4>
                                        <p>{{Illuminate\Support\Str::limit(strip_tags(@$data->details->description),120)}}</p>
                                        <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="read-more"
                                        >@lang('read more')
                                            <i class="fal fa-long-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
