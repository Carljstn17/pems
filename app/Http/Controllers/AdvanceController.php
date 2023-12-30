<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Advance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvanceController extends Controller
{
    public function storeAdvance(Request $request)
    {
        $user_id = $request->input('user_id');
        $amount = $request->input('amount');

        $user = User::find($user_id);
        $name = $user ? $user->name : null;

        // Create a new Advance instance and save it to the database
        Advance::create([
            "entry_by"=> Auth::id(),
            'user_id' => $user_id,
            'name' => $name,
            'amount' => $amount,
        ]);
        // Redirect back or to a specific route after successful submission
        return redirect()->route('latest.payroll')->with('success', 'Advances added successfully!');
    }

    public function advanceList() {
        $advances = Advance::all();
        $laborers = User::where('role', 'laborer')->get();

        // Pass the advances data to the view
        return view('payroll.advanceList', compact('advances', 'laborers'));
    }

    public function getAdvance($id)
    {
        // Fetch the advance for the selected laborer
        $advance = Advance::where('user_id', $id)->first();

        return response()->json($advance);
    }
}
