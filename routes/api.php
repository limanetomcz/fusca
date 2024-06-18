<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logs', [LogController::class, 'store']);
Route::middleware('auth:sanctum')->get('/logs', [LogController::class, 'getLog']);
