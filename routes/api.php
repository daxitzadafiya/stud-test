<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('courses', CourseController::class);
Route::apiResource('students', StudentController::class);

Route::controller(AuthController::class)->prefix('auth')->middleware('api')->group(
    function () {
        Route::post('/register',  'register');
        Route::post('/login',  'login');
        Route::get('/logout',  'logout');
        Route::get('/refresh',  'refresh');
        Route::get('/profile',  'profile');
    }
);
