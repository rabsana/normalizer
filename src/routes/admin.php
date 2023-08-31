<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-29 04:48
 */

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => config('rabsana-normalizer.middlewares')], function () {
    Route::group(['middleware' => 'can:index,Rabsana\Normalizer\Models\Normalizer'], function () {
        // Set Language
        Route::middleware('setLang')->group(function () {
            Route::get('rabsana-normalizer/normalizers', 'Rabsana\\Normalizer\\Controllers\\NormalizerController@index')->name('rabsana_normalizer.normalizers.index');
            Route::get('rabsana-normalizer/normalizers/create', 'Rabsana\\Normalizer\\Controllers\\NormalizerController@create')->name('rabsana_normalizer.normalizers.create');
            Route::post('rabsana-normalizer/normalizers', 'Rabsana\\Normalizer\\Controllers\\NormalizerController@store')->name('rabsana_normalizer.normalizers.store');
            Route::get('rabsana-normalizer/normalizers/{id}/edit', 'Rabsana\\Normalizer\\Controllers\\NormalizerController@edit')->name('rabsana_normalizer.normalizers.edit');
            Route::put('rabsana-normalizer/normalizers/{id}', 'Rabsana\\Normalizer\\Controllers\\NormalizerController@update')->name('rabsana_normalizer.normalizers.update');
            Route::delete('rabsana-normalizer/normalizers/{id}', 'Rabsana\\Normalizer\\Controllers\\NormalizerController@destroy')->name('rabsana_normalizer.normalizers.destroy');
        });
    });
});


