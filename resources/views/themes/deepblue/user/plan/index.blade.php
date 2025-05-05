@extends(template().'layouts.user')
@section('title',trans('Investment Plan'))
@push('style')
    <style>
        .disabled-plan {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .plan-locked, .plan-active {
            position: relative;
        }
        
        .plan-locked::after, .plan-active::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }
    </style>
@endpush
@section('content')


    @push('navigator')
        <!-- PAGE-NAVIGATOR -->
        <section id="page-navigator">
            <div class="container-fluid">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)"
                                                       class="cursor-inherit">{{trans('Investment Plan')}}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
        <!-- /PAGE-NAVIGATOR -->
    @endpush




    <section id="dashboard">
        <div class="dashboard-wrapper add-fund pb-50">
            <div class="row">
                <div class="col-md-12">
                    <div class="card secbg">
                        <div class="card-body ">

                            <div class="table-responsive">
                                <table class="table table table-hover table-striped text-white " id="service-table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">@lang('SL')</th>
                                        <th scope="col">@lang('Name')</th>
                                        <th scope="col">@lang('Price')</th>
                                        <th scope="col">@lang('Profit')</th>
                                        <th scope="col">@lang('Capital Back')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($plans as $key => $plan)
                                        @php
                                            $getTime = getTime($plan);
                                            $isPlanActive = in_array($plan->id, $userActivePlans);
                                            $isBasePlanRequired = $plan->base_plan_id && !in_array($plan->base_plan_id, $userActivePlans);
                                            $rowClass = $isPlanActive ? 'plan-active' : ($isBasePlanRequired ? 'plan-locked' : '');
                                        @endphp
                                        <tr class="{{ $rowClass }}">
                                            <td>{{loopIndex($plans) + $key}}</td>
                                            <td>
                                                {{$plan->name}}
                                            </td>
                                            <td>
                                                {{$plan->price}}
                                            </td>
                                            <td>
                                                @if ($plan->profit_type == 1)
                                                    <span>{{getAmount($plan->profit)}}{{'%'}} @lang('Every') {{trans($getTime->name)}}</span>
                                                @else
                                                    <span>{{trans(basicControl()->currency_symbol)}}{{getAmount($plan->profit)}} @lang('Every') {{trans($getTime->name)}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {!! $plan->getCapitalBackStatus() !!}
                                            </td>
                                            <td>
                                                @if(in_array($plan->id, $userActivePlans))
                                                    @php
                                                        $userPlan = auth()->user()->userPlans()->where('plan_id', $plan->id)->where('is_active', true)->first();
                                                        $expiryText = $userPlan && $userPlan->expires_at ? 'Active till ' . $userPlan->expires_at->format('d M Y') : 'Active (Lifetime)';
                                                    @endphp
                                                    <div class="btn btn-success base-btn btn-block btn-rounded" 
                                                        style="opacity: 0.7; cursor: default;">
                                                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                                                        {{ $expiryText }}
                                                    </div>
                                                @elseif($plan->base_plan_id && !in_array($plan->base_plan_id, $userActivePlans))
                                                    @php
                                                        $basePlan = \App\Models\ManagePlan::find($plan->base_plan_id);
                                                    @endphp
                                                    <div class="btn btn-warning base-btn btn-block btn-rounded"
                                                        style="opacity: 0.7; cursor: not-allowed;">
                                                        <i class="fas fa-lock" aria-hidden="true"></i>
                                                        @lang('Purchase') {{ $basePlan ? $basePlan->name : 'base plan' }} @lang('to unlock')
                                                    </div>
                                                @else
                                                    <a class="btn btn-primary base-btn btn-block btn-rounded investNow"
                                                    data-price="{{$plan->price}}"
                                                    data-resource="{{$plan}}"
                                                    href="javascript:void(0)">
                                                        <i class="fal fa-usd-circle" aria-hidden="true"></i>
                                                        @lang('Invest')
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="100%" class="text-center">
                                                <div class="text-center p-4">
                                                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                                    <p class="mb-0">@lang('No data to show')</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                            </div>


                            {{ $plans->appends($_GET)->links(template().'partials.pagination') }}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                                            value="balance">@lang('Deposit Balance - '.currencyPosition(auth()->user()->balance))</option>
                                        <option
                                            value="interest_balance">@lang('Interest Balance -'.currencyPosition(auth()->user()->interest_balance))</option>
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
                                <button class="btn-login login-auth-btn" type="submit"><span>@lang('Invest Now')</span></button>
                            </div>

                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        "use strict";
        (function ($) {
            $(document).on('click', '.investNow', function () {
                let plan = $(this).data('resource');
                
                // Prevent opening modal for locked plans
                if (plan.base_plan_id) {
                    let basePlanActive = false;
                    @foreach($userActivePlans as $activePlanId)
                        if (plan.base_plan_id == {{ $activePlanId }}) {
                            basePlanActive = true;
                        }
                    @endforeach
                    
                    if (!basePlanActive) {
                        // Base plan is not active, show message
                        let basePlanName = '';
                        @foreach($plans as $p)
                            if (plan.base_plan_id == {{ $p->id }}) {
                                basePlanName = '{{ $p->name }}';
                            }
                        @endforeach
                        
                        Notiflix.Notify.failure("You need to purchase " + basePlanName + " plan first to unlock this plan");
                        return;
                    }
                }
                
                // Check if plan is already active
                let isPlanActive = false;
                @foreach($userActivePlans as $activePlanId)
                    if (plan.id == {{ $activePlanId }}) {
                        isPlanActive = true;
                    }
                @endforeach
                
                if (isPlanActive) {
                    Notiflix.Notify.info("You already have an active subscription to this plan");
                    return;
                }
                
                $("#investment-modal").toggleClass("modal-open");
                let data = $(this).data('resource');
                let price = $(this).data('price');
                let symbol = "{{trans(basicControl()->currency_symbol)}}";
                let currency = "{{trans(basicControl()->base_currency)}}";
                $('.price-range').text(`@lang('Invest'): ${price}`);

                if (data.fixed_amount == '0') {
                    $('.invest-amount').val('');
                    $('#amount').attr('readonly', false);
                } else {
                    $('.invest-amount').val(data.fixed_amount);
                    $('#amount').attr('readonly', true);
                }

                $('.profit-details').html(`<strong> @lang('Interest'): ${(data.profit_type == '1') ? `${data.profit} %` : `${data.profit} ${currency}`}  </strong>`);
                $('.profit-validity').html(`<strong>  @lang('Per') ${data.schedule} @lang('hours') ,  ${(data.is_lifetime == '0') ? `${data.repeatable} @lang('times')` : `@lang('Lifetime')`} </strong>`);
                $('.plan-name').text(data.name);
                $('.plan-id').val(data.id);
            });



            $(".btn-close-investment").on('click',function(){
                $("#investment-modal").removeClass("modal-open");
            });


            $("#investment-modal .modal-wrapper").on('click', function(e) {
                $("#modal-login").removeClass("modal-open");
            });


        })(jQuery);

        $(document).on('click','.btn-login',function (){
            console.log('hello')
        })
    </script>
    @if(count($errors) > 0 )
        <script>
            @foreach($errors->all() as $key => $error)
            Notiflix.Notify.failure("@lang($error)");
            @endforeach
        </script>
    @endif
@endpush


