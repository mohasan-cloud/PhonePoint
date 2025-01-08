<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ModulesDataController;
use App\Http\Controllers\EmailController;

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

Route::middleware('auth:sanctum')->get('/get-authenticated-user', [AuthController::class, 'getAuthenticatedUser']);

Route::middleware('auth:sanctum')->post('/leads', [ModulesDataController::class, 'index']);
Route::middleware('auth:sanctum')->post('/moduledata_count', [ModulesDataController::class, 'moduledataCount']);
Route::middleware('auth:sanctum')->post('/pielabel_count', [ModulesDataController::class, 'pieLabeldataCount']);
Route::middleware('auth:sanctum')->post('/moduledata_today_count', [ModulesDataController::class, 'moduledatatodayCount']);
Route::middleware('auth:sanctum')->post('/crm/{slug}', [ModulesDataController::class, 'index']);
Route::middleware('auth:sanctum')->post('/attendance/checkout', [ModulesDataController::class, 'checkout']);
Route::middleware('auth:sanctum')->post('/attendance/checkin', [ModulesDataController::class, 'checkin']);
Route::middleware('auth:sanctum')->post('/attendance/checkinout_status', [ModulesDataController::class, 'checkinout_status']);
Route::post('/getmoduledatabyslug/{slug}', [ModulesDataController::class, 'getModuleDataBySlug']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/send-email', [EmailController::class, 'sendEmail']);
