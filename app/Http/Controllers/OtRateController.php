<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyAttribute;
use Illuminate\Support\Facades\Auth;

class OtRateController extends Controller
{

    public function storeNewRate(Request $request)
    {
        CompanyAttribute::create([
            'ot_rate' => $request->input('ot_rate'),
            'entry_by' => Auth::id(),
        ]);

        return redirect()->route('new.payroll')->with('success', 'OT Rate added successfully.');
    }
}
