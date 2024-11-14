<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::prefix('profiles')->group(function () {
    Route::get('/', [ProfileController::class, 'index']);

    Route::post('', [ProfileController::class, 'store'])->middleware('auth:sanctum');
    Route::post('{id}', [ProfileController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('{id}', [ProfileController::class, 'delete'])->middleware('auth:sanctum');
});
