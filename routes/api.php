<?php

use App\Http\Controllers\Front\HomePageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::post('/register', [AuthController::class, 'register'])->name('register.user');

Route::post('/login', [AuthController::class, 'loginUser'])->name('login.user');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/showUser', [AuthController::class, 'userShow'])->name('user.show');
// });


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/showUser', [AuthController::class, 'userShow'])->name('user.show');

    Route::post('/updateUser', [AuthController::class, 'updateUser'])->name('update.user');

    Route::post('/logoutUser', [AuthController::class, 'logout'])->name('logout.user');

});

// todo: Home Page Data Routes
Route::get('/getHomeData', [HomePageController::class, 'getHomeData']);

Route::get('/getHeaderCategoriesData', [HomePageController::class, 'getHeaderCategoriesData']);

// Route::get('/getCategoryData/{slug?}', [HomePageController::class, 'getCategoryData']);


Route::post('/getCategoryData', [HomePageController::class, 'getCategoryData']);

Route::post('/getUserData', [HomePageController::class, 'getUserData']);