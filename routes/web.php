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

Auth::routes();

Route::get('/' , 'HomeController@index')->name('index');

//  RESTful
Route::resource('otherRestful' , 'projectMainController');

// Auth
Route::post('/signin' , 'authController@signin');
Route::post('/signup' , 'authController@signup')->middleware('CheckPassword');
Route::post('/update' , 'authController@update');
Route::get('/signout' , 'authController@signout');
Route::post('/updatePassword' , 'authController@updatePass')->middleware('CheckSession');
Route::post('/changepass' , 'authController@changepass')->middleware('CheckSession');
Route::post('/changeStatus' , 'authController@changeStatus')->middleware('CheckSession');

// Main pages
Route::get('/main' , 'HomeController@index')->name('index');
Route::get('/usermanage', 'HomeController@usermanage')->middleware('CheckSession');
Route::post('/usermanage', 'HomeController@usermanage')->middleware('CheckSession');
Route::get('/reportmanage', 'HomeController@reportmanage')->middleware('CheckSession');
Route::post('/reportmanage', 'HomeController@reportmanage')->middleware('CheckSession');
Route::get('/profile', 'HomeController@profile')->middleware('CheckSession');
Route::post('/profile', 'HomeController@profile')->middleware('CheckSession');

// Load Reports
Route::post('/reportSummary', 'ViewReports@getinfo')->middleware('CheckSession');
Route::post('/reportSummarySecond', 'ViewReports@getinfoSecond')->middleware('CheckSession');

Route::post('/creports', 'ViewReports@getinfocreports')->middleware('CheckSession');
Route::post('/creportsSec', 'ViewReports@getinfocreportsSecond')->middleware('CheckSession');

// getDateinfo
Route::post('/getDateinfo', 'ViewReports@getDateinfo')->middleware('CheckSession');
Route::post('/getchartinfodata', 'ViewReports@getchartinfodata')->middleware('CheckSession');

// Edit action
Route::post('/editaction', 'ViewReports@editaction')->middleware('CheckSession');
Route::get('/editaction', 'ViewReports@editaction')->middleware('CheckSession');
Route::post('/savedata', 'ViewReports@savedata')->middleware('CheckSession');
Route::post('/removeinquries', 'ViewReports@removeinquries')->middleware('CheckSession');
Route::post('/removemoveouts', 'ViewReports@removemoveouts')->middleware('CheckSession');
Route::post('/removecc', 'ViewReports@removecc')->middleware('CheckSession');
Route::post('/editprofile', 'ViewReports@editprofile')->middleware('CheckSession');


// Create file upload form
Route::get('/upload-file', 'FileUpload@createForm');

// Store file
Route::post('/upload-file', 'FileUpload@fileUpload')->name('fileUpload');