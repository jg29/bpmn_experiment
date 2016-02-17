<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/', "PagesController@home");

Route::get('/danke', "PagesController@danke");
Route::get('/test', function(){
    return  "juhu" ; //  shell_exec("/usr/local/bin/convert diagram.svg test.png");

});

Route::get('/freigabe/{experiment}', "FreigabeController@freigabe");
Route::post('/freigabe/{experiment}/save','FreigabeController@save');




Route::get('auswertung/timeline/{element}/{student}','AuswertungController@timeline');
Route::get('auswertung/excel/{id}','AuswertungController@excel');
Route::get('auswertung/{id}','AuswertungController@show');



Route::resource('user','UserController');



Route::resource('experiment','ExperimentController');

Route::post('/', "StudentController@redirect");
Route::get('experiment/{key}/{id}','StudentController@element');
Route::post('experiment/{key}/{id}/save','StudentController@save');
Route::post('experiment/{key}/{id}/svg','StudentController@saveSvg');
Route::post('experiment/{key}/{id}/draw','StudentController@saveDraw');

Route::post('element/orderxor','ElementController@orderXor');
Route::post('element/order','ElementController@order');

Route::resource('element','ElementController');

Route::get('field/up','FieldController@up');
Route::get('field/down','FieldController@down');
Route::resource('field','FieldController');


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');