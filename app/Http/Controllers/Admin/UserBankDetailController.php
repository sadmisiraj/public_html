<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserBankDetail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\Notify;

class UserBankDetailController extends Controller
{
    use Notify;

    public function index($status = null)
    {
        $title = "Bank Account Details";
        if ($status == 'verified') {
            $title = "Verified Bank Accounts";
            $bankDetails = UserBankDetail::with('user')->verified()->latest()->paginate(config('basic.paginate'));
        } elseif ($status == 'unverified') {
            $title = "Unverified Bank Accounts";
            $bankDetails = UserBankDetail::with('user')->unverified()->latest()->paginate(config('basic.paginate'));
        } else {
            $bankDetails = UserBankDetail::with('user')->latest()->paginate(config('basic.paginate'));
        }
        
        return view('admin.bank_details.index', compact('title', 'bankDetails'));
    }

    public function search(Request $request, $status = null)
    {
        $search = $request->search;
        $bankDetails = UserBankDetail::with('user')
            ->whereHas('user', function ($query) use ($search) {
                $query->where('username', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->orWhere('bank_name', 'like', "%$search%")
            ->orWhere('account_number', 'like', "%$search%")
            ->orWhere('ifsc_code', 'like', "%$search%");
        
        if ($status == 'verified') {
            $bankDetails = $bankDetails->verified();
        } elseif ($status == 'unverified') {
            $bankDetails = $bankDetails->unverified();
        }
        
        $bankDetails = $bankDetails->latest()->paginate(config('basic.paginate'));
        return view('admin.bank_details.index', compact('bankDetails', 'search'));
    }

    public function verify($id)
    {
        $bankDetail = UserBankDetail::findOrFail($id);
        $bankDetail->is_verified = true;
        $bankDetail->save();
        
        // Send notification to user
        $user = $bankDetail->user;
        $msg = [
            'username' => $user->username,
            'bank_name' => $bankDetail->bank_name,
            'account_number' => $bankDetail->account_number
        ];
        
        $this->sendMailSms($user, 'BANK_ACCOUNT_VERIFIED', $msg);
        $this->userPushNotification($user, 'BANK_ACCOUNT_VERIFIED', $msg);
        
        return back()->with('success', 'Bank account verified successfully');
    }

    public function reject($id)
    {
        $bankDetail = UserBankDetail::findOrFail($id);
        $bankDetail->is_verified = false;
        $bankDetail->save();
        
        // Send notification to user
        $user = $bankDetail->user;
        $msg = [
            'username' => $user->username,
            'bank_name' => $bankDetail->bank_name,
            'account_number' => $bankDetail->account_number
        ];
        
        $this->sendMailSms($user, 'BANK_ACCOUNT_REJECTED', $msg);
        $this->userPushNotification($user, 'BANK_ACCOUNT_REJECTED', $msg);
        
        return back()->with('success', 'Bank account verification rejected');
    }
}
