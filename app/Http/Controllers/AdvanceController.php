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
        $entryBy = Auth::id();
        // Process the form data and store it in the database
        foreach ($request->user_id as $key => $userId) {
            $user = User::find($userId);

            if ($user) {
                $user->advances()->create([
                    'amount' => $request->amount[$key],
                    'name' => $user->name,
                    'entry_by' => $entryBy,
                ]);
            }
        }
        // Redirect back or to a specific route after successful submission
        return redirect()->route('latest.payroll')->with('success', 'Advances added successfully!');
    }

    public function advanceList() {
        $advances = Advance::all();

        // Pass the advances data to the view
        return view('payroll.advanceList', ['advances' => $advances]);
    }

    public function getAdvance($id)
    {
        // Fetch the advance for the selected laborer
        $advance = Advance::where('user_id', $id)->first();

        return response()->json($advance);
    }
}
