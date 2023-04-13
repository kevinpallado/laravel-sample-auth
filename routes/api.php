<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\AuthenticationUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes.
Route::group(['prefix' => 'v1'], function() {
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/login', [AuthenticationController::class, 'login']);
    
    Route::apiResource('deals', PropertyDealsController::class)->middleware(['throttle:30,1'])->only('store');
    // Protected routes
    Route::group(['middleware' => ['auth:sanctum','verify.email']], function(){
        Route::get('auth-user', [AuthenticationUserController::class, 'user']);
        Route::prefix('admin')->group(function () {
            Route::apiResource('users', UsersController::class);
        });
        // all user access
        Route::apiResource('deals', PropertyDealsController::class)->only('index');
        Route::post('logout', [AuthenticationController::class, 'logout']);
    });
    Route::get('account/verify/{token}', [AuthenticationController::class, 'verifyAccount'])->name('user.verify');
});
