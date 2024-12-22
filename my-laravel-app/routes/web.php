<?php

use App\Http\Controllers\Birds\Web\BirdWebController;
use App\Http\Controllers\Dashboard\Web\DashboardWebController;
use App\Http\Controllers\Workers\Web\WorkerWebController;
use App\Http\Controllers\Auth\Web\LoginWebController;
use App\Http\Controllers\Admin\Web\AdminWebController;
use App\Http\Controllers\Settings\SettingsController;
use Illuminate\Support\Facades\Route;   
use App\Application\Enums\UserRole;

// Redirect root to login if not authenticated
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginWebController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [LoginWebController::class, 'login'])->name('admin.login.submit');
});

// Protected routes
Route::middleware(['auth', \App\Http\Middleware\AdminAuthenticate::class])->group(function () {
    // Dashboard routes
    Route::get('/home', [DashboardWebController::class, 'home'])->name('home');
    Route::get('/dashboard', [DashboardWebController::class, 'home'])->name('dashboard');
    
    // Worker routes
    Route::get('/workers', [WorkerWebController::class, 'index'])->name('workers.index');
    Route::post('/workers/add', [WorkerWebController::class, 'addWorker'])->name('workers.add');
    Route::get('/workers/archive', [WorkerWebController::class, 'viewArchive'])->name('workers.archive');
    Route::put('/workers/{id}', [WorkerWebController::class, 'updateWorker'])->name('workers.update');
    Route::delete('/workers/{id}', [WorkerWebController::class, 'softDeleteWorker'])->name('workers.delete');
    Route::post('/workers/{id}/restore', [WorkerWebController::class, 'restoreWorker'])->name('workers.restore');
    Route::get('/handler-stats', [WorkerWebController::class, 'showHandlerStats'])->name('handler.stats');
    
    // Bird routes
    Route::get('/birds', [BirdWebController::class, 'viewBirdPage'])->name('birds.index');
    Route::post('/birds/add', [BirdWebController::class, 'addBird'])->name('birds.add');
    Route::put('/birds/{id}', [BirdWebController::class, 'updateBird'])->name('birds.update');
    Route::delete('/birds/{id}', [BirdWebController::class, 'softDeleteBird'])->name('birds.delete');
    Route::get('/birds/archive', [BirdWebController::class, 'viewArchive'])->name('birds.archive');
    Route::post('/birds/{id}/restore', [BirdWebController::class, 'restoreBird'])->name('birds.restore');
    
    // Account management routes
    Route::get('/admin/accounts', [LoginWebController::class, 'showAccounts'])->name('admin.accounts');
    Route::post('/admin/register', [LoginWebController::class, 'register'])->name('admin.register');
    Route::get('/admin/register', [LoginWebController::class, 'showRegisterForm'])->name('admin.register.form');
    Route::post('/admin/logout', [LoginWebController::class, 'logout'])->name('admin.logout');
    
    // Settings routes
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
    
    // User management routes
    Route::put('/admin/users/{id}', [LoginWebController::class, 'updateUser'])->name('admin.users.update');
});

// Keep your existing debug routes at the bottom
Route::get('/debug/storage/{filename}', function ($filename) {
    $path = storage_path('app/public/images/' . $filename);
    return [
        'exists' => file_exists($path),
        'path' => $path,
        'permissions' => decoct(fileperms($path) & 0777),
        'readable' => is_readable($path)
    ];
});

Route::get('storage/images/{filename}', function ($filename) {
    $path = storage_path('app/public/images/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    $file = file_get_contents($path);
    $type = mime_content_type($path);
    
    return response($file)
        ->header('Content-Type', $type)
        ->header('Access-Control-Allow-Origin', 'http://localhost:52622')
        ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept')
        ->header('Access-Control-Allow-Credentials', 'true')
        ->header('Vary', 'Origin');
});

