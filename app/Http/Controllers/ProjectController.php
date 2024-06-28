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
            "client"=> 'required|max:150',
            "contract"=> 'required|integer|max:999999999',
            "location"=> 'required|max:255',
            "date_started" => 'required|date',
            "contact" => 'required|string|min:7|max:15',
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
        return redirect('/staff/ongoing-projects')->with('success', 'Employee registered successfully.')->withInput();
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

    public function projectListOwner()
    {      
        $projects = Project::where('status', 'new')->latest()->paginate(10);
        
        return view('owner.project', compact('projects'));
    }
    
    public function showProjectOwner($id)
    {
        $project = Project::where('id', $id)->firstOrFail();
        
        $pendingCount = $project->payrollBatches()->where('status', 'pending')->count();
        $invalidCount = $project->payrollBatches()->where('status', 'invalid')->count();
        $validCount = $project->payrollBatches()->where('status', 'valid')->count();
        
        $invalidReceiptCount = $project->receipts()->where('remarks', 'invalid')->count();
        $validReceiptCount = $project->receipts()->where('remarks', 'valid')->count();
        
        return view('owner.projectShow', compact('project', 'invalidCount', 'validCount', 'pendingCount','invalidReceiptCount', 'validReceiptCount'));
    }
    
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
    
    public function analytics()
    {
        $projects = Project::with('payrollBatches', 'receipts')->get();
        
        $data = [];
    
        foreach ($projects as $project) {
            $dailyData = $project->payrollBatches()
                                 ->where('status', 'valid')
                                 ->selectRaw('DATE(created_at) as date, SUM(total_salary) as total_salary')
                                 ->groupBy('date')
                                 ->get()
                                 ->pluck('total_salary', 'date');
    
            $weeklyData = $project->payrollBatches()
                                  ->where('status', 'valid')
                                  ->selectRaw('YEARWEEK(created_at) as week, SUM(total_salary) as total_salary')
                                  ->groupBy('week')
                                  ->get()
                                  ->pluck('total_salary', 'week');
    
            $monthlyData = $project->payrollBatches()
                                   ->where('status', 'valid')
                                   ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_salary) as total_salary')
                                   ->groupBy('month')
                                   ->get()
                                   ->pluck('total_salary', 'month');
    
            $dailyReceipts = $project->receipts()
                                     ->selectRaw('DATE(created_at) as date, SUM(amount) as total_amount')
                                     ->groupBy('date')
                                     ->get()
                                     ->pluck('total_amount', 'date');
    
            $weeklyReceipts = $project->receipts()
                                      ->selectRaw('YEARWEEK(created_at) as week, SUM(amount) as total_amount')
                                      ->groupBy('week')
                                      ->get()
                                      ->pluck('total_amount', 'week');
    
            $monthlyReceipts = $project->receipts()
                                       ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as total_amount')
                                       ->groupBy('month')
                                       ->get()
                                       ->pluck('total_amount', 'month');
    
            $data[] = [
                'project_name' => $project->project_dsc,
                'daily' => [
                    'total_salary' => $dailyData,
                    'total_amount' => $dailyReceipts,
                ],
                'weekly' => [
                    'total_salary' => $weeklyData,
                    'total_amount' => $weeklyReceipts,
                ],
                'monthly' => [
                    'total_salary' => $monthlyData,
                    'total_amount' => $monthlyReceipts,
                ],
            ];
        }
    
        return response()->json(['data' => $data]);
    }

}
