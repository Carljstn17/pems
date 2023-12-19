<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Estimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        // Paginate projects
        $projects = Project::where('status', 'new')->latest()->paginate(2);

        // Retrieve only the latest estimate group_id
        $estimate = Estimate::latest('updated_at');
        $estimates = $estimate->where('status', ['pending', 'new'])
           ->latest('updated_at')->get()->groupBy('group_id');

        return view('staff.dashboard', compact('estimates', 'projects'));
    }

    public function showPanel()
    {
        // Paginate projects
        $projects = Project::where('status', 'new')->latest()->paginate(2);

        // Retrieve only the latest estimate group_id
        $estimate = Estimate::latest('updated_at');
        $estimates = $estimate->where('status', ['pending', 'new'])
           ->latest('updated_at')->get()->groupBy('group_id');

        return view('owner.panel', compact('estimates', 'projects'));
    }
}
