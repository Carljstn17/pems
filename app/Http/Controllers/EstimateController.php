<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EstimateTotal;
use Illuminate\Support\Facades\Auth;

class EstimateController extends Controller
{
    public function showStaffEstimate()
    {
        return view('staff.estimate');
    }

    ////////////////////////////////////////////////////////////////////////////////////
    
    public function showLatestEstimate()
    {
        $groupedEstimates = Estimate::with('user')->get()->groupBy('group_id');

        return view('estimate.latest', compact('groupedEstimates'));
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function showNewEstimate()
    {
        $formId = Str::uuid(); 

        return view('estimate.new', compact('formId'));
    }

    ////////////////////////////////////////////////////////////////////////////////////
    
    public function showOldEstimate()
    {
        // $allPayrolls = Payroll::all()

        return view('estimate.old');
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function show($group_id)
    {
        $estimates = Estimate::with('user')->where('group_id', $group_id)->get();

        return view('estimate.show', compact('estimates', 'group_id'));
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

        // Calculate total amount
        $totalAmount = Estimate::where('group_id', $groupId)->sum('amount');

        // Update the total amount in the estimates table
        Estimate::where('group_id', $groupId)->update(['total_amount' => $totalAmount]);

        EstimateTotal::updateOrCreate(
            ['group_id' => $groupId],
            ['total_amount' => $totalAmount]
        );

        // Redirect or perform any other actions as needed
        return redirect()->route('staff.estimate')->with('success', 'Items added successfully.');
    }


    ////////////////////////////////////////////////////////////////////////////////////

    public function edit(Estimate $estimate)
    {
        // Check if the user is authorized to update this estimate
        $this->authorize('update', $estimate);

        return view('estimates.edit', compact('estimate'));
    }

    ////////////////////////////////////////////////////////////////////////////////////

    public function update(Request $request, Estimate $estimate)
    {
        // Validate the request
        $request->validate([
            'description' => 'required|string',
            'uom' => 'nullable|string',
            'quantity' => 'required|numeric',
            'unit_cost' => 'required|numeric',
        ]);

        // Check if the user is authorized to update this estimate
        $this->authorize('update', $estimate);

        // Update the estimate
        $estimate->update($request->all());

        // Update the total amount in estimate_totals table
        $this->updateTotalAmount($estimate->group_id);

        return redirect()->route('estimates.index')->with('success', 'Estimate updated successfully.');
    }

    private function updateTotalAmount($groupId)
    {
        $totalAmount = Estimate::where('group_id', $groupId)->sum('amount');

        // Debugging statements
        info('Total Amount:', ['total_amount' => $totalAmount]);

        // Update or create the total in the estimate_totals table
        EstimateTotal::updateOrCreate(
            ['group_id' => $groupId],
            ['total_amount' => $totalAmount]
        );
    }
}
