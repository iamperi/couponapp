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

require __DIR__.'/auth.php';

Route::get('/', 'HomeController@index')->name('home');

Route::post('coupons/assign', 'CouponController@assign')->name('coupons.assign')->middleware(['throttle:coupons']);

Route::prefix('admin')
        ->name('admin.')
        ->middleware(['auth', 'admin'])
        ->group(function() {
    Route::get('/', 'Admin\AdminController@index')->name('index');

    Route::get('shops', 'Admin\ShopController@index')->name('shops.index');
    Route::post('shops', 'Admin\ShopController@store')->name('shops.store');

    Route::get('historic', 'Admin\HistoricController@index')->name('historic.index');

    Route::get('campaigns', 'Admin\CampaignController@index')->name('campaigns.index');
    Route::post('campaigns', 'Admin\CampaignController@store')->name('campaigns.store');
    Route::post('campaigns/{campaign}/toggle', 'Admin\CampaignController@toggle')->name('campaigns.toggle');

    Route::get('coupons/validate', 'Admin\CouponValidationController@index')->name('coupons.validation.index');
    Route::post('coupons/{coupon}/validate', 'Admin\CouponValidationController@store')->name('coupons.validation.store');
    Route::post('coupons/{coupon}/pay', 'Admin\CouponPaymentController@update')->name('coupons.payment.update');
});
