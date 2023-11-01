<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShowroomController;
use App\http\Controllers\api\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('showrooms', ShowroomController::class);
    Route::get('/logout',[UserController::class,'logout']);
});

//http://localhost:8000/api/resgister 
Route::post('/register',[UserController::class,'register']);
//http://localhost:8000/api/login
Route::post('/login',[UserController::class,'login']);
