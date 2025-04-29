@extends(template().'layouts.user')
@section('title',__('Payout'))

@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="section-header">
                <h3>@lang('Payout')</h3>
            </div>
            <div class="col-12">
                <div class="row g-4 g-lg-5">
                    <div class="col-lg-6">
                        <div class="card">
                            <form action="{{ route('user.payout.confirm',$payout->trx_id) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                    <div class="card-body">
                                        <div class="row g-4">
                                                @if($payoutMethod->supported_currency)
                                                    <div class="col-md-12">
                                                        <label for="from_wallet" class="mb-2">@lang('Select Bank Currency')</label>
                                                        <div class="input-box search-currency-dropdown">
                                                            <input type="text" name="currency_code"
                                                                   placeholder="Selected"
                                                                   autocomplete="off"
                                                                   value="{{ $payout->payout_currency_code }}"
                                                                   class="form-control transfer-currency @error('currency_code') is-invalid @enderror">

                                                            @error('currency_code')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($payoutMethod->code == 'paypal')
                                                    <div class="row">
                                                        <div class="col-md-12 mt-2">
                                                            <label for="from_wallet">@lang('Select Recipient Type')</label>
                                                            <div class="form-group search-currency-dropdown">
                                                                <select id="from_wallet" name="recipient_type"
                                                                        class="form-control form-control-sm" required>
                                                                    <option value="" disabled=""
                                                                            selected="">@lang('Select Recipient')</option>
                                                                    <option value="EMAIL">@lang('Email')</option>
                                                                    <option value="PHONE">@lang('phone')</option>
                                                                    <option value="PAYPAL_ID">@lang('Paypal Id')</option>
                                                                </select>
                                                                @error('recipient_type')
                                                                <span class="text-danger">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif


                                                @if(isset($payoutMethod->inputForm))

                                                    @foreach($payoutMethod->inputForm as $key => $value)
                                                        @if($value->type == 'text')
                                                            <label for="{{ $value->field_name }}">@lang($value->field_label)</label>
                                                            <div class="input-box mt-2">
                                                                <input type="text" name="{{ $value->field_name }}"
                                                                       placeholder="{{ __(snake2Title($value->field_name)) }}"
                                                                       autocomplete="off"
                                                                       value="{{ old(snake2Title($value->field_name)) }}"
                                                                       class="form-control @error($value->field_name) is-invalid @enderror">
                                                                <div class="invalid-feedback">
                                                                    @error($value->field_name) @lang($message) @enderror
                                                                </div>
                                                            </div>
                                                        @elseif($value->type == 'textarea')
                                                            <label for="{{ $value->field_name }}" class="mt-3">@lang($value->field_label)</label>
                                                            <div class="input-box mt-2">
                                                            <textarea
                                                                class="form-control @error($value->field_name) is-invalid @enderror"
                                                                name="{{$value->field_name}}"
                                                                rows="5">{{ old($value->field_name) }}</textarea>
                                                                <div
                                                                    class="invalid-feedback">@error($value->field_name) @lang($message) @enderror</div>
                                                            </div>
                                                        @elseif($value->type == 'file')

                                                            <div class="input-box mt-2 ">
                                                                <label for="image-upload"
                                                                      >@lang($value->field_label)</label>
                                                                <div id="image-preview" class="image-input">
                                                                    <label for="image-upload" id="image-label">
                                                                        <i class="fa-regular fa-upload"></i>
                                                                    </label>
                                                                    <input type="file" name="{{ $value->field_name }}"
                                                                           class="form-control @error($value->field_name) is-invalid @enderror"
                                                                           id="image-upload"/>
                                                                    <img class=" preview-image" id="image_preview_container"
                                                                         src="{{getFile(config('filelocation.default'))}}"
                                                                         alt="@lang('Upload Image')">
                                                                </div>
                                                                <div class="invalid-feedback d-block">
                                                                    @error($value->field_name) @lang($message) @enderror
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </div>
                                    </div>
                                <div class="card-footer d-flex justify-content-end bg-white">
                                    <button type="submit" class="btn btn-primary">@lang('submit') <span></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div id="tab1" class="content active">
                            <ul class="list-group list-group-numbered">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold-500">@lang('Payout Method')</div>
                                    </div>
                                    <span class="">{{ __($payoutMethod->name) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold-500">@lang('Request Amount')</div>

                                    </div>
                                    <span class=" ">{{ (getAmount($payout->amount)) }} {{ $payout->payout_currency_code }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold-500">@lang('Percentage')</div>
                                    </div>
                                    <span class=" ">{{ (getAmount($payout->percentage)) }} {{ $payout->payout_currency_code }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold-500">@lang('Charge Percentage')</div>
                                    </div>
                                    <span class=" ">{{ (getAmount($payout->charge_percentage)) }} {{ $payout->payout_currency_code }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold-500">@lang('Charge Fixed')</div>
                                    </div>
                                    <span class=" ">{{ (getAmount($payout->charge_fixed)) }} {{ $payout->payout_currency_code }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold-500">@lang('Charge')</div>
                                    </div>
                                    <span class=" ">{{ (getAmount($payout->charge)) }} {{ $payout->payout_currency_code }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold-500">@lang('Amount In Base Currency')</div>
                                    </div>
                                    <span class=" ">{{ (getAmount($payout->amount_in_base_currency)) }} {{ $payout->base_currency }}</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('extra_scripts')
    <script src="{{ asset('assets/dashboard/js/jquery.uploadPreview.min.js') }}"></script>
@endpush
@push('script')
    <script>
        'use strict'
        $(document).on("change",'#image-upload',function () {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#image_preview_container').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endpush
@push('style')
    <style>
        .form-control {
            background-color: var(--bgLight);
            border-color: var(--bgLight);
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .image-input {
            position: relative;
            width:25%;
            padding: 20px;
            border: 2px dashed #ddd;
            cursor: pointer;
        }

        .image-input input#image-upload {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .image-input #image-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .image-input #image-label i {
            font-size: 24px;
            color: var(--primary);
            opacity: 0.5;
        }
        .form-control:focus {
            color: #212529;
            background-color: var(--bgLight);
            border-color: var(--primary);
            outline: 0;
            box-shadow: none;
        }
    </style>
@endpush
@push('script')
    <script type="text/javascript">

    </script>

    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.failure("{{ trans($error) }}");
            @endforeach
        </script>
    @endif
@endpush
