<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicControl;
use App\Models\OfferImage;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Exception;

class SecuritySettingsController extends Controller
{
    use Upload;
    
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
    
    /**
     * Show the dashboard popup settings page
     */
    public function dashboardPopupSettings()
    {
        $data['basicControl'] = basicControl();
        return view('admin.security.dashboard_popup', $data);
    }
    
    /**
     * Update dashboard popup settings
     */
    public function updateDashboardPopupSettings(Request $request)
    {
        $request->validate([
            'dashboard_popup_image' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            'dashboard_popup_url' => 'nullable|url|max:255',
            'show_dashboard_popup' => 'required|in:0,1'
        ]);

        try {
            $basic = basicControl();
            
            if ($request->hasFile('dashboard_popup_image')) {
                $image = $this->fileUpload($request->dashboard_popup_image, config('filelocation.popup.path'), null, null, 'webp', 80, $basic->dashboard_popup_image, $basic->dashboard_popup_image_driver);
                if ($image) {
                    $path = $image['path'];
                    $driver = $image['driver'];
                } else {
                    return back()->with('error', 'Image could not be uploaded.');
                }
            }

            $response = BasicControl::updateOrCreate([
                'id' => $basic->id ?? ''
            ], [
                'dashboard_popup_image' => $path ?? $basic->dashboard_popup_image,
                'dashboard_popup_image_driver' => $driver ?? $basic->dashboard_popup_image_driver,
                'dashboard_popup_url' => $request->dashboard_popup_url,
                'show_dashboard_popup' => $request->show_dashboard_popup
            ]);

            if (!$response) {
                throw new Exception('Something went wrong when updating data');
            }

            Artisan::call('optimize:clear');
            return back()->with('success', 'Dashboard popup settings updated successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the offer images settings page
     */
    public function offerImagesSettings()
    {
        return redirect()->route('admin.offer-images.index');
    }

    /**
     * Show the Manual RGP Credit form
     */
    public function manualRgpCreditForm()
    {
        return view('admin.security.manual_rgp_credit');
    }

    /**
     * AJAX: Find all parents up to the root for a given username
     */
    public function findUserParents(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);
        $user = \App\Models\User::whereRaw('LOWER(username) = ?', [strtolower($request->username)])->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $parents = [];
        $creditedIds = [];
        $current = $user;
        while ($current && $current->rgp_parent_id) {
            $parent = \App\Models\User::find($current->rgp_parent_id);
            if (!$parent || in_array($parent->id, $creditedIds)) break;
            $parents[] = [
                'id' => $parent->id,
                'username' => $parent->username,
                'fullname' => trim($parent->firstname . ' ' . $parent->lastname),
                'referral_node' => $current->referral_node,
            ];
            $creditedIds[] = $parent->id;
            $current = $parent;
        }
        // Only add root if not already credited and not the original user
        if ($current && !$current->rgp_parent_id && !in_array($current->id, $creditedIds) && $current->id != $user->id) {
            $parents[] = [
                'id' => $current->id,
                'username' => $current->username,
                'fullname' => trim($current->firstname . ' ' . $current->lastname),
                'referral_node' => $user->referral_node, // for root, use the original user's node
            ];
        }
        return response()->json(['parents' => $parents]);
    }

    /**
     * AJAX: Credit RGP points to all parents in the chain (by username)
     */
    public function manualRgpCredit(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'points' => 'required|numeric|min:0.01',
        ]);
        $user = \App\Models\User::whereRaw('LOWER(username) = ?', [strtolower($request->username)])->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $points = round($request->points, 2);
        $credited = [];
        $creditedIds = [];
        $current = $user;
        $rgpTransactionService = new \App\Services\RgpTransactionService();
        while ($current && $current->rgp_parent_id) {
            $parent = \App\Models\User::find($current->rgp_parent_id);
            if (!$parent) break;
            if (!in_array($parent->id, $creditedIds) && $parent->id != $user->id) {
                $side = $current->referral_node ?? 'left';
                
                // Let the service handle the RGP value update
                $rgpTransactionService->createTransaction(
                    $parent,
                    'credit',
                    $side,
                    $points,
                    'Manual point added',
                    'manual',
                    $user->id,
                    null
                );
                
                $credited[] = [
                    'id' => $parent->id,
                    'username' => $parent->username,
                    'fullname' => trim($parent->firstname . ' ' . $parent->lastname),
                    'side' => $side,
                    'points' => $points
                ];
                $creditedIds[] = $parent->id;
            }
            $current = $parent;
        }
        // After the loop, $current is the root (no parent)
        if ($current && !$current->rgp_parent_id && !in_array($current->id, $creditedIds) && $current->id != $user->id) {
            $side = $user->referral_node ?? 'left';
            
            // Let the service handle the RGP value update
            $rgpTransactionService->createTransaction(
                $current,
                'credit',
                $side,
                $points,
                'Manual point added',
                'manual',
                $user->id,
                null
            );
            
            $credited[] = [
                'id' => $current->id,
                'username' => $current->username,
                'fullname' => trim($current->firstname . ' ' . $current->lastname),
                'side' => $side,
                'points' => $points
            ];
            $creditedIds[] = $current->id;
        }
        return response()->json(['credited' => $credited]);
    }
}
