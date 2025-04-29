@extends('admin.layouts.app')
@section('page_title',__('Create Plan'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Create Plan')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Create Plan')</h1>
                </div>
            </div>
        </div>
        <form action="{{route('admin.plan.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3 mb-lg-5">
                        <!-- Header -->
                        <div class="card-header">
                            <h4 class="card-header-title">@lang('Plan Information')</h4>
                        </div>
                        <!-- End Header -->

                        <!-- Body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="planName" class="form-label">@lang('Name')</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" name="name" id="planName" placeholder="e.g : basic plan">
                                        @error("name")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="plan_period_fixed">
                                    <label for="badge" class="form-label">@lang('Badge Name')  <small>({{trans('Optional')}})</small></label>
                                    <i class="bi bi-info-circle text-body ms-1"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       aria-label="The Badge Name is an optional label that can be associated with this plan. It can be a short description or identifier, such as 'Gold Member' or 'Premium'."
                                       data-bs-original-title="The Badge Name is an optional label that can be associated with this plan. It can be a short description or identifier, such as 'Gold Member' or 'Premium'."
                                    ></i>
                                    <div class=" mb-4">
                                        <input type="text" name="badge" value="{{old('badge')}}" id="badge" class="form-control @error('badge') is-invalid @enderror" placeholder="e.g : premium , popular">
                                        @error("badge")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6" id="minimum_invest_field">
                                    <label for="minimum_invest" class="form-label">@lang('Minimum Amount')</label>
                                    <div class="input-group mb-4">
                                        <input type="number" class="form-control @error('minimum_amount') is-invalid @enderror" value="{{old('minimum_amount')}}" id="minimum_invest" name="minimum_amount" placeholder="e.g : 2000" step="0.01">
                                        <span class="input-group-text" id="priceCurrency">{{basicControl()->currency_symbol}}</span>
                                        @error("minimum_amount")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6" id="maximum_invest_field">
                                    <label for="maximum_invest" class="form-label">@lang('Maximum Amount')</label>
                                    <div class="input-group mb-4">
                                        <input type="text" class="form-control @error('maximum_amount') is-invalid @enderror" value="{{old('maximum_amount')}}" id="minimum_invest" name="maximum_amount" placeholder="e.g : 5000">
                                        <span class="input-group-text" id="priceCurrency">{{basicControl()->currency_symbol}}</span>
                                        @error("maximum_amount")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6" id="fixed_invest_amount">
                                    <label for="plan_price" class="form-label">@lang('Fixed Amount')</label>
                                    <div class="input-group mb-4">
                                        <input type="number" class="form-control @error('fixed_amount') is-invalid @enderror" value="{{old('fixed_amount')}}" id="plan_price" name="fixed_amount" placeholder="e.g : 8000" step="0.01">
                                        <span class="input-group-text" id="priceCurrency">{{basicControl()->currency_symbol}}</span>
                                        @error("fixed_amount")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="return_period" class="form-label">@lang('Yield')</label>
                                    <i class="bi bi-info-circle text-body ms-1"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       aria-label="The Yield represents the percentage return on investment over the specified period."
                                       data-bs-original-title="The Yield represents the percentage return on investment over the specified period."
                                    ></i>
                                    <div class="input-group mb-4">
                                        <input type="number" class="form-control @error('profit') is-invalid @enderror" id="return_period" value="{{old('profit')}}" name="profit" placeholder="e.g : 5.00" step="0.001">

                                        <!-- Select -->
                                        <div class="tom-select-custom">
                                            <select class="js-select form-select" name="profit_type" autocomplete="off"
                                                    data-hs-tom-select-options='{
                                                  "placeholder": "Select a person...",
                                                  "hideSearch": true
                                             }'>

                                                <option value="1" @selected(old('profit_type') == 1)>%</option>
                                                <option value="0" @selected(old('profit_type') == 0)>{{basicControl()->currency_symbol}}</option>
                                            </select>
                                        </div>
                                        <!-- End Select -->
                                        @error("profit")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="profit" class="form-label">@lang('Accrual')</label>
                                    <!-- Select -->
                                    <div class="tom-select-custom">
                                        <select class="js-select form-select @error('schedule') is-invalid @enderror" name="schedule"   autocomplete="off"
                                                data-hs-tom-select-options='{
                                                  "placeholder": "Select a period",
                                                  "hideSearch": true
                                             }'>
                                            <option>@lang('Select a Period')</option>
                                            @foreach($times as $item)
                                                <option value="{{$item->time}}" @selected(old('schedule') == $item->time)>@lang('Every') {{$item->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <!-- End Select -->
                                    @error("schedule")
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6" id="Maturity">
                                    <label for="profit" class="form-label">@lang('Maturity')</label>
                                    <i class="bi bi-info-circle text-body ms-1"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       aria-label="how many times?"
                                       data-bs-original-title="how many times?"
                                    ></i>
                                    <div class="input-group mb-4">
                                        <input type="number" name="repeatable"   value="{{old('repeatable')}}"  class="form-control @error('repeatable') is-invalid @enderror" placeholder="e.g : 50">
                                        <!-- Select -->
                                        <span class="input-group-text">@lang('Days')</span>
                                        @error("repeatable")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Body -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h4 class="card-header-title">@lang(' Status')</h4>
                                </div>
                                <div class="card-body">
                                    <div class="list-group-item mb-4">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h5 class="mb-0">@lang('Plan Price Type')</h5>
                                                        <p class="fs-5 text-body mb-0">@lang('Invest amount has range then turn off this button')</p>
                                                    </div>
                                                    <div class="col-sm-auto d-flex align-items-center">
                                                        <div class="form-check form-switch form-switch-google">
                                                            <input type="hidden" name="plan_price_type" value="0">
                                                            <input class="form-check-input" name="plan_price_type"
                                                                   type="checkbox" id="plan_price_type" value="1" @checked(old('plan_price_type') == 1)>
                                                            <label class="form-check-label"
                                                                   for="plan_price_type"></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 ms-3 mb-4">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h5 class="mb-0">@lang('Capital Back')</h5>
                                                        <p class="fs-5 text-body mb-0">@lang('If you want to return of the original amount of money invested at the end of the investment period , then please turn on this button')</p>
                                                    </div>
                                                    <div class="col-sm-auto d-flex align-items-center">
                                                        <div class="form-check form-switch form-switch-google">
                                                            <input type="hidden" name="is_capital_back" value="0">
                                                            <input class="form-check-input" name="is_capital_back"
                                                                   type="checkbox" id="is_capital_back" value="1" @checked(old('is_capital_back') == 1)>
                                                            <label class="form-check-label"
                                                                   for="is_capital_back"></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item mb-4">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h5 class="mb-0">@lang('Return')</h5>
                                                        <p class="fs-5 text-body mb-0">@lang('If return type has lifetime then turn on this button.')</p>
                                                    </div>
                                                    <div class="col-sm-auto d-flex align-items-center">
                                                        <div class="form-check form-switch form-switch-google">
                                                            <input type="hidden" name="is_lifetime" value="0">
                                                            <input class="form-check-input" name="is_lifetime"
                                                                   type="checkbox" id="is_lifetime" value="1" @checked(old('is_lifetime') == 1)>
                                                            <label class="form-check-label"
                                                                   for="is_lifetime"></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('is_lifetime')
                                        <span class="invalid-feedback d-block ms-3">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="list-group-item mb-4">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h5 class="mb-0">@lang('Featured')</h5>
                                                        <p class="fs-5 text-body mb-0">@lang('If plan period has unlimited then turn on this button.')</p>
                                                    </div>
                                                    <div class="col-sm-auto d-flex align-items-center">
                                                        <div class="form-check form-switch form-switch-google">
                                                            <input type="hidden" name="featured" value="0">
                                                            <input class="form-check-input" name="featured"
                                                                   type="checkbox" id="featured" value="1" @checked(old('featured') == 1)>
                                                            <label class="form-check-label"
                                                                   for="featured"></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('unlimited_period')
                                        <span class="ms-4 invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h4 class="card-header-title">@lang('Publish')</h4>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <button class="btn btn-primary" type="submit" name="status" value="1">@lang('Save & Publish')</button>
                                        <button class="btn btn-info ms-3" type="submit" name="status" value="0">@lang('Save & Draft')</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>


    </div>



@endsection
@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hs-add-field.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hs-file-attach.min.js') }}"></script>
@endpush
@push('script')
    <script>
        (function () {
            new HSFileAttach('.js-file-attach')
            HSCore.components.HSFlatpickr.init('.js-flatpickr')
        })();
        (function() {
            // INITIALIZATION OF ADD FIELD
            // =======================================================
            new HSAddField('.js-add-field')
        })();
        (function() {
            // INITIALIZATION OF SELECT
            // =======================================================
            HSCore.components.HSTomSelect.init('.js-select')
        })();
        $(document).on('click', '.deleteInputField', function () {
            $(this).closest('.row').remove();
        });



        if ( $('#plan_price_type').is(':checked')){
            $('#minimum_invest_field').hide();
            $('#maximum_invest_field').hide();
            $('#fixed_invest_amount').show();
        }else {
            $('#minimum_invest_field').show();
            $('#maximum_invest_field').show();
            $('#fixed_invest_amount').hide();
        }

        if ( $('#is_lifetime').is(':checked')){
            $('#Maturity').hide()
        }else {
            $('#Maturity').show()
        }

        $(document).on('change','#is_lifetime',function (){
            if ($(this).is(':checked')) {
                $('#Maturity').hide()
            } else {
                $('#Maturity').show()
            }
        })

        $(document).on('change','#plan_price_type',function (){
            if ($(this).is(':checked')) {
                $('#minimum_invest_field').hide();
                $('#maximum_invest_field').hide();
                $('#fixed_invest_amount').show();
            } else {
                $('#minimum_invest_field').show();
                $('#maximum_invest_field').show();
                $('#fixed_invest_amount').hide();
            }
        })

    </script>
@endpush
