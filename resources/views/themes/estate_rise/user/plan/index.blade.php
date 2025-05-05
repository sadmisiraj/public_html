@extends(template().'layouts.user')
@section('title',trans('Purchase Plan'))
@push('style')
    <style>
        .disabled-plan {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .plan-locked, .plan-active {
            opacity: 0.7;
            position: relative;
        }
        
        .plan-locked::after, .plan-active::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.05);
            z-index: 1;
        }
    </style>
@endpush
@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Purchase Plan')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Purchase Plan')</li>
                </ol>
            </nav>
        </div>

        <!-- Cmn table section start -->
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0 border-0">
                <h4>@lang('Plan List')</h4>
            </div>
            <div class="card-body">
                <div class="cmn-table">
                    <div class="table-responsive overflow-hidden">
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Profit')</th>
                                <th scope="col">@lang('Capital Back')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody> @forelse ($plans as $key => $plan)
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
                                        @if($plan->is_capital_back == 0)
                                            <span class="badge text-bg-danger">@lang('No')</span>
                                        @else
                                            <span class="badge text-bg-success">@lang('Yes')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array($plan->id, $userActivePlans))
                                            @php
                                                $userPlan = auth()->user()->userPlans()->where('plan_id', $plan->id)->where('is_active', true)->first();
                                                $expiryText = $userPlan && $userPlan->expires_at ? 'Active till ' . $userPlan->expires_at->format('d M Y') : 'Active (Lifetime)';
                                            @endphp
                                            <button class="cmn-btn btn-success disabled" style="opacity: 0.7; cursor: default; background-color: #28a745; color: #fff;">
                                                <i class="fas fa-check-circle" aria-hidden="true"></i>
                                                {{ $expiryText }}
                                            </button>
                                        @elseif($plan->base_plan_id && !in_array($plan->base_plan_id, $userActivePlans))
                                            @php
                                                $basePlan = \App\Models\ManagePlan::find($plan->base_plan_id);
                                            @endphp
                                            <button class="cmn-btn btn-warning disabled" 
                                                style="opacity: 0.7; cursor: not-allowed; background-color: #ffc107; color: #212529;">
                                                <i class="fas fa-lock" aria-hidden="true"></i>
                                                @lang('Purchase') {{ $basePlan ? $basePlan->name : 'base plan' }} @lang('to unlock')
                                            </button>
                                        @else
                                            <a class="cmn-btn investNow" href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#InvestModal" data-price="{{$plan->price}}"
                                            data-resource="{{$plan}}"><i class="fal fa-usd-circle"
                                                                        aria-hidden="true"></i> @lang('Purchase') </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="100%" class="text-center">
                                        <div class="text-center p-4">
                                            <img class="dataTables-image mb-3"
                                                 src="{{ asset('assets/admin/img/oc-error.svg') }}"
                                                 alt="Image Description" data-hs-theme-appearance="default">
                                            <p class="mb-0">@lang('No data to show')</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cmn table section end -->

        <!-- pagination section start -->
        <div class="pagination-section">
            {{ $plans->appends($_GET)->links(template().'partials.pagination') }}
        </div>
        <!-- pagination section end -->
    </div>


    <!-- Modal section start -->
    <div class="modal fade" id="InvestModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="staticBackdropLabel">@lang('Purchase Now')</h1>
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
                                            value="interest_balance">@lang('Profit Balance')
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
                        <button type="submit" class="cmn-btn">@lang('Purchase Now')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal section end -->
@endsection

@push('script')
    <script>
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
            
            let data = $(this).data('resource');
            let price = $(this).data('price');
            let symbol = "{{basicControl()->currency_symbol}}";
            let currency = "{{basicControl()->base_currency}}";
            $('.price-range').text(`@lang('Purchase Range'): ${price}`);

            if (data.fixed_amount == '0') {
                $('.invest-amount').val('');
                $('#amount').attr('readonly', false);
            } else {
                $('.invest-amount').val(data.fixed_amount);
                $('#amount').attr('readonly', true);
            }

            $('.profit-details').html(`@lang('Profit'): ${(data.profit_type == '1') ? `${data.profit} %` : `${data.profit} ${currency}`}`);
            $('.profit-validity').html(`@lang('Per') ${data.schedule} @lang('hours') ,  ${(data.is_lifetime == '0') ? `${data.repeatable} @lang('times')` : `@lang('Lifetime')`}`);
            $('.plan-name').text(data.name);
            $('.plan-id').val(data.id);
            $('.show-currency').text("{{basicControl()->base_currency}}");
        });
    </script>

    @if(count($errors) > 0 )
        <script>
            @foreach($errors->all() as $key => $error)
            Notiflix.Notify.failure("@lang($error)");
            @endforeach
        </script>
    @endif
@endpush
