<?php

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
Route::group(['prefix' => 'admin', 'name' => 'admin.fastdl', 'middleware' => 'isAdmin'], function () {
    Route::name('admin.fastdl')->get('fastdl', 'FastdlController@index');

    Route::name('admin.fastdl.edit')->get('fastdl/{id}', 'FastdlController@edit');
    Route::name('admin.fastdl.save')->patch('fastdl/{id}', 'FastdlController@save');
    Route::name('admin.fastdl.update')->put('fastdl/{id}', 'FastdlController@update');

    Route::name('admin.fastdl.accounts')->get('fastdl/{fastdlDs}/accounts', 'FastdlAccountsController@list');
    Route::name('admin.fastdl.accounts.last_error')->get('fastdl/{fastdlDs}/accounts/last_error', 'FastdlAccountsController@lastError');
    Route::name('admin.fastdl.accounts.create')->get('fastdl/{fastdlDs}/accounts/create', 'FastdlAccountsController@create');
    Route::name('admin.fastdl.accounts.store')->post('fastdl/{fastdlDs}/accounts/create', 'FastdlAccountsController@store');

    Route::name('admin.fastdl.accounts.show')->get('fastdl/accounts/{fastdlServer}', 'FastdlAccountsController@show');
    Route::name('admin.fastdl.accounts.destroy')->delete('fastdl/accounts/{fastdlServer}', 'FastdlAccountsController@destroy');
});
