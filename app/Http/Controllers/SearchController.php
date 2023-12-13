<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Estimate;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchProject(Request $request)
    {
        $query = $request->input('query');

        // Perform the search query on your model
        $results = Project::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('project_id', 'LIKE', "%$query%")
                ->orWhere('project_dsc', 'LIKE', "%$query%");
        })
        ->where(function ($queryBuilder) {
            // Add a condition where 'status' is equal to 'new'
            $queryBuilder->where('status', '=', 'new');
        })
        ->get();

        return view('project.search', ['results' => $results, 'query' => $query]);
    }

    public function searchOldProject(Request $request)
    {
        $query = $request->input('query');

        // Perform the search query on your model
        $results = Project::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('project_id', 'LIKE', "%$query%")
                ->orWhere('project_dsc', 'LIKE', "%$query%");
        })
        ->where(function ($queryBuilder) {
            // Add a condition where 'status' is equal to 'new'
            $queryBuilder->where('status', '=', 'old');
        })
        ->get();

        return view('project.searchOld', ['results' => $results, 'query' => $query]);
    }

    public function searchEstimate(Request $request)
    {
        $query = $request->input('query');

        // Perform the search query, adjust this based on your database structure
        $estimates = Estimate::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('description', 'LIKE', "%$query%")
                ->orWhere('uom', 'LIKE', "%$query%")
                ->orWhere('group_id', 'LIKE', "%$query%");
        })
        ->where(function ($queryBuilder) {
            // Add a condition where 'status' is equal to 'pending' or 'new'
            $queryBuilder->whereIn('status', ['pending', 'new']);
        })   
        ->get();

        return view('estimate.search', ['estimates' => $estimates, 'query' => $query]);
    }

    public function searchRejectEstimate(Request $request)
    {
        $query = $request->input('query');

        // Perform the search query, adjust this based on your database structure
        $estimates = Estimate::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('description', 'LIKE', "%$query%")
                ->orWhere('uom', 'LIKE', "%$query%")
                ->orWhere('group_id', 'LIKE', "%$query%");
        })
        ->where(function ($queryBuilder) {
            // Add a condition where 'status' is equal to 'new'
            $queryBuilder->where('status', '=', 'rejected');
        })
        ->get();

        return view('estimate.searchReject', ['estimates' => $estimates, 'query' => $query]);
    }

}
