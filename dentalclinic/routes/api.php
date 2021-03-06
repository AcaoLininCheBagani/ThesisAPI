<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {
//     Route::post('/login', [UserController::class, 'login']);
//     Route::post('/adminregister', [UserController::class, 'adminregister']);
//     Route::post('/logout', [UserController::class, 'logout']);
//     Route::post('/refresh', [UserController::class, 'refresh']);
//     Route::get('/admin-profile', [UserController::class, 'userProfile']);

// });

//Route::post('login', [AuthController::class, 'userlogin']);
// Route::post('/userlogin', [AuthController::class, 'userlogin']);
// Route::post('login', [ 'as' => 'login', 'uses' => 'AuthController@userlogin']);
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    //admin
    Route::get('/admin-profile', [AdminController::class, 'userProfile']);
    Route::post('/adminlogin', [AdminController::class, 'login']);
    Route::post('/adminlogout', [AdminController::class, 'logout']);
    Route::post('/adminregister', [AdminController::class, 'register']);

    //user
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
