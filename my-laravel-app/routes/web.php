<?php

use App\Http\Controllers\Birds\Web\BirdWebController;
use App\Http\Controllers\Dashboard\Web\DashboardWebController;
use App\Http\Controllers\Workers\Web\WorkerWebController;
use Illuminate\Support\Facades\Route;

Route::get('/birds', [BirdWebController::class, 'index']);
Route::get('/dashboard', [DashboardWebController::class, 'viewDashboard'])->name('dashboard');

// ... existing routes ...

Route::put('/birds/{id}', [BirdWebController::class, 'updateBird'])->name('birds.update');
Route::post('/bird/add', [BirdWebController::class, 'addBird'])->name('birds.add');
Route::get('/birds/search', [BirdWebController::class, 'search'])->name('birds.search');

Route::get('/workers', [WorkerWebController::class, 'showWorkerPage'])->name('workers.show');
Route::post('/worker/add', [WorkerWebController::class, 'addWorker'])->name('workers.add');
Route::put('/workers/{id}', [WorkerWebController::class, 'updateWorker'])->name('workers.update');
Route::get('/workers/search', [WorkerWebController::class, 'search'])->name('workers.search');