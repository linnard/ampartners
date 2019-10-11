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

Route::group(['prefix' => 'v1', 'namespace' => 'Api', 'middleware' => ['auth'] ], function () {

    //Companies
    Route::get('/companies', 'CompaniesController@index')->name('companies.index');

    //Users
    Route::put('/users/{user}, UsersController@update')
        ->where('user', '[0-9]+')
        ->name('users.update');

    //Clients
    Route::get('/clients', 'ClientsController@index')->name('clients.index');
    Route::post('/clients', 'ClientsController@store')->name('clients.store');
    Route::patch('/clients/{client}', 'ClientsController@patch')
        ->where('client', '[0-9]+')
        ->name('clients.patch');


    //Property Types
    Route::get('/properties', 'PropertiesController@index')->name('properties.index');
    Route::put('/properties/{property}', 'PropertiesController@update')
        ->where('property', '[0-9]+')
        ->name('properties.update');

    //Files
    Route::post('/files', 'FilesController@upload')->name('files.upload');

    //Vacancies
    Route::post('/vacancies', 'VacanciesController@store')->name('vacancies.store');
    Route::get('/vacancies', 'VacanciesController@index')->name('vacancies.index');

    Route::put('/vacancies/{vacancy}', 'VacanciesController@update')
        ->where('vacancy', '[0-9]+')
        ->name('vacancies.update');
});

