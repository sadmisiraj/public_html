<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GoldAgentInventory;
use App\Models\GoldCoinOrder;
use App\Models\GoldAgentInventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoldAgentController extends Controller
{
    public function index()
    {
        $pageTitle = 'Agent Dashboard';
        $user = Auth::user();

        if (!$user->is_gold_agent) {
            abort(403);
        }

        $inventories = GoldAgentInventory::with('goldCoin')
            ->where('user_id', $user->id)
            ->get();

        $orders = GoldCoinOrder::with(['goldCoin', 'user'])
            ->where('agent_user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view(template() . 'user.agent.index', compact('pageTitle', 'inventories', 'orders'));
    }

    public function markDelivered(Request $request, $trx_id)
    {
        $user = Auth::user();
        if (!$user->is_gold_agent) {
            abort(403);
        }

        $order = GoldCoinOrder::where('trx_id', $trx_id)
            ->where('agent_user_id', $user->id)
            ->firstOrFail();

        // Mark delivered and decrement inventory by coins_count (per order)
        $order->agent_delivered_at = now();
        $order->status = 'completed';
        $order->save();

        $inv = GoldAgentInventory::where('user_id', $user->id)
            ->where('gold_coin_id', $order->gold_coin_id)
            ->first();
        $decrement = max(1, (int)($order->coins_count ?? 1));
        if ($inv && $inv->stock > 0) {
            $inv->stock = max(0, $inv->stock - $decrement);
            $inv->save();
        }

        GoldAgentInventoryLog::create([
            'user_id' => $user->id,
            'gold_coin_id' => $order->gold_coin_id,
            'change_type' => 'agent_deliver',
            'quantity_change' => -$decrement,
            'reference' => $order->trx_id,
            'meta' => [
                'order_id' => $order->id,
                'buyer_id' => $order->user_id,
                'buyer_firstname' => optional($order->user)->firstname,
                'buyer_lastname' => optional($order->user)->lastname,
                'buyer_username' => optional($order->user)->username,
            ],
        ]);

        return back()->with('success', 'Order marked as delivered.');
    }
}


