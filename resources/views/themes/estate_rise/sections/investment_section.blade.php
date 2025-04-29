<!-- Pricing section start -->
<section class="pricing-section">
    <div class="container">
        <div class="row gx-4 gy-0 align-items-center text-center text-md-start">
            <div class="col-md-6">
                <div class="section-subtitle" data-aos="fade-up" data-aos-duration="500"> {{$investment_section['single']['heading']??''}}</div>
                <h2 data-aos="fade-up" data-aos-duration="700">
                    {{$investment_section['single']['sub_heading']??''}}
                </h2>
            </div>
            <div class="col-md-6">
                <p class="mb-0" data-aos="fade-up" data-aos-duration="900">
                    {{$investment_section['single']['short_details']??''}}
                </p>
            </div>
        </div>
        <div class="mt-4 mt-lg-5">
            <div class="row g-4 justify-content-center">
                @if(isset($plans))
                    @foreach($plans as $k => $data)

                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="500">
                    <div class="pricing-box">
                        <span class="pricing-shape"></span>
                        <div class="img-box">
                            <img src="{{template(true).'img/pricing-plan/customer-service.png'}}" alt="">
                        </div>
                        <h4 class="mb-0">@lang($data->name)</h4>
                        <div class="title"> {{$data->price}}</div>
                        @if ($data->profit_type == 1)
                            <h5 class="mb-0">{{getAmount($data->profit)}}{{'%'}} @lang('Every') @lang($data->time?->name)</h5>
                        @else
                            <h5 class="mb-0">{{trans(basicControl()->currency_symbol)}}{{getAmount($data->profit)}} @lang('Every') @lang($data->time?->name)</h5>
                        @endif
                        <ul class="pricing-feature">
                            <li>@lang('Profit For') {{($data->is_lifetime ==1) ? trans('Lifetime') : trans('Every').' '.trans($data->time?->name)}}</li>
                            <li>@lang('Capital will back') : <span class="badge text-bg-{{($data->is_capital_back ==1) ? 'success':'danger'}}">{{($data->is_capital_back ==1) ? trans('Yes'): trans('No')}}</span></li>
                            @if($data->is_lifetime == 0)
                                <li>@lang('Total')  {{getAmount($data->profit*$data->repeatable)}} {{($data->profit_type == 1) ? '%': basicControl()->currency_symbol}}
                                    +
                                    @if($data->is_capital_back == 1)
                                        <span class="badge text-bg-success">@lang('Capital')</span>
                                    @endif
                                </li>

                            @else
                                <li>@lang('Lifetime Earning')</li>
                            @endif
                        </ul>
                        <a href="javascript:void(0)"
                           data-bs-toggle="modal"
                           data-bs-target="#InvestModal"
                           class="pricing-btn investNow"
                           data-price="{{$data->price}}"
                           data-resource="{{$data}}"

                        >@lang('invest now')
                            <span class="animate-arrow-up d-inline-block">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 17L17 7" stroke="currentColor" stroke-opacity="0.9" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M7 7H17V17" stroke="currentColor" stroke-opacity="0.9" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                        </a>
                    </div>
                </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Pricing section end -->
<!-- Modal section start -->
<div class="modal fade" id="InvestModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="staticBackdropLabel">@lang('Invest Now')</h1>
                <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-light fa-xmark"></i>
                </button>
            </div>
            <form class="login-form" id="invest-form" action="{{route('user.purchase-plan')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="text-center">
                        <h5 class="title plan-name"></h5>
                        <p class="price-range"></p>
                        <p class="profit-details"></p>
                        <p class="profit-validity"></p>
                    </div>
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-12">
                            <select class="form-select" aria-label="Default select example" name="balance_type">
                                @auth
                                    <option
                                        value="balance">@lang('Deposit Balance')
                                        - {{currencyPosition(auth()->user()->balance)}}</option>
                                    <option
                                        value="interest_balance">@lang('Interest Balance')
                                        - {{currencyPosition(auth()->user()->interest_balance)}}</option>
                                @endauth
                                <option value="checkout">@lang('Checkout')</option>
                            </select>
                        </div>
                        <div class="input-box col-12">
                            <div class="input-group">
                                <input type="text" class="form-control invest-amount" name="amount" id="amount"
                                       value="{{old('amount')}}"
                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                       autocomplete="off" placeholder="@lang('Enter amount')"/>
                                <span class="input-group-text show-currency"></span>
                            </div>
                        </div>
                        <input type="hidden" name="plan_id" class="plan-id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="cmn-btn">@lang('Invest Now')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal section end -->
<!-- Plan_modal_end -->
@if(count($errors) > 0 )
    <script>
        @foreach($errors->all() as $key => $error)
        Notiflix.Notify.failure("@lang($error)");
        @endforeach
    </script>
@endif

