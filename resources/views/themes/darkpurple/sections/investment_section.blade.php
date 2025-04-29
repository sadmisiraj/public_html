<!-- pricing section -->
<section class="pricing-section">
    <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-text text-center">
                        <h5>{!! $investment_section['single']['heading']??'' !!}</h5>
                        <h2>{!! $investment_section['single']['sub_heading']??'' !!}</h2>
                        <p>{!! $investment_section['single']['short_details']??'' !!}</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 g-lg-5 justify-content-center">
                @foreach($plans as $k => $data)
                    @php
                        $getTime = $data->time;
                    @endphp


                    @if($data)
                        <div class="col-lg-4 col-md-6">
                            <div
                                class="pricing-box"
                                data-aos="fade-up"
                                data-aos-duration="1000"
                                data-aos-anchor-placement="center-bottom">
                                <h4 class="text-capitalize">@lang($data->name)</h4>
                                <h2>{{$data->price}}</h2>
                                @if ($data->profit_type == 1)
                                    <h5>{{getAmount($data->profit)}}{{'%'}} <small
                                            class="small-font">@lang('Every') {{trans($getTime->name)}}</small></h5>
                                @else
                                    <h5>
                                        {{currencyPosition($data->profit+0)}}
                                        <small class="small-font">@lang('Every') {{trans($getTime->name)}}</small></h5>
                                @endif
                                <ul>
                                    <li>
                                        <i class="far fa-chevron-double-right"></i> @lang('Profit For')  {{($data->is_lifetime ==1) ? trans('Lifetime') : trans('Every').' '.trans($getTime->name)}}
                                        <span class="badge">@lang('Yes')</span>
                                    </li>
                                    <li>
                                        <i class="far fa-chevron-double-right"></i> @lang('Capital will back')
                                        <small><span
                                                class="badge">{{($data->is_capital_back ==1) ? trans('Yes'): trans('No')}}</span></small>
                                    </li>

                                    <li>
                                        @if($data->is_lifetime == 0)
                                            <i class="far fa-chevron-double-right"></i> {{trans($data->profit*$data->repeatable)}} {{($data->profit_type == 1) ? '%': trans(basicControl()->base_currency)}}
                                            +
                                            @if($data->is_capital_back == 1)
                                                <span class="badge">@lang('Capital')</span>
                                            @endif
                                        @else
                                            <span class="badge">@lang('Lifetime Earning')</span>
                                        @endif
                                    </li>
                                </ul>
                                <button type="button" class="btn-custom investNow" data-price="{{$data->price}}"
                                        data-resource="{{$data}}">
                                    @lang('Invest Now')
                                </button>
                                <span class="feature text-capitalize">@lang(\Illuminate\Support\Str::limit($data->badge, 8))</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Modal -->
            <div class="modal fade addFundModal" id="investNowModal" tabindex="-1" aria-labelledby="planModalLabel"
                 aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <form action="{{route('user.purchase-plan')}}" method="post" id="invest-form" class="login-form">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="planModalLabel">@lang('Invest Now')</h4>
                                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fal fa-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <h2 class="title text-center plan-name"></h2>
                                <p class="text-center price-range font-20"></p>
                                <p class="text-center profit-details font-18"></p>
                                <p class="text-center profit-validity pb-3 font-18"></p>

                                <div class="row g-4">
                                    <div class="input-box col-12">
                                        <h6 class="mb-2 golden-text d-block modal_text_level">@lang('Select wallet')</h6>
                                        <select class="form-select" name="balance_type">
                                            @auth
                                                <option
                                                    value="balance">@lang('Deposit Balance - '.currencyPosition(auth()->user()->balance))</option>
                                                <option
                                                    value="interest_balance">@lang('Interest Balance -'.currencyPosition(auth()->user()->interest_balance))</option>
                                            @endauth
                                            <option value="checkout">@lang('Checkout')</option>
                                        </select>
                                    </div>
                                    <div class="input-box col-12">
                                        <h6 class="mb-2 golden-text d-block modal_text_level">@lang('Amount')</h6>
                                        <div class="input-group mb-3">
                                            <input
                                                type="text" class="invest-amount form-control" name="amount" id="amount"
                                                value="{{old('amount')}}"
                                                onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                autocomplete="off"
                                                placeholder="@lang('Enter amount')" required>
                                            <button class="gold-btn show-currency input-group-text btn-custom-2"
                                                    id="basic-addon2" type="button"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="plan_id" class="plan-id">
                                <button type="submit" class="btn-custom">@lang('Invest Now')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</section>

<!-- Plan_modal_end -->
@if(count($errors) > 0 )
    <script>
        @foreach($errors->all() as $key => $error)
        Notiflix.Notify.failure("@lang($error)");
        @endforeach
    </script>
@endif


