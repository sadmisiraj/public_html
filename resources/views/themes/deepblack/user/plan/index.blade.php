@extends(template().'layouts.user')
@section('title',trans('Investment Plan'))
@section('content')

    <!-- Invest history -->
    <section class="transaction-history mt-5 pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="header-text-full">
                        <h2>{{trans('Investment Plan')}}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="table-parent table-responsive">
                        <table class="table table-striped mb-5">
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
                            <tbody>
                            @forelse ($plans as $key => $plan)
                                @php
                                    $getTime = getTime($plan);
                                @endphp
                                <tr>
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
                                        <a class="gold-btn btn investNow" href="javascript:void(0)" data-price="{{$plan->price}}" data-resource="{{$plan}}"><i class="fa fa-usd" aria-hidden="true"></i> @lang('Invest') </a>
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

                        {{ $plans->appends($_GET)->links(template().'partials.user-pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->

    <div id="investModal" class="modal fade investModal" tabindex="-1" role="dialog" data-bs-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content form-block">
                <div class="modal-header">
                    <h4 class="modal-title method-name golden-text">@lang('Invest Now')</h4>
                    <button
                        type="button"
                        data-bs-dismiss="modal"
                        class="btn-close"
                        aria-label="Close"
                    >
                        <img src="{{asset(template(true).'img/icon/cross.png')}}" alt="@lang('modal dismiss')" />
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h2 class="title golden-text text-center plan-name"></h2>
                        <p class="price-range"></p>
                        <p class="profit-details"></p>
                        <p class="profit-validity"></p>
                    </div>
                    <form class="login-form" id="invest-form" action="{{route('user.purchase-plan')}}" method="post">
                        @csrf

                        <div class="row g-3 align-items-end">
                            <div class="col-12">

                                <div class="form-group mb-30 mt-3">
                                    <div class="box">
                                        <h5 class="golden-text">@lang('Select Wallet')</h5>
                                        <div class="input-group">
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
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="form-group mb-30 mt-3">
                                    <div class="box">
                                        <h5 class="golden-text">@lang('Amount')</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control amount invest-amount" name="amount" id="amount" value="{{old('amount')}}" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" autocomplete="off" placeholder="@lang('Enter amount')" />

                                            <button class="gold-btn show-currency"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="plan_id" class="plan-id">
                            <div class="input-box col-12">
                                <button class="gold-btn btn w-100"><i class="fa fa-usd me-2"></i>@lang('Invest Now')</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
    @if(count($errors) > 0 )
        <script>
            @foreach($errors->all() as $key => $error)
            Notiflix.Notify.failure("@lang($error)");
            @endforeach
        </script>
    @endif
@endpush
