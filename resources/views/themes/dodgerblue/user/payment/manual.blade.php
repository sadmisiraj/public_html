@extends(template().'layouts.user')
@section('title')
    {{ 'Pay with '.optional($deposit->gateway)->name ?? '' }}
@endsection

@section('content')
    <section class="feature-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="feature-box">
                    <div class="col-md-12">
                        <h3 class="title text-center">{{trans('Please follow the instruction below')}}</h3>
                        <p class="text-center mt-2 ">{{trans('You have requested to payment')}} <b
                                class="text--base">{{getAmount($deposit->amount)}} {{$deposit->payment_method_currency}}
                                {{config('basic.base_currency')}}</b> , {{trans('Please pay')}}
                            <b class="text--base">{{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</b> {{trans('for successful payment')}}
                        </p>

                        <p class=" mt-2 ">
                            <?php echo optional($deposit->gateway)->note; ?>
                        </p>

                        <form action="{{route('addFund.fromSubmit',$deposit->trx_id)}}" method="post"
                              enctype="multipart/form-data"
                              class="form-row  preview-form">
                            @csrf
                            @if(optional($deposit->gateway)->parameters)
                                @foreach($deposit->gateway->parameters as $k => $v)
                                    @if($v->type == "text")
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group  ">
                                                <label>{{trans($v->field_label)}} @if($v->validation == 'required')
                                                        <span class="text--danger">*</span>
                                                    @endif </label>
                                                <input type="text" name="{{$k}}"
                                                       class="form-control bg-transparent"
                                                       @if($v->validation == "required") required @endif>
                                                @if ($errors->has($k))
                                                    <span
                                                        class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        @elseif($v->type == "number")
                                            <div class="col-md-12 mt-2">
                                                <div class="form-group  ">
                                                    <label>{{trans($v->field_label)}} @if($v->validation == 'required')
                                                            <span class="text--danger">*</span>
                                                        @endif </label>
                                                    <input type="text" name="{{$k}}"
                                                           class="form-control bg-transparent"
                                                           @if($v->validation == "required") required @endif>
                                                    @if ($errors->has($k))
                                                        <span
                                                            class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                    @elseif($v->type == "textarea")
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <label>{{trans($v->field_label)}} @if($v->validation == 'required')
                                                        <span class="text--danger">*</span>
                                                    @endif </label>
                                                <textarea name="{{$k}}" class="form-control bg-transparent"
                                                          rows="3"
                                                          @if($v->validation == "required") required @endif></textarea>
                                                @if ($errors->has($k))
                                                    <span
                                                        class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @elseif($v->type == "file")
                                        <div class="col-md-6 form-group">
                                            <label>{{trans($v->field_label)}} @if($v->validation == 'required')
                                                    <span class="text--danger">*</span>
                                                @endif </label>
                                            <div class="image-input">
                                                <label for="image-upload" id="image-label">
                                                    <i class="fa-regular fa-upload"></i>
                                                </label>

                                                <input type="file" name="{{$k}}" id="image" accept="image/*"
                                                       @if($v->validation == "required") required @endif>
                                                <img class="w-100 preview-image" id="image_preview_container"
                                                     src="{{getFile(config('filelocation.default'))}}"
                                                     alt="@lang('Upload Image')">
                                            </div>
                                            @error($k)
                                            <span class="text-danger">@lang($message)</span>
                                            @enderror
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="col-md-12 ">
                                <div class=" form-group">
                                    <button type="submit" class="btn btn-primary w-100 mt-3">
                                        <span>@lang('Confirm Now')</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        'use strict'
        $(document).on("change",'#image',function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
    </script>
@endpush
