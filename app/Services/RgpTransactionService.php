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
        
        // Get previous values using accessors
        $previousRgpL = (int) $user->rgp_l;
        $previousRgpR = (int) $user->rgp_r;
        
        // Calculate new values based on transaction type and side
        $newRgpL = $previousRgpL;
        $newRgpR = $previousRgpR;
        
        if ($transactionType === 'credit') {
            if ($side === 'left' || $side === 'both') {
                $newRgpL = $previousRgpL + (int) $amount;
            }
            if ($side === 'right' || $side === 'both') {
                $newRgpR = $previousRgpR + (int) $amount;
            }
        } elseif ($transactionType === 'debit') {
            if ($side === 'left' || $side === 'both') {
                $newRgpL = max(0, $previousRgpL - (int) $amount);
            }
            if ($side === 'right' || $side === 'both') {
                $newRgpR = max(0, $previousRgpR - (int) $amount);
            }
        } elseif ($transactionType === 'match') {
            // For matching, amount is subtracted from both sides
            $newRgpL = max(0, $previousRgpL - (int) $amount);
            $newRgpR = max(0, $previousRgpR - (int) $amount);
        }
        
        // Create the transaction record
        $transaction = RgpTransaction::create([
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
        
        // Update the user's RGP values in the database
        $user->rgp_l = $newRgpL;
        $user->rgp_r = $newRgpR;
        $user->save();
        
        return $transaction;
    }
} 