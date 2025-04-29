@extends(template().'layouts.user')
@section('title')
    @lang('Payout Confirm')
@endsection
@push('navigator')
    <!-- PAGE-NAVIGATOR -->
    <section id="page-navigator">
        <div class="container-fluid">
            <div aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">@lang('Payout Confirm')</a></li>
                </ol>
            </div>
        </div>
    </section>
    <!-- /PAGE-NAVIGATOR -->
@endpush
@section('content')
   <section id="dashboard">
       <div class="main row">
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
                                           <div class="col-md-12 mb-3">
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
                                               <div class="col-md-12 mb-3">
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
                                                   <div class="col-md-12 mb-3">
                                                       <label  for="{{ $value->field_name }}">@lang($value->field_label)</label>
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
                                                   </div>
                                               @elseif($value->type == 'textarea')
                                                   <div class="col-md-12 mb-3">
                                                       <label for="{{ $value->field_name }}" class="mt-3">@lang($value->field_label)</label>
                                                       <div class="input-box mt-2">
                                                            <textarea
                                                                class="form-control @error($value->field_name) is-invalid @enderror"
                                                                name="{{$value->field_name}}"
                                                                rows="2">{{ old($value->field_name) }}</textarea>
                                                           <div
                                                               class="invalid-feedback">@error($value->field_name) @lang($message) @enderror</div>
                                                       </div>
                                                   </div>
                                               @elseif($value->type == 'file')
                                                   <div class="col-md-12">
                                                       <div class="input-box">
                                                           <label class="mb-3" for="image-upload"
                                                           >@lang($value->field_label)</label>
                                                           <div id="image-preview" class="image-inputs">
                                                               <label for="image-upload" id="image-label">
                                                                   <i class="fas fa-upload"></i>
                                                               </label>
                                                               <input type="file" name="{{ $value->field_name }}"
                                                                      class="form-control @error($value->field_name) is-invalid @enderror"
                                                                      id="image-upload"/>
                                                               <img class="preview-image" id="image_preview_container"
                                                                    src="{{getFile(config('filelocation.default'))}}"
                                                                    alt="@lang('Upload Image')">
                                                           </div>
                                                           <div class="invalid-feedback d-block">
                                                               @error($value->field_name) @lang($message) @enderror
                                                           </div>
                                                       </div>
                                                   </div>
                                               @endif
                                           @endforeach
                                       @endif

                                   </div>
                               </div>
                               <div class="card-footer d-flex justify-content-end">
                                   <button type="submit" class="btn btn-primary base-btn btn-block btn-rounded">@lang('submit') <span></span></button>
                               </div>
                           </form>
                       </div>
                   </div>
                   <div class="col-lg-4">
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
                               <span class=" ">{{ (getAmount($payout->amount_in_base_currency)) }} {{ basicControl()->base_currency }}</span>
                           </li>
                       </ul>
                   </div>
               </div>
           </div>
       </div>
   </section>

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
        .list-group-numbered{
            border: 1px solid var(--bordercolor);
        }
        .list-group-numbered li {
            border-bottom: 1px solid var(--bordercolor);
        }
        #dashboard{
            margin-top: 55px!important;
        }
        .form-control {
            background-color: var(--bgLight);
            border-color: var(--bgLight);
        }

        .card{
            background: transparent;
            border: 1px solid var(--bordercolor);
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .image-inputs {
            position: relative;
            padding: 20px;
            border: 2px dashed #ddd;
            cursor: pointer;
            height: 230px !important;
            width: 288px;
        }

        .preview-image{
            max-height: 186px;
            width: 243px;
        }

        .image-inputs input#image-upload {
            position: absolute;
            width: 84%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            max-height: 185px;
            padding: 0;
        }

        .image-inputs #image-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .image-inputs #image-label i {
            font-size: 24px;
            color: var(--primary);
            opacity: 0.5;
        }
        .form-control:focus {
            color: #FFFFFF;
            outline: 0;
            box-shadow: none;
        }
        .card-body textarea:focus{
            background: transparent;
        }

        .card-body textarea{
            line-height: 2;
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
