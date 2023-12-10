<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payroll;
use App\Models\Project;
use Illuminate\Http\Request;
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
        // $payrolls = Payroll::all();

        return view('payroll.latest');
    }
    public function showPayrollNew()
    {
        $projects = Project::all();
        $laborers = User::where('role', 'laborer')->get();

        return view('payroll.new', compact('projects', 'laborers'));
    }
    public function showPayrollOngoing()
    {
        // $allPayrolls = Payroll::all()

        return view('payroll.ongoing');
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
