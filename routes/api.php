<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//'middleware' => ['auth:api', 'role:admin']

Route::group(['prefix' => 'v1', 'namespace' => 'Api' ], function () {

    Route::get('/companies', 'CompaniesController@index')->name('companies.index');

    Route::put('/users/{user}')
        ->uses('UsersController@update')
        ->name('api.user.update')
        ->where('user', '[0-9]+');
});

