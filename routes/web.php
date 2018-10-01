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

Route::get('/', [
  'uses' => 'pagesController@dashboard',
  'as' => 'dashboard'
]);

Route::get('/itemmaster', [
  'uses' => 'pagesController@itemmaster',
  'as' => 'itemmaster'
]);

Route::get('/prescription', [
  'uses' => 'pagesController@prescription',
  'as' => 'prescription'
]);

Route::get('inventory/{itemid}', 'prescriptionsController@getInventory');

Route::apiResource('items', 'itemMasterController');
Route::apiResource('prescriptions', 'prescriptionsController');
