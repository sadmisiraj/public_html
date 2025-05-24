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
        $requirePayoutOtp = $request->has('require_payout_otp') ? 1 : 0;
        $requireMoneyTransferOtp = $request->has('require_money_transfer_otp') ? 1 : 0;

        try {
            $basic = basicControl();
            $response = BasicControl::updateOrCreate([
                'id' => $basic->id ?? ''
            ], [
                'require_payout_otp' => $requirePayoutOtp,
                'require_money_transfer_otp' => $requireMoneyTransferOtp,
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
