<style>
    .banner_area {
        background: linear-gradient(90deg, {{hex2rgba(primaryColor(),0.8)}} 0, {{hex2rgba(secondaryColor(),0.9)}}  100%), url({{$pageSeo['breadcrumb_image']}}) no-repeat !important;
        background-size: 100% 100% !important;
        background-position: center !important;
        position: relative !important;
    }
</style>
@if(!request()->is('/'))
    @if (isset($pageSeo) && $pageSeo)
    <!-- banner_area_start -->
    <div class="banner_area">
        <div class="container">
            <div class="row ">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="text_area">
                        <h3>
                            {!! $pageSeo['page_title'] !!}
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="breadcrumb_area">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('page') }}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{!! $pageSeo['page_title'] !!}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner_area_end -->
    @endif
@endif


