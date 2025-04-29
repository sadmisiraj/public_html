@extends(template().'layouts.app')
@section('title', trans('Blogs'))

@section('content')
    <section class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-text text-center">
                    <h5>{!! $blog['single']['heading']??'' !!}</h5>
                    <h6>{!! $blog['single']['sub_heading']??'' !!}</h6>
                </div>
            </div>
        </div>
        <div class="row g-4 g-lg-5">
            @foreach($blogs as $k => $data)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-box" data-aos="fade-up" data-aos-duration="1000" data-aos-anchor-placement="center-bottom">
                        <div class="img-box">
                            <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}">
                                <img src="{{getFile($data->blog_image_driver ,$data->blog_image)}}" class="img-fluid" alt="@lang('blog-image')" />
                            </a>
                        </div>
                        <div class="text-box">
                            <div class="date-author">
                                <span><i class="far fa-calendar-alt"></i> {{dateTime(@$data->created_at,'d M, Y')}} </span>
                            </div>
                            <a href="{{route('blog.details',optional($data->details)->slug??'blog-details')}}" class="title">{{\Illuminate\Support\Str::limit(@$data->details->title,60)}}</a>
                            <p>
                                @lang(\Illuminate\Support\Str::limit(strip_tags(@$data->details->description), 120))
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
