<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstimateController extends Controller
{
    public function showStaffEstimate()
    {
        return view('staff.estimate');
    }
    
    public function showLatestEstimate()
    {
        // $payrolls = Payroll::all();

        return view('estimate.latest');
    }

    public function showNewEstimate()
    {
        $formId = Str::uuid(); 

        return view('estimate.new', compact('formId'));
    }
    
    public function showOldEstimate()
    {
        // $allPayrolls = Payroll::all()

        return view('estimate.old');
    }

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
            Estimate::create([
                "user_id" => Auth::id(),
                'description' => $description,
                'uom' => $request->uom[$key],
                'quantity' => $request->quantity[$key],
                'unit_cost' => $request->unit_cost[$key],
                'group_id' => $groupId,
            ]);
        }

        // Redirect or perform any other actions as needed
        return redirect()->route('staff.estimate')->with('success', 'Items added successfully.');
    }
}
