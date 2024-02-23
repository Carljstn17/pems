<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Project;
use App\Models\Estimate;
use App\Models\Machinery;
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
        $query = $request->input('query');

        $estimates = Estimate::where(function ($queryBuilder) use ($query, $status) {
            $queryBuilder->where('description', 'LIKE', "%{$query}%")
                ->orWhere('group_id', 'LIKE', "%{$query}%")
                ->orWhere('user_id', 'LIKE', "%{$query}%")
                ;
        })
        ->whereIn('status', $status)
        ->get()
        ->groupBy('group_id');
    
        return view('estimate.search', ['estimates' => $estimates, 'query' => $query]);
    }

    public function searchRejectEstimate(Request $request, $status = 'rejected')
    {
        $query = $request->input('query');

        $estimates = Estimate::where(function ($queryBuilder) use ($query, $status) {
            $queryBuilder->where('description', 'LIKE', "%{$query}%")
                ->orWhere('group_id', 'LIKE', "%{$query}%")
                ->orWhere('user_id', 'LIKE', "%{$query}%")
                ;
        })
        ->where('status', 'LIKE', "%{$status}%")
        ->get()
        ->groupBy('group_id');
    
        return view('estimate.searchReject', ['estimates' => $estimates, 'query' => $query]);
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
}