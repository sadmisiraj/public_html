<!-- FAQ -->
<section id="investment">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="heading-container">
                    <h6 class="topheading">{!! $investment_section['single']['heading']??'' !!}</h6>
                    <h3 class="heading">{!! $investment_section['single']['sub_heading']??'' !!}</h3>
                    <p class="slogan">{!! $investment_section['single']['short_details']??'' !!}</p>
                </div>
            </div>
        </div>
        <div class="investment-wrapper">
            <div class="row">
                @foreach($plans as $k => $data)
                    @php
                        $getTime = $data->time;
                    @endphp


                    <div class=" col-md-6 col-lg-4">
                        <div class="card-type-1 card align-items-start wow fadeInUp" data-wow-duration="1s"
                             data-wow-delay="0.15s">
                            @if($data->badge)
                                <div class="featured"><span>{{__($data->badge)}}</span></div>
                            @endif
                            <h4 class="h4">@lang($data->name)</h4>

                            <h4 class="h4 themecolor">
                                {{$data->price}}
                            </h4>
                            <div class="d-flex align-items-baseline">
                                <h4 class="h4"> {{getAmount($data->profit)}}{{($data->profit_type == 1) ? '%': ' '. trans(basicControl()->base_currency)}}</h4>
                                <h6 class="ml-5">@lang('Every') {{trans($getTime->name)}} </h6>
                            </div>
                            <hr class="hr">

                            <p class="text">@lang('Profit For')  {{($data->is_lifetime ==1) ? trans('Lifetime') : trans('Every').' '.trans($getTime->name)}}</p>
                            <p class="text">
                                @lang('Capital will back') :
                                <span class="badge badge-{{($data->is_capital_back ==1) ? 'success':'danger'}} px-2 py-1">{{($data->is_capital_back ==1) ? trans('Yes'): trans('No')}}</span>
                            </p>

                            <p class="text">
                                @if($data->is_lifetime == 0)
                                    @if($data->is_capital_back == 1)
                                        @lang('Total')   {{trans($data->profit*$data->repeatable)}} {{($data->profit_type == 1) ? '%': ' '. trans(basicControl()->base_currency)}}
                                        + <span class="badge badge-success">@lang('Capital')</span>
                                    @endif
                                @else
                                    @lang('Lifetime Earning')
                                @endif
                            </p>

                            <button class="btn-base text-uppercase mt-30 investNow" type="button"
                                    data-price="{{$data->price}}"
                                    data-resource="{{$data}}">@lang('Invest Now')</button>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
<!-- /FAQ -->



<!-- MODAL-LOGIN -->
<div id="investment-modal">
    <div class="modal-wrapper">
        <div class="modal-login-body">
            <div class="btn-close  btn-close-investment">&times;</div>
            <div class="form-block pb-5">
                <form class="login-form" id="invest-form" action="{{route('user.purchase-plan')}}" method="post">
                    @csrf
                    <div class="signin ">
                        <h3 class="title mb-30 plan-name"></h3>

                        <p class="text-success text-center price-range font-20"></p>
                        <p class="text-success text-center profit-details font-18"></p>
                        <p class="text-success text-center profit-validity pb-3 font-18"></p>


                        <div class="form-group  mb-30">
                            <strong class="text-white mb-2 d-block">@lang('Select wallet')</strong>
                            <select class="form-control" name="balance_type">
                                @auth
                                    <option
                                        value="balance">@lang('Deposit Balance') - {{currencyPosition(auth()->user()->balance)}}</option>
                                    <option
                                        value="interest_balance">@lang('Interest Balance') - {{currencyPosition(auth()->user()->interest_balance)}}</option>
                                @endauth
                                <option value="checkout">@lang('Checkout')</option>
                            </select>
                        </div>

                        <div class="form-group mb-30">
                            <strong class="text-white mb-2 d-block">@lang('Enter Amount')</strong>
                            <input type="text" class="form-control invest-amount" id="amount" name="amount"
                                   value="{{old('amount')}}"
                                   onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                   autocomplete="off">
                        </div>
                        <input type="hidden" name="plan_id" class="plan-id">

                        <div class="btn-area mb-30">
                            <button class="btn-login login-auth-btn" type="submit"><span>@lang('Invest Now')</span>
                            </button>
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

