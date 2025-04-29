<!-- testimonial section -->


<section class="testimonial-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text text-center">
                    <h5>{!! $testimonial_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $testimonial_section['single']['sub_heading']??'' !!}</h2>
                    <p >{!! $testimonial_section['single']['short_text']??'' !!}</p>
                </div>
            </div>
        </div>

        <div class="{{(session()->get('rtl') == 1) ? 'client-testimonials-rtl': 'client-testimonials'}} owl-carousel">
            @foreach(collect($testimonial_section['multiple'])->toArray() as $key => $data)
                <div class="review-box">
                    <img class="quote" src="{{asset(template(true).'img/icon/quote.png')}}" alt="@lang('quote img')" />
                    <div class="img-box">
                        <img class="img-fluid" src="{{$data['media']->image?getFile($data['media']->image->driver,$data['media']->image->path):''}}" alt="@lang('testimonial img')" />
                    </div>
                    <div class="text-box">
                        <h4 class="golden-text">{!! $data['name'] !!}</h4>
                        <span>{!! $data['designation'] !!}</span>
                        <p>{{strip_tags($data['description'])}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
