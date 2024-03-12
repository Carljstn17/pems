<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estimate;
use App\Models\Project;
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
        $perPage = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        
        $estimates = Estimate::whereIn('status', ['accepted','pending'])
            ->orderByRaw("FIELD(status, 'accepted', 'pending')")
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
        $perPage = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        
        $estimates = Estimate::whereIn('status', ['accepted','pending'])
            ->orderByRaw("FIELD(status, 'pending', 'accepted')")
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
         $projects = Project::where('status', 'new')->latest()->get();
        return view('estimate.new', compact('projects'));
    }

    ////////////////////////////////////////////////////////////////////////////////////
    
    public function showRejectEstimate()
    {
        $perPage = 20;
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
        $perPage = 20;
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
            'title' => 'required|string|max:120',
            'project_id' => 'required',
            'description.*' => 'required|string|max:120',
            'uom.*' => 'nullable|string|max:15',
            'quantity.*' => 'required|numeric|max:999',
            'unit_cost.*' => 'required|numeric|max:999999',
            'remarks' => 'required|string|max:255'
        ]);

        // Save items to the database
        $latestGroupId = Estimate::max('group_id');
        $groupIdCounter = (int)substr($latestGroupId, -5) + 1;
        $groupId = 'ID-' . str_pad($groupIdCounter, 5, '0', STR_PAD_LEFT);

        foreach ($request->description as $key => $description) {
            $quantity = $request->quantity[$key];
            $unitCost = $request->unit_cost[$key];
            $project_id = $request->input('project_id');
            $title = $request->input('title');

            // Calculate the amount
            $amount = $quantity * $unitCost;

            // Create Estimate with amount
            Estimate::create([
                "user_id" => Auth::id(),
                'project_id' => $project_id,
                'title' => $title,
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
            'description.*' => 'required|string|max:120',
            'uom.*' => 'nullable|string|max:15',
            'quantity.*' => 'required|numeric|max:999',
            'unit_cost.*' => 'required|numeric|max:999999',
            'remarks' => 'required|string|max:255'
        ]);

        // Save items to the database
        $latestGroupId = Estimate::max('group_id');
        $groupIdCounter = (int) substr($latestGroupId, -5) + 1;
        $groupId = 'ID-' . str_pad($groupIdCounter, 5, '0', STR_PAD_LEFT);

        foreach ($request->description as $key => $description) {
            $quantity = $request->quantity[$key];
            $unitCost = $request->unit_cost[$key];

            // Calculate the amount
            $amount = $quantity * $unitCost;

            // Create Estimate with amount
            $estimateData = [
                'user_id' => Auth::id(),
                'project_id' => $projectId,
                'title' => $title,
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

            $estimate = Estimate::create($estimateData);
        }
        
        $owners = User::where('role', 'owner')->get();
        
        foreach ($owners as $owner) {
            $estimate = Estimate::where('group_id', $groupId)->get(); 
            $owner->notify(new EstimateEntryNotification($estimate));
        } 

        // Redirect or perform any other actions as needed
        return redirect()->route('owner.estimate')->with('success', 'Items added successfully.')->withInput();
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
    
        Estimate::where('group_id', $group_id)->update([
            'status' => 'rejected',
            'remarks' => $request->remarks,
        ]);
        
        $user = User::find($estimate->user_id);
        if($user){
            $user->notify(new EstimateNotification($estimate));
        }
        
        return redirect()->route('owner.estimateReject')->with('success', 'Estimate updated successfully!');
    }

    public function accept(Request $request, $group_id)
    {
        $estimate = Estimate::where('group_id', $group_id)->firstOrFail(); // Retrieve the estimate
    
        Estimate::where('group_id', $group_id)->update([
            'status' => 'accepted',
            'remarks' => $request->remarks,
        ]);

        $user = User::find($estimate->user_id);
        if($user){
            $user->notify(new EstimateNotification($estimate));
        }
        
        return redirect()->route('owner.estimate')->with('success', 'Estimate updated successfully!');
    }

    public function export($group_id)
    {
        $logoUrl = 'https://example.com/logo.jpg';

        return Excel::download(new EstimatesExport($group_id, $logoUrl), 'estimates.xlsx');
    }
    
    
    public function showCreateForm()
    {
        $projects = Project::where('status', 'new')->latest()->get();
        
        return view('owner.createEstimate', compact('projects'));
    }
}
