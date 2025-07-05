<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RgpTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RgpTransactionController extends Controller
{
    /**
     * Display a listing of the user's RGP transactions.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $transactionType = $request->transaction_type;
        $side = $request->side;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        
        $transactions = $user->rgpTransactions()
            ->with(['relatedUser', 'plan'])
            ->when($transactionType, function ($query) use ($transactionType) {
                return $query->where('transaction_type', $transactionType);
            })
            ->when($side, function ($query) use ($side) {
                return $query->where('side', $side);
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->latest()
            ->paginate(getPaginate());
            
        return view(template() . 'user.rgp_transactions.index', compact('transactions', 'transactionType', 'side', 'dateFrom', 'dateTo'));
    }
} 