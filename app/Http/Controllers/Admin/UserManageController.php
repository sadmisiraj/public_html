<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManageController extends Controller
{
    public function update(Request $request, $id)
    {
        $userData = User::findOrFail($id);
        $rules = [
            'firstName' => 'nullable',
            'lastName' => 'nullable',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,' . $userData->id,
            'username' => 'required|alpha_dash|unique:users,username,' . $userData->id,
            'country' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'zipCode' => 'nullable',
            'addressOne' => 'nullable',
            'addressTwo' => 'nullable',
            'referral_node' => 'nullable|in:left,right,',
            'status' => 'nullable'
        ];
        // ... existing code ...
        $userData->address_one = $request->addressOne;
        $userData->address_two = $request->addressTwo;
        $userData->status = $request->status;
        $userData->referral_node = $request->referral_node;
        $userData->save();
        // ... existing code ...
    }
} 