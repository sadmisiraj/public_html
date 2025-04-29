@if(!request()->is('/'))
    <!-- banner section -->
    @if (isset($pageSeo) && $pageSeo)
<!-- banner section -->
<section class="banner-section" style="background: url({{$pageSeo['breadcrumb_image']}});">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3><span class="text-stroke">{!! $pageSeo['page_title'] !!}</span></h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('page') }}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$pageSeo['page_title']}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
    @endif
@endif
