@extends(template().'layouts.app')
@section('title', 'Blogs')

@section('content')


    <section class="blog_area shape1">
        <div class="container">
            <div class="row">
                <div class="section_header mb-50 text-center text-sm-start">
                    <div class="section_subtitle">{!! $blog['single']['heading']??'' !!}</div>
                    <h1>{!! $blog['single']['sub_heading']??'' !!}</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach($blogs as $k => $data)
                    <div class="col-lg-4 col-sm-6">
                        <div class="blog_box box1">
                            <div class="image_area">
                                <img src="{{getFile($data->blog_image_driver ,$data->blog_image)}}"
                                     alt="@lang('blog-image')">
                            </div>
                            <div class="text_area">
                                <h4><a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">{{\Illuminate\Support\Str::limit(optional($data->details)->title,60)}}</a></h4>
                                <span><a href=""><i class="fa fa-user"></i>@lang('Admin')</a></span>
                                <span><i class="fa-regular fa-clock"></i>{{dateTime(@$data->created_at,'d M, Y')}}</span>
                                <p class="pt-35 pb-35">
                                    @lang(\Illuminate\Support\Str::limit(strip_tags(optional($data->details)->description), 120))
                                </p>
                            </div>
                            <div class="btn_area d-flex justify-content-center">
                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="custom_btn bottom-right-radius-0">@lang('Read More')<i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="blog_area">
        <div class="container">
            <div class="row">
                <div class="section_content">
                    <div class="section_header text-center">
                        <span class="section_category">{!! $blog['single']['title']??'' !!}</span>
                        <h2>{!! $blog['single']['sub_title']??'' !!}</h2>
                        <p>{!! $blog['single']['short_details']??'' !!}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($blogs as $k => $data)
                    <div class="col-lg-4 col-sm-6 pt-50">
                        <div class="single_card_area shadow1">
                            <div class="card_header">
                                <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                    <img src="{{getFile($data->blog_image_driver ,$data->blog_image)}}" alt="@lang('blog-image')">
                                </a>
                            </div>
                            <div class="card_body pt-2">
                                <div class="blog_content">
                                    <div class="blog_date">
                                        <img src="{{ asset(template(true).'img/calendar.png') }}" alt="">{{dateTime($data->created_at,'d M, Y')}}
                                    </div>
                                    <h5 class="card-title pt-3 pb-2"><a class="blog_title" href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">{{\Illuminate\Support\Str::limit(optional($data->details)->title,60)}}</a></h5>
                                    <p class="card-text pb-2">
                                        @lang(\Illuminate\Support\Str::limit(strip_tags(optional($data->details)->description), 120))
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
