<!-- Deposit withdraw section start -->
<section class="deposit-withdraw-section">
    <div class="container">
        <div class="deposit-withdraw-section-top text-center text-md-start">
            <div class="row g-4 g-sm-5 align-items-center">
                <div class="col-md-6" data-aos="fade-up" data-aos-duration="500">
                    <div class="img-box">
                        <img src="{{isset($deposit_withdrawals_section['single']['media']->image)?getFile($deposit_withdrawals_section['single']['media']->image->driver,$deposit_withdrawals_section['single']['media']->image->path):''}}" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="section-subtitle" data-aos="fade-up" data-aos-duration="700">{{$deposit_withdrawals_section['single']['heading']??''}}</div>
                    <h2 class="mb-10" data-aos="fade-up" data-aos-duration="900">{!! $deposit_withdrawals_section['single']['sub_heading']??'' !!}</h2>
                    <p class="mb-0" data-aos="fade-up" data-aos-duration="1100">
                        {!! $deposit_withdrawals_section['single']['short_details']??'' !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="cmn-tabs mt-50 d">
            <ul class="nav nav-pills mb-40 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation" data-aos="fade-up" data-aos-duration="900">
                    <button class="nav-link active" id="pills-Last-Deposit-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-Last-Deposit" type="button" role="tab"
                            aria-controls="pills-Last-Deposit" aria-selected="true">@lang('Last Deposit')</button>
                </li>
                <li class="nav-item" role="presentation" data-aos="fade-up" data-aos-duration="1100">
                    <button class="nav-link" id="pills-Last-Withdrawal-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-Last-Withdrawal" type="button" role="tab"
                            aria-controls="pills-Last-Withdrawal" aria-selected="false">@lang('Last Withdrawal')</button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-Last-Deposit" role="tabpanel"
                 aria-labelledby="pills-Last-Deposit-tab" tabindex="0">
                <div class="transaction-table  pb-3">
                    <div class="cmn-table">
                        <div class="table-responsive overflow-hidden">
                            <table class="table table-striped align-middle">
                                <thead>
                                <tr data-aos="fade-up" data-aos-duration="700">
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Amount')</th>
                                    <th scope="col">@lang('Gateway')</th>
                                    <th scope="col">@lang('Date')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(isset($deposits))
                                        @foreach($deposits->take(5) as $item)
                                            <tr data-aos="fade-up" data-aos-duration="700">
                                        <td data-label="Name">
                                            <div class="profile-box">
                                                <div class="img-box">
                                                    <img src="{{getFile(optional($item->user)->image_driver , optional($item->user)->image) }}" alt="@lang('deposit user image')">
                                                </div>
                                                <div class="text-box">
                                                    {{optional($item->user)->fullname}}
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Amount">
                                            <span>{{currencyPosition($item->payable_amount_in_base_currency + 0)}}</span>
                                        </td>
                                        <td data-label="Gateway">
                                            <span>{{optional($item->gateway)->name}}</span>
                                        </td>
                                        <td data-label="Date">
                                            <span>{{dateTime($item->created_at)}}</span>
                                        </td>
                                    </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-Last-Withdrawal" role="tabpanel"
                 aria-labelledby="pills-Last-Withdrawal-tab" tabindex="0">
                <div class="transaction-table pb-3">
                    <div class="cmn-table">
                        <div class="table-responsive overflow-hidden">
                            <table class="table table-striped align-middle">
                                <thead>
                                <tr>
                                    <th scope="col" data-aos="fade-up" data-aos-duration="500">@lang('Name')</th>
                                    <th scope="col" data-aos="fade-up" data-aos-duration="700">@lang('Amount')</th>
                                    <th scope="col" data-aos="fade-up" data-aos-duration="900">@lang('Gateway')</th>
                                    <th scope="col" data-aos="fade-up" data-aos-duration="1100">@lang('Date')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($withdraws))
                                    @foreach($withdraws->take(5) as $item)
                                        <tr>
                                            <td data-label="Name">
                                                <div class="profile-box">
                                                    <div class="img-box">
                                                        <img src="{{getFile(optional($item->user)->image_driver , optional($item->user)->image) }}" alt="@lang('Withdraw User Image')">
                                                    </div>
                                                    <div class="text-box">
                                                        {{optional($item->user)->fullname}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Amount">
                                                <span>{{currencyPosition($item->amount_in_base_currency + 0)}}</span>
                                            </td>
                                            <td data-label="Gateway">
                                                <span>{{optional($item->method)->name}}</span>
                                            </td>
                                            <td data-label="Date">
                                                <span>{{dateTime($item->created_at)}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Deposit withdraw section end -->
