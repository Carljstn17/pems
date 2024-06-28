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
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewPayrollNotification;

class PayrollController extends Controller
{
    public function showStaffPayroll()
    {
        return view('staff.payroll');
    }

    public function showPayrollLatest()
    {
        $payrollBatch = PayrollBatch::whereIn('status', ['valid','pending'])
            ->orderByRaw("FIELD(status, 'valid', 'pending')")
            ->latest('created_at')->paginate(10);
            
        $laborers = User::where('role', 'laborer')->get();
        $projects = Project::where('status', 'new')->latest()->get();

        return view('payroll.latest', compact('payrollBatch','laborers', 'projects'));
    }
    
    public function submitProject(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
        ]);

        $projectId = $request->input('project_id');

        // Redirect to a specific view or handle the project selection as needed
        return redirect()->route('new.payroll', ['project_id' => $projectId]);
    }

    public function ownerPayrollLatest()
    {
        $payrollBatch = PayrollBatch::whereIn('status', ['valid','pending'])
            ->orderByRaw("FIELD(status, 'pending', 'valid')")
            ->latest('created_at')->paginate(10);

        return view('owner.payroll', compact('payrollBatch'));
    }
    
    public function invalidList()
    {
        $payrollBatch = PayrollBatch::where('status', 'invalid')
            ->latest('created_at')->paginate(10);

        return view('payroll.invalid', compact('payrollBatch'));
    }
    
    public function invalidListOwner()
    {
        $payrollBatch = PayrollBatch::where('status', 'invalid')
            ->latest('created_at')->paginate(10);

        return view('owner.payrollInvalid', compact('payrollBatch'));
    }

    public function showPayrollNew($project_id)
    {
        $project = Project::findOrFail($project_id);
        $projectId = $project->id;
        $ot_rate_default_value = 1.25;
        $laborers = User::where('role', 'laborer')
                        ->where('project_id', $project_id)
                        ->get();

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

        return view('payroll.new', compact('project', 'laborers', 'ot_rate_default_value', 'projectId'));
    }

    public function storePayroll(Request $request){
        DB::beginTransaction();
        $batchData = [
            "entry_by" => Auth::id(),
            'project_id' => $request->project_id,
            'ot_rate' => $request->ot_rate,
            'total_salary' => $request->total_salary,
            'total_advance' => $request->total_advance,
            'total_net' => $request->total_net,
        ];
        
        $request->validate([
            'project_id' => 'required|numeric',
            'ot_rate' => 'required|numeric',
            'total_salary' => 'required|numeric',
            'total_advance' => 'nullable|numeric',
            'total_net' => 'required|numeric',
        ], [
            'total_salary.required' => 'There is no Total Amount. Please check the data'
        ]);
        
        $payrollBatch = PayrollBatch::create($batchData);
        
        $users = $request->input('user_id');

        foreach ($users as $userId) {
            // Check if the checklist is checked for the current user
            if ($request->has('checklist') && isset($request->checklist[$userId])) {
            
            $data = $request->validate([
                'rate_per_day.' . $userId => 'required|numeric|max:9999',
                'no_of_days.' . $userId => 'required|numeric|max:99',
            ], [
                'rate_per_day.' . $userId . '.required' => 'The RATE/DAY field is required*',
                'no_of_days.' . $userId . '.required' => 'The DAYS field is required*',
                'rate_per_day.' . $userId . '.max' => 'The RATE/DAY amount is too much*',
                'no_of_days.' . $userId . '.max' => 'The DAYS amount is too much*',
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
                    'net_amount' => $request->net_amount[$userId],
                    'project_id' => $request->project_id,
                    'batch_id' => $payrollBatch->id,
                ];
                
                if(empty($payrollData['no_of_days']) || empty($payrollData['rate_per_day']) || empty($payrollData['salary']) || empty($payrollData['net_amount'])){
                    DB::rollBack();
                }
                
                $result = Payroll::create($payrollData);
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

        
        $owners = User::where('role', 'owner')->get();
        Notification::send($owners, new NewPayrollNotification($payrollBatch));
        DB::commit();
        
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
        PayrollBatch::where('id', $batchId)->update(['status' => 'invalid']);

        Advance::whereExists(function ($query) use ($batchId) {
            $query->select(DB::raw(1))
                  ->from('payroll_batches')
                  ->join('payrolls', 'payrolls.batch_id', '=', 'payroll_batches.id')
                  ->whereColumn('advances.payroll_id', 'payroll_batches.id')
                  ->where('payrolls.batch_id', $batchId)
                  ->whereNotNull('payrolls.advance_amount')
                  ->whereColumn('advances.user_id', 'payrolls.user_id');
        })->update(['remarks' => 'valid', 'payroll_id' => null]);

        // Redirect back or to any other page after update
        return redirect()->back()->with('success', 'Remarks invalid!');
    }

    public function updateBatchRemarks($batchId)
    {
        PayrollBatch::where('id', $batchId)->update(['status' => 'invalid']);

        Advance::whereExists(function ($query) use ($batchId) {
            $query->select(DB::raw(1))
                  ->from('payroll_batches')
                  ->join('payrolls', 'payrolls.batch_id', '=', 'payroll_batches.id')
                  ->whereColumn('advances.payroll_id', 'payroll_batches.id')
                  ->where('payrolls.batch_id', $batchId)
                  ->whereNotNull('payrolls.advance_amount')
                  ->whereColumn('advances.user_id', 'payrolls.user_id');
        })->update(['remarks' => 'valid', 'payroll_id' => null]);
            
        // Redirect back or to any other page after update
        return redirect()->back()->with('success', 'Remarks invalid!');
    }
    
    public function statusCorrectValid($batchId)
    {
        PayrollBatch::where('id', $batchId)->update(['status' => 'valid']);
            
        // Redirect back or to any other page after update
        return redirect()->back()->with('success', 'status is valid!');
    }

    public function laborerPayroll()
    {
        $userId = Auth::id();

        $payrolls = DB::table('payrolls')
        ->join('projects', 'payrolls.project_id', '=', 'projects.id')
        ->join('payroll_batches', 'payrolls.batch_id', '=', 'payroll_batches.id')
        ->select('payrolls.*', 'projects.project_id', 'projects.project_dsc')
        ->where('payrolls.user_id', $userId)
        ->where('payroll_batches.status', 'valid') // Filter based on remarks from payroll_batches table
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
        ->select('payrolls.*', 'projects.project_dsc', DB::raw('CONCAT(users.fname, " ", COALESCE(users.mname, ""), " ", users.lname) AS entry_by'))
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
