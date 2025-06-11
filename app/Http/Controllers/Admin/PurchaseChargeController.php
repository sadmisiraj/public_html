<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseChargeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Purchase Charges Management';
        $charges = PurchaseCharge::ordered()->get();
        return view('admin.control_panel.purchase_charges', compact('pageTitle', 'charges'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'status' => 'required|boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        PurchaseCharge::create($request->all());

        return back()->with('success', 'Purchase charge added successfully');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'status' => 'required|boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $charge = PurchaseCharge::findOrFail($id);
        $charge->update($request->all());

        return back()->with('success', 'Purchase charge updated successfully');
    }

    public function destroy($id)
    {
        $charge = PurchaseCharge::findOrFail($id);
        $charge->delete();

        return back()->with('success', 'Purchase charge deleted successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $charge = PurchaseCharge::findOrFail($id);
        $charge->status = $request->status;
        $charge->save();

        return back()->with('success', 'Purchase charge status updated successfully');
    }
}
