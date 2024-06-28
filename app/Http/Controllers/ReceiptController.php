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
        $receipts = Receipt::where('remarks','valid')->latest()->paginate(10);
        $projects = Project::where('status', 'new')->latest()->get();
        $suppliers = Supplier::all();

        return view('receipt.latest', compact('receipts','projects', 'suppliers'));
    }

    public function showOwnerReceipt()
    {
        $receipts = Receipt::where('remarks','valid')->latest()->paginate(10);
        $projects = Project::where('status', 'new')->latest()->get();
        $suppliers = Supplier::all();

        return view('owner.receipt', compact('receipts','projects', 'suppliers'));
    }
    
    public function showReceiptInvalid()
    {
        $receipts = Receipt::where('remarks','invalid')->latest()->paginate(10);
        $projects = Project::where('status', 'new')->latest()->get();
        $suppliers = Supplier::all();

        return view('receipt.invalid', compact('receipts','projects', 'suppliers'));
    }
    
    public function showOwnerReceiptInvalid()
    {
        $receipts = Receipt::where('remarks','invalid')->latest()->paginate(10);
        $projects = Project::where('status', 'new')->latest()->get();
        $suppliers = Supplier::all();

        return view('owner.receiptInvalid', compact('receipts','projects', 'suppliers'));
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
            'si_or_no' => 'required|max:15',
            'supplier_id' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric|max:999999|min:0',
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
    
    public function updateReceipt(Request $request, $id)
    {
        $validatedData = $request->validate([
            'project_id' => 'required',
            'receipt_date' => 'required|date',
            'si_or_no' => 'required|max:15',
            'supplier_id' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric|max:100000|min:0',
            'receipt_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming receipt_photo is the file input name
        ],[
            'project_id.required' => 'The project is no longer exist.'
            ]);
    
        $receipt = Receipt::findOrFail($id);
    
        // Update the receipt data
        $receipt->update([
            'project_id' => $validatedData['project_id'],
            'description' => $validatedData['description'],
            'si_or_no' => $validatedData['si_or_no'],
            'supplier_id' => $validatedData['supplier_id'],
            'amount' => $validatedData['amount'],
            'receipt_date' => $validatedData['receipt_date'],
            // Update other fields as needed
        ]);
    
        // Handle receipt photo update if necessary
        if ($request->hasFile('receipt_photo')) {
            $receipt_photo = $request->file('receipt_photo');
            $path = $receipt_photo->store('receipts', 'public');
            $receipt->update(['receipt_photo' => $path]);
        }
    
        return redirect()->back()->with('success', 'Receipt updated successfully');
    }

}
