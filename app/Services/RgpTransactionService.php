<?php

namespace App\Services;

use App\Models\RgpTransaction;
use App\Models\User;
use Illuminate\Support\Str;

class RgpTransactionService
{
    /**
     * Create a new RGP transaction record
     *
     * @param User $user
     * @param string $transactionType
     * @param string $side
     * @param float $amount
     * @param string $remarks
     * @param string $source
     * @param int|null $relatedUserId
     * @param int|null $planId
     * @return RgpTransaction
     */
    public function createTransaction(
        User $user,
        string $transactionType,
        string $side,
        float $amount,
        string $remarks,
        string $source = 'system',
        ?int $relatedUserId = null,
        ?int $planId = null
    ): RgpTransaction {
        // Generate a unique transaction ID
        $transactionId = 'RGP-' . strtoupper(Str::random(8));
        
        // Get previous values
        $previousRgpL = floatval($user->rgp_l ?? 0);
        $previousRgpR = floatval($user->rgp_r ?? 0);
        
        // Calculate new values based on transaction type and side
        $newRgpL = $previousRgpL;
        $newRgpR = $previousRgpR;
        
        if ($transactionType === 'credit') {
            if ($side === 'left' || $side === 'both') {
                $newRgpL = $previousRgpL + $amount;
            }
            if ($side === 'right' || $side === 'both') {
                $newRgpR = $previousRgpR + $amount;
            }
        } elseif ($transactionType === 'debit') {
            if ($side === 'left' || $side === 'both') {
                $newRgpL = $previousRgpL - $amount;
            }
            if ($side === 'right' || $side === 'both') {
                $newRgpR = $previousRgpR - $amount;
            }
        } elseif ($transactionType === 'match') {
            // For matching, amount is subtracted from both sides
            $newRgpL = $previousRgpL - $amount;
            $newRgpR = $previousRgpR - $amount;
        }
        
        // Create the transaction record
        return RgpTransaction::create([
            'user_id' => $user->id,
            'transaction_type' => $transactionType,
            'side' => $side,
            'amount' => $amount,
            'previous_rgp_l' => $previousRgpL,
            'previous_rgp_r' => $previousRgpR,
            'new_rgp_l' => $newRgpL,
            'new_rgp_r' => $newRgpR,
            'transaction_id' => $transactionId,
            'remarks' => $remarks,
            'source' => $source,
            'related_user_id' => $relatedUserId,
            'plan_id' => $planId,
        ]);
    }
} 