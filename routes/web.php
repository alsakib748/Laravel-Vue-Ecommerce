<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::get('/', function () {
    return view('admin/index');
});

Route::get('/createRole', function () {

    $role = new App\Models\Role();
    $role->name = 'Customer';
    $role->slug = 'customer';
    $role->save();

});

Route::get('/createAdmin', [AuthController::class, 'createAdmin']);