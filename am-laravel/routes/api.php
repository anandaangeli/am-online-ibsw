<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\BudgetRequestApiController;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'AM Online Laravel API',
        'time' => now()->toIso8601String()
    ]);
});

Route::post('/login', [AuthController::class, 'apiLogin']);

// API Dokumen (Budget Request & Cash Advance) untuk testing di Postman
Route::get('/budget-requests', [BudgetRequestApiController::class, 'index']);
Route::get('/budget-requests/{id}', [BudgetRequestApiController::class, 'show']);
Route::post('/budget-requests', [BudgetRequestApiController::class, 'store']);
Route::patch('/budget-requests/{id}/status', [BudgetRequestApiController::class, 'updateStatus']);
Route::delete('/budget-requests/{id}', [BudgetRequestApiController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
