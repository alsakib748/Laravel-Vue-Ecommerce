<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\auth\authController;


// Route::get('/', function () {
//     return view('admin/index');
// });

Route::get('/login', function () {
    return view('auth/signin');
});

Route::post('/login_user', [AuthController::class, 'loginUser'])->name('login.user');

Route::get('/createRole', function () {

    $role = new App\Models\Role();
    $role->name = 'Customer';
    $role->slug = 'customer';
    $role->save();

});

Route::get('/createAdmin', [AuthController::class, 'createAdmin']);