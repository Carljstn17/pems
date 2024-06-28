<?php

namespace App\Http\Controllers;

use App\Models\Machinery;
use Illuminate\Http\Request;
use App\Models\MachineryReport;
use Illuminate\Support\Facades\Auth;

class MachineryController extends Controller
{
    public function allMachinery(){
        $machinery_types = Machinery::distinct()->get(['machinery_type']);
        $machinery_names = Machinery::distinct()->get(['machinery_name']);
        $machineries = Machinery::orderBy('machinery_type')->paginate(10);
        $machineriesByType = $machineries->sortBy('property')->groupBy('machinery_type');
        $machineryReports = MachineryReport::all();

        return view("machinery.all", compact('machinery_types', 'machinery_names', 'machineriesByType', 'machineries', 'machineryReports'));
    }

    public function allMachineryOwner(){
        $machineries = Machinery::orderBy('machinery_type')->paginate(10);
        $machineriesByType = $machineries->sortBy('property')->groupBy('machinery_type');

        return view("owner.machinery", compact('machineriesByType', 'machineries'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'machinery_type' => 'required|string|max:50',
            'machinery_name' => 'required|string|max:50',
            'unit_cost' => 'required|numeric|max:9999999',
            'property' => 'required|string|max:8',
            'status' => 'required|string',
            'whereabout' => 'required|string|max:255',
        ], [
            'machinery_type.required' => 'Machinery type is required.',
            'machinery_name.required' => 'Machinery name is required.',
            'unit_cost.required' => 'Unit cost is required.',
            'unit_cost.numeric' => 'Unit cost must be a number.',
            'property.required' => 'Property is required.',
            'property.max' => 'Property cannot exceed 5 characters.',
            'status.required' => 'Status is required.',
            'whereabout.required' => 'Whereabout is required.',
            'whereabout.max' => 'Whereabout is too long.',
        ]);
    
        // Generate the unique property format
        $uniqueProperty = $this->generateUniqueProperty($validatedData['property']);
    
        // Create a new instance of your model and save the data
        $machinery = Machinery::create([
            "user_id" => Auth::id(),
            'machinery_type' => $validatedData['machinery_type'],
            'machinery_name' => $validatedData['machinery_name'],
            'unit_cost' => $validatedData['unit_cost'],
            'property' => $uniqueProperty,
            // Add other fields as needed
        ]);
    
        // Create MachineryReport only if Machinery was created successfully
        if ($machinery) {
            MachineryReport::create([
                "user_id" => Auth::id(),
                'machinery_id' => $machinery->id,
                'status' => $validatedData['status'],
                'whereabout' => $validatedData['whereabout'],
            ]);
    
            return redirect()->back()->with('success', 'Machinery data has been successfully stored!');
        }
    
        // If Machinery creation failed, redirect back with error message
        return redirect()->back()->with('error', 'Machinery data could not be stored.')->withInput();
    }


    private function generateUniqueProperty($requestedProperty)
    {
        $baseProperty = 'GBG-' . date('Y') . '-' . $requestedProperty . '-' . date('m') . '-';

        // Check if a property with the same base exists
        $latestProperty = Machinery::where('property', 'like', $baseProperty . '%')
            ->orderBy('property', 'desc')
            ->first();

        if ($latestProperty) {
            // Extract the last three digits and increment
            $lastDigits = (int)substr($latestProperty->property, -3);
            $newDigits = str_pad($lastDigits + 1, 3, '0', STR_PAD_LEFT);

            return $baseProperty . $newDigits;
        }

        // If no existing properties with the same base, use -001
        return $baseProperty . '001';
    }

    public function update(Request $request, Machinery $machinery)
    {
        // Validate the form data
        $request->validate([
            'status' => 'required|string',
            'whereabout' => 'required|string|max:255',
        ]);

        $machineryReport = new MachineryReport([
            "user_id"=> Auth::id(),
            'status' => $request->input('status'),
            'whereabout' => $request->input('whereabout'),
        ]);

        $machinery->machineryReport()->save($machineryReport);

        return redirect()->back()->with('success', 'Machinery updated successfully');
    }

    public function machineryLogs()
    {
        $machineryLogs = MachineryReport::with('user', 'machineryLog')->latest('updated_at')->paginate(15);

        return view('owner.machineryLogs', compact('machineryLogs'));
    }
}
