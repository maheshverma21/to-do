<?php

use App\Http\Controllers\TaskController;

Route::get('/',               [TaskController::class, 'index']);
Route::get ('/tasks/all',     [TaskController::class, 'all']);
Route::post('/tasks',         [TaskController::class, 'store']);
Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggle']);
Route::delete('/tasks/{task}',       [TaskController::class, 'destroy']);


