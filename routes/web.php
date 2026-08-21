<?php

use App\Http\Controllers\CleaningRequestController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');
Route::post('requests', [CleaningRequestController::class, 'store'])->name('requests.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [CleaningRequestController::class, 'dashboard'])->name('dashboard');
    Route::delete('requests/{cleaningRequest}', [CleaningRequestController::class, 'destroy'])->name('requests.destroy');
});

require __DIR__.'/settings.php';
