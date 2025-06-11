<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GoldCoin;
use App\Models\GoldCoinOrder;
use App\Models\PurchaseCharge;
use App\Models\Transaction;
use App\Models\InAppNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDF;

class GoldCoinController extends Controller
{
    public function index()
    {
        $pageTitle = 'Purchase Gold';
        $coins = GoldCoin::where('status', 1)->latest()->get();
        $basic = basicControl();
        
        return view(template() . 'user.gold_coin.index', compact('pageTitle', 'coins', 'basic'));
    }
    
    public function coinDetails($id)
    {
        $pageTitle = 'Gold Coin Details';
        $coin = GoldCoin::where('status', 1)->findOrFail($id);
        $user = Auth::user();
        $basic = basicControl();
        $purchaseCharges = PurchaseCharge::getActiveCharges();
        
        return view(template() . 'user.gold_coin.purchase', compact('pageTitle', 'coin', 'user', 'basic', 'purchaseCharges'));
    }
    
    public function purchaseGold(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coin_id' => 'required|exists:gold_coins,id',
            'weight' => 'required|numeric|min:0.01',
            'payment_source' => 'required|in:deposit,profit,performance',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $coin = GoldCoin::where('status', 1)->findOrFail($request->coin_id);
        
        $weight = $request->weight;
        $subtotal = $weight * $coin->price_per_gram;
        
        // Calculate purchase charges using configurable charges
        $purchaseCharges = PurchaseCharge::getActiveCharges();
        $chargesBreakdown = [];
        $totalCharges = 0;
        $gstAmount = 0; // Keep for backward compatibility
        
        foreach ($purchaseCharges as $charge) {
            $chargeAmount = $charge->calculateChargeAmount($subtotal);
            $chargesBreakdown[] = [
                'label' => $charge->label,
                'type' => $charge->type,
                'value' => $charge->value,
                'amount' => $chargeAmount
            ];
            $totalCharges += $chargeAmount;
            
            // Set GST amount for backward compatibility (first charge named GST or any charge)
            if (stripos($charge->label, 'gst') !== false || $gstAmount == 0) {
                $gstAmount = $chargeAmount;
            }
        }
        
        // Calculate total price with charges
        $totalPrice = $subtotal + $totalCharges;
        
        // Check if user has sufficient balance
        if ($request->payment_source == 'deposit' && $user->balance < $totalPrice) {
            return back()->with('error', 'Insufficient deposit balance')->withInput();
        } elseif ($request->payment_source == 'profit' && $user->interest_balance < $totalPrice) {
            return back()->with('error', 'Insufficient profit balance')->withInput();
        } elseif ($request->payment_source == 'performance' && $user->profit_balance < $totalPrice) {
            return back()->with('error', 'Insufficient performance balance')->withInput();
        }
        
        // Deduct from the appropriate balance
        if ($request->payment_source == 'deposit') {
            $user->balance -= $totalPrice;
        } elseif ($request->payment_source == 'profit') {
            $user->interest_balance -= $totalPrice;
        } elseif ($request->payment_source == 'performance') {
            $user->profit_balance -= $totalPrice;
        }
        
        $user->save();
        
        // Create a unique transaction ID
        $trxId = Str::upper(Str::random(12));
        
        // Record the order
        $order = new GoldCoinOrder();
        $order->user_id = $user->id;
        $order->gold_coin_id = $coin->id;
        $order->weight_in_grams = $weight;
        $order->price_per_gram = $coin->price_per_gram;
        $order->subtotal = $subtotal;
        $order->purchase_charges = $chargesBreakdown;
        $order->total_charges = $totalCharges;
        $order->gst_amount = $gstAmount; // Keep for backward compatibility
        $order->total_price = $totalPrice;
        $order->payment_source = $request->payment_source;
        $order->status = 'pending';
        $order->trx_id = $trxId;
        $order->save();
        
        // Record the transaction
        $chargesList = implode(', ', array_column($chargesBreakdown, 'label'));
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $totalPrice,
            'charge' => 0,
            'type' => 'GOLD_COIN_PURCHASE',
            'remarks' => 'Gold coin purchase of ' . $weight . 'g ' . $coin->name . ' with charges: ' . $chargesList,
            'trx_id' => $trxId
        ]);
        
        // Notify admin about the new order
        InAppNotification::create([
            'in_app_notificationable_id' => null, // Admin notification
            'in_app_notificationable_type' => 'App\\Models\\Admin',
            'description' => json_encode([
                'message' => 'New gold coin purchase order #' . $trxId . ' from ' . $user->username,
                'data' => ['username' => $user->username, 'amount' => $totalPrice]
            ])
        ]);
        
        return redirect()->route('user.goldcoin.orders')->with('success', 'Gold purchase order placed successfully');
    }
    
    public function orders()
    {
        $pageTitle = 'My Gold Orders';
        $orders = GoldCoinOrder::where('user_id', Auth::id())
                              ->with('goldCoin')
                              ->latest()
                              ->paginate(15);
        $basic = basicControl();
        
        return view(template() . 'user.gold_coin.orders', compact('pageTitle', 'orders', 'basic'));
    }
    
    public function orderDetails($trx_id)
    {
        $pageTitle = 'Order Details';
        $order = GoldCoinOrder::where('user_id', Auth::id())
                             ->where('trx_id', $trx_id)
                             ->with('goldCoin')
                             ->firstOrFail();
        $basic = basicControl();
        
        return view(template() . 'user.gold_coin.order_details', compact('pageTitle', 'order', 'basic'));
    }
    
    public function exportOrdersCSV($status = null)
    {
        $user = Auth::user();
        $query = GoldCoinOrder::where('user_id', $user->id)->with('goldCoin');
        
        if ($status && $status != 'all') {
            $query->where('status', $status);
        }
        
        $orders = $query->latest()->get();
        
        $fileName = 'gold_coin_orders_' . ($status ? $status . '_' : '') . date('Y-m-d') . '.csv';
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        
        $columns = ['TRX ID', 'Gold Coin', 'Weight (g)', 'Price Per Gram', 'Subtotal', 'Total Charges', 'Total Price', 'Payment Source', 'Status', 'Date'];
        
        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($orders as $order) {
                $row['TRX ID'] = $order->trx_id;
                $row['Gold Coin'] = $order->goldCoin->name . ' (' . $order->goldCoin->karat . ')';
                $row['Weight (g)'] = $order->weight_in_grams;
                $row['Price Per Gram'] = $order->price_per_gram;
                $row['Subtotal'] = $order->subtotal;
                $row['Total Charges'] = $order->getTotalChargesAmount();
                $row['Total Price'] = $order->total_price;
                $row['Payment Source'] = ucfirst($order->payment_source);
                $row['Status'] = ucfirst($order->status);
                $row['Date'] = $order->created_at->format('d M, Y H:i:s');
                
                fputcsv($file, array($row['TRX ID'], $row['Gold Coin'], $row['Weight (g)'], $row['Price Per Gram'], $row['Subtotal'], $row['Total Charges'], $row['Total Price'], $row['Payment Source'], $row['Status'], $row['Date']));
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportOrdersPDF($status = null)
    {
        $user = Auth::user();
        $query = GoldCoinOrder::where('user_id', $user->id)->with('goldCoin');
        
        if ($status && $status != 'all') {
            $query->where('status', $status);
        }
        
        $orders = $query->latest()->get();
        $basic = basicControl();
        
        $pageTitle = 'Gold Coin Orders' . ($status ? ' - ' . ucfirst($status) : '');
        
        $pdf = PDF::loadView(template() . 'user.gold_coin.orders_pdf', compact('orders', 'pageTitle', 'basic', 'user'));
        
        return $pdf->download('gold_coin_orders_' . ($status ? $status . '_' : '') . date('Y-m-d') . '.pdf');
    }
}
