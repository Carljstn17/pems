<?php

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MachineryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//owner route
Route::get('/owner-login', [AuthController::class, 'showOwnerLoginForm'])
    ->name('owner-login');
Route::post('/owner/login', [AuthController::class, 'ownerLogin']);


//owner auth
Route::middleware(['auth', CheckUserRole::class . ':owner'])->group(function () {
    // Routes accessible only to owners
    Route::get('/owner/dashboard', [DashboardController::class, 'showPanel'])->name('owner.dashboard');
    Route::post('/owner/register', [AuthController::class, 'registerStaff']);
    Route::get('/owner/accounts', [AuthController::class, 'showAdminRegister'])->name('owner.register');
    Route::resource('users', UserController::class);
    Route::delete('/users/soft-delete/{user}', [UserController::class, 'softDelete']);

    Route::get('/owner/estimate/', [EstimateController::class, 'showLatestOwner'])->name('owner.estimate');
    Route::post('/owner/estimate/create', [EstimateController::class, 'storeEstimateOwner'])->name('owner.storeEstimate');
    Route::get('/owner/estimate/show/{group_id}', [EstimateController::class, 'showOwner'])->name('owner.estimateShow');
    Route::get('/owner/estimate/showreject/{group_id}', [EstimateController::class, 'showRejectOwner'])->name('owner.estimateShowReject');
    Route::delete('/estimates/{groupId}/soft-delete', [EstimateController::class, 'softDelete'])->name('estimates.delete');

    Route::get('/owner/tool', [ToolController::class, 'allToolOwner'])->name('owner.tool');
    Route::get('/owner/machinery', [MachineryController::class, 'allMachineryOwner'])->name('owner.machinery');
});




// staff route
Route::get('/staff-login', [AuthController::class, 'showStaffLoginForm'])->name('staff-login');
Route::post('/staff/login', [AuthController::class, 'staffLogin']);

// staff auth
Route::middleware(['auth', CheckUserRole::class . ':staff'])->group(function () {
    // Routes accessible only to staff
    Route::get('/staff/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

    // Route::get('/staff/projects', [ProjectController::class, 'showStaffProject']);
    Route::get('/staff/ongoing-projects', [ProjectController::class, 'showOnProject'])->name('ongoing-projects');
    Route::get('/staff/new-projects', [ProjectController::class, 'showNewProject']);
    Route::get('/finish-project/{id}', [ProjectController::class, 'finishProject'])->name('finish-project');
    Route::get('/staff/old-projects', [ProjectController::class, 'displayOldProject'])->name('old-projects');
    Route::get('/staff/show-old/{oldProject}', [ProjectController::class, 'showOldProject'])->name('show-old');
    Route::get('/staff/add-projects', [ProjectController::class, 'addProject']);
    Route::post('/staff/store', [ProjectController::class, 'store']);
    Route::get('/staff/show/{id}', [ProjectController::class, 'show'])->name('project.showproject');
    Route::get('/search/project', [SearchController::class, 'searchProject'])->name('search');
    Route::get('/search/project/old', [SearchController::class, 'searchOldProject'])->name('search.old');


    Route::get('/staff/payroll', [PayrollController::class, 'showStaffPayroll'])->name('staff.payroll');
    Route::get('/staff/payroll/latest', [PayrollController::class, 'showPayrollLatest'])->name('latest.payroll');
    Route::get('/staff/payroll/new/', [PayrollController::class, 'showPayrollNew'])->name('new.payroll');
    Route::get('/get-advance/{id}', [AdvanceController::class, 'getAdvance']);
    Route::get('/staff/payroll/advance', [PayrollController::class, 'showPayrollAdvance']);
    Route::post('/payroll/advances', [AdvanceController::class, 'storeAdvance']);
    Route::get('/advance/list', [AdvanceController::class, 'advanceList'])->name('advance');
    Route::get('/staff/payroll/on-going', [PayrollController::class, 'showPayrollOngoing'])->name('on.payroll');
    // Route::get('/staff/payroll/show-latest/{id}', [ProjectController::class, 'showLatest'])->name('payroll.');
    // Route::get('/staff/payroll/all-ongoing/{id}', [ProjectController::class, 'showOngoing'])->name('payroll.');

    Route::get('/staff/estimate', [EstimateController::class, 'showStaffEstimate'])->name('staff.estimate');
    Route::get('/staff/estimate/latest', [EstimateController::class, 'showLatestEstimate'])->name('latest');
    Route::get('/staff/estimate/new', [EstimateController::class, 'showNewEstimate']);
    Route::get('/staff/estimate/reject', [EstimateController::class, 'showRejectEstimate'])->name('reject');
    Route::post('/items', [EstimateController::class, 'store'])->name('estimate.store');
    Route::get('/staff/estimate/form/{group_id}', [EstimateController::class, 'show'])->name('estimate.form');
    Route::get('/staff/estimate/reject/{group_id}', [EstimateController::class, 'showOld'])->name('show.reject');
    Route::get('/estiates/edit/{group_id}', [EstimateController::class, 'edit'])->name('estimate.edit');
    Route::patch('/estimates/update/', [EstimateController::class, 'update'])->name('estimate.update');
    Route::delete('/estimates/{groupId}/delete', [EstimateController::class, 'softDeleteForStaff'])->name('estimates.softDelete');
    Route::get('/search/estimate', [SearchController::class, 'searchEstimate'])->name('estimate.search');
    Route::get('/search/reject', [SearchController::class, 'searchRejectEstimate'])->name('search.reject');

    Route::get('/staff/receipt', [ReceiptController::class, 'showStaffReceipt'])->name('latest.receipt');
    Route::get('/staff/receipt/on-going', [ReceiptController::class, 'showReceiptOngoing'])->name('on.receipt');
    Route::get('/staff/receipt/new', [ReceiptController::class, 'showReceiptNew']);
    Route::post('/receipt/create', [ReceiptController::class, 'createEntry'])->name('entry.create');
    Route::get('/receipt/supplier', [SupplierController::class, 'supplierForm'])->name('supplier.form');
    Route::get('/supplier/list', [SupplierController::class, 'supplierList'])->name('supplier');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/receipt/project/{project_id}', [ReceiptController::class, 'projectReceipt'])->name('project.receipt');
    Route::get('/receipt/form/{id}', [ReceiptController::class, 'show'])->name('receipt.form');

    Route::get('/staff/tool', [ToolController::class, 'allTool'])->name('staff.tool');
    Route::post('/store-tools', [ToolController::class, 'store'])->name('store.tools');
    Route::put('/tools/{tool}', [ToolController::class, 'update'])->name('update.tool');

    Route::get('/staff/machinery', [MachineryController::class, 'allMachinery'])->name('staff.machinery');
    Route::post('/store-machinery', [MachineryController::class, 'store'])->name('store.machinery');
    Route::put('/machineries/{machinery}', [MachineryController::class, 'update'])->name('update.machinery');
    Route::get('/staff/machinery/search', [SearchController::class, 'searchMachinery'])->name('machinery.search');
});

// laborer login
Route::get('/laborer-login', [AuthController::class, 'showLaborerLoginForm'])->name('laborer-login');
Route::post('/laborer/login', [AuthController::class, 'laborerLogin']);
// laborer auth
Route::middleware(['auth', CheckUserRole::class . ':laborer'])->group(function () {
    // Routes accessible only to owners
    Route::get('/laborer/profile', [AuthController::class, 'showLaborerPanel']);
});


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
