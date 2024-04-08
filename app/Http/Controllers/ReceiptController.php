<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Project;
use App\Models\Receipt;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    public function showStaffReceipt()
    {
        $receipts = Receipt::latest()->paginate(4);
        $projects = Project::where('status', 'new')->latest()->get();
        $suppliers = Supplier::all();

        return view('receipt.latest', compact('receipts','projects', 'suppliers'));
    }

    public function showOwnerReceipt()
    {
        $receipts = Receipt::latest()->paginate(4);
        $projects = Project::where('status', 'new')->latest()->get();
        $suppliers = Supplier::all();

        return view('owner.receipt', compact('receipts','projects', 'suppliers'));
    }

    public function showReceiptOngoing()
    {
        $receipts = Receipt::all();
        $projects = Project::where('status', 'new')->latest()->paginate(6);
        $suppliers = Supplier::all();

        return view('receipt.ongoing', compact('receipts','projects', 'suppliers'));
    }

    public function ownerOngoingReceipt()
    {
        $receipts = Receipt::all();
        $projects = Project::where('status', 'new')->latest()->paginate(6);
        $suppliers = Supplier::all();

        return view('owner.payrolLOngoing', compact('receipts','projects', 'suppliers'));
    }

    public function projectReceipt($project_id)
    {
        $projects = Project::all();
        $suppliers = Supplier::all(); 

        $receipts = Receipt::where('project_id', $project_id)->latest()->paginate(4);

        return view('receipt.showProject', compact('receipts', 'projects', 'suppliers'));
    }

    public function ownerProjectReceipt($project_id)
    {
        $projects = Project::all();
        $suppliers = Supplier::all(); 

        $receipts = Receipt::where('project_id', $project_id)->latest()->paginate(4);

        return view('owner.receiptProject', compact('receipts', 'projects', 'suppliers'));
    }
    public function showReceiptForm()
    {
        $projects = Project::where('status', 'new')->latest()->get();
        $suppliers = Supplier::all();

        return view('receipt.new', compact('projects', 'suppliers'));
    }

    public function createEntry(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'project_id' => 'required',
            'receipt_date' => 'required|date',
            'si_or_no' => 'required',
            'supplier_id' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric|max:100000',
            'receipt_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming receipt_photo is the file input name
        ]);
    
        // Upload the receipt photo and get its path
        $photoPath = $request->file('receipt_photo')->store('receipts');
    
        // Create a new entry record in the database
        Receipt::create([
            "user_id" => Auth::id(),
            'project_id' => $validatedData['project_id'],
            'receipt_date' => $validatedData['receipt_date'],
            'si_or_no' => $validatedData['si_or_no'],
            'supplier_id' => $validatedData['supplier_id'],
            'description' => $validatedData['description'],
            'amount' => $validatedData['amount'],
            'receipt_photo' => $photoPath,
        ]);
    
        // Redirect back to the user interface
        return redirect()->route('latest.receipt')->with('success', 'Entry submitted successfully!');
    }


    public function show($id) {
        $receipts = Receipt::where('id', $id)->firstOrFail();
        $projects = Project::where('status', 'new')->latest()->get();
        $suppliers = Supplier::all();

        Log::info('Photo Path:', [$receipts->photo_path]);
        return view('receipt.showReceipt', compact('receipts','projects', 'suppliers'));
    }

    public function showForOwner($id) {
        $receipts = Receipt::where('id', $id)->firstOrFail();
        $projects = Project::where('status', 'new')->latest()->get();
        $suppliers = Supplier::all();

        Log::info('Photo Path:', [$receipts->photo_path]);
        return view('owner.receiptShow', compact('receipts','projects', 'suppliers'));
    }

    public function updateReceiptRemarks($receiptId)
    {
        Receipt::where('id', $receiptId)->update(['remarks' => 'invalid']);

        // Redirect back or to any other page after update
        return redirect()->back()->with('success', 'Remarks updated successfully!');
    }
}
