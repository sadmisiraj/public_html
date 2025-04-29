
@if(!request()->is('/'))
    @if (isset($pageSeo) && $pageSeo)
<section class="banner-section" style="background-image: url({{$pageSeo['breadcrumb_image']}})!important;">
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h3>{!! $pageSeo['page_title'] !!}</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('page') }}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{!! $pageSeo['page_title'] !!}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
    @endif
@endif
