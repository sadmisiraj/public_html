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
                               placeholder="RGP Pair Matching Value" value="{{ min(floatval($user->rgp_l ?? 0), floatval($user->rgp_r ?? 0)) }}" autocomplete="off" readonly>
                        <!-- <div class="input-group-text">{{ $basicControl->base_currency ?? 'USD' }}</div> -->
                    </div>
                    @php
                        $matchableValue = min(floatval($user->rgp_l ?? 0), floatval($user->rgp_r ?? 0));
                    @endphp
                    <small class="form-text {{ $matchableValue > 0 ? 'text-success' : 'text-muted' }}">
                        @lang('Current matchable value: :value (RGPL and RGPR)', ['value' => $matchableValue])
                    </small>
                    <small class="form-text text-muted">
                        @lang('When matching occurs, this value will be added to the user\'s balance.')
                    </small>
                    @error('rgp_pair_matching')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-3 col-form-label form-label">@lang('Freeze Daily Credit Show')</label>
                <div class="col-sm-9">
                    <div class="form-check form-switch">
                        <input type="hidden" name="freeze_daily_credit_show" value="0">
                        <input type="checkbox" class="form-check-input" name="freeze_daily_credit_show"
                               id="freezeDailyCreditSwitch" value="1" {{ $user->freeze_daily_credit_show == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="freezeDailyCreditSwitch">
                            @lang('When enabled, shows 0 for today earned RGP values in user profile')
                        </label>
                    </div>
                    @error('freeze_daily_credit_show')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">@lang('Save Changes')</button>
            </div>
        </form>
        
        @php
            $matchableValue = min(floatval($user->rgp_l ?? 0), floatval($user->rgp_r ?? 0));
        @endphp
        @if($matchableValue > 0)
            <div class="mt-4">
                <form action="{{ route('admin.user.match.rgp', $user->id) }}" method="POST">
                    @csrf
                    <div class="alert alert-info">
                        <p>
                            <i class="bi bi-info-circle me-2"></i>
                            @lang('Clicking the Match button will subtract :value from both RGP L and RGP R, and add :value to the user\'s balance.', ['value' => $matchableValue])
                        </p>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>
                            @lang('Match RGP Value (:value)', ['value' => $matchableValue])
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
<!-- End Card --> 