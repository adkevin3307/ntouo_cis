<?php

use App\Information;
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

Route::post('/course', 'InformationController@store');

Route::post('/message', 'MessagesController@store');

Route::get('/courses', 'InformationController@show');

Route::get('/messages/{course_id}/{grade}', 'MessagesController@show');

Route::put('/course/{course_id}/{grade}', 'InformationController@update');

Route::delete('/course/{course_id}/{grade}', 'InformationController@destroy');
