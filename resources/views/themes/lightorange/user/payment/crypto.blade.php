@extends(template().'layouts.user')
@section('title')
	{{ __('Pay with').' '.__(optional($deposit->gateway)->name) }}
@endsection
@section('content')
<div class="container-fluid mt-lg-5">
		<div class="row d-flex justify-content-center">
			<div class="col-md-5">
                <h4 class="">{{ __('Pay with').' '.__(optional($deposit->gateway)->name) }}</h4>
				<div class="card bg-transparent mt-5">
					<div class="card-header bg-transparent">@lang('Payment Preview')</div>
					<div class="card-body text-center">
						<h4 class="text-color"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ getAmount($data->amount) }}</span> {{ __($data->currency) }}</h4>
						<h5>@lang('TO') <span class="text-success"> {{ __($data->sendto) }}</span></h5>
						<img src="{{ $data->img }}">
						<h4 class="text-color bold">@lang('SCAN TO SEND')</h4>
					</div>
				</div>
			</div>
		</div>
</div>
@endsection

@push('style')
    <style>
        .card,
        .card-header{
            border: 1px solid var(--bordercolor);
        }

        .mt-5 {
            margin-top: 2rem !important;
        }
        .card img {
            padding: 20px;
        }
    </style>
@endpush
