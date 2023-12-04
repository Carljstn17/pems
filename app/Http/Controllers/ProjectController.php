<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function showOnProject()
    {
        $projects = Project::all();

        return view('staff.oprojects')->with('projects', $projects);
    }
    public function store(Request $request)
    {
        $request->validate([
            "project_id"=> 'required|string|max:15',
            "project_dsc"=> 'required|string|max:120',
            "client"=> 'required',
            "contract"=> 'required|integer',
            "location"=> 'required',
            "date_started" => 'required|date',
            "contact" => 'required|string|max:15',
            ]);
            
        Project::create([
            "project_id"=> $request->input('project_id'),
            "user_id"=> Auth::id(),
            "project_dsc"=> $request->input('project_dsc'),
            "client"=> $request->input('client'),
            "contract"=> $request->input('contract'),
            "location"=> $request->input('location'),
            "date_started" => $request->input('date_started'),
            "contact" => $request->input('contact'),
        ]);
        return redirect('/staff/ongoing-projects')->with('success', 'Employee registered successfully.');
    }
    public function show($id){

    }
    public function showStaffProject()
    {
        return view('staff.projects');
    }
    public function showNewProject()
    {
        return view('staff.nprojects');
    }
    public function showAllProject()
    {
        return view('staff.aprojects');
    }
    public function addProject()
    {
        return view('staff.addprojects');
    }
}
