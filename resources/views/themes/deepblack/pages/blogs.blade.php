@extends(template().'layouts.app')
@section('title', trans('Blogs'))

@section('content')
    <section class="blog-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-text text-center">
                        <h5>{!! $blog['single']['heading']??'' !!}</h5>
                        <h2>{!! $blog['single']['sub_heading']??'' !!}</h2>
                        <p>{!! $blog['single']['short_text']??'' !!}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($blogs as $k => $data)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="blog-box">
                            <div class="img-box">
                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                    <img class="img-fluid"
                                         src="{{getFile($data->blog_image_driver,$data->blog_image)}}"
                                         alt="@lang('blog-image')">
                                </a>
                            </div>
                            <div class="text-box">
                                <span class="date">{{dateTime($data->created_at)}}</span>
                                <h4 class="title golden-text">
                                    <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                        {{\Illuminate\Support\Str::limit(optional($data->details)->title,60)}}
                                    </a>
                                </h4>
                                <p class="description">{{strip_tags(Illuminate\Support\Str::limit(strip_tags(optional($data->details)->description),120))}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
