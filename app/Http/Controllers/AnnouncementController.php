<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // List all announcements for admin
    public function index()
    {
        $announcements = Announcement::orderByDesc('created_at')->get();
        return view('admin.announcement.index', compact('announcements'));
    }

    // Store a new announcement
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        Announcement::create($request->only(['text', 'status', 'start_date', 'end_date']));
        return back()->with('success', 'Announcement added successfully.');
    }

    // Update an announcement
    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        $announcement = Announcement::findOrFail($id);
        $announcement->update($request->only(['text', 'status', 'start_date', 'end_date']));
        return back()->with('success', 'Announcement updated successfully.');
    }

    // Delete an announcement
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return back()->with('success', 'Announcement deleted successfully.');
    }
} 