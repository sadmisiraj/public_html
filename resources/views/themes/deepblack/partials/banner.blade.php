@if(!request()->is('/'))
    <!-- banner section -->
    @if (isset($pageSeo) && $pageSeo)
<section class="page-banner" style="background: url({{$pageSeo['breadcrumb_image']}});">
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2>{!! $pageSeo['page_title'] !!}</h2>
                </div>
            </div>
        </div>
    </div>
</section>
    @endif
@endif

