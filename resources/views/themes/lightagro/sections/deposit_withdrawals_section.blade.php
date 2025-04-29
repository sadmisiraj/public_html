<!-- latest transactions -->
<section class="latest-transaction">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-text text-center">
                    <h5>{!! $deposit_withdrawals_section['single']['heading']??'' !!}</h5>
                    <h3>{!! $deposit_withdrawals_section['single']['sub_heading']??'' !!}</h3>
                    <p class="mx-auto">{!! $deposit_withdrawals_section['single']['short_text']??'' !!}</p>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="nav justify-content-center mb-5" id="nav-tab" role="tablist">
                        <button class="btn-custom active" id="last-deposit-tab" data-bs-toggle="tab"
                                data-bs-target="#last-deposit" type="button" role="tab"
                                aria-controls="last-deposit" aria-selected="true">
                            @lang('Last Deposit')
                        </button>
                        <button class="btn-custom" id="last-withdraw-tab" data-bs-toggle="tab"
                                data-bs-target="#last-withdraw" type="button" role="tab"
                                aria-controls="last-withdraw" aria-selected="false">
                            @lang('Last Withdrawal')
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="last-deposit" role="tabpanel"
                         aria-labelledby="last-deposit-tab" tabindex="0">
                        <div class="transaction-wrapper owl-carousel">
                            @if(isset($deposits))
                            @foreach($deposits->take(4) as $item)
                                <div class="transaction-box">
                                    <div class="img-box">
                                        <img
                                            src="{{getFile(optional($item->user)->image_driver , optional($item->user)->image) }}"
                                            class="img-fluid" alt="@lang('deposit user image')"/>
                                    </div>
                                    <div class="text-box">
                                        <h5>
                                            @lang('Amount') {{currencyPosition($item->payable_amount_in_base_currency + 0)}}</h5>
                                        <h6>@lang('Name'): {{optional($item->user)->fullname}}</h6>
                                        <h6>{{dateTime($item->created_at)}}</h6>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="last-withdraw" role="tabpanel"
                         aria-labelledby="last-withdraw-tab" tabindex="0">
                        <div class="transaction-wrapper owl-carousel">
                            @if(isset($withdraws))
                            @foreach($withdraws->take(4) as $item)
                                <div class="transaction-box">
                                    <div class="img-box">
                                        <img src="{{getFile(optional($item->user)->image_driver , optional($item->user)->image) }}" class="img-fluid" alt="@lang('withdrawal user image')"/>
                                    </div>
                                    <div class="text-box">
                                        <h5>@lang('Amount'): {{currencyPosition($item->amount_in_base_currency + 0)}}</h5>
                                        <h6>@lang('Name'): {{optional($item->user)->fullname}}</h6>
                                        <h6>{{dateTime($item->created_at)}}</h6>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
