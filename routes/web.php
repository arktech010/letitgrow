<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//Lecturer
Route::get('/add-lecturer', 'App\Http\Controllers\LecturerController@index')->name('add.lecturer');
Route::post('/store-lecturer', 'App\Http\Controllers\LecturerController@store')->name('store.lecturer');
Route::get('/lecturer', 'App\Http\Controllers\LecturerController@show')->name('store.lecturer');
Route::get('/', 'App\Http\Controllers\LecturerController@show')->name('store.lecturer');
Route::get('/module/{faculty_id}', 'App\Http\Controllers\LecturerController@module')->name('module.lecturer');



//CSV
Route::get('/csv', 'App\Http\Controllers\LecturerController@export')->name('export.csv');


