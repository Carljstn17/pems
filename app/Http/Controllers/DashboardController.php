<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Estimate;
use App\Models\Payroll;
use App\Models\PayrollBatch;
use App\Models\Receipt;
use App\Models\Advance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\AdvanceRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // public function showDashboard()
    // {
    //     // Calculate the start of the current week (Sunday 12:01 AM)
    //     $startOfWeek = now()->startOfWeek()->startOfDay();
    
    //     // Calculate the end of the current week (Saturday 11:59 PM)
    //     $endOfWeek = now()->endOfWeek()->endOfDay();
    
    //     $projects = Project::where('status', 'new')->count();
    //     $estimates = Estimate::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
    //     $payrolls = PayrollBatch::where('status', 'valid')->count();
    //     $receipts = Receipt::where('remarks', 'valid')
    //               ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
    //               ->count();
    
    //     return view('staff.dashboard', compact('estimates', 'projects', 'payrolls', 'receipts'));
    // }
    
    public function showDashboard()
    {
        $projects = Project::where('status', 'new')->count();
        $estimates = Estimate::where('status', 'accepted')->count();
        $payrolls = PayrollBatch::where('status', 'valid')->count();
        $receipts = Receipt::where('remarks', 'valid')->count();
    
        return view('staff.dashboard', compact('estimates', 'projects', 'payrolls', 'receipts'));
    }

    // public function showPanel()
    // {
    //     // Calculate the start of the current week (Sunday 12:01 AM)
    //     $startOfWeek = now()->startOfWeek()->startOfDay();
    
    //     // Calculate the end of the current week (Saturday 11:59 PM)
    //     $endOfWeek = now()->endOfWeek()->endOfDay();
    
    //     $projects = Project::where('status', 'new')->count();
    //     $estimates = Estimate::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
    //     $payrolls = PayrollBatch::where('status', 'pending')->count();
    //     $receipts = Receipt::where('remarks', 'valid')
    //               ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
    //               ->count();
    
    //     return view('owner.panel', compact('estimates', 'projects', 'payrolls', 'receipts'));
    // }
    
    public function showPanel()
    {
        $projects = Project::where('status', 'new')->count();
        $estimates = Estimate::where('status', 'pending')->count();
        $payrolls = PayrollBatch::where('status', 'pending')->count();
        $receipts = Receipt::where('remarks', 'valid')->count();
    
        return view('owner.panel', compact('estimates', 'projects', 'payrolls', 'receipts'));
    }

    
    public function Dashboard()
    {
        $user = Auth::user();

        $advanceRequest = AdvanceRequest::where('entry_by', $user->id)
            ->where('status', 'accepted')
            ->orderBy('created_at', 'desc')
            ->first();
            
        $payrollNotif = DB::table('payrolls')
            ->join('payroll_batches', 'payrolls.batch_id', '=', 'payroll_batches.id')
            ->where('payrolls.user_id', $user->id)
            ->where('payroll_batches.status', 'valid')
            ->orderBy('payrolls.created_at', 'desc')
            ->select('payrolls.*')
            ->first();
            
        $date = date_create($payrollNotif->created_at);
        $formattedDate = date_format($date, 'y-m-d');
            
        $advanceNotif = Advance::where('payroll_id', $user->id)
            ->where('remarks', 'added')
            ->orderBy('created_at', 'desc')
            ->first();

        return view('laborer.dashboard', compact('advanceRequest', 'payrollNotif', 'advanceNotif', 'formattedDate'));
    }
    
}
