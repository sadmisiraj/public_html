<?php

namespace App\Helpers;

use App\Models\GoldCoinOrder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class GoldPurchaseLimitHelper
{
    /**
     * Check if user has exceeded gold purchase limits
     *
     * @param int|null $userId
     * @return array{allowed: bool, message: ?string, remaining_purchases: ?int, reset_date: ?\Illuminate\Support\Carbon}
     */
    public static function checkGoldPurchaseLimit($userId = null)
    {
        $basicControl = basicControl();

        if (!$basicControl->gold_purchase_limit_enabled) {
            return [
                'allowed' => true,
                'message' => null,
                'remaining_purchases' => null,
                'reset_date' => null,
            ];
        }

        $userId = $userId ?? Auth::id();
        $limitType = $basicControl->gold_purchase_limit_type;
        $limitCount = $basicControl->gold_purchase_limit_count;
        $limitDays = $basicControl->gold_purchase_limit_days;

        $periodStart = self::getPeriodStartDate($limitType, $limitDays, $userId);

        // Count orders in current period (pending + completed considered as used)
        $ordersInPeriod = GoldCoinOrder::where('user_id', $userId)
            ->whereIn('status', ['pending', 'completed'])
            ->where('created_at', '>=', $periodStart)
            ->count();

        $remainingPurchases = max(0, $limitCount - $ordersInPeriod);
        $resetDate = self::getNextResetDate($limitType, $limitDays, $userId);

        if ($ordersInPeriod >= $limitCount) {
            $message = self::generateLimitMessage($limitType, $limitCount, $limitDays, $resetDate);
            return [
                'allowed' => false,
                'message' => $message,
                'remaining_purchases' => 0,
                'reset_date' => $resetDate,
            ];
        }

        return [
            'allowed' => true,
            'message' => null,
            'remaining_purchases' => $remainingPurchases,
            'reset_date' => $resetDate,
        ];
    }

    private static function getPeriodStartDate(string $limitType, int $limitDays, int $userId)
    {
        return match ($limitType) {
            'daily' => Carbon::today(),
            'weekly' => Carbon::now()->startOfWeek(),
            'custom_days' => self::getCustomPeriodStart($limitDays, $userId),
            default => Carbon::today(),
        };
    }

    private static function getCustomPeriodStart(int $limitDays, int $userId)
    {
        $firstOrder = GoldCoinOrder::where('user_id', $userId)
            ->whereIn('status', ['pending', 'completed'])
            ->orderBy('created_at', 'asc')
            ->first();

        if (!$firstOrder) {
            return Carbon::today();
        }

        $firstDate = Carbon::parse($firstOrder->created_at)->startOfDay();
        $daysSinceFirst = $firstDate->diffInDays(Carbon::today());
        $completedCycles = (int) floor($daysSinceFirst / $limitDays);

        return $firstDate->addDays($completedCycles * $limitDays);
    }

    private static function getNextResetDate(string $limitType, int $limitDays, int $userId)
    {
        return match ($limitType) {
            'daily' => Carbon::tomorrow(),
            'weekly' => Carbon::now()->endOfWeek()->addDay(),
            'custom_days' => self::getPeriodStartDate($limitType, $limitDays, $userId)->copy()->addDays($limitDays),
            default => Carbon::tomorrow(),
        };
    }

    private static function generateLimitMessage(string $limitType, int $limitCount, int $limitDays, $resetDate): string
    {
        $timeUntilReset = Carbon::now()->diffForHumans($resetDate, true);

        return match ($limitType) {
            'daily' => "You have exhausted your daily gold purchase limit of {$limitCount} purchase(s). Please wait {$timeUntilReset} to buy again.",
            'weekly' => "You have exhausted your weekly gold purchase limit of {$limitCount} purchase(s). Please wait {$timeUntilReset} to buy again.",
            'custom_days' => "You have exhausted your gold purchase limit of {$limitCount} purchase(s) every {$limitDays} day(s). Please wait {$timeUntilReset} to buy again.",
            default => 'You have reached your gold purchase limit. Please try again later.',
        };
    }

    /**
     * Provide user-friendly info for UI
     */
    public static function getLimitInfo($userId = null): array
    {
        $basicControl = basicControl();

        if (!$basicControl->gold_purchase_limit_enabled) {
            return [
                'enabled' => false,
                'message' => 'No gold purchase limits are currently active.'
            ];
        }

        $userId = $userId ?? Auth::id();
        $limitCheck = self::checkGoldPurchaseLimit($userId);

        $limitType = $basicControl->gold_purchase_limit_type;
        $limitCount = $basicControl->gold_purchase_limit_count;
        $limitDays = $basicControl->gold_purchase_limit_days;

        $periodDescription = match ($limitType) {
            'daily' => 'per day',
            'weekly' => 'per week',
            'custom_days' => "every {$limitDays} day(s)",
            default => 'per period',
        };

        return [
            'enabled' => true,
            'limit_count' => $limitCount,
            'period_description' => $periodDescription,
            'remaining_purchases' => $limitCheck['remaining_purchases'],
            'reset_date' => $limitCheck['reset_date'],
            'message' => "You can make {$limitCount} gold purchase(s) {$periodDescription}. Remaining: {$limitCheck['remaining_purchases']}"
        ];
    }
}


