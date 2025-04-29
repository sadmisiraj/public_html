<!-- plan start -->
<section class="pricing-section">
    <div class="container">
        <div class="row">
            <div class="header-text text-center">
                <h5>{!! $investment_section['single']['heading']??'' !!}</h5>
                <h2>{!! $investment_section['single']['sub_heading']??'' !!}</h2>
                <p class="mx-auto">{!! $investment_section['single']['short_text']??'' !!}</p>
            </div>
        </div>

        <div class="row justify-content-center g-4 g-lg-5">
            @foreach($plans as $k => $data)
                @php
                    $getTime = $data->time;
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-box">
                        <h4>@lang($data->name)</h4>
                        <h2 class="text-primary">{{strip_tags($data->price)}}</h2>
                        @if ($data->profit_type == 1)
                            <h6>{{getAmount($data->profit)}}{{'%'}} @lang('Every') {{trans($getTime->name)}}</h6>
                        @else
                            <h6><sup class="font-18">{{currencyPosition($data->profit)}} @lang('Every') {{trans($getTime->name)}}</h6>
                        @endif

                        <ul>
                            <li>@lang('Profit For') {{($data->is_lifetime ==1) ? trans('Lifetime') : trans('Every').' '.trans($getTime->name)}}</li>
                            <li>@lang('Capital will back') : <span class="bg-{{($data->is_capital_back ==1) ? 'success':'danger'}}">{{($data->is_capital_back ==1) ? trans('Yes'): trans('No')}}</span></li>
                            @if($data->is_lifetime == 0)
                                <li>@lang('Total') {{trans($data->profit*$data->repeatable)}} {{($data->profit_type == 1) ? '%': trans(basicControl()->currency_symbol)}} +
                                    @if($data->is_capital_back == 1)
                                        <span class="bg-success">@lang('Capital')</span>
                                    @endif
                                </li>

                            @else
                                <li>@lang('Lifetime Earning')</li>
                            @endif

                        </ul>
                        <button class="btn-custom w-100 investNow" type="button" data-price="{{$data->price}}" data-resource="{{$data}}">@lang('Invest now')</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- plan end -->

<!-- Modal -->
<div class="modal fade" id="investModal" tabindex="-1" aria-labelledby="investModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="investModalLabel">@lang('Invest Now')</h4>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fal fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h5 class="title plan-name"></h5>
                    <p class="price-range"></p>
                    <p class="profit-details"></p>
                    <p class="profit-validity"></p>
                </div>
                <form class="login-form" id="invest-form" action="{{route('user.purchase-plan')}}" method="post">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-12">
                            <select class="form-select" aria-label="Default select example" name="balance_type">
                                @auth
                                    <option
                                        value="balance">@lang('Deposit Balance') - {{currencyPosition(auth()->user()->balance)}}</option>
                                    <option
                                        value="interest_balance">@lang('Interest Balance') - {{currencyPosition(auth()->user()->interest_balance)}}</option>
                                @endauth
                                <option value="checkout">@lang('Checkout')</option>
                            </select>
                        </div>
                        <div class="input-box col-12">
                            <div class="input-group">
                                <input type="text" class="form-control invest-amount" name="amount" id="amount" value="{{old('amount')}}" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" autocomplete="off" placeholder="@lang('Enter amount')" />
                                <span class="input-group-text show-currency"></span>
                            </div>
                        </div>
                        <input type="hidden" name="plan_id" class="plan-id">
                        <div class="input-box col-12">
                            <button class="btn-custom w-100"><i class="fal fa-wallet"></i>@lang('Invest Now')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if(count($errors) > 0 )
    <script>
        @foreach($errors->all() as $key => $error)
        Notiflix.Notify.failure("@lang($error)");
        @endforeach
    </script>
@endif
