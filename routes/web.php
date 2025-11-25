<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Mahasiswa\AspirationController;
use App\Http\Controllers\Mahasiswa\ResponseController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminAspirationController;
use App\Http\Controllers\Admin\AdminResponseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\PublicAspirationController;
use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Aspiration;

// Public Routes
Route::get('/', function () {
    $stats = [
        'total'      => Aspiration::count(),
        'in_progress'=> Aspiration::whereIn('status', ['submitted','under_review','in_progress'])->count(),
        'completed'  => Aspiration::where('status', 'completed')->count(),
    ];

    return view('landing', compact('stats'));
})->name('landing');

Route::get('/public-aspirations', [PublicAspirationController::class, 'index'])->name('public.aspirations');
Route::get('/public-aspirations/{aspiration}', [PublicAspirationController::class, 'show'])->name('public.aspirations.show');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Mahasiswa Routes
Route::middleware(['auth'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', function () {
        $aspirations = auth()->user()->aspirations()->latest()->take(5)->get();
        return view('mahasiswa.dashboard', compact('aspirations'));
    })->name('dashboard');
    
    Route::resource('aspirations', AspirationController::class);
    Route::post('aspirations/{aspiration}/responses', [ResponseController::class, 'store'])->name('responses.store');
    Route::delete('responses/{response}', [ResponseController::class, 'destroy'])->name('responses.destroy');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/aspirations', [AdminAspirationController::class, 'index'])->name('aspirations.index');
    Route::get('/aspirations/{aspiration}', [AdminAspirationController::class, 'show'])->name('aspirations.show');
    Route::put('/aspirations/{aspiration}/status', [AdminAspirationController::class, 'updateStatus'])->name('aspirations.status');
    
    Route::post('aspirations/{aspiration}/responses', [AdminResponseController::class, 'store'])->name('responses.store');
    
    Route::resource('categories', CategoryController::class);

    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
});
