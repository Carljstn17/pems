<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Advance;
use App\Models\Payroll;
use App\Models\Project;
use App\Models\PayrollBatch;
use Illuminate\Http\Request;
use App\Exports\PayrollExport;
use App\Models\CompanyAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PayrollController extends Controller
{
    public function showStaffPayroll()
    {
        return view('staff.payroll');
    }

    public function showPayrollLatest()
    {
        $payrollBatch = PayrollBatch::latest('created_at')->paginate(5);
        $laborers = User::where('role', 'laborer')->get();

        return view('payroll.latest', compact('payrollBatch','laborers'));
    }

    public function ownerPayrollLatest()
    {
        $payrollBatch = PayrollBatch::latest('created_at')->paginate(5);
        $laborers = User::where('role', 'laborer')->get();

        return view('owner.payroll', compact('payrollBatch','laborers'));
    }

    public function showPayrollNew()
    {
        $ot_rate_default_value = 1.25;
        $projects = Project::where('status', 'new')->latest()->get();
        $laborers = User::where('role', 'laborer')->get();

        foreach ($laborers as $laborer) {
            $payroll = DB::table('payrolls')->where('user_id', $laborer->id)->orderBy('created_at', 'desc')->first();
            $laborer->payroll = $payroll; 

            if(empty($payroll)) {
                $payroll = new Payroll();
                $laborer->payroll = $payroll; 
            }

            if($ot_rate_default_value != $payroll->ot_rate) {
                $ot_rate_default_value = $payroll->ot_rate;
            }
        }

        return view('payroll.new', compact('projects', 'laborers', 'ot_rate_default_value'));
    }

    public function storePayroll(Request $request){
        $payrollBatch = [
            "entry_by" => Auth::id(),
            'project_id' => $request->project_id,
            'ot_rate' => $request->ot_rate,
            'total_salary' => $request->total_salary,
            'total_advance' => $request->total_advance,
            'total_net' => $request->total_net,
        ];

        $payrollBatch = PayrollBatch::create($payrollBatch);
        
        $users = $request->input('user_id');

        foreach ($users as $userId) {
            // Check if the checklist is checked for the current user
            if ($request->has('checklist') && isset($request->checklist[$userId])) {
                $data = $request->validate([
                    'rate_per_day.' . $userId => 'required|numeric',
                    'no_of_days.' . $userId => 'required|numeric',
                    // Add other validation rules as needed
                ]);
    
                $payrollData = [
                    "entry_by" => Auth::id(),
                    'user_id' => $userId,
                    'rate_per_day' => $data['rate_per_day'][$userId],
                    'no_of_days' => $data['no_of_days'][$userId],
                    'name' => $request->name[$userId],
                    'ot_rate' => $request->ot_rate,
                    'ot_hour' => $request->ot_hour[$userId],
                    'ot_amount' => $request->ot_total[$userId],
                    'salary' => $request->salary[$userId],
                    'advance_amount' => $request->advance_amount[$userId],
                    'net_amount' => $request->net_salary[$userId],
                    'project_id' => $request->project_id,
                    'batch_id' => $payrollBatch->id,
                ];
    
                $payroll = Payroll::create($payrollData);

            }

            $advances = $request->input('advances');

            if ($advances !== null) {
                foreach ($advances as $id) {
                    $advance = Advance::find($id);
            
                    if ($advance !== null) {
                        $advance->payroll_id = $payrollBatch->id;
                        $advance->remarks = 'added';
                        $advance->save();
                    }
                }
            } else {
                // Handle the case where $advances is null, if needed
                // For example, log an error, throw an exception, or provide a default behavior
            }
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
    
    public function showPayroll($batchId)
    {
        $payrolls = DB::table('payrolls')->where('batch_id', $batchId)->get();
        $batch = PayrollBatch::findOrFail($batchId);

        return view('payroll.showPayroll', compact('payrolls', 'batch'));
    }

    public function projectPayroll($project_id)
    {
        $projects = Project::all();
        $laborers = User::where('role', 'laborer')->get();
        $payrollBatch = PayrollBatch::where('project_id', $project_id)->latest('created_at')->paginate(5);

        return view('payroll.showProject', compact('projects', 'payrollBatch', 'laborers'));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////

    public function showOwnerPayroll($batchId)
    {
        $payrolls = DB::table('payrolls')->where('batch_id', $batchId)->get();
        $batch = PayrollBatch::findOrFail($batchId);

        return view('owner.payrollShow', compact('payrolls', 'batch'));
    }

    public function ownerBatchRemarks($batchId)
    {
        PayrollBatch::where('id', $batchId)->update(['remarks' => 'invalid']);

        // Update remarks in advance table
        $userIds = DB::table('payrolls')->where('batch_id', $batchId)->pluck('user_id')->toArray();
        
        Advance::whereIn('user_id', $userIds)->update(['remarks' => 'add']);

        // Redirect back or to any other page after update
        return redirect()->back()->with('success', 'Remarks updated successfully!');
    }

    public function updateBatchRemarks($batchId)
    {
        PayrollBatch::where('id', $batchId)->update(['remarks' => 'invalid']);

        // Update remarks in advance table
        $userIds = DB::table('payrolls')->where('batch_id', $batchId)->pluck('user_id')->toArray();
        
        Advance::whereIn('user_id', $userIds)->update(['remarks' => 'add']);

        // Redirect back or to any other page after update
        return redirect()->back()->with('success', 'Remarks updated successfully!');
    }

    public function laborerPayroll()
    {
        $userId = Auth::id();

        $payrolls = DB::table('payrolls')
        ->join('projects', 'payrolls.project_id', '=', 'projects.id')
        ->join('payroll_batches', 'payrolls.batch_id', '=', 'payroll_batches.id')
        ->select('payrolls.*', 'projects.project_id')
        ->where('payrolls.user_id', $userId)
        ->where('payroll_batches.remarks', 'valid') // Filter based on remarks from payroll_batches table
        ->latest('payrolls.created_at')
        ->paginate(5);

        return view('laborer.payroll', compact('payrolls'));
    }

    public function laborerShowPayroll($payrollId)
    {
        $payrolls = DB::table('payrolls')
        ->join('projects', 'payrolls.project_id', '=', 'projects.id')
        ->join('users', 'payrolls.entry_by', '=', 'users.id')
        ->where('payrolls.id', $payrollId)
        ->select('payrolls.*', 'projects.project_dsc', 'users.name as entry_by')
        ->first();

        return view('laborer.payrollShow', compact('payrolls', ));
    }

    public function export($batchId)
    {
        $payrolls = DB::table('payrolls')->where('batch_id', $batchId)->get();
        $batch = PayrollBatch::findOrFail($batchId);

        return Excel::download(new PayrollExport($payrolls, $batch), 'payroll.xlsx');
    }

}
