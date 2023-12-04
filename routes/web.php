<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\AuthController;
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

Route::get('/nav', function () {
    return view('navigation');
});

//owner route
Route::get('/owner-login', [AuthController::class, 'showOwnerLoginForm'])
    ->name('owner-login');
Route::post('/owner/login', [AuthController::class, 'ownerLogin']);


//owner auth
Route::middleware(['auth', CheckUserRole::class . ':admin'])->group(function () {
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
    Route::get('/staff/all-projects', [ProjectController::class, 'showAllProject']);
    Route::get('/staff/add-projects', [ProjectController::class, 'addProject']);
    Route::post('/staff/store', [ProjectController::class, 'store']);
});




Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
