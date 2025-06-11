<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Exception;

class SecuritySettingsController extends Controller
{
    /**
     * Show the security settings index page
     */
    public function index()
    {
        $data['basicControl'] = basicControl();
        return view('admin.security.index', $data);
    }

    /**
     * Show the payout settings page
     */
    public function payoutSettings()
    {
        $data['basicControl'] = basicControl();
        return view('admin.security.payout_settings', $data);
    }

    /**
     * Update payout settings
     */
    public function updatePayoutSettings(Request $request)
    {
        $request->validate([
            'money_transfer_limit_type' => 'required_if:money_transfer_limit_enabled,1|in:daily,weekly,custom_days',
            'money_transfer_limit_count' => 'required_if:money_transfer_limit_enabled,1|integer|min:1|max:100',
            'money_transfer_limit_days' => 'required_if:money_transfer_limit_type,custom_days|integer|min:1|max:365',
        ]);

        $requirePayoutOtp = $request->has('require_payout_otp') ? 1 : 0;
        $requireMoneyTransferOtp = $request->has('require_money_transfer_otp') ? 1 : 0;
        $moneyTransferLimitEnabled = $request->has('money_transfer_limit_enabled') ? 1 : 0;

        try {
            $basic = basicControl();
            $response = BasicControl::updateOrCreate([
                'id' => $basic->id ?? ''
            ], [
                'require_payout_otp' => $requirePayoutOtp,
                'require_money_transfer_otp' => $requireMoneyTransferOtp,
                'money_transfer_limit_enabled' => $moneyTransferLimitEnabled,
                'money_transfer_limit_type' => $request->money_transfer_limit_type ?? 'daily',
                'money_transfer_limit_count' => $request->money_transfer_limit_count ?? 1,
                'money_transfer_limit_days' => $request->money_transfer_limit_days ?? 1,
            ]);

            if (!$response) {
                throw new Exception('Something went wrong when updating the data.');
            }

            Artisan::call('optimize:clear');
            return back()->with('success', 'Security settings updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
