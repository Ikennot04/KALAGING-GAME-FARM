<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BirdController;


    Route::post('/bird/add', [BirdController::class, 'addBird']);      // Create a new bird
    

