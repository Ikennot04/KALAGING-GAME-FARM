<?php

use App\Http\Controllers\Birds\Web\BirdWebController;
use App\Http\Controllers\Dashboard\Web\DashboardWebController;
use App\Http\Controllers\Dashboard\API\DashboardApiController;
use App\Http\Controllers\Workers\Web\WorkerWebController;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', [DashboardWebController::class, 'home'])->name('home');

// Birds routes
Route::get('/birds', [BirdWebController::class, 'viewBirdPage'])->name('birds.index');


Route::get('/dashboard', [DashboardWebController::class, 'viewDashboard'])->name('dashboard');
Route::put('/birds/{id}', [BirdWebController::class, 'updateBird'])->name('birds.update');
Route::post('/bird/add', [BirdWebController::class, 'addBird'])->name('birds.add');
Route::get('/birds/search', [BirdWebController::class, 'search'])->name('birds.search');
Route::get('/birds/count', [DashboardWebController::class, 'getBirdCount'])->name('birds.count');

// Archive routes
Route::get('/birds/archive', [BirdWebController::class, 'viewArchive'])->name('birds.archive');
Route::post('/birds/{id}/restore', [BirdWebController::class, 'restoreBird'])->name('birds.restore');
Route::delete('/birds/{id}', [BirdWebController::class, 'softDeleteBird'])->name('birds.delete');

// Workers routes
Route::get('/workers', [WorkerWebController::class, 'showWorkerPage'])->name('workers.index');
Route::post('/worker/add', [WorkerWebController::class, 'addWorker'])->name('workers.add');
Route::put('/workers/{id}', [WorkerWebController::class, 'updateWorker'])->name('workers.update');
Route::get('/workers/search', [WorkerWebController::class, 'search'])->name('workers.search');
Route::get('/workers/count', [DashboardWebController::class, 'getWorkerCount'])->name('workers.count');
Route::get('/dashboard/stats', [DashboardWebController::class, 'getDashboardStats'])->name('dashboard.stats');

// Worker Archive routes
Route::get('/workers/archive', [WorkerWebController::class, 'viewArchive'])->name('workers.archive');
Route::post('/workers/{id}/restore', [WorkerWebController::class, 'restoreWorker'])->name('workers.restore');
Route::delete('/workers/{id}', [WorkerWebController::class, 'softDeleteWorker'])->name('workers.delete');