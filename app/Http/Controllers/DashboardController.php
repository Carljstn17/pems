<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Estimate;
use App\Models\Payroll;
use App\Models\PayrollBatch;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\AdvanceRequest;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $projects = Project::where('status', 'new')->count();
        $estimates = Estimate::whereBetween('created_at', [now()->subDays(5), now()])->count();
        $payrolls = PayrollBatch::where('remarks', 'valid')
                   ->whereBetween('created_at', [now()->subDays(5), now()])
                   ->count();
        $receipts = Receipt::where('remarks', 'valid')
                   ->whereBetween('created_at', [now()->subDays(5), now()])
                   ->count();

        return view('staff.dashboard', compact('estimates', 'projects', 'payrolls', 'receipts'));
    }

    public function showPanel()
    {
        // Paginate projects
        $projects = Project::where('status', 'new')->count();
        $estimates = Estimate::whereBetween('created_at', [now()->subDays(5), now()])->count();
        $payrolls = PayrollBatch::where('remarks', 'valid')
                   ->whereBetween('created_at', [now()->subDays(5), now()])
                   ->count();
        $receipts = Receipt::where('remarks', 'valid')
                   ->whereBetween('created_at', [now()->subDays(5), now()])
                   ->count();

        return view('owner.panel', compact('estimates', 'projects', 'payrolls', 'receipts'));
    }
    
    public function Dashboard()
    {
        $advanceRequest = AdvanceRequest::where('status', 'accepted')
            ->orderBy('created_at', 'desc')
            ->first();

        return view('laborer.dashboard', compact('advanceRequest'));
    }
    
}
