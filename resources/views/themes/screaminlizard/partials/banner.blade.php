
@if(!request()->is('/'))
    @if (isset($pageSeo) && $pageSeo)
        <section class="banner-section" style="background-image: url({{$pageSeo['breadcrumb_image']}})!important;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-stroke">{!! $pageSeo['page_title'] !!}</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('page') }}">@lang('home')</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{!! $pageSeo['page_title'] !!} </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif
