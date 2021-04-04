<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlmightyController;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    //admin

    Route::post('/adminlogin', [AdminController::class, 'login']);
    Route::post('/adminlogout', [AdminController::class, 'logout']);
    Route::post('/dentistregister', [AdminController::class, 'register']);
    Route::post('/adminregister', [AdminController::class, 'registerAdmin']);
    Route::get('/search/{name}', [AdminController::class, 'search']);
    Route::post('/diagnosis', [AdminController::class, 'diagnosis']);
    Route::get('/viewPatient', [AdminController::class, 'viewPatient']);
    Route::post('/createUser', [AdminController::class, 'storeUser']);
    Route::get('/view2', [AdminController::class, 'patientMedicalHistory']);
    Route::put('/updateUser/{id}', [AdminController::class, 'updatePatient']);
    Route::get('/tooth/{id}', [AdminController::class, 'searchID']);
    //user
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    //TEST ROUTE

    Route::get('/getCon', [AuthController::class, 'findCon']);
    Route::get('/getDiag', [AuthController::class, 'findDiag']);
    Route::post('/refreshToken', [AuthController::class, 'refresh']);
});


Route::get('/admin-profile', [AdminController::class, 'userProfile']);

