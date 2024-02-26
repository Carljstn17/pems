<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Concern;
use Illuminate\Http\Request;
use App\Models\AdvanceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewConcernNotification;

class ConcernController extends Controller
{
    public function viewConcernForm()
    {
        $user = Auth::user();

        // Calculate the count of entries for the user within the current month
        $monthlyEntryCount = Concern::where('entry_by', $user->id)
            ->whereYear('created_at', '=', now()->year)
            ->whereMonth('created_at', '=', now()->month)
            ->count();

        return view('laborer.concern', compact('monthlyEntryCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'concern' => 'required|string',
        ]);

        $user = Auth::user();
        $monthlyEntryCount = Concern::where('entry_by', $user->id)
            ->whereYear('created_at', '=', now()->year)
            ->whereMonth('created_at', '=', now()->month)
            ->count();

        // Deny entry if the monthly count exceeds 2
        if ($monthlyEntryCount >= 1) {
            return redirect()->back()->with('error', 'You have already made entries this month. Entry denied.');
        }

        // Store the form data in the advance_requests table
        $concern = Concern::create([
            'concern' => $request->input('concern'),
            'entry_by' => $user->id,
            // Add other attributes as needed
        ]);

        $staffUsers = User::where('role', 'staff')->get();

        foreach ($staffUsers as $staffUser) {
            Notification::send($staffUser, new NewConcernNotification($concern));
        }

        return redirect()->back()->with('success', 'Request submitted successfully!');
    }

    public function checkNewEntries()
    {
        $newEntriesCount = Concern::where('created_at', '>', now()->subHour()) // Check entries in the last hour
            ->count();

        return response()->json(['new_entries_count' => $newEntriesCount]);
    }

    public function show($id){
        $concerns = Concern::where('id', $id)->firstOrFail();
        
        return view('staff.showConcernNotif', compact('concerns'));
    }

    public function allConcern(){
        $concerns = Concern::latest()->paginate(4);
        
        return view('staff.allConcern', compact('concerns'));
    }
    
    
}
