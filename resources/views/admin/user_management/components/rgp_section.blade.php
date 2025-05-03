<!-- Card -->
<div id="rgpSection" class="card">
    <div class="card-header">
        <h2 class="card-title h4">@lang('RGP Management')</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.user.rgp.update', $user->id) }}" method="post">
            @csrf
            <div class="row mb-4">
                <label for="rgp_l" class="col-sm-3 col-form-label form-label">@lang('RGP L')</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="rgp_l" id="rgp_l"
                               placeholder="RGP Left Value" value="{{ old('rgp_l', $user->rgp_l ?? '') }}" autocomplete="off">
                        <!-- <div class="input-group-text">{{ $basicControl->base_currency ?? 'USD' }}</div> -->
                    </div>
                    @error('rgp_l')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label for="rgp_r" class="col-sm-3 col-form-label form-label">@lang('RGP R')</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="rgp_r" id="rgp_r"
                               placeholder="RGP Right Value" value="{{ old('rgp_r', $user->rgp_r ?? '') }}" autocomplete="off">
                        <!-- <div class="input-group-text">{{ $basicControl->base_currency ?? 'USD' }}</div> -->
                    </div>
                    @error('rgp_r')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label for="rgp_pair_matching" class="col-sm-3 col-form-label form-label">@lang('RGP Pair Matching')</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="rgp_pair_matching" id="rgp_pair_matching"
                               placeholder="RGP Pair Matching Value" value="{{ old('rgp_pair_matching', $user->rgp_pair_matching ?? '') }}" autocomplete="off">
                        <!-- <div class="input-group-text">{{ $basicControl->base_currency ?? 'USD' }}</div> -->
                    </div>
                    @error('rgp_pair_matching')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">@lang('Save Changes')</button>
            </div>
        </form>
    </div>
</div>
<!-- End Card --> 