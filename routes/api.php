<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:api');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('throttle:login_limit'); // <--- Cuma boleh 5x per menit

Route::middleware(['auth:api', 'throttle:api'])->group(function () {
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/todos', [TodoController::class, 'index']);      
    Route::post('/todos', [TodoController::class, 'store']);     
    Route::put('/todos/{id}', [TodoController::class, 'update']); 
    Route::delete('/todos/{id}', [TodoController::class, 'destroy']); 
});