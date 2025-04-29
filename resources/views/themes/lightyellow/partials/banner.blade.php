
@if(!request()->is('/'))
    @if (isset($pageSeo) && $pageSeo)
<section class="banner_area" style="background-image: url({{$pageSeo['breadcrumb_image']}})!important;">
    <div class="container">
        <div class="row">
            <div class="banner_title">
                <h2>{!! $pageSeo['page_title'] !!}</h2>
                <h6><a href="{{route('page')}}">@lang('Home')</a><i class="fa fa-arrow-right"></i> <Span>{!! $pageSeo['page_title'] !!}</Span></h6>
            </div>
        </div>
    </div>
</section>
    @endif
@endif
