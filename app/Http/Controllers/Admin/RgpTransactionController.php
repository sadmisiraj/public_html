<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RgpTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class RgpTransactionController extends Controller
{
    /**
     * Display a listing of all RGP transactions.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $userId = $request->user_id;
        $transactionType = $request->transaction_type;
        $side = $request->side;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        
        // Get all transactions without pagination first to check if there are any
        $allTransactions = RgpTransaction::count();
        
        $transactions = RgpTransaction::with(['user', 'relatedUser', 'plan'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('transaction_id', 'like', "%$search%")
                      ->orWhere('remarks', 'like', "%$search%")
                      ->orWhereHas('user', function ($u) use ($search) {
                          $u->where('username', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                      });
                });
            })
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            })
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
            
        $users = User::where('status', 1)->get();
        
        // Set a default empty message
        $emptyMessage = 'No transactions found';
        
        // Add debug information
        if ($allTransactions == 0) {
            $emptyMessage = 'No RGP transactions exist in the database';
        } else if ($transactions->count() == 0) {
            $emptyMessage = 'Transactions exist but none match the current filters';
        }
        
        return view('admin.rgp_transactions.index', compact('transactions', 'users', 'search', 'userId', 'transactionType', 'side', 'dateFrom', 'dateTo', 'emptyMessage', 'allTransactions'));
    }

    /**
     * Display RGP transactions for a specific user.
     */
    public function userTransactions($id)
    {
        $user = User::findOrFail($id);
        $transactions = $user->rgpTransactions()
            ->with(['relatedUser', 'plan'])
            ->latest()
            ->paginate(getPaginate());
            
        return view('admin.rgp_transactions.user_transactions', compact('transactions', 'user'));
    }
} 