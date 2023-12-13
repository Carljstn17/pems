<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Estimate;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $projects = Project::where('status', 'new')->get();
        $estimates = Estimate::where('status', ['pending', 'new'])->get()->groupBy('group_id');

        return view('staff.dashboard', compact('estimates', 'projects'));
    }
}
