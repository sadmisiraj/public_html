<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoldAgentInventory;
use App\Models\GoldCoin;
use App\Models\GoldCoinOrder;
use App\Models\GoldAgentInventoryLog;
use App\Models\User;
use Illuminate\Http\Request;

class GoldAgentController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Gold Pickup Agents';
        $q = $request->get('q');

        $users = User::query()
            ->when($q, function ($query) use ($q) {
                $query->where('username', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->orderByDesc('is_gold_agent')
            ->orderBy('username')
            ->paginate(20);

        return view('admin.gold_agents.index', compact('pageTitle', 'users', 'q'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'is_gold_agent' => 'required|in:0,1',
        ]);
        $user = User::findOrFail($request->user_id);
        $user->is_gold_agent = (int) $request->is_gold_agent === 1;
        $user->save();

        return back()->with('success', 'Agent status updated.');
    }

    public function inventory($userId)
    {
        $pageTitle = 'Manage Agent Inventory';
        $agent = User::findOrFail($userId);
        $coins = GoldCoin::active()->get();
        $inventories = GoldAgentInventory::where('user_id', $agent->id)->get()->keyBy('gold_coin_id');

        return view('admin.gold_agents.inventory', compact('pageTitle', 'agent', 'coins', 'inventories'));
    }

    public function inventoryUpdate(Request $request, $userId)
    {
        $agent = User::findOrFail($userId);
        $request->validate([
            'stock' => 'array',
            'stock.*' => 'nullable|integer|min:0',
        ]);

        $stocks = $request->input('stock', []);
        foreach ($stocks as $coinId => $stock) {
            $inv = GoldAgentInventory::firstOrNew([
                'user_id' => $agent->id,
                'gold_coin_id' => $coinId,
            ]);
            $newStock = (int)($stock ?? 0);
            $oldStock = (int)($inv->exists ? $inv->stock : 0);
            $delta = $newStock - $oldStock;
            $inv->stock = $newStock;
            $inv->save();

            if ($delta !== 0) {
                GoldAgentInventoryLog::create([
                    'user_id' => $agent->id,
                    'gold_coin_id' => $coinId,
                    'change_type' => $delta > 0 ? 'admin_add' : 'admin_remove',
                    'quantity_change' => $delta,
                    'reference' => null,
                    'meta' => ['old' => $oldStock, 'new' => $newStock],
                ]);
            }
        }

        return back()->with('success', 'Inventory updated successfully.');
    }

    public function deliveries()
    {
        $pageTitle = 'Delivered Gold Orders by Agents';
        $orders = GoldCoinOrder::with(['user', 'goldCoin', 'agentUser'])
            ->whereNotNull('agent_delivered_at')
            ->latest('agent_delivered_at')
            ->paginate(20);

        return view('admin.gold_agents.deliveries', compact('pageTitle', 'orders'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Gold Orders by Agents';
        $orders = GoldCoinOrder::with(['user', 'goldCoin', 'agentUser'])
            ->whereNull('agent_delivered_at')
            ->whereNotNull('agent_user_id')
            ->latest()
            ->paginate(20);

        return view('admin.gold_agents.pending', compact('pageTitle', 'orders'));
    }

    public function transactions(Request $request, $userId)
    {
        $pageTitle = 'Agent Coin Transactions';
        $agent = User::findOrFail($userId);

        $coins = GoldCoin::active()->get();
        $changeTypes = ['admin_add', 'admin_remove', 'agent_deliver'];

        $logs = GoldAgentInventoryLog::with('goldCoin')
            ->where('user_id', $agent->id)
            ->when($request->coin_id, function ($q) use ($request) {
                $q->where('gold_coin_id', $request->coin_id);
            })
            ->when($request->change_type, function ($q) use ($request) {
                $q->where('change_type', $request->change_type);
            })
            ->when($request->reference, function ($q) use ($request) {
                $q->where('reference', 'like', "%" . trim($request->reference) . "%");
            })
            ->when($request->buyer, function ($q) use ($request) {
                $term = trim($request->buyer);
                $q->where(function ($x) use ($term) {
                    $x->where('meta->buyer_username', 'like', "%{$term}%")
                      ->orWhere('meta->buyer_firstname', 'like', "%{$term}%")
                      ->orWhere('meta->buyer_lastname', 'like', "%{$term}%");
                });
            })
            ->when($request->from_date && $request->to_date, function ($q) use ($request) {
                $q->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59',
                ]);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.gold_agents.transactions', compact('pageTitle', 'agent', 'logs', 'coins', 'changeTypes', 'request'));
    }
}


