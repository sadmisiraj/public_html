<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GoldCoin;
use App\Models\GoldCoinOrder;
use App\Models\Transaction;
use App\Models\InAppNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        
        return view(template() . 'user.gold_coin.purchase', compact('pageTitle', 'coin', 'user', 'basic'));
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
        
        // Calculate GST (18%)
        $gstRate = 0.18;
        $gstAmount = $subtotal * $gstRate;
        
        // Calculate total price with GST
        $totalPrice = $subtotal + $gstAmount;
        
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
        $order->gst_amount = $gstAmount;
        $order->total_price = $totalPrice;
        $order->payment_source = $request->payment_source;
        $order->status = 'pending';
        $order->trx_id = $trxId;
        $order->save();
        
        // Record the transaction
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $totalPrice,
            'charge' => 0,
            'type' => 'GOLD_COIN_PURCHASE',
            'remarks' => 'Gold coin purchase of ' . $weight . 'g ' . $coin->name . ' with GST',
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
}
