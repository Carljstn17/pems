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
        $projects = Project::where('status', 'new')->latest()->get();
        $laborers = User::where('role', 'laborer')->get();

        foreach($laborers as $laborer) {
            $payroll = new Payroll();
            $laborer->setPayroll($payroll);
        }

        return view('payroll.new', compact('projects', 'laborers'));
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
