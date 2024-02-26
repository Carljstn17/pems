<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\ToolReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ToolController extends Controller
{
    public function allTool(){
        $tools_types = Tool::distinct()->get(['tool_type']);
        $tools_names = Tool::distinct()->get(['tool_name']);
        $tools = Tool::orderBy('tool_type')->paginate(10);
        $toolsByType = $tools->sortBy('property')->groupBy('tool_type');
        $toolReports = ToolReport::all();

        return view("tool.all", compact('tools_types', 'tools_names', 'toolsByType','tools','toolReports'));
    }

    public function allToolOwner(){
        $tools = Tool::orderBy('tool_type')->paginate(10);
        $toolsByType = $tools->sortBy('property')->groupBy('tool_type');

        return view("owner.tool", compact('toolsByType','tools'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'tool_type' => 'required|string',
            'tool_name' => 'required|string',
            'unit_cost' => 'required|numeric',
            'property' => 'required|string|max:5',
        ]);

        // Generate the unique property format
        $uniqueProperty = $this->generateUniqueProperty($request->input('property'));

        // Create a new instance of your model and save the data
        $tool = Tool::create([
            "user_id"=> Auth::id(),
            'tool_type' => $request->input('tool_type'),
            'tool_name' => $request->input('tool_name'),
            'unit_cost' => $request->input('unit_cost'),
            'property' => $uniqueProperty,
            // Add other fields as needed
        ]);

        ToolReport::create([
            "user_id"=> Auth::id(),
            'tool_id' => $tool->id,
            'status' => $request->input('status'),
            'whereabout' => $request->input('whereabout'),
        ]);

        // Redirect back or to a specific page after storing the data
        return redirect()->back()->with('success', 'Tool data has been successfully stored!');
    }


    private function generateUniqueProperty($requestedProperty)
    {
        $baseProperty = 'GBG-' . date('Y') . '-' . $requestedProperty . '-' . date('m') . '-';

        // Check if a property with the same base exists
        $latestProperty = Tool::where('property', 'like', $baseProperty . '%')
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

    public function update(Request $request, Tool $tool)
    {
        // Validate the form data
        $request->validate([
            'status' => 'required|string',
            'whereabout' => 'required|string',
        ]);

        // Create a new ToolReport record
        $toolReport = new ToolReport([
            "user_id"=> Auth::id(),
            'status' => $request->input('status'),
            'whereabout' => $request->input('whereabout'),
        ]);

        // Associate the ToolReport with the Tool and save both
        $tool->toolReport()->save($toolReport);

        return redirect()->back()->with('success', 'Tool updated successfully');
    }

    public function toolLogs()
    {
        $toolLogs = ToolReport::with('user', 'toolLog')->latest('updated_at')->paginate(15);

        return view('owner.toolLogs', compact('toolLogs'));
    }
}
