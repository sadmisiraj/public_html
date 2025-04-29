<!-- Payment section start -->
<section class="payment-section">
    <div class="container">
        <div class="row">
            <div class="section-header text-center">
                <div class="section-subtitle" data-aos="fade-up" data-aos-duration="500">{{$payment_section['single']['heading']??''}}</div>
                <h2 class="section-title mx-auto" data-aos="fade-up" data-aos-duration="700">{{$payment_section['single']['sub_heading']??''}}</h2>
                <p class="cmn-para-text mx-auto mb-0" data-aos="fade-up" data-aos-duration="900">
                    {{$payment_section['single']['short_details']??''}}
                </p>
            </div>
        </div>
        <div class="owl-carousel owl-theme payment-carousel">
            @if(isset($gateways))
                @php($gateway_duration = 400)
                @foreach($gateways as $gateway)
                    @php($gateway_duration += 100)
                    <div class="item">
                        <div class="payment-box" data-aos="fade-up" data-aos-duration="{{$gateway_duration}}">
                            <div class="img-box">
                                <img src="{{getFile($gateway->driver,$gateway->image)}}" alt="Gateway Image">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- Payment section end -->
