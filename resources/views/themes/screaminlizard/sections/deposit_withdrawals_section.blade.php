


<section class="latest-transaction">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="header-text text-center">
                    <h5>{!! $deposit_withdrawals_section['single']['heading']??null !!}</h5>
                    <h2> {!! styleSentence($deposit_withdrawals_section['single']['sub_heading']??null,3) !!} </h2>
                    <p class="mx-auto">
                        {!! $deposit_withdrawals_section['single']['short_details']??null !!}
                    </p>
                    <div class="nav mt-5" id="nav-tab" role="tablist">
                        <button class="btn-custom active" id="last-deposit-tab" data-bs-toggle="tab" data-bs-target="#last-deposit" type="button" role="tab" aria-controls="last-deposit" aria-selected="true">@lang('Last Deposit')</button>
                        <button class="btn-custom" id="last-withdraw-tab" data-bs-toggle="tab" data-bs-target="#last-withdraw" type="button" role="tab" aria-controls="last-withdraw" aria-selected="false">@lang('Last Withdrawal')</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="last-deposit" role="tabpanel" aria-labelledby="last-deposit-tab" tabindex="0">
                        <div class="transaction-wrapper">
                            <!-- table -->
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
                                            <td data-label="Name">
                                        <span class="currency">
                                           <img src="{{getFile(optional($item->user)->image_driver , optional($item->user)->image) }}" alt="@lang('Image Missing')"/>
                                           {{optional($item->user)->fullname}}
                                        </span>
                                            </td>
                                            <td data-label="Amount">{{currencyPosition($item->payable_amount_in_base_currency   + 0)}}</td>
                                            <td data-label="Gateway">{{optional($item->gateway)->name}}</td>
                                            <td data-label="Date">{{dateTime($item->created_at)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="last-withdraw" role="tabpanel" aria-labelledby="last-withdraw-tab" tabindex="0">

                        <div class="transaction-wrapper">
                            <!-- table -->
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
                                            <td data-label="Name">
                                        <span class="currency">
                                           <img src="{{getFile(optional($item->user)->image_driver , optional($item->user)->image) }}" alt="@lang('Image Missing')"/>
                                           {{optional($item->user)->fullname}}
                                        </span>
                                            </td>
                                            <td data-label="Amount">{{currencyPosition($item->amount_in_base_currency + 0)}}</td>
                                            <td data-label="Gateway">{{optional($item->payoutMethod)->name}}</td>
                                            <td data-label="Date">{{dateTime($item->created_at)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
