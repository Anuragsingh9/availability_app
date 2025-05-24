<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\PublicAvailabilityController;

Route::prefix('admin')->group(function () {
    Route::get('/availabilities', [AvailabilityController::class, 'index'])->name('admin.availabilities.index');
    Route::get('/availabilities/create', [AvailabilityController::class, 'create'])->name('admin.availabilities.create');
    Route::post('/availabilities', [AvailabilityController::class, 'store'])->name('admin.availabilities.store');
    Route::get('/availabilities/{id}/edit', [AvailabilityController::class, 'edit'])->name('admin.availabilities.edit');
    Route::put('/availabilities/{id}', [AvailabilityController::class, 'update'])->name('admin.availabilities.update');
    Route::delete('/availabilities/{id}', [AvailabilityController::class, 'destroy'])->name('admin.availabilities.destroy');
});

Route::get('/', [PublicAvailabilityController::class, 'index'])->name('availability.index');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
