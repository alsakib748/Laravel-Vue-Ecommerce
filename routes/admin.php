<?php

use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin/index');
})->middleware('admin')->name('admin.dashboard');

Route::middleware(['admin', 'auth'])->group(function () {


    // Additional admin routes can be added here
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');


});