<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::post('coupons/assign', 'CouponController@assign')->name('coupons.assign')->middleware(['throttle:coupons']);

Route::prefix('admin')
        ->name('admin.')
        ->middleware(['auth', 'admin'])
        ->group(function() {
    Route::get('/', 'Admin\AdminController@index')->name('index');

    Route::get('shops', 'Admin\ShopController@index')->name('shops.index');
    Route::post('shops', 'Admin\ShopController@store')->name('shops.store');

    Route::post('campaigns', 'Admin\CampaignController@store')->name('campaigns.store');
    Route::post('campaigns/{campaign}/deactivate', 'Admin\CampaignController@deactivate')->name('campaigns.deactivate');

    Route::post('coupons/{coupon}/verify', 'Admin\CouponController@verify')->name('coupons.verify');
});
