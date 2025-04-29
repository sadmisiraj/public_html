<!-- PAYMENT-METHOD -->
<section id="payment-method">
    <div class="container">

        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="heading-container">
                    <h6 class="topheading">{!! $we_accepted_section['single']['heading']??'' !!}</h6>
                    <h3 class="heading">{!! $we_accepted_section['single']['sub_heading']??'' !!}</h3>
                    <p class="slogan">{!! $we_accepted_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>

        <div class="carousel-container wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.15s">
            <div class="{{(session()->get('rtl') == 1) ? 'carousel-payment-rtl': 'carousel-payment'}}  owl-carousel owl-theme">
                @foreach($gateways as $gateway)
                    <div class="item-carousel">
                        <div class="payment-fig">
                            <img src="{{getFile($gateway->driver,$gateway->image)}}" alt="{{$gateway->name}}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- /PAYMENT-METHOD -->
