<?php

namespace App\Helpers;

use App\Models\MoneyTransfer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MoneyTransferLimitHelper
{
    /**
     * Check if user has exceeded money transfer limits
     *
     * @param int $userId
     * @return array
     */
    public static function checkTransferLimit($userId = null)
    {
        $basicControl = basicControl();
        
        // If limits are not enabled, allow transfer
        if (!$basicControl->money_transfer_limit_enabled) {
            return [
                'allowed' => true,
                'message' => null,
                'remaining_transfers' => null,
                'reset_date' => null
            ];
        }

        $userId = $userId ?? Auth::id();
        $limitType = $basicControl->money_transfer_limit_type;
        $limitCount = $basicControl->money_transfer_limit_count;
        $limitDays = $basicControl->money_transfer_limit_days;

        // Calculate the period start date based on limit type
        $periodStart = self::getPeriodStartDate($limitType, $limitDays);
        
        // Count transfers in the current period
        $transfersInPeriod = MoneyTransfer::where('sender_id', $userId)
            ->where('created_at', '>=', $periodStart)
            ->count();

        $remainingTransfers = max(0, $limitCount - $transfersInPeriod);
        $resetDate = self::getNextResetDate($limitType, $limitDays);

        if ($transfersInPeriod >= $limitCount) {
            $message = self::generateLimitMessage($limitType, $limitCount, $limitDays, $resetDate);
            return [
                'allowed' => false,
                'message' => $message,
                'remaining_transfers' => 0,
                'reset_date' => $resetDate
            ];
        }

        return [
            'allowed' => true,
            'message' => null,
            'remaining_transfers' => $remainingTransfers,
            'reset_date' => $resetDate
        ];
    }

    /**
     * Get the start date for the current period
     *
     * @param string $limitType
     * @param int $limitDays
     * @return Carbon
     */
    private static function getPeriodStartDate($limitType, $limitDays)
    {
        switch ($limitType) {
            case 'daily':
                return Carbon::today();
            
            case 'weekly':
                return Carbon::now()->startOfWeek();
            
            case 'custom_days':
                // For custom days, we need to find the start of the current cycle
                // This is a bit more complex as we need to calculate based on user's first transfer
                $firstTransfer = MoneyTransfer::where('sender_id', Auth::id())
                    ->orderBy('created_at', 'asc')
                    ->first();
                
                if (!$firstTransfer) {
                    return Carbon::today();
                }
                
                $firstTransferDate = Carbon::parse($firstTransfer->created_at)->startOfDay();
                $daysSinceFirst = $firstTransferDate->diffInDays(Carbon::today());
                $completedCycles = floor($daysSinceFirst / $limitDays);
                
                return $firstTransferDate->addDays($completedCycles * $limitDays);
            
            default:
                return Carbon::today();
        }
    }

    /**
     * Get the next reset date for the limit period
     *
     * @param string $limitType
     * @param int $limitDays
     * @return Carbon
     */
    private static function getNextResetDate($limitType, $limitDays)
    {
        switch ($limitType) {
            case 'daily':
                return Carbon::tomorrow();
            
            case 'weekly':
                return Carbon::now()->endOfWeek()->addDay();
            
            case 'custom_days':
                $periodStart = self::getPeriodStartDate($limitType, $limitDays);
                return $periodStart->copy()->addDays($limitDays);
            
            default:
                return Carbon::tomorrow();
        }
    }

    /**
     * Generate user-friendly limit message
     *
     * @param string $limitType
     * @param int $limitCount
     * @param int $limitDays
     * @param Carbon $resetDate
     * @return string
     */
    private static function generateLimitMessage($limitType, $limitCount, $limitDays, $resetDate)
    {
        $timeUntilReset = Carbon::now()->diffForHumans($resetDate, true);
        
        switch ($limitType) {
            case 'daily':
                return "You have exhausted your daily transfer limit of {$limitCount} transfer(s). Please wait {$timeUntilReset} to make your next transaction.";
            
            case 'weekly':
                return "You have exhausted your weekly transfer limit of {$limitCount} transfer(s). Please wait {$timeUntilReset} to make your next transaction.";
            
            case 'custom_days':
                return "You have exhausted your transfer limit of {$limitCount} transfer(s) for every {$limitDays} day(s). Please wait {$timeUntilReset} to make your next transaction.";
            
            default:
                return "You have reached your transfer limit. Please try again later.";
        }
    }

    /**
     * Get user-friendly information about current limits
     *
     * @param int $userId
     * @return array
     */
    public static function getLimitInfo($userId = null)
    {
        $basicControl = basicControl();
        
        if (!$basicControl->money_transfer_limit_enabled) {
            return [
                'enabled' => false,
                'message' => 'No transfer limits are currently active.'
            ];
        }

        $userId = $userId ?? Auth::id();
        $limitCheck = self::checkTransferLimit($userId);
        
        $limitType = $basicControl->money_transfer_limit_type;
        $limitCount = $basicControl->money_transfer_limit_count;
        $limitDays = $basicControl->money_transfer_limit_days;
        
        $periodDescription = match ($limitType) {
            'daily' => 'per day',
            'weekly' => 'per week',
            'custom_days' => "every {$limitDays} day(s)",
            default => 'per period'
        };

        return [
            'enabled' => true,
            'limit_count' => $limitCount,
            'period_description' => $periodDescription,
            'remaining_transfers' => $limitCheck['remaining_transfers'],
            'reset_date' => $limitCheck['reset_date'],
            'message' => "You can make {$limitCount} transfer(s) {$periodDescription}. Remaining: {$limitCheck['remaining_transfers']}"
        ];
    }
} 