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
use App\Http\Controllers\ConcernController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CombinedController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MachineryController;
use App\Http\Controllers\AdvanceRequestController;
use App\Models\AdvanceRequest;

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

Route::get('/notifications', 'NotificationController@index');

//owner route
Route::get('/owner-login', [AuthController::class, 'showOwnerLoginForm'])
    ->name('owner-login');
Route::post('/owner/login', [AuthController::class, 'ownerLogin']);

Route::put('update-receipt-remarks/{receiptId}', [ReceiptController::class, 'updateReceiptRemarks'])->name('updateReceiptRemarks');

//owner auth
Route::middleware(['auth', CheckUserRole::class . ':owner'])->group(function () {
    // Routes accessible only to owners
    Route::get('/owner/dashboard', [DashboardController::class, 'showPanel'])->name('owner.dashboard');
    Route::post('/owner/register', [AuthController::class, 'registerStaff']);
    Route::get('/owner/accounts', [AuthController::class, 'showAdminRegister'])->name('owner.register');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/soft-delete/{user}', [UserController::class, 'softDelete'])->name('owner.user-delete');

    Route::get('/owner/show/{id}', [ProjectController::class, 'showProjectOwner'])->name('owner.showproject');

    Route::get('/owner/estimate/', [EstimateController::class, 'showLatestOwner'])->name('owner.estimate');
    Route::post('/owner/estimate/create', [EstimateController::class, 'storeEstimateOwner'])->name('owner.storeEstimate');
    Route::get('/owner/estimate/show/{group_id}', [EstimateController::class, 'showOwner'])->name('owner.estimateShow');
    Route::get('/owner/estimate/reject', [EstimateController::class, 'rejectEstimate'])->name('owner.estimateReject');
    Route::get('/owner/estimate/showreject/{group_id}', [EstimateController::class, 'showRejectOwner'])->name('owner.estimateShowReject');
    Route::put('/estimates/{group_id}/reject', [EstimateController::class, 'reject'])->name('owner.reject');
    Route::put('/estimates/{group_id}/accept', [EstimateController::class, 'accept'])->name('owner.accept');

    Route::get('/owner/payroll/latest', [PayrollController::class, 'ownerPayrollLatest'])->name('owner.payroll');
    Route::get('/owner/payroll/show-latest/{batchId}', [PayrollController::class, 'showOwnerPayroll'])->name('owner.showPayroll');
    Route::put('/update-batch-remarks/{batchId}', [PayrollController::class, 'ownerBatchRemarks'])->name('ownerBatchRemarks');

    Route::get('/owner/tool', [ToolController::class, 'allToolOwner'])->name('owner.tool');
    Route::get('/owner/tool/report', [ToolController::class, 'toolLogs'])->name('owner.toolLogs');
    Route::get('/owner/machinery', [MachineryController::class, 'allMachineryOwner'])->name('owner.machinery');
    Route::get('/owner/machinery/report', [MachineryController::class, 'machineryLogs'])->name('owner.machineryLogs');

    Route::get('/owner/receipt', [ReceiptController::class, 'showOwnerReceipt'])->name('owner.receipt');
    Route::get('/owner/receipt/{id}', [ReceiptController::class, 'showForOwner'])->name('owner.showReceipt');
    Route::get('/owner/supplier/list', [SupplierController::class, 'ownerSupplierList'])->name('owner.supplier');
    Route::get('/owner/receipt/project/{project_id}', [ReceiptController::class, 'ownerProjectReceipt'])->name('owner.projectReceipt');
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
    Route::post('/staff/payroll/store/', [PayrollController::class, 'storePayroll'])->name('store.payroll');
    Route::get('/get-advance/{id}', [AdvanceController::class, 'getAdvance']);
    Route::get('/staff/payroll/advance', [PayrollController::class, 'showPayrollAdvance']);
    Route::post('/payroll/advances', [AdvanceController::class, 'storeAdvance']);
    Route::get('/advance/list', [AdvanceController::class, 'advanceList'])->name('advance');
    Route::get('/staff/payroll/on-going', [PayrollController::class, 'showPayrollOngoing'])->name('on.payroll');
    Route::get('/staff/payroll/show-latest/{batchId}', [PayrollController::class, 'showPayroll'])->name('show.payroll');
    Route::get('/payroll/project/{project_id}', [PayrollController::class, 'projectPayroll'])->name('project.payroll');
    Route::put('/staff/update-batch-remarks/{batchId}', [PayrollController::class, 'updateBatchRemarks'])->name('staff.updateBatchRemarks');

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

    Route::get('/staff/laborer', [AuthController::class, 'showStaffLaborer'])->name('staff.laborer');
    Route::post('/staff/register', [AuthController::class, 'registerLaborer'])->name('staff.register');
    Route::put('/staff/{user}', [UserController::class, 'updateLaborer'])->name('staff.editLaborer');
    Route::delete('/staff/laborer-soft-delete/{user}', [UserController::class, 'softDeleteLaborer'])->name('staff.laborer-soft-delete');

    Route::get('/advance/req-notif/{id}', [AdvanceRequestController::class, 'show'])->name('request.notif');
    Route::get('/advance-req/all-notif', [AdvanceRequestController::class, 'allRequest'])->name('request.allNotif');

    Route::get('/concern/notif/{id}', [ConcernController::class, 'show'])->name('concern.notif');
    Route::get('/concern/all-notif', [ConcernController::class, 'allConcern'])->name('concern.allNotif');
    Route::get('/concerns/{id}/confirm-accept', [ConcernController::class, 'confirmAccept'])->name('concerns.confirm.accept');

    Route::get('export-estimates/{group_id}', [EstimateController::class, 'export'])->name('export-estimates');
    Route::get('/payroll/export/{batchId}', [PayrollController::class, 'export'])->name('payroll.export');

});

// laborer login
Route::get('/laborer-login', [AuthController::class, 'showLaborerLoginForm'])->name('laborer-login');
Route::post('/laborer/login', [AuthController::class, 'laborerLogin']);
// laborer auth
Route::middleware(['auth', CheckUserRole::class . ':laborer'])->group(function () {
    // Routes accessible only to owners
    Route::get('/laborer/dashboard', [AuthController::class, 'showLaborerPanel'])->name('laborer.dashboard');
    Route::get('/laborer/profile', [AuthController::class, 'showLaborerInfo'])->name('laborer.profile');
    Route::put('/update-info/{user}', [UserController::class, 'updateInfo'])->name('laborer.updateInfo');
    Route::get('/laborer/payroll', [PayrollController::class, 'laborerPayroll'])->name('laborer.payroll');
    Route::get('/laborer/payroll/show/{payrollId}', [PayrollController::class, 'laborerShowPayroll'])->name('laborer.showPayroll');
    Route::get('/laborer/advance-list', [AdvanceController::class, 'laborerAdvanceList'])->name('laborer.advanceList');
    Route::get('/laborer/advance-req', [AdvanceRequestController::class, 'viewRequestForm'])->name('laborer.advanceReq');
    Route::post('/submit/advance-req', [AdvanceRequestController::class, 'store'])->name('form.submitReq');
    Route::get('/laborer/concern', [ConcernController::class, 'viewConcernForm'])->name('laborer.concern');
    Route::post('/submit/concern', [ConcernController::class, 'store'])->name('form.submitConcern');
    Route::get('/advance-request-count', [AdvanceRequestController::class, 'getNotificationCount'])->name('notification.count.advance');
    Route::get('/notification-count-concern', [ConcernController::class, 'getNotificationCount'])->name('notification.count.concern');
});


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
