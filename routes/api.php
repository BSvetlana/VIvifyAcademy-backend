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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', 'Auth\LoginController@authenticate');

Route::middleware('jwt')->get('/all-galleries/{page}/{term?}','GalleriesController@index');
Route::middleware('jwt')->post('/galleries','GalleriesController@store');
Route::middleware('jwt')->get('/galleries/{id}','GalleriesController@show');
Route::middleware('jwt')->put('/galleries/{id}','GalleriesController@update');
Route::middleware('jwt')->delete('/galleries/{id}','GalleriesController@destroy');

Route::middleware('jwt')->get('/my-gallery/{page}/{term?}','MyGalleriesController@index');
Route::middleware('jwt')->get('/authors/{id}/{page}/{term?}','AuthorsGalleriesController@index');
Route::middleware('jwt')->post('/galleries/{id}/comments', 'CommentsController@store');
