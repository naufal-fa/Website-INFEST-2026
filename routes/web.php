<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InsvidayController;
use App\Http\Controllers\Admin\InsvidayAdminController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\Admin\IncomeAdminController;
use App\Http\Controllers\Admin\InshowAdminController;
use App\Http\Controllers\Admin\InstryAdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        // INSVIDAY
        // Route::get('/insviday/registrations', [InsvidayAdminController::class, 'index'])->name('insviday.index');
        // Route::get('/insviday/registrations/export', [InsvidayAdminController::class, 'export'])->name('insviday.export');

        // INCOME
        // Route::get('/income/registrations',   [IncomeAdminController::class, 'index'])->name('income.index');

        // INSHOW
        // Route::get('/inshow/registrations',   [InshowAdminController::class, 'index'])->name('inshow.index');

        // INSTRY
        // Route::get('/instry/registrations',   [InstryAdminController::class, 'index'])->name('instry.index');
    });

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::prefix('events')->name('events.')->group(function(){
        Route::view('/inshow', 'events.inshow')->name('inshow');

        Route::get('/income', [IncomeController::class, 'show'])->name('income');
        Route::post('/income/register', [IncomeController::class, 'register'])->name('income.register');
        Route::post('/income/abstract', [IncomeController::class, 'submitAbstract'])->name('income.abstract');

        Route::get('/insviday', [InsvidayController::class, 'show'])->name('insviday');
        Route::post('/insviday/apply', [InsvidayController::class, 'apply'])->name('insviday.apply');

        Route::view('/instry',   'events.instry')->name('instry');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
