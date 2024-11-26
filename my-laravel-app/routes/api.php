<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Birds\API\BirdApiController;
use App\Http\Controllers\Workers\API\WorkerApiController;
use Illuminate\Support\Facades\Route;

Route::post('/bird/add', [BirdApiController::class, 'addBird']);
Route::get('/birds', [BirdApiController::class, 'getAll']);
Route::get('/birds/search', [BirdApiController::class, 'search']);
Route::put('/birds/update/{id}', [BirdApiController::class, 'updateBird']);

Route::post('/worker/add', [WorkerApiController::class, 'addWorker']);
Route::get('/workers', [WorkerApiController::class, 'getAll']);
Route::get('/workers/search', [WorkerApiController::class, 'search']);
Route::put('/workers/update/{id}', [WorkerApiController::class, 'updateWorker']);


