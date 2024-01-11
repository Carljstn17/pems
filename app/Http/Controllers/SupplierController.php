<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function supplierForm() {

        return view('receipt.supplier');
    }

    public function ownerSupplierList() {
        $suppliers = Supplier::all();

        // Pass the advances data to the view
        return view('owner.supplier', compact('suppliers'));
    }

    public function supplierList() {
        $suppliers = Supplier::all();

        // Pass the advances data to the view
        return view('receipt.supplierList', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $suppliersData = $request->input('suppliers');

        if ($suppliersData && is_array($suppliersData)) {
            foreach ($suppliersData as $supplierData) {
                if (is_array($supplierData)) {
                    // Check if any of the required fields are not null or empty
                    if (!empty($supplierData['name']) || !empty($supplierData['contact']) || !empty($supplierData['address'])) {
                        Supplier::create([
                            'user_id' => Auth::id(),
                            'name' => $supplierData['name'],
                            'contact' => $supplierData['contact'],
                            'address' => $supplierData['address'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('latest.receipt')->with('success', 'Supplier created successfully!');
    }
}
