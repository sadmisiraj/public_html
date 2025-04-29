
@if(isset($how_works_section) && isset($how_works_section['single']['media']->image))
    <style>
        #banner-wrap::before{
            background-image: linear-gradient(90deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%), url({{getFile($how_works_section['single']['media']->image->driver,$how_works_section['single']['media']->image->path)}});
        }
    </style>
@endif
<!-- BANNER-WRAP -->
<section id="banner-wrap">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-md-6">
                <div class="youtube-wrapper wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.15s">
                    <div class="btn-container">
                        <div class="btn-play grow-play">
                            <i class="icofont-ui-play"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 offset-md-1 col-md-5">
                <div class="wrapper wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
                    <h3 class="h3 mb-30">{!! $how_works_section['single']['heading']??'' !!}</h3>
                    <div class="vertical-timeline">
                        @foreach(collect($how_works_section['multiple'])->toArray()??[] as $k =>  $item)
                            <div class="media align-items-center mb-20">
                                <div class="media-counter"><span>{{++$k}}</span></div>
                                <div class="media-body ml-20">
                                    <h6 class="media-title mb-10">{!! $item['title'] !!}</h6>
                                    <p class="text">
                                        {!! $item['short_description'] !!}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /BANNER-WRAP -->


<!-- MODAL-VIDEO -->
<div id="modal-video">
    <div class="modal-wrapper">
        <div class="modal-content">
            <div class="btn-close">&times;</div>
            <div class="modal-container">
                <iframe width="100%" height="100%"
                        src="{{isset($how_works_section['single']['media']->video_url)?$how_works_section['single']['media']->video_url:''}}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<!-- /MODAL-VIDEO -->
