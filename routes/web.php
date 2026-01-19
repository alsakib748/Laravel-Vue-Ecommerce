<?php

use App\Http\Controllers\Front\HomePageController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\auth\authController;


Route::get('/', function () {
    // return view('admin/index');
    return view('index');
});


Route::get('/login', function () {
    return view('auth/signin');
});

Route::get('/apiDocs', function () {
    return view('apiDocs');
});

Route::post('/login_user', [AuthController::class, 'loginUser'])->name('login.user');

Route::post('/changeSlug', [HomePageController::class, 'changeSlug'])->name('change.slug');

Route::get('/createRole', function () {
    $role = new App\Models\Role();
    $role->name = 'Customer';
    $role->slug = 'customer';
    $role->save();
});

Route::get('/createAdmin', [AuthController::class, 'createAdmin']);

Route::get('/{vue_capture?}', function () {
    return view('index');
})->where('vue_capture', '[\/\w\.-]*');
