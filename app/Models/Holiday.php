<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Holiday extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
        'status' => 'boolean',
    ];

    /**
     * Check if today is a holiday
     * @return bool
     */
    public static function isHoliday(): bool
    {
        $today = Carbon::now();
        $dayOfWeek = $today->dayOfWeek;
        
        // Check if today matches with any specific date holiday
        $specificHoliday = self::where('type', 'specific')
            ->where('date', $today->format('Y-m-d'))
            ->where('status', true)
            ->exists();
            
        if ($specificHoliday) {
            return true;
        }
        
        // Check if today matches with any weekly holiday
        $weeklyHoliday = self::where('type', 'weekly')
            ->where('day_of_week', $dayOfWeek)
            ->where('status', true)
            ->exists();
            
        return $weeklyHoliday;
    }

    /**
     * Get the next working day after a given date
     * @param Carbon $date
     * @return Carbon
     */
    public static function getNextWorkingDay($date)
    {
        $nextDay = $date->copy()->addDay();
        
        while (self::isHolidayOnDate($nextDay)) {
            $nextDay->addDay();
        }
        
        return $nextDay;
    }

    /**
     * Check if a specific date is a holiday
     * @param Carbon $date
     * @return bool
     */
    public static function isHolidayOnDate($date)
    {
        $dayOfWeek = $date->dayOfWeek;
        
        // Check if date matches with any specific date holiday
        $specificHoliday = self::where('type', 'specific')
            ->where('date', $date->format('Y-m-d'))
            ->where('status', true)
            ->exists();
            
        if ($specificHoliday) {
            return true;
        }
        
        // Check if date matches with any weekly holiday
        $weeklyHoliday = self::where('type', 'weekly')
            ->where('day_of_week', $dayOfWeek)
            ->where('status', true)
            ->exists();
            
        return $weeklyHoliday;
    }
} 