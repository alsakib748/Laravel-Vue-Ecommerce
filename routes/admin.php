<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SizeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\HomeBannerController;

Route::get('/dashboard', function () {
    return view('admin/index');
})->middleware('admin')->name('admin.dashboard');

Route::middleware(['admin', 'auth'])->group(function () {

    // Additional admin routes can be added here
    // todo: Profile Section
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/save/profile', [ProfileController::class, 'store'])->name('save.profile');

    // todo: Home Banner
    Route::get('/home_banner', [HomeBannerController::class, 'index']);
    Route::post('/updateHomeBanner', [HomeBannerController::class, 'store'])->name('homebanner.store');

    // todo: Size
    Route::get('/manage_size', [SizeController::class, 'index']);
    Route::post('/updateSize', [SizeController::class, 'store'])->name('size.store');

    // todo: Color
    Route::get('/manage_color', [ColorController::class, 'index']);
    Route::post('/updateColor', [ColorController::class, 'store'])->name('color.store');

    // todo: Attributes
    Route::get('/attribute-name', [AttributeController::class, 'index_attribute_name'])->name('attribute.name');
    Route::post('/update-attribute-name', [AttributeController::class, 'store_attribute_name'])->name('attribute.name.store');

    // todo: Attribute Value
    Route::get('/attribute-value', [AttributeController::class, 'index_attribute_value'])->name('attribute.value');
    Route::post('/update-attribute-value', [AttributeController::class, 'store_attribute_value'])->name('attribute.value.store');

    // todo: Category
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');

    Route::get('/deleteData/{id?}/{table?}', [DashboardController::class, 'deleteData'])->name('delete.data');

});