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
        $results = Project::where('project_id', 'LIKE', "%$query%")
                            ->orWhere('project_dsc', 'LIKE', "%$query%")
                            ->get();

        return view('project.search', ['results' => $results, 'query' => $query]);
    }

    public function searchEstimate(Request $request)
    {
        $query = $request->input('query');

        // Perform the search query, adjust this based on your database structure
        $estimates = Estimate::where('description', 'LIKE', "%$query%")
            ->orWhere('uom', 'LIKE', "%$query%")
            ->orWhere('group_id', 'LIKE', "%$query%")
            ->get();

        return view('estimate.latest', ['estimates' => $estimates, 'query' => $query]);
    }

}
