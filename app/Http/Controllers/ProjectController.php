<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Utils\AmountCalculator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectController extends Controller
{
    public function showOnProject()
    {
        $projects = Project::where('status', 'new')->latest()->paginate(6);

        return view('project.onprojects')->with('projects', $projects);
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
    public function show($id)
    {      
        $project = Project::where('id', $id)->firstOrFail();

        $totalAmountsReceiptByProject = AmountCalculator::calculateTotalAmountsReceiptByProject();
        // Retrieve the total amount for the specific project_id
        $totalAmountReceiptByProject = $totalAmountsReceiptByProject[$project->id] ?? 0;

        $totalAmountsPayrollByProject = AmountCalculator::calculateTotalAmountsPayrollByProject();
        // Retrieve the total amount for the specific project_id
        $totalAmountPayrollByProject = $totalAmountsPayrollByProject[$project->id] ?? 0;

        $totalAmountByProject = $totalAmountReceiptByProject + $totalAmountPayrollByProject;
        $projectContract = $project->contract;

        $totalAmountAndContractDifference = $totalAmountByProject - $projectContract;

        $colorStyle = ($projectContract > $totalAmountByProject) ? 'color: green;' : 'color: red;';
        // Make it negative if $totalAmountByProject is larger

        return view('project.showproject', compact('project', 'totalAmountsReceiptByProject', 'totalAmountsPayrollByProject', 'totalAmountByProject', 'totalAmountAndContractDifference', 'colorStyle', 'projectContract'));
    }

    public function showProjectOwner($id)
    {      
        $project = Project::where('id', $id)->firstOrFail();

        $totalAmountsReceiptByProject = AmountCalculator::calculateTotalAmountsReceiptByProject();
        // Retrieve the total amount for the specific project_id
        $totalAmountReceiptByProject = $totalAmountsReceiptByProject[$project->id] ?? 0;

        $totalAmountsPayrollByProject = AmountCalculator::calculateTotalAmountsPayrollByProject();
        // Retrieve the total amount for the specific project_id
        $totalAmountPayrollByProject = $totalAmountsPayrollByProject[$project->id] ?? 0;

        $totalAmountByProject = $totalAmountReceiptByProject + $totalAmountPayrollByProject;
        $projectContract = $project->contract;

        $totalAmountAndContractDifference = $totalAmountByProject - $projectContract;

        $colorStyle = ($projectContract > $totalAmountByProject) ? 'color: green;' : 'color: red;';
        // Make it negative if $totalAmountByProject is larger

        return view('owner.project', compact('project', 'totalAmountsReceiptByProject', 'totalAmountsPayrollByProject', 'totalAmountByProject', 'totalAmountAndContractDifference', 'colorStyle', 'projectContract'));
    }
    // public function showStaffProject()
    // {
    //     return view('staff.projects');
    // }
    public function showNewProject()
    {
        return view('project.nprojects');
    }

    public function finishProject($id)
    {
        $project = Project::find($id);
    
        if ($project) {
            $project->status = 'old';
            $project->save();
        }
    
        // Redirect to the Old Project page or wherever you want to go
        return redirect()->route('old-projects');
    }

    public function displayOldProject()
    {
        $oldProjects = Project::where('status', 'old')->latest()->paginate(6);

        return view('project.oldprojects', ['oldProjects' => $oldProjects]);
    }

    public function showOldProject($id)
    {
        $oldProject = Project::where('id', $id)->first();

        if (!$oldProject) {
            abort(404); // Or handle the not found case as appropriate for your application
        }
        // Your logic for displaying old projects
        return view('project.showoldproject')->with('oldProject', $oldProject);
    }

    public function addProject()
    {
        return view('project.addprojects');
    }
}
