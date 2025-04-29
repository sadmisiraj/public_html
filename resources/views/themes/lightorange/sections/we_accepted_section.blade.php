<section id="payment-section">
    <img class="img img-1 zoomInOutInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-1.png')}}" alt="@lang('ellipse-1-image')">
    <img class="img img-2 zoomInOutInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-2.png')}}" alt="@lang('ellipse-2-image')">
    <img class="img img-3 zoomInOut2sInfinite" src="{{asset('assets/themes/lightorange/images/home/ellipse-3.png')}}" alt="@lang('ellipse-3-image')">
    <div class="overlay pt-150 pb-150">
        <div class="container">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-lg-10">
                    <div class="section-header">
                        <h4 class="sub-title">{!! $we_accepted_section['single']['heading']??'' !!}</h4>
                        <h3 class="title">{!! $we_accepted_section['single']['sub_heading']??'' !!}</h3>
                        <p class="area-para">{!! $we_accepted_section['single']['short_details']??'' !!}</p>
                    </div>
                </div>
            </div>

            <div class="{{(session()->get('rtl') == 1) ? 'payment-carousel-rtl': 'payment-carousel'}} wow fadeInUp">
                @foreach($gateways as $gateway)
                    <div class="col">
                        <div class="single-item">
                            <img src="{{getFile($gateway->driver,$gateway->image)}}" alt="{{$gateway->name}}" class="p-2">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- payment method end -->
