<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estimate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EstimateTotal;
use App\Models\EstimateDelete;
use App\Exports\EstimatesExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use App\Notifications\EstimateNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Notifications\EstimateEntryNotification;

class EstimateController extends Controller
{
    public function showStaffEstimate()
    {
        return view('staff.estimate');
    }

    ////////////////////////////////////////////////////////////////////////////////////
    
    public function showLatestEstimate()
    {
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        
        $estimates = Estimate::whereIn('status', ['accepted','pending'])
            ->latest('updated_at')
            ->get()
            ->groupBy('group_id');

        $results = $estimates->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $estimates = new LengthAwarePaginator($results, $estimates->count(), $perPage, $currentPage, [
        'path' => LengthAwarePaginator::resolveCurrentPath(),
    ]);

        return view('estimate.latest', compact('estimates'));
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function showLatestOwner()
    {
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        
        $estimates = Estimate::whereIn('status', ['accepted','pending'])
            ->latest('updated_at')
            ->get()
            ->groupBy('group_id');

        $results = $estimates->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $estimates = new LengthAwarePaginator($results, $estimates->count(), $perPage, $currentPage, [
        'path' => LengthAwarePaginator::resolveCurrentPath(),
    ]);

        return view('owner.estimate', compact('estimates'));
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function showNewEstimate()
    {
        $formId = Str::uuid(); 

        return view('estimate.new', compact('formId'));
    }

    ////////////////////////////////////////////////////////////////////////////////////
    
    public function showRejectEstimate()
    {
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        
        $estimates = Estimate::where('status', 'rejected')
            ->latest('updated_at')
            ->get()
            ->groupBy('group_id');

        $results = $estimates->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $estimates = new LengthAwarePaginator($results, $estimates->count(), $perPage, $currentPage, [
        'path' => LengthAwarePaginator::resolveCurrentPath(),
    ]);

        return view('estimate.reject', compact('estimates'));
    }

    public function rejectEstimate()
    {
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        
        $estimates = Estimate::where('status', 'rejected')
            ->latest('updated_at')
            ->get()
            ->groupBy('group_id');

        $results = $estimates->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $estimates = new LengthAwarePaginator($results, $estimates->count(), $perPage, $currentPage, [
        'path' => LengthAwarePaginator::resolveCurrentPath(),
    ]);

        return view('owner.estimateReject', compact('estimates'));
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function show($group_id)
    {
        $estimates = Estimate::with('user')->where('group_id', $group_id)->get();

        return view('estimate.show', compact('estimates', 'group_id'));
    }

    public function showOld($group_id)
    {
        $estimates = Estimate::with('user')->where('group_id', $group_id)->get();

        return view('estimate.showReject', compact('estimates', 'group_id'));
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function showOwner($group_id)
    {
        $estimates = Estimate::with('user')->where('group_id', $group_id)->get();

        return view('owner.estimateShow', compact('estimates', 'group_id'));
    }

    public function showRejectOwner($group_id)
    {
        $estimates = Estimate::with('user')->where('group_id', $group_id)->get();

        return view('owner.estimateShowReject', compact('estimates', 'group_id'));
    }


    ////////////////////////////////////////////////////////////////////////////////////

    public function store(Request $request)
    {
        // Validation (you can customize based on your needs)
        $request->validate([
            'description.*' => 'required|string',
            'uom.*' => 'nullable|string',
            'quantity.*' => 'required|numeric',
            'unit_cost.*' => 'required|numeric',
            'remarks' => 'required|string'
        ]);

        // Save items to the database
        $latestGroupId = Estimate::max('group_id');
        $groupIdCounter = (int)substr($latestGroupId, -5) + 1;
        $groupId = 'EstimateID-' . str_pad($groupIdCounter, 5, '0', STR_PAD_LEFT);

        foreach ($request->description as $key => $description) {
            $quantity = $request->quantity[$key];
            $unitCost = $request->unit_cost[$key];

            // Calculate the amount
            $amount = $quantity * $unitCost;

            // Create Estimate with amount
            Estimate::create([
                "user_id" => Auth::id(),
                'description' => $description,
                'uom' => $request->uom[$key],
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'amount' => $amount, // Add the calculated amount
                'group_id' => $groupId,
                'remarks' => $request->remarks,
            ]);
        }

        $owners = User::where('role', 'owner')->get();
        
        foreach ($owners as $owner) {
            $estimates = Estimate::where('group_id', $groupId)->get(); // Get the estimates for the current group
            $owner->notify(new EstimateEntryNotification($estimates));
        }    
        
        // Redirect or perform any other actions as needed
        return redirect()->route('latest')->with('success', 'Items added successfully.');
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function storeEstimateOwner(Request $request)
    {
        // Validation (you can customize based on your needs)
        $request->validate([
            'description.*' => 'required|string',
            'uom.*' => 'nullable|string',
            'quantity.*' => 'required|numeric',
            'unit_cost.*' => 'required|numeric',
        ]);

        // Save items to the database
        $latestGroupId = Estimate::max('group_id');
        $groupIdCounter = (int) substr($latestGroupId, -5) + 1;
        $groupId = 'EstimateID-' . str_pad($groupIdCounter, 5, '0', STR_PAD_LEFT);

        foreach ($request->description as $key => $description) {
            $quantity = $request->quantity[$key];
            $unitCost = $request->unit_cost[$key];

            // Calculate the amount
            $amount = $quantity * $unitCost;

            // Create Estimate with amount
            $estimateData = [
                'user_id' => Auth::id(),
                'description' => $description,
                'uom' => $request->uom[$key],
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'amount' => $amount, // Add the calculated amount
                'group_id' => $groupId,
                'remarks' => $request->remarks,
            ];

            // Set status to 'accepted' if the user's role is 'owner'
            if (Auth::user()->role === 'owner') {
                $estimateData['status'] = 'accepted';
            }

            Estimate::create($estimateData);
        }

        // Redirect or perform any other actions as needed
        return redirect()->route('owner.estimate')->with('success', 'Items added successfully.');
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function edit($group_id)
    {
        $estimates = Estimate::where('group_id', $group_id)->get();
        
        return view('estimate.edit')->with('estimates', $estimates);
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function update(Request $request)
    {
            // Check if the user is authorized to update this estimate
            // $this->authorize('update', $estimate);

            $estimates = $request->input('estimateId');
            $groupId = $request->input('groupId')[0];

            foreach ($estimates as $estimateId) {
                Estimate::where('id', $estimateId)->update([
                    'description' => $request->input('description')[$estimateId],
                    'uom' => $request->input('uom')[$estimateId],
                    'quantity' => $request->input('quantity')[$estimateId],
                    'unit_cost' => $request->input('unit_cost')[$estimateId],
                    'remarks' => $request->input('remarks'),
                    // Update other fields as needed
                ]);
            }

            // Redirect with a success message
            return redirect()->route('estimate.form', ['group_id' => $groupId])->with('success', 'Estimates within Group ID ' . $groupId . ' are updated successfully.');
    }


    public function reject(Request $request, $group_id)
    {
        $estimate = Estimate::where('group_id', $group_id)->firstOrFail(); // Retrieve the estimate
    
    // Update the estimate status and remarks
        $estimate->update([
            'status' => 'rejected',
            'remarks' => $request->remarks,
        ]);
        
        // Send email notification to the user to whom the estimate belongs
        $estimate->user->notify(new EstimateNotification($estimate));
        
        return redirect()->route('owner.estimate')->with('success', 'Estimate updated successfully!');
    }

    public function accept(Request $request, $group_id)
    {
        $estimate = Estimate::where('group_id', $group_id)->firstOrFail(); // Retrieve the estimate
    
        Estimate::where('group_id', $group_id)->update([
            'status' => 'accepted',
            'remarks' => $request->remarks,
        ]);

        $estimate->user->notify(new EstimateNotification($estimate));
        
        return redirect()->route('owner.estimate')->with('success', 'Estimate updated successfully!');
    }

    public function export($group_id)
    {
        $logoUrl = 'https://example.com/logo.jpg';

        return Excel::download(new EstimatesExport($group_id, $logoUrl), 'estimates.xlsx');
    }
}
