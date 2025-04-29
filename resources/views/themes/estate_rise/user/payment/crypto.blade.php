@extends(template().'layouts.user')
@section('title')
    {{ __('Pay with ').__(optional($deposit->gateway)->name) }}
@endsection
@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1"> {{ __('Pay with').' '.__(optional($deposit->gateway)->name) }}</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active"> {{ __('Pay with').' '.__(optional($deposit->gateway)->name) }}</li>
                </ol>
            </nav>
        </div>
        <div class="container-fluid mt-lg-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card card-primary shadow">
                        <h5 class="card-header bg-white">@lang('Payment Preview')</h5>
                        <div class="card-body text-center">
                            <h4 class="text-color"> @lang('PLEASE SEND EXACTLY') <span
                                    class="text-success"> {{ getAmount($data->amount) }}</span> {{ __($data->currency) }}
                            </h4>
                            <h5>@lang('TO') <span class="text-success"> {{ __($data->sendto) }}</span></h5>
                            <img src="{{ $data->img }}">
                            <h4 class="text-color bold">@lang('SCAN TO SEND')</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

