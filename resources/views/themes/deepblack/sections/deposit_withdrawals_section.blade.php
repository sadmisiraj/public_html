<section class="transaction-section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header-text text-center">
                    <h5>{!! $deposit_withdrawals_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $deposit_withdrawals_section['single']['sub_heading']??'' !!}</h2>
                    <p>{!! $deposit_withdrawals_section['single']['short_text']??'' !!}</p>
                    <div class="button-group">
                        <button
                            data-id="lastDeposit"
                            class="transaction-tab active">
                            {{trans('Last Deposit')}}
                        </button>
                        <button data-id="lastWithdraw" class="transaction-tab">
                            {{trans('Last Withdrawal')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- last deposit content -->
        <div id="lastDeposit" class="row transaction-content active justify-content-center">
            @foreach($deposits->take(4) as $item)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div
                        class="box"
                        data-aos="fade-right"
                        data-aos-duration="1200"
                        data-aos-anchor-placement="center-bottom"
                    >
                        <h4 class="golden-text">{{optional($item->user)->fullname}}</h4>
                        <h5>{{dateTime($item->created_at)}}</h5>
                        <div class="img-box">
                            <img src="{{getFile(optional($item->user)->image_driver , optional($item->user)->image) }}" alt="@lang('doposit user image')"/>
                        </div>
                        <h2>{{currencyPosition($item->payable_amount_in_base_currency + 0)}}</h2>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- last withdraw content -->
        <div id="lastWithdraw" class="row transaction-content justify-content-center">
            @foreach($withdraws->take(4) as $item)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div
                        class="box"
                        data-aos="fade-right"
                        data-aos-duration="1200"
                        data-aos-anchor-placement="center-bottom"
                    >
                        <h4 class="golden-text">{{optional($item->user)->fullname}}</h4>
                        <h5>{{dateTime($item->created_at)}}</h5>
                        <div class="img-box">
                            <img src="{{getFile(optional($item->user)->image_driver , optional($item->user)->image) }}" alt="@lang('withdrawal user image')" />
                        </div>
                        <h2>{{currencyPosition($item->amount_in_base_currency + 0)}}</h2>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
