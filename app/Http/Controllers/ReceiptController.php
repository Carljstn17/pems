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
    // public function showReceiptNew()
    // {
    //     $projects = Project::where('status', 'new')->latest()->get();
    //     $suppliers = Supplier::all();

    //     return view('receipt.latest', compact('projects', 'suppliers'));
    // }

    public function createEntry(Request $request)
    {
        // Upload the receipt photo and get its path
        $photoPath = $request->file('receipt_photo')->store('receipts');

        // Create a new entry record in the database
        Receipt::create([
            "user_id"=> Auth::id(),
            'project_id' => $request->input('project_id'),
            'receipt_date' => $request->input('receipt_date'),
            'si_or_no' => $request->input('si_or_no'),
            'supplier_id' => $request->input('supplier_id'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
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
        return view('receipt.showReceipt', compact('receipts','projects', 'suppliers'));
    }

}
