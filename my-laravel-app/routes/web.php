<?php

use App\Http\Controllers\Birds\Web\BirdWebController;
use App\Http\Controllers\Dashboard\Web\DashboardWebController;
use Illuminate\Support\Facades\Route;

Route::get('/birds', [BirdWebController::class, 'index']);
Route::get('/dashboard', [DashboardWebController::class, 'viewDashboard'])->name('dashboard');

// ... existing routes ...

Route::put('/birds/{id}', [BirdWebController::class, 'updateBird'])->name('birds.update');
Route::post('/bird/add', [BirdWebController::class, 'addBird'])->name('birds.add');
