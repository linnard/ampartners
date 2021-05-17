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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//onesignal
Route::post('onesignal/subscribe', 'OnesignalController@subscribe')->name('onesignal.subscribe')->middleware('auth');

/*Route::get('add-permissions', function (){
    \Spatie\Permission\Models\Permission::create(['name' => \App\Constants\User\Permission::ControlVacancies]);
    \Spatie\Permission\Models\Permission::create(['name' => \App\Constants\User\Permission::ViewVacancies]);
});*/

Route::get('vb', function (){
    return redirect('viber://pa?chatURI=ampartners');
});

Route::get('viber', function (){
    return redirect('viber://pa?chatURI=ampartners');
});

Route::get('tg', function (){
    return redirect('tg://resolve?domain=ampartnersbot');
});

Route::get('telegram', function (){
    return redirect('tg://resolve?domain=ampartnersbot');
});


//Adminpanel routes
Route::group(['prefix' => 'adminpanel', 'namespace' => 'Adminpanel', 'middleware' => ['role:admin'] ], function () {
    Route::get('/{any?}', 'AdminpanelController@index')->name('adminpanel.index');
});


//Controlpanel routes
Route::group(['prefix' => 'controlpanel', 'namespace' => 'Controlpanel', 'middleware' => ['role:partner'] ], function () {
    Route::get('/{any?}', 'ControlpanelController@index')->name('controlpanel.index');
});

Route::get('test', function(){
    event(new \App\Events\Client\StatusUpdated(\App\Models\Client::find(1), 'mudaaak'));
});

