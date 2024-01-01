<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Advance;
use App\Models\Payroll;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\CompanyAttribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PayrollController extends Controller
{
    public function showStaffPayroll()
    {
        return view('staff.payroll');
    }

    public function showPayrollLatest()
    {
        $projects = Project::where('status', 'new')->latest()->get();
        $laborers = User::where('role', 'laborer')->get();

        return view('payroll.latest', compact('projects','laborers'));
    }

    public function showPayrollNew()
    {
        $ot_rate_default_value = 1.25;
        $projects = Project::where('status', 'new')->latest()->get();
        $laborers = User::where('role', 'laborer')->get();

        foreach ($laborers as $laborer) {
            if (empty($laborer->payroll)) {
                $payroll = new Payroll();
                $laborer->setPayroll($payroll);
            } else {
                if ($ot_rate_default_value != $laborer->payroll->ot_rate) {
                    $ot_rate_default_value = $laborer->payroll->ot_rate;
                }
            }
        }

        return view('payroll.new', compact('projects', 'laborers', 'ot_rate_default_value'));
    }

    public function storePayroll(Request $request){
        $users = $request->input('user_id');

        foreach ($users as $userId) {
            Payroll::create([
                "entry_by" => Auth::id(),
                'user_id' => $userId,
                'rate_per_day' => $request->rate_per_day[$userId],
                'no_of_days' => $request->no_of_days[$userId],
                'name' => $request->name[$userId],
                'ot_rate' => $request->ot_rate,
                'ot_hour' => $request->ot_hour[$userId],
                'ot_amount' => $request->ot_total[$userId],
                'salary' => $request->salary[$userId],
                'advance_amount' => $request->advance_amount[$userId],
                'net_amount' => $request->net_salary[$userId],
                'project_id' => $request->project_id,
            ]);
        }

        return redirect()->route('latest.payroll')->with('success', 'Payroll record created successfully');
    }
    

    public function showPayrollAdvance()
    {
        $projects = Project::all();
        $laborers = User::where('role', 'laborer')->get();

        return view('payroll.advance', compact('projects', 'laborers'));
    }

    public function showPayrollOngoing()
    {
        $projects = Project::where('status', 'new')->latest()->paginate(6);

        return view('payroll.ongoing')->with('projects', $projects);
    }

    public function getAdvances(User $user)
    {
        $advances = $user->advances; // Assuming a relationship exists between User and Advance models

        return response()->json($advances);
    }
    
    // public function showLatest($id)
    // {
    //     try {
    //         $payrolls = Payroll::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    //     } catch (ModelNotFoundException $e) {
    //         abort(404);
    //     }

    //     return view('project.showproject')->with('payrolls', $payrolls);
    // }

    // public function showOngoing($id)
    // {
    //     try {
    //         $allPayrolls = Payroll::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    //     } catch (ModelNotFoundException $e) {
    //         abort(404);
    //     }

    //     return view('project.showproject')->with('payrolls', $allPayrolls);
    // }
}
