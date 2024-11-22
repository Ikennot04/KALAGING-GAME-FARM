<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Birds\API\BirdApiController;
use Illuminate\Support\Facades\Route;

Route::post('/bird/add', [BirdApiController::class, 'addBird']);
Route::get('/birds', [BirdApiController::class, 'getAll']);
Route::get('/birds/search', [BirdApiController::class, 'search']);


