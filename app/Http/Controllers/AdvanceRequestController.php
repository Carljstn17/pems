<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AdvanceRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAdvanceNotification;

class AdvanceRequestController extends Controller
{
    public function viewRequestForm()
    {
        $user = Auth::user();

        // Calculate the count of entries for the user within the current month
        $monthlyEntryCount = AdvanceRequest::where('entry_by', $user->id)
            ->whereYear('created_at', '=', now()->year)
            ->whereMonth('created_at', '=', now()->month)
            ->count();

        return view('laborer.advance-req', compact('monthlyEntryCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $user = Auth::user();
        $monthlyEntryCount = AdvanceRequest::where('entry_by', $user->id)
            ->whereYear('created_at', '=', now()->year)
            ->whereMonth('created_at', '=', now()->month)
            ->count();

        // Deny entry if the monthly count exceeds 2
        if ($monthlyEntryCount >= 2) {
            return redirect()->back()->with('error', 'You have already made 2 entries this month. Entry denied.');
        }

        // Store the form data in the advance_requests table
        $advanceRequest = AdvanceRequest::create([
            'amount' => $request->input('amount'),
            'text' => $request->input('text'),
            'entry_by' => $user->id,
            // Add other attributes as needed
        ]);

        $staffUsers = User::where('role', 'staff')->get();

        foreach ($staffUsers as $staffUser) {
            Notification::send($staffUser, new NewAdvanceNotification($advanceRequest));
        }

        return redirect()->back()->with('success', 'Request submitted successfully!');
    }

    public function getNewRequestCount()
    {
        try {
            $newAdvanceRequestCount = AdvanceRequest::where('is_read', false)->count();
            return response()->json(['count' => $newAdvanceRequestCount]);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error fetching advance request count: ' . $e->getMessage());

            // Return a JSON response with an error message
            return response()->json(['error' => 'Error fetching advance request count'], 500);
        }
    }

    public function show($id){
        $requests = AdvanceRequest::where('id', $id)->firstOrFail();
        
        return view('staff.showRequestNotif', compact('requests'));
    }

    public function allRequest(){
        $requests = AdvanceRequest::latest()->paginate(8);

        return view('staff.allRequest', compact('requests'));
    }
}
