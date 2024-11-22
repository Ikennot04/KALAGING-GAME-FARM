<?php

use App\Http\Controllers\Birds\Web\BirdWebController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [BirdWebController::class, 'index']);
