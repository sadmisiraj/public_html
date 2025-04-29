@extends(template().'layouts.user')
@section('title',trans('Purchase Plan'))
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
                                        @if($plan->is_capital_back == 0)
                                            <span class="badge text-bg-danger">@lang('No')</span>
                                        @else
                                            <span class="badge text-bg-success">@lang('Yes')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="cmn-btn investNow" href="javascript:void(0)" data-bs-toggle="modal"
                                           data-bs-target="#InvestModal" data-price="{{$plan->price}}"
                                           data-resource="{{$plan}}"><i class="fal fa-usd-circle"
                                                                        aria-hidden="true"></i> @lang('Purchase') </a>
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
            let data = $(this).data('resource');
            console.log(data);
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
