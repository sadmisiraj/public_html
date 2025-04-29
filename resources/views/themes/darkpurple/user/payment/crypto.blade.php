@extends(template().'layouts.user')
@section('title')
	{{ __('Pay with').' '.__(optional($deposit->gateway)->name) }}
@endsection
@section('content')
<div class="main-content">
	<section class="section mt-lg-5">
		<div class="row justify-content-center">
			<div class="col-md-5">
                <h4>{{ __('Pay with').' '.__(optional($deposit->gateway)->name) }}</h4>
				<div class="card bg-transparent">
					<div class="card-header">
                        <h5 class="card-header-title">@lang('Payment Preview')</h5>
                    </div>
					<div class="card-body text-center">
						<h4 class="text-color"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ getAmount($data->amount) }}</span> {{ __($data->currency) }}</h4>
						<h5>@lang('TO') <span class="text-success"> {{ __($data->sendto) }}</span></h5>
						<img src="{{ $data->img }}">
						<h4 class="text-color bold">@lang('SCAN TO SEND')</h4>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@push('style')
    <style>
        .card img {
            padding: 20px;
        }
        .card {
            border: 1px solid var(--primary);
        }
        .card-header {
            padding: 0;
            margin: 0;
        }
    </style>
@endpush

