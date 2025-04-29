<section class="deposit-withdraw-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-text text-center">
                    <h5>{!! $deposit_withdrawals_section['single']['heading']??'' !!}</h5>
                    <h2>{!! $deposit_withdrawals_section['single']['sub_heading']??'' !!}</h2>
                    <p>{!! $deposit_withdrawals_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="deposit-switcher">
                    <button tab-id="tab1" class="tab active">{{trans('Deposit')}}</button>
                    <button tab-id="tab2" class="tab">{{trans('Withdraw')}}</button>
                </div>
                <div id="tab1" class="content active">
                    <div class="table-parent table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Gateway')</th>
                                <th scope="col">@lang('Date')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deposits->take(5) as $item)
                                <tr>
                                    <td>{{optional($item->user)->fullname}}</td>
                                    <td>{{currencyPosition($item->payable_amount_in_base_currency + 0)}}</td>
                                    <td>
                                    <span class="currency">
                                       <img src="{{getFile(optional($item->user)->image_driver , optional($item->user)->image) }}" alt="" />
                                       {{optional($item->gateway)->name}}
                                    </span>
                                    </td>
                                    <td>{{dateTime($item->created_at)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="tab2" class="content">
                    <div class="table-parent table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Gateway')</th>
                                <th scope="col">@lang('Date')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdraws->take(5) as $item)
                                <tr>
                                    <td>{{optional($item->user)->fullname}}</td>
                                    <td>{{currencyPosition($item->amount_in_base_currency+0)}}</td>
                                    <td>
                                        <span class="currency">
                                           <img src="{{getFile(optional($item->user)->image_driver , optional($item->user)->image) }}" alt="" />
                                          {{optional($item->payoutMethod)->name}}
                                        </span>
                                    </td>
                                    <td>{{dateTime($item->created_at)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

