<style>
    @for($i=1; $i<= count(collect($how_works_section['multiple'])??[]);$i++)
@if($i%2 != 0)


.how-it-works .box-{{$i}}  {
        margin-left: 50px;
        margin-right: 0;
    }

    .how-it-works.rtl .box-{{$i}}  {
        margin-right: 50px;
        margin-left: 0;
    }

    .how-it-works .box-{{$i}}::before {
        left: -94px;
        right: -94px;
    }

    .how-it-works.rtl .box-{{$i}}::before {
        left: -94px;
    }

    .how-it-works .box-{{$i}}::after {
        left: -65px;
    }

    .how-it-works.rtl .box-{{$i}}::after {
        left: -65px;
    }

    @else

.how-it-works.rtl .box-{{$i}}::after {
        left: -65px;
        right: auto;
    }

    .how-it-works.rtl .box-{{$i}}::before {
        left: -94px;
        right: auto;
    }

    .how-it-works .box-{{$i}}  {
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: end;
        text-align: right;
    }


    .how-it-works.rtl .box-{{$i}}  {
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: start;
        text-align: left;
        margin-left: 50px;
    }

    @endif
.how-it-works .box-{{$i}}::before {
        content: "{{$i}}";
    }
    @endfor
.how-it-works .box.box-last::after {
        width: 0;
    }
</style>


<!-- how it works -->
<section class="how-it-works @if(session()->get('rtl') == 1) rtl @endif">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text text-center">
                    <h5>{!! $how_works_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $how_works_section['single']['sub_heading']??'' !!}</h2>
                    <p>{!! $how_works_section['single']['short_text']??'' !!}</p>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach(collect($how_works_section['multiple'])->toArray() as $k =>  $item)
                @if($k == 0)
                    <div class="col-lg-6"></div>
                @endif
                <div class="col-lg-6">
                    <div
                        class="box box-{{$k+1}}  @if(count(collect($how_works_section['multiple'])??[]) == ($k+1)) box-last @endif"
                        data-aos="fade-up"
                        data-aos-duration="800"
                        data-aos-anchor-placement="center-bottom"
                    >
                        <div class="img">
                            <img
                                src="{{getFile($item['media']->icon->driver,$item['media']->icon->path)}}"
                                class="img-center" alt="@lang('how it work image')"/>
                        </div>
                        <div class="text">
                            <h4 class="golden-text">{!! $item['title'] !!}</h4>
                            <p>{!! $item['short_description'] !!}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6"></div>
                <div class="col-lg-6"></div>
            @endforeach
        </div>
    </div>
</section>
