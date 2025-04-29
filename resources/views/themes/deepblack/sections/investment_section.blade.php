
    <!-- plan start -->
    <section class="pricing-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-text text-center">
                        <h5>{!! $investment_section['single']['heading']??'' !!}</h5>
                        <h2>{!! $investment_section['single']['sub_heading']??'' !!}</h2>
                        <p>{!! $investment_section['single']['short_text']??'' !!}</p>
                    </div>
                </div>
            </div>

            <div class="row ">
                @foreach($plans as $k => $data)
                    @php
                        $getTime = $data->time;
                    @endphp
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div
                            class="box"
                            data-aos="fade-up"
                            data-aos-duration="800"
                            data-aos-anchor-placement="center-bottom"
                        >
                            <h2>@lang($data->name)</h2>
                            <h3>{{$data->price}}</h3>
                            <div class="bg">
                                @if ($data->profit_type == 1)
                                    <span class="golden-text">{{getAmount($data->profit)}}{{'%'}} <small class="small-font">@lang('Every') {{trans($getTime->name)}}</small></span>
                                @else
                                    <span class="golden-text"><small>{{currencyPosition($data->profit)}} </small><small class="small-font">@lang('Every') {{trans($getTime->name)}}</small></span>
                                @endif
                            </div>

                            <h4 class="golden-text">@lang('Profit For')  {{($data->is_lifetime ==1) ? trans('Lifetime') : trans('Every').' '.trans($getTime->name)}}</h4>
                            <h4>@lang('Capital will back') :
                                <small><span class="badge-small badge bg-{{($data->is_capital_back ==1) ? 'success':'danger'}}">{{($data->is_capital_back ==1) ? trans('Yes'): trans('No')}}</span></small></h4>
                            <h4>
                                @if($data->is_lifetime == 0)
                                    <span class="golden-text">@lang('Total') {{trans($data->profit*$data->repeatable)}} {{($data->profit_type == 1) ? '%': trans(basicControl()->currency_symbol)}} + </span>
                                    @if($data->is_capital_back == 1)
                                        <span class="badge-small badge bg-success">@lang('Capital')</span>
                                    @endif
                                @else
                                    <span class="golden-text">@lang('Lifetime Earning')</span>
                                @endif
                            </h4>
                            <button class="gold-btn btn investNow" type="button"
                                    data-price="{{$data->price}}"
                                    data-resource="{{$data}}">@lang('Invest Now')
                            </button>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- plan end -->


<!-- INVEST-NOW MODAL -->
<div class="modal fade addFundModal" id="investNowModal" tabindex="-1" data-bs-backdrop="static"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title golden-text" id="exampleModalLabel">@lang('Invest Now')</h3>
                <button
                    type="button"
                    data-bs-dismiss="modal"
                    class="btn-close btn-close-investment"
                    aria-label="Close"
                >
                    <img src="{{asset(template(true).'img/icon/cross.png')}}" alt="@lang('cross img')" />
                </button>
            </div>
            <div class="modal-body">
                <div class="form-block">
                    <form class="login-form" id="invest-form" action="{{route('user.purchase-plan')}}" method="post">
                        @csrf
                        <div class="signin">
                            <h2 class="title golden-text text-center plan-name"></h2>

                            @if(getTheme() == 'lightorange')
                                <p class="text-center price-range font-20 planDetails"></p>
                                <p class="text-center profit-details font-18 planDetails"></p>
                                <p class="text-center profit-validity pb-3 font-18 planDetails"></p>
                            @elseif(getTheme() == 'deepblack')
                                <p class="text-center price-range lebelFont"></p>
                                <p class="text-center profit-details lebelFont"></p>
                                <p class="text-center profit-validity pb-3 lebelFont"></p>
                            @else
                                <p class="text-success text-center price-range font-20"></p>
                                <p class="text-success text-center profit-details font-18"></p>
                                <p class="text-success text-center profit-validity pb-3 font-18"></p>
                            @endif

                            <div class="form-group mb-3">
                                <h5 class="mb-2 golden-text d-block modal_text_level">@lang('Select wallet')</h5>
                                <select class="form-control" name="balance_type">
                                    @auth
                                        <option
                                            value="balance" class="bg-dark text-white">@lang('Deposit Balance - '.currencyPosition(auth()->user()->balance))</option>
                                        <option
                                            value="interest_balance" class="bg-dark text-white">@lang('Interest Balance -'.currencyPosition(auth()->user()->interest_balance))</option>
                                    @endauth
                                    <option value="checkout" class="bg-dark text-white">@lang('Checkout')</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <div class="box">
                                    <h5 class="golden-text">@lang('Amount')</h5>
                                    <div class="input-group">
                                        <input
                                            type="text" class="invest-amount form-control" name="amount" id="amount" value="{{old('amount')}}"
                                            onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                            autocomplete="off"
                                            placeholder="@lang('Enter amount')">
                                        <button class="gold-btn show-currency"></button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="plan_id" class="plan-id">

                            <div class="btn-area mb-30 modal-footer border-top-0 p-0">
                                <button type="submit" class="gold-btn w-100">@lang('Invest Now')</button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- INVEST-NOW MODAL -->
    <!-- Plan_modal_end -->
    @if(count($errors) > 0 )
        <script>
            @foreach($errors->all() as $key => $error)
            Notiflix.Notify.failure("@lang($error)");
            @endforeach
        </script>
    @endif
