<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\UserKyc;
use App\Models\UserBankDetail;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KycVerificationController extends Controller
{
    use Upload;
    public function kyc()
    {
        $data['kyc'] = Kyc::orderBy('id', 'asc')->where('status', 1)->get();
        return view(template() . 'user.verification_center.index', $data);
    }

    public function kycForm($id)
    {
        $data['kyc'] = Kyc::findOrFail($id);
        $data['userKyc'] = UserKyc::where('user_id', auth()->id())->where('kyc_id', $id)
            ->where('status', '!=', 2)
            ->first();
        return view(template() . 'user.verification_center.kyc_form', $data);
    }

    public function verificationSubmit(Request $request)
    {
        $kyc = Kyc::where('id', $request->type)->where('status', 1)->firstOrFail();

        $params = $kyc->input_form;
        $reqData = $request->except('_token', '_method');
        $rules = [];
        if ($params !== null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation == 'required' ? $cus->validation : 'nullable'];
                if ($cus->type === 'file') {
                    $rules[$key][] = 'image';
                    $rules[$key][] = 'mimes:jpeg,jpg,png';
                    $rules[$key][] = 'max:2048';
                } elseif ($cus->type === 'text') {
                    $rules[$key][] = 'max:191';
                } elseif ($cus->type === 'number') {
                    $rules[$key][] = 'integer';
                } elseif ($cus->type === 'textarea') {
                    $rules[$key][] = 'min:3';
                    $rules[$key][] = 'max:300';
                }
            }
        }

        // Add validation rules for bank details
        $rules['BankName'] = ['required', 'string', 'max:191'];
        $rules['AccountNumber'] = ['required', 'string', 'max:191'];
        $rules['IFSCCode'] = ['required', 'string', 'max:191'];
        
        // Add validation rules for Aadhar card
        $rules['aadhar_number'] = ['required', 'string', 'size:12'];
        $rules['aadhar_front'] = ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'];
        $rules['aadhar_back'] = ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'];

        $validator = Validator::make($reqData, $rules);
        if ($validator->fails()) {
            $validator->errors()->add($kyc->name, '1');
            return back()->withErrors($validator)->withInput();
        }

        $reqField = [];

        foreach ($request->except('_token', '_method', 'type', 'BankName', 'AccountNumber', 'IFSCCode', 'aadhar_number', 'aadhar_front', 'aadhar_back') as $k => $v) {
            foreach ($params as $inKey => $inVal) {
                if ($k == $inKey) {
                    if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                        try {
                            $file = $this->fileUpload($request[$inKey], config('filelocation.kyc.path'),null,null,'webp',80);
                            $reqField[$inKey] = [
                                'field_name' => $inVal->field_name,
                                'field_label' => $inVal->field_label,
                                'field_value' => $file['path'],
                                'field_driver' => $file['driver'],
                                'validation' => $inVal->validation,
                                'type' => $inVal->type,
                            ];
                        } catch (\Exception $exp) {
                            session()->flash('error', 'Could not upload your ' . $inKey);
                            return back()->withInput();
                        }
                    } else {
                        $reqField[$inKey] = [
                            'field_name' => $inVal->field_name,
                            'field_label' => $inVal->field_label,
                            'validation' => $inVal->validation,
                            'field_value' => $v,
                            'type' => $inVal->type,
                        ];
                    }
                }
            }
        }

        // Process Aadhar card fields
        if ($request->hasFile('aadhar_front')) {
            try {
                $aadharFrontFile = $this->fileUpload($request['aadhar_front'], config('filelocation.kyc.path'), null, null, 'webp', 80);
                $reqField['aadhar_front'] = [
                    'field_name' => 'aadhar_front',
                    'field_label' => 'Aadhar Card Front Side',
                    'field_value' => $aadharFrontFile['path'],
                    'field_driver' => $aadharFrontFile['driver'],
                    'validation' => 'required',
                    'type' => 'file',
                ];
            } catch (\Exception $exp) {
                session()->flash('error', 'Could not upload your Aadhar Card Front Side');
                return back()->withInput();
            }
        }

        if ($request->hasFile('aadhar_back')) {
            try {
                $aadharBackFile = $this->fileUpload($request['aadhar_back'], config('filelocation.kyc.path'), null, null, 'webp', 80);
                $reqField['aadhar_back'] = [
                    'field_name' => 'aadhar_back',
                    'field_label' => 'Aadhar Card Back Side',
                    'field_value' => $aadharBackFile['path'],
                    'field_driver' => $aadharBackFile['driver'],
                    'validation' => 'required',
                    'type' => 'file',
                ];
            } catch (\Exception $exp) {
                session()->flash('error', 'Could not upload your Aadhar Card Back Side');
                return back()->withInput();
            }
        }

        // Add Aadhar number to reqField
        $reqField['aadhar_number'] = [
            'field_name' => 'aadhar_number',
            'field_label' => 'Aadhar Card Number',
            'validation' => 'required',
            'field_value' => $request->aadhar_number,
            'type' => 'text',
        ];

        // Get current user
        $user = auth()->user();
        $userId = $user->id;

        UserKyc::create([
            'user_id' => $userId,
            'kyc_id' => $kyc->id,
            'kyc_type' => $kyc->name,
            'kyc_info' => $reqField
        ]);

        // Get bank details from request
        $bankName = $request->input('BankName');
        $accountNumber = $request->input('AccountNumber');
        $ifscCode = $request->input('IFSCCode');
        
        if ($bankName && $accountNumber && $ifscCode) {
            \Log::info('Saving bank details', [
                'user_id' => $userId,
                'bank_name' => $bankName,
                'account_number' => $accountNumber,
                'ifsc_code' => $ifscCode
            ]);
            
            try {
                // Check if user already has bank details
                $existingBankDetails = UserBankDetail::where('user_id', $userId)->first();
                
                if ($existingBankDetails) {
                    // Update existing record
                    $existingBankDetails->update([
                        'bank_name' => $bankName,
                        'account_number' => $accountNumber,
                        'ifsc_code' => $ifscCode,
                        'is_verified' => false // will be verified by admin
                    ]);
                    
                    \Log::info('Updated existing bank details', ['id' => $existingBankDetails->id]);
                } else {
                    // Create new record
                    $newBankDetails = new UserBankDetail();
                    $newBankDetails->user_id = $userId;
                    $newBankDetails->bank_name = $bankName;
                    $newBankDetails->account_number = $accountNumber;
                    $newBankDetails->ifsc_code = $ifscCode;
                    $newBankDetails->is_verified = false;
                    $newBankDetails->save();
                    
                    \Log::info('Created new bank details', ['id' => $newBankDetails->id]);
                }
            } catch (\Exception $e) {
                \Log::error('Error saving bank details', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } else {
            \Log::warning('Bank details not saved - missing required fields', [
                'bankName' => $bankName,
                'accountNumber' => $accountNumber,
                'ifscCode' => $ifscCode,
            ]);
        }

        return back()->with('success', 'KYC Sent Successfully');
    }

    public function history()
    {
        $data['userKyc'] = UserKyc::with(['user', 'kyc'])->where('user_id', auth()->id())->paginate(basicControl()->paginate);
        return view(template() . 'user.verification_center.history', $data);
    }

}
