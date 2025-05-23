@extends(template().'layouts.user')
@section('title',__($page_title))

@section('content')
    <div class="main-wrapper">
        <div class="pagetitle">
            <h3 class="mb-1">@lang('Balance Transfer')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Balance Transfer')</li>
                </ol>
            </nav>
        </div>


        <!-- transactions section start -->
        <div class="transactions-section mt-50">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>@lang('Balance Transfer')</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('user.money.transfer')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div>
                                            <label for="Recipient-username"
                                                   class="form-label">@lang('Receiver User ID') </label>
                                            <input type="text" class="form-control"
                                                   id="Recipient-username" name="username" value="{{old('username')}}" required>
                                        </div>
                                        @error('username')
                                        <div class="error text-danger">@lang($message) </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="currency" class="form-label">@lang('Enter Amount')</label>
                                            <input type="text" class="form-control"  name="amount" value="{{old('amount')}}" id="currency">
                                        </div>
                                        @error('amount')
                                        <div class="error text-danger">@lang($message) </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="Amount" class="form-label">@lang('Select Wallet')</label>
                                            <select name="wallet_type" id="wallet_type" class="form-control" required>
                                                <option value="" selected disabled>{{trans('Select Wallet')}}</option>
                                                <option value="balance" >{{trans('Deposit Balance')}}</option>
                                                <option value="interest_balance" >{{trans('Profit Balance')}}</option>
                                                <option value="profit_balance" >{{trans('Performance Balance')}}</option>
                                            </select>
                                        </div>
                                        @error('wallet_type')
                                        <div class="error text-danger">@lang($message) </div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div>
                                            <label for="exampleFormControlTextarea1"
                                                   class="form-label">@lang('Enter Password')</label>
                                            <input type="password" name="password" class="form-control"
                                                   id="Password" value="{{old('password')}}" required>
                                        </div>

                                    </div>

                                    <div class="btn-area">
                                        <button type="submit" class="cmn-btn w-100">@lang('send money')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- transactions section end -->
    </div>
@endsection
