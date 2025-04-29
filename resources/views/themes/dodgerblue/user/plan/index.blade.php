@extends(template().'layouts.user')
@section('title',trans('Investment Plan'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">@lang('Investment Plan')</h3>
                </div>
                <!-- table -->
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
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
                                    <a class="btn btn-primary investNow" href="javascript:void(0)"  data-price="{{$plan->price}}" data-resource="{{$plan}}"><i class="fal fa-usd-circle" aria-hidden="true"></i> @lang('Invest') </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="100%" class="text-center">
                                    <div class="text-center p-4">
                                        <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
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
@push('style')
    <style>
        .invest-amount{
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
        .input-group-text {
            display: flex;
            align-items: center;
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #ffffff;
            text-align: center;
            white-space: nowrap;
            background-color: #49c0ec;
            border: 1px solid #ffffff;
            border-radius: .25rem;
        }
    </style>
@endpush
