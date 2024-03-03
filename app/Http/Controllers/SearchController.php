<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Project;
use App\Models\Estimate;
use App\Models\Machinery;
use App\Models\PayrollBatch;
use App\Models\Receipt;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use Searchable;

    public function searchProject(Request $request, $status = 'new')
    {
        $query = $request->input('query');

        $results = Project::search($query, ['project_id', 'project_dsc'], $status)->get();

        return view('project.search', ['results' => $results, 'query' => $query]);
    }

    public function searchOldProject(Request $request, $status = 'old')
    {
        $query = $request->input('query');

        $results = Project::search($query, ['project_id', 'project_dsc'], $status)->get();

        return view('project.search', ['results' => $results, 'query' => $query]);
    }

    public function searchEstimate(Request $request, $status = ['pending','accepted'])
    {
        $searchQuery = $request->input('query');

        $estimates = Estimate::where(function ($queryBuilder) use ($searchQuery, $status) {
            $queryBuilder->where('description', 'LIKE', "%{$searchQuery}%")
                ->orWhere('group_id', 'LIKE', "%{$searchQuery}%")
                ->orWhere('user_id', 'LIKE', "%{$searchQuery}%")
                ->orWhereHas('entry', function ($query) use ($searchQuery) {
                    $query->where('username', 'LIKE', "%{$searchQuery}%");
                })
                ;
        })
        ->whereIn('status', $status)
        ->get()
        ->groupBy('group_id');
    
        return view('estimate.search', ['estimates' => $estimates, 'query' => $searchQuery]);
    }
    
    public function searchEstimateForOwner(Request $request, $status = ['pending','accepted'])
    {
        $searchQuery = $request->input('query');

        $estimates = Estimate::where(function ($queryBuilder) use ($searchQuery, $status) {
            $queryBuilder->where('description', 'LIKE', "%{$searchQuery}%")
                ->orWhere('group_id', 'LIKE', "%{$searchQuery}%")
                ->orWhere('user_id', 'LIKE', "%{$searchQuery}%")
                ->orWhereHas('entry', function ($query) use ($searchQuery) {
                    $query->where('username', 'LIKE', "%{$searchQuery}%");
                })
                ;
        })
        ->whereIn('status', $status)
        ->get()
        ->groupBy('group_id');
    
        return view('owner.searchEstimate', ['estimates' => $estimates, 'query' => $searchQuery]);
    }

    public function searchRejectEstimate(Request $request, $status = 'rejected')
    {
        $searchQuery = $request->input('query');

        $estimates = Estimate::where(function ($queryBuilder) use ($searchQuery, $status) {
            $queryBuilder->where('description', 'LIKE', "%{$searchQuery}%")
                ->orWhere('group_id', 'LIKE', "%{$searchQuery}%")
                ->orWhere('user_id', 'LIKE', "%{$searchQuery}%")
                ->orWhereHas('entry', function ($query) use ($searchQuery) {
                    $query->where('username', 'LIKE', "%{$searchQuery}%");
                })
                ;
        })
        ->where('status', 'LIKE', "%{$status}%")
        ->get()
        ->groupBy('group_id');
    
        return view('estimate.searchReject', ['estimates' => $estimates, 'query' => $searchQuery]);
    }
    
    public function searchRejectEstimateForOwner(Request $request, $status = 'rejected')
    {
        $searchQuery = $request->input('query');

        $estimates = Estimate::where(function ($queryBuilder) use ($searchQuery, $status) {
            $queryBuilder->where('description', 'LIKE', "%{$searchQuery}%")
                ->orWhere('group_id', 'LIKE', "%{$searchQuery}%")
                ->orWhere('user_id', 'LIKE', "%{$searchQuery}%")
                ->orWhereHas('entry', function ($query) use ($searchQuery) {
                    $query->where('username', 'LIKE', "%{$searchQuery}%");
                })
                ;
        })
        ->where('status', 'LIKE', "%{$status}%")
        ->get()
        ->groupBy('group_id');
    
        return view('owner.searchEstimateReject', ['estimates' => $estimates, 'query' => $searchQuery]);
    }

    public function searchMachinery(Request $request)
    {
        $searchQuery = $request->input('query');
    
        $machineries = Machinery::where('machinery_type', 'LIKE', "%{$searchQuery}%")
        ->orWhere('property', 'LIKE', "%{$searchQuery}%")
        ->orWhere('machinery_name', 'LIKE', "%{$searchQuery}%")
        ->orWhere('unit_cost', 'LIKE', "%{$searchQuery}%")
        ->orWhereHas('machineryReport', function ($query) use ($searchQuery) {
            $query->where('whereabout', 'LIKE', "%{$searchQuery}%")
                ->orWhere('status', 'LIKE', "%{$searchQuery}%");
        })
        ->get();
    
        return view('machinery.search', ['machineries' => $machineries, 'query' => $searchQuery]);
    }    
    
    public function searchMachineryForOwner(Request $request)
    {
        $searchQuery = $request->input('query');
    
        $machineries = Machinery::where('machinery_type', 'LIKE', "%{$searchQuery}%")
        ->orWhere('property', 'LIKE', "%{$searchQuery}%")
        ->orWhere('machinery_name', 'LIKE', "%{$searchQuery}%")
        ->orWhere('unit_cost', 'LIKE', "%{$searchQuery}%")
        ->orWhereHas('machineryReport', function ($query) use ($searchQuery) {
            $query->where('whereabout', 'LIKE', "%{$searchQuery}%")
                ->orWhere('status', 'LIKE', "%{$searchQuery}%");
        })
        ->get();
    
        return view('owner.searchMachinery', ['machineries' => $machineries, 'query' => $searchQuery]);
    }    

    public function searchTool(Request $request)
    {
        $searchQuery = $request->input('query');
    
        $tools = Tool::where('tool_type', 'LIKE', "%{$searchQuery}%")
        ->orWhere('property', 'LIKE', "%{$searchQuery}%")
        ->orWhere('tool_name', 'LIKE', "%{$searchQuery}%")
        ->orWhere('unit_cost', 'LIKE', "%{$searchQuery}%")
        ->orWhereHas('toolReport', function ($query) use ($searchQuery) {
            $query->where('whereabout', 'LIKE', "%{$searchQuery}%")
                ->orWhere('status', 'LIKE', "%{$searchQuery}%");
        })
        ->get();
    
        return view('tool.search', ['tools' => $tools, 'query' => $searchQuery]);
    }    
    
    public function searchToolForOwner(Request $request)
    {
        $searchQuery = $request->input('query');
    
        $tools = Tool::where('tool_type', 'LIKE', "%{$searchQuery}%")
        ->orWhere('property', 'LIKE', "%{$searchQuery}%")
        ->orWhere('tool_name', 'LIKE', "%{$searchQuery}%")
        ->orWhereHas('toolReport', function ($query) use ($searchQuery) {
            $query->where('whereabout', 'LIKE', "%{$searchQuery}%")
                ->orWhere('status', 'LIKE', "%{$searchQuery}%");
        })
        ->get();
    
        return view('owner.searchTool', ['tools' => $tools, 'query' => $searchQuery]);
    }
    
    public function searchPayroll(Request $request)
    {
        $searchQuery = $request->input('query');
    
        $payrollBatch = PayrollBatch::where('id', 'LIKE', "%{$searchQuery}%")
            ->orWhere('project_id', 'LIKE', "%{$searchQuery}%")
            ->orWhere('entry_by', 'LIKE', "%{$searchQuery}%")
            ->orWhere('created_at', 'LIKE', "%{$searchQuery}%")
            ->orWhere('remarks', 'LIKE', "%{$searchQuery}%")
            ->orWhereHas('entry', function ($query) use ($searchQuery) {
                $query->where('username', 'LIKE', "%{$searchQuery}%");
            })
            ->get();
    
        return view('payroll.search', ['payrollBatch' => $payrollBatch, 'query' => $searchQuery]);
    }

    public function searchPayrollProject(Request $request, $status = 'new')
    {
        $query = $request->input('query');

        $projects = Project::search($query, ['project_id', 'project_dsc'], $status)->get();

        return view('payroll.searchProject', ['projects' => $projects, 'query' => $query]);
    }
    
   public function searchPayrollForOwner(Request $request)
    {
        $searchQuery = $request->input('query');
    
        $payrollBatch = PayrollBatch::where('id', 'LIKE', "%{$searchQuery}%")
            ->orWhere('project_id', 'LIKE', "%{$searchQuery}%")
            ->orWhere('entry_by', 'LIKE', "%{$searchQuery}%")
            ->orWhere('created_at', 'LIKE', "%{$searchQuery}%")
            ->orWhere('remarks', 'LIKE', "%{$searchQuery}%")
            ->orWhereHas('entry', function ($query) use ($searchQuery) {
                $query->where('username', 'LIKE', "%{$searchQuery}%");
            })
            ->get();
    
        return view('owner.searchPayroll', ['payrollBatch' => $payrollBatch, 'query' => $searchQuery]);
    }
    
    public function searchReceipt(Request $request)
    {
        $searchQuery = $request->input('query');
    
        $receipts = Receipt::where('id', 'LIKE', "%{$searchQuery}%")
            ->orWhere('project_id', 'LIKE', "%{$searchQuery}%")
            ->orWhere('user_id', 'LIKE', "%{$searchQuery}%")
            ->orWhere('created_at', 'LIKE', "%{$searchQuery}%")
            ->orWhere('si_or_no', 'LIKE', "%{$searchQuery}%")
            ->orWhere('description', 'LIKE', "%{$searchQuery}%")
            ->orWhere('remarks', 'LIKE', "%{$searchQuery}%")
            ->orWhereHas('user', function ($query) use ($searchQuery) {
                $query->where('username', 'LIKE', "%{$searchQuery}%");
            })
            ->orWhereHas('supplier', function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', "%{$searchQuery}%");
            })
            ->get();
    
        return view('receipt.search', ['receipts' => $receipts, 'query' => $searchQuery]);
    }

    public function searchReceiptForOwner(Request $request)
    {
        $searchQuery = $request->input('query');
    
        $receipts = Receipt::where('id', 'LIKE', "%{$searchQuery}%")
            ->orWhere('project_id', 'LIKE', "%{$searchQuery}%")
            ->orWhere('user_id', 'LIKE', "%{$searchQuery}%")
            ->orWhere('created_at', 'LIKE', "%{$searchQuery}%")
            ->orWhere('si_or_no', 'LIKE', "%{$searchQuery}%")
            ->orWhere('description', 'LIKE', "%{$searchQuery}%")
            ->orWhere('remarks', 'LIKE', "%{$searchQuery}%")
            ->orWhereHas('user', function ($query) use ($searchQuery) {
                $query->where('username', 'LIKE', "%{$searchQuery}%");
            })
            ->orWhereHas('supplier', function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', "%{$searchQuery}%");
            })
            ->get();
    
        return view('owner.searchReceipt', ['receipts' => $receipts, 'query' => $searchQuery]);
    }
    
    
    
}