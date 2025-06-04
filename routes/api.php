<?php

use App\Http\Controllers\Admin\PatientsController;
use App\Http\Controllers\Admin\ReceptionistsController;
use App\Http\Controllers\Admin\SpecialtiesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function(){
    Route::post(('/logout'), [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // User routes (trừ store)
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    // Doctor routes
    Route::prefix('doctors')->group(function () {
        // Khai báo trước route động /{$id}
        Route::get('/', [DoctorController::class, 'index']);
        Route::get('/available-users', [DoctorController::class, 'getAvailableUsers']);
        // Khai báo sau
        Route::get('/{id}', [DoctorController::class, 'show']); 
        Route::put('/{id}', [DoctorController::class, 'update']); 
        Route::delete('/{id}', [DoctorController::class, 'destroy']);
        
    });

    // Receptionist routes
    Route::prefix('receptionists')->group(function () {
        // Khai báo trước route động /{$id}
        Route::get('/', [ReceptionistsController::class, 'index']);
        Route::get('/available-users', [ReceptionistsController::class, 'getAvailableUsers']);
        // Khai báo sau
        Route::get('/{id}', [ReceptionistsController::class, 'show']); 
        Route::put('/{id}', [ReceptionistsController::class, 'update']); 
        Route::delete('/{id}', [ReceptionistsController::class, 'destroy']);
        
    });

    // Receptionist routes
    Route::prefix('patients')->group(function () {
        // Khai báo trước route động /{$id}
        Route::get('/', [PatientsController::class, 'index']);
        Route::get('/available-users', [PatientsController::class, 'getAvailableUsers']);
        // Khai báo sau
        Route::get('/{id}', [PatientsController::class, 'show']); 
        Route::put('/{id}', [PatientsController::class, 'update']); 
        Route::delete('/{id}', [PatientsController::class, 'destroy']);
        
    });

    // Receptionist routes
    Route::prefix('specialties')->group(function () {
        Route::get('/', [SpecialtiesController::class, 'index']);
        Route::get('/{id}', [SpecialtiesController::class, 'show']); 
        Route::put('/{id}', [SpecialtiesController::class, 'update']); 
        Route::delete('/{id}', [SpecialtiesController::class, 'destroy']);
    });
});
// Route::get('/doctors/available-users', [DoctorController::class, 'getAvailableUsers']);

// Route store không cần xác thực
Route::post('/users', [UserController::class, 'store']);
Route::post('/doctors', [DoctorController::class, 'store']);
Route::post('/receptionists', [ReceptionistsController::class, 'store']);
Route::post('/patients', [PatientsController::class, 'store']);
Route::post('/specialties', [SpecialtiesController::class, 'store']);

