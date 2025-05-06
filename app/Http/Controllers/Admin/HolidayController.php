<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use App\Models\BasicControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class HolidayController extends Controller
{
    /**
     * Display the holiday management page
     */
    public function index()
    {
        $data['pageTitle'] = 'Holiday Management';
        $data['weeklyHolidays'] = Holiday::where('type', 'weekly')->get();
        $data['specificHolidays'] = Holiday::where('type', 'specific')->latest()->paginate(15);
        $data['basicControl'] = BasicControl::first();
        
        // Initialize weekly holidays if not exist
        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        
        foreach ($dayNames as $index => $dayName) {
            Holiday::firstOrCreate(
                ['type' => 'weekly', 'day_of_week' => $index],
                ['name' => $dayName, 'status' => ($index == 0 || $index == 6) ? true : false] // Default weekends as holidays
            );
        }
        
        return view('admin.control_panel.holiday_management', $data);
    }

    /**
     * Update weekly holiday settings
     */
    public function updateWeeklyHolidays(Request $request)
    {
        $request->validate([
            'days' => 'nullable|array',
            'days.*' => 'integer|between:0,6',
        ]);

        // Update the weekly holidays
        Holiday::where('type', 'weekly')->update(['status' => false]);
        
        if ($request->has('days')) {
            Holiday::where('type', 'weekly')
                ->whereIn('day_of_week', $request->days)
                ->update(['status' => true]);
        }

        return back()->with('success', 'Weekly holiday settings updated successfully');
    }

    /**
     * Store a new specific holiday
     */
    public function storeSpecificHoliday(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'date' => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $holiday = new Holiday();
        $holiday->name = $request->name;
        $holiday->date = $request->date;
        $holiday->type = 'specific';
        $holiday->status = true;
        $holiday->save();

        return back()->with('success', 'Holiday added successfully');
    }

    /**
     * Update a specific holiday
     */
    public function updateSpecificHoliday(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            $holiday = Holiday::findOrFail($id);
            $holiday->name = $request->name;
            $holiday->date = $request->date;
            $holiday->status = $request->status;
            $holiday->save();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Holiday updated successfully']);
            }
            return back()->with('success', 'Holiday updated successfully');
        } catch (\Exception $e) {
            \Log::error('Holiday update error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to update holiday: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Failed to update holiday: ' . $e->getMessage());
        }
    }

    /**
     * Delete a specific holiday
     */
    public function deleteSpecificHoliday($id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();

        return back()->with('success', 'Holiday deleted successfully');
    }

    /**
     * Toggle holiday profit disable setting via form submission
     */
    public function toggleProfitDisable(Request $request)
    {
        try {
            // Remove the dd for production
            // dd("here");
            
            $value = $request->input('value') ? 1 : 0;
            
            $basicControl = BasicControl::first();
            if (!$basicControl) {
                throw new \Exception('Basic control settings not found');
            }
            
            $basicControl->update([
                'holiday_profit_disable' => $value
            ]);
            
            // If it's an AJAX request, return JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Setting updated successfully']);
            }
            
            // Otherwise redirect back with success message
            return back()->with('success', 'Profit on holidays setting updated successfully');
        } catch (\Exception $e) {
            \Log::error('Holiday profit disable toggle error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to update setting: ' . $e->getMessage()], 500);
            }
            
            return back()->with('error', 'Failed to update setting: ' . $e->getMessage());
        }
    }
} 