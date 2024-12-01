<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Birds\API\BirdApiController;
use App\Http\Controllers\Workers\API\WorkerApiController;
use App\Http\Controllers\Dashboard\API\DashboardApiController;

use Illuminate\Support\Facades\Route;

Route::post('/bird/add', [BirdApiController::class, 'addBird']);

Route::get('/birds', [BirdApiController::class, 'getAll']);

Route::get('/birds/search', [BirdApiController::class, 'search']);

Route::put('/birds/update/{id}', [BirdApiController::class, 'updateBird']);

Route::get('/birds/count', [DashboardApiController::class, 'getBirdCount']);

Route::get('/birds/{id}', [BirdApiController::class, 'getBirdById']);

Route::post('/worker/add', [WorkerApiController::class, 'addWorker']);
Route::get('/workers', [WorkerApiController::class, 'getAll']);
Route::get('/workers/search', [WorkerApiController::class, 'search']);
Route::put('/workers/update/{id}', [WorkerApiController::class, 'updateWorker']);
Route::get('/workers/count', [DashboardApiController::class, 'getWorkerCount']);
Route::get('/dashboard/stats', [DashboardApiController::class, 'getDashboardStats']);
Route::get('/workers/{id}', [WorkerApiController::class, 'getWorkerById']);