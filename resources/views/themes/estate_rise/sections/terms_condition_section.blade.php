<!-- Policy section start -->
<section class="policy-section">
    <img class="shape2" src="{{asset(template(true).'img/background/net-shape.png')}}" alt="EstateRise">
    <img class="shape3" src="{{asset(template(true).'img/background/net-left.png')}}" alt="EstateRise">
    <div class="container">
        <div class="row">
            <div class="policy-section-inner">
                @foreach(collect($terms_condition_section['multiple'])->toArray() as $item)
                    <div class="mb-4">
                        <h5>{!! $item['heading']??'' !!}</h5>
                        {!! $item['description']??'' !!}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Policy section end -->
