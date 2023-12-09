<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProjectController;

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
    Route::get('/owner/dashboard', [AuthController::class, 'showOwnerPanel']);
    Route::post('/owner/register', [AuthController::class, 'registerStaff']);
    Route::get('/owner/accounts', [AuthController::class, 'showAdminRegister'])->name('owner.register');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/soft-delete/{user}', [UserController::class, 'softDelete']);

    Route::get('/order', [Controller::class, 'showOrder'])->name('order');
});




// staff route
Route::get('/staff-login', [AuthController::class, 'showStaffLoginForm'])->name('staff-login');
Route::post('/staff/login', [AuthController::class, 'staffLogin']);

// staff auth
Route::middleware(['auth', CheckUserRole::class . ':staff'])->group(function () {
    // Routes accessible only to staff
    Route::get('/staff/dashboard', [AuthController::class, 'showStaffPanel']);
    Route::get('/staff/projects', [ProjectController::class, 'showStaffProject']);
    Route::get('/staff/ongoing-projects', [ProjectController::class, 'showOnProject']);
    Route::get('/staff/new-projects', [ProjectController::class, 'showNewProject']);
    Route::get('/finish-project/{id}', [ProjectController::class, 'finishProject'])->name('finish-project');
    Route::get('/staff/old-projects', [ProjectController::class, 'displayOldProject'])->name('old-projects');
    Route::get('/staff/show-old/{oldProject}', [ProjectController::class, 'showOldProject'])->name('show-old');
    Route::get('/staff/add-projects', [ProjectController::class, 'addProject']);
    Route::post('/staff/store', [ProjectController::class, 'store']);
    Route::get('/staff/show/{id}', [ProjectController::class, 'show'])->name('project.showproject');
    Route::get('/search/project', [SearchController::class, 'searchProject'])->name('search');

    Route::get('/staff/payroll', [PayrollController::class, 'showStaffPayroll'])->name('staff.payroll');
    Route::get('/staff/payroll/latest', [PayrollController::class, 'showPayrollLatest']);
    Route::get('/staff/payroll/new', [PayrollController::class, 'showPayrollNew']);
    Route::get('/staff/payroll/on-going', [PayrollController::class, 'showPayrollOngoing']);
    // Route::get('/staff/payroll/show-latest/{id}', [ProjectController::class, 'showLatest'])->name('payroll.');
    // Route::get('/staff/payroll/all-ongoing/{id}', [ProjectController::class, 'showOngoing'])->name('payroll.');
});




Route::get('/logout', [AuthController::class, 'logout'])->name('logout');