<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Models\EstimateDelete;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EstimateTotal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class EstimateController extends Controller
{
    public function showStaffEstimate()
    {
        return view('staff.estimate');
    }

    ////////////////////////////////////////////////////////////////////////////////////
    
    public function showLatestEstimate()
    {
        $estimate = Estimate::latest('updated_at');
        $estimates = $estimate->whereIn('status', ['pending', 'accepted'])->get()->groupBy('group_id');

        return view('estimate.latest', compact('estimates'));
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function showLatestOwner()
    {
        $estimate = Estimate::latest('updated_at');
        $estimates = $estimate->whereIn('status', ['pending', 'accepted'])->get()->groupBy('group_id');

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
        $estimatesReject = Estimate::where('status', 'rejected')
            ->groupBy('group_id')
            ->selectRaw('group_id, MAX(id) as id, MAX(user_id) as user_id, MAX(description) as description, MAX(uom) as uom, SUM(quantity) as total_quantity, MAX(unit_cost) as unit_cost, MAX(created_at) as created_at, MAX(updated_at) as updated_at')
            ->latest('created_at')
            ->paginate(5);

        return view('estimate.reject', compact('estimatesReject'));
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
            ]);
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
                    // Update other fields as needed
                ]);
            }

            // Redirect with a success message
            return redirect()->route('estimate.form', ['group_id' => $groupId])->with('success', 'Estimates within Group ID ' . $groupId . ' are updated successfully.');
    }

    public function softDelete($groupId)
    {

        $estimates = Estimate::where('group_id', $groupId)->get();
    
        // Log the soft delete
        foreach ($estimates as $estimate) {
            EstimateDelete::create([
                'group_id' => $estimate->group_id,
                'user_id' => auth()->id(),
            ]);
    
            // Soft delete each estimate
            $estimate->delete();
        }
    
        return redirect()->route('owner.estimate')->with('success', 'Estimate soft deleted successfully.');
    }    

    public function softDeleteForStaff($groupId)
    {

        $estimates = Estimate::where('group_id', $groupId)->get();
    
        // Log the soft delete
        foreach ($estimates as $estimate) {
            EstimateDelete::create([
                'group_id' => $estimate->group_id,
                'user_id' => auth()->id(),
            ]);
    
            // Soft delete each estimate
            $estimate->delete();
        }
    
        return redirect()->route('latest')->with('success', 'Estimate soft deleted successfully.');
    }  

}
