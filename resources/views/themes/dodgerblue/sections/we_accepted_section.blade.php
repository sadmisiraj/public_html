<!-- payment gateway -->
<section class="payment-gateway">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="gateways {{(session()->get('rtl') == 1) ? 'partners-rtl': 'partners'}} owl-carousel">
                    @foreach($gateways as $gateway)
                        <div class="box">
                            <img src="{{getFile($gateway->driver,$gateway->image)}}" alt=""/>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
