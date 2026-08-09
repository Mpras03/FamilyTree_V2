<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FamilyTreeController;
use App\Http\Controllers\Admin\PersonController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('persons', PersonController::class)->except(['show']);
    Route::get('/silsilah', [FamilyTreeController::class, 'index'])->name('family-tree');
});
