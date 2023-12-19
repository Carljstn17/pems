<?php

namespace App\Http\Controllers;

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

    public function searchEstimate(Request $request, $status = 'pending,new')
    {
        $query = $request->input('query');

        $estimates = Estimate::search($query, ['description', 'uom', 'group_id'], $status)->get();

        return view('estimate.search', ['estimates' => $estimates, 'query' => $query]);
    }

    public function searchRejectEstimate(Request $request)
    {
        return $this->searchEstimate($request, 'rejected');
    }

    public function searchMachinery(Request $request)
    {
        $query = $request->input('query');

        $machineries = Machinery::search($query, ['machinery_type', 'property', 'machinery_name', 'unit_cost'])->paginate(10);

        return view('machinery.all', ['machineries' => $machineries, 'query' => $query]);
    }
}