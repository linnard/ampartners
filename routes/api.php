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


//Config
Route::group(['prefix' => 'v1', 'namespace' => 'Api' ], function () {
    Route::get('config/filters', 'ConfigController@getFilters');

    //Filters
    Route::get('filters', 'FiltersController@index');

    //Vacancies
    Route::resource('vacancies', 'VacanciesController');
});


Route::group(['prefix' => 'v1', 'namespace' => 'Api', 'middleware' => ['auth:api'] ], function () {

    //Route::get('/clear', 'ClearController@clear');

    //Info
    Route::get('counts', 'InfoController@counts');

    //Roles
    Route::get('roles', 'RolesController@index');

    //Permissions
    Route::get('permissions', 'PermissionsController@index');

    //Companies
    Route::get('companies', 'CompaniesController@index');


    Route::get('vacancy-statuses', 'VacanciesController@getStatuses');


    //Users
    Route::get('users', 'UsersController@index');
    Route::post('users', 'UsersController@store');
    Route::put('users/{user}', 'UsersController@update')->where('user', '[0-9]+');
    Route::put('users/{user}/status', 'UsersController@updateStatus')->where('user', '[0-9]+');

    //Clients
    Route::get('clients', 'ClientsController@index');
    Route::get('clients/{client}', 'ClientsController@show');
    Route::post('clients', 'ClientsController@store');
    Route::post('clients/search', 'ClientsController@search');
    Route::post('clients/{client}/complete', 'ClientsController@complete')->where('client', '[0-9]+');
    Route::get('clients/{client}/files', 'ClientsController@downloadZip')->where('client', '[0-9]+');
    Route::put('clients/{client}/status', 'ClientsController@updateStatus')->where('client', '[0-9]+');
    Route::patch('clients/{client}', 'ClientsController@patch')->where('client', '[0-9]+');
    Route::post('clients/{client}/file', 'ClientsController@upload')->where('client', '[0-9]+');

    //Property Types
    Route::get('/properties', 'PropertiesController@index');
    Route::put('/properties/{property}', 'PropertiesController@update')->where('property', '[0-9]+');

    //Files
    Route::get('/files/{file}', 'FilesController@download');
    Route::delete('/files/{file}', 'FilesController@delete');

    //Vacancies
    Route::post('/client-vacancies', 'ClientVacanciesController@store');
    Route::get('/client-vacancies', 'ClientVacanciesController@index');
    Route::put('/client-vacancies/{vacancy}', 'ClientVacanciesController@update')->where('vacancy', '[0-9]+');

    //Logs
    Route::get('/logs', 'LogsController@index');
    Route::put('/logs/read', 'LogsController@read');

    //Notifications
    Route::get('/notifications', 'NotificationsController@index');
    Route::put('/notifications/read', 'NotificationsController@read');

    //Statuses
    Route::get('/statuses', 'StatusesController@index');
});

