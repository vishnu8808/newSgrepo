<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CommisionController;
use Illuminate\Support\Facades\Route;

/**Route::get('/', function () {
    return view('welcome');
    
});**/


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/users/list', [HomeController::class, 'getUsers'])->name('users.list');
    Route::get('/users/add', [HomeController::class, 'add'])->name('users.add');
    Route::post('/users/save', [HomeController::class, 'store'])->name('users.save');
    Route::get('/users/view/{id}', [HomeController::class, 'view'])->name('users.view');

    Route::get('/sales/list', [SalesController::class, 'getList'])->name('sales.list');
    Route::post('/sales/store', [SalesController::class, 'store'])->name('sales.save');
   
    Route::get('/commision/view', [CommisionController::class, 'view'])->name('com.view');
    Route::get('/commision/list', [CommisionController::class, 'getList'])->name('com.list');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
