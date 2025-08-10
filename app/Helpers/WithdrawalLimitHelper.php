<?php

namespace App\Helpers;

use App\Models\Payout;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class WithdrawalLimitHelper
{
    /**
     * Check if user has exceeded withdrawal limits
     *
     * @param int $userId
     * @return array
     */
    public static function checkWithdrawalLimit($userId = null)
    {
        $basicControl = basicControl();
        
        // If limits are not enabled, allow withdrawal
        if (!$basicControl->withdrawal_limit_enabled) {
            return [
                'allowed' => true,
                'message' => null,
                'remaining_withdrawals' => null,
                'reset_date' => null
            ];
        }

        $userId = $userId ?? Auth::id();
        $limitType = $basicControl->withdrawal_limit_type;
        $limitCount = $basicControl->withdrawal_limit_count;
        $limitDays = $basicControl->withdrawal_limit_days;

        // Calculate the period start date based on limit type
        $periodStart = self::getPeriodStartDate($limitType, $limitDays);
        
        // Count withdrawals in the current period (only count successful and pending withdrawals)
        $withdrawalsInPeriod = Payout::where('user_id', $userId)
            ->whereIn('status', [1, 2]) // 1 = pending, 2 = successful
            ->where('created_at', '>=', $periodStart)
            ->count();

        $remainingWithdrawals = max(0, $limitCount - $withdrawalsInPeriod);
        $resetDate = self::getNextResetDate($limitType, $limitDays);

        if ($withdrawalsInPeriod >= $limitCount) {
            $message = self::generateLimitMessage($limitType, $limitCount, $limitDays, $resetDate);
            return [
                'allowed' => false,
                'message' => $message,
                'remaining_withdrawals' => 0,
                'reset_date' => $resetDate
            ];
        }

        return [
            'allowed' => true,
            'message' => null,
            'remaining_withdrawals' => $remainingWithdrawals,
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
                // This is a bit more complex as we need to calculate based on user's first withdrawal
                $firstWithdrawal = Payout::where('user_id', Auth::id())
                    ->whereIn('status', [1, 2])
                    ->orderBy('created_at', 'asc')
                    ->first();
                
                if (!$firstWithdrawal) {
                    return Carbon::today();
                }
                
                $firstWithdrawalDate = Carbon::parse($firstWithdrawal->created_at)->startOfDay();
                $daysSinceFirst = $firstWithdrawalDate->diffInDays(Carbon::today());
                $completedCycles = floor($daysSinceFirst / $limitDays);
                
                return $firstWithdrawalDate->addDays($completedCycles * $limitDays);
            
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
                return "You have exhausted your daily withdrawal limit of {$limitCount} withdrawal(s). Please wait {$timeUntilReset} to make your next transaction.";
            
            case 'weekly':
                return "You have exhausted your weekly withdrawal limit of {$limitCount} withdrawal(s). Please wait {$timeUntilReset} to make your next transaction.";
            
            case 'custom_days':
                return "You have exhausted your withdrawal limit of {$limitCount} withdrawal(s) for every {$limitDays} day(s). Please wait {$timeUntilReset} to make your next transaction.";
            
            default:
                return "You have reached your withdrawal limit. Please try again later.";
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
        
        if (!$basicControl->withdrawal_limit_enabled) {
            return [
                'enabled' => false,
                'message' => 'No withdrawal limits are currently active.'
            ];
        }

        $userId = $userId ?? Auth::id();
        $limitCheck = self::checkWithdrawalLimit($userId);
        
        $limitType = $basicControl->withdrawal_limit_type;
        $limitCount = $basicControl->withdrawal_limit_count;
        $limitDays = $basicControl->withdrawal_limit_days;
        
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
            'remaining_withdrawals' => $limitCheck['remaining_withdrawals'],
            'reset_date' => $limitCheck['reset_date'],
            'message' => "You can make {$limitCount} withdrawal(s) {$periodDescription}. Remaining: {$limitCheck['remaining_withdrawals']}"
        ];
    }
} 