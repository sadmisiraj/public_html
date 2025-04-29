<style>
    .how-it-work::before {
        background-image: url({{isset($how_works_section['single']['media']->image)? getFile($how_works_section['single']['media']->image->driver,$how_works_section['single']['media']->image->path):''}});
    }
</style>
<section class="how-it-work">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="video-box">
                    <a class="play-vdo" href="{{ $how_works_section['single']['media']->video_url??'' }}" data-fancybox="video" target="_blank">
                        <i class="fas fa-play"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="work-process">
                    <h2 class="mb-5">@lang('How it works')</h2>
                    @foreach(collect($how_works_section['multiple'])->toArray() as $k =>  $item)
                        <div class="box" data-aos="fade-up" data-aos-duration="1000" data-aos-anchor-placement="center-bottom">
                            <div class="count">
                                <h2>{{++$k}}<span>@lang('.')</span></h2>
                            </div>
                            <div class="text">
                                <h4>{!! $item['title']??'' !!}</h4>
                                <p>{!! $item['short_description']??'' !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
