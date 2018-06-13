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

Route::get('/', function () {
    return view('pages.home');
});
Route::post('/activities', 'MainController@Activities');

Route::get('/track', function () {
    return view('pages.track');
});
Route::post('/track/users', 'MainController@Users');
Route::post('/track/drinkType', 'MainController@DrinkType');
Route::post('/track/recode', 'MainController@drinkRecode');

Route::get('/deposit', function () {
    return view('pages.deposit');
});
Route::post('/deposit/users', 'MainController@Users');
Route::post('/deposit/recode', 'MainController@depositRecode');
Route::get('/deposit/confirm/{id}', 'MainController@Confirm');
Route::get('/deposit/cancel/{id}', 'MainController@Cancel');

Route::get('/balance', function () {
    return view('pages.balance');
});
Route::post('/balance/getData', 'MainController@getData');
