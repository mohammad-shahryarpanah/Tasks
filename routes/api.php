<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/index/tasks', [\App\Http\Controllers\Api\v1\TaskController::class, 'index']);
Route::post('/store/tasks', [\App\Http\Controllers\Api\v1\TaskController::class, 'store']);
Route::put('/update/tasks/{id}', [\App\Http\Controllers\Api\v1\TaskController::class, 'update']);
Route::delete('/delete/tasks/{id}', [\App\Http\Controllers\Api\v1\TaskController::class, 'destroy']);
