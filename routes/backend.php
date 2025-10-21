<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin/index');
})->middleware('admin')->name('admin.dashboard');