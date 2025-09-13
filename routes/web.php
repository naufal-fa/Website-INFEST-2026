<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::prefix('events')->name('events.')->group(function(){
        Route::view('/inshow', 'events.inshow')->name('inshow');

        Route::get('/income', [IncomeController::class, 'show'])->name('income');
        Route::post('/income/register', [IncomeController::class, 'register'])->name('income.register');
        Route::post('/income/abstract', [IncomeController::class, 'submitAbstract'])->name('income.abstract');

        Route::view('/invisday', 'events.invisday')->name('invisday');
        Route::view('/instry',   'events.instry')->name('instry');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
