<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'HomeController@users');

Route::get('/send-request/{id}', 'InviteController@sendRequest');
Route::get('/requests', 'InviteController@getRequests');
Route::get('/accept/{id}', 'InviteController@acceptRequest');
Route::get('/decline/{id}', 'InviteController@declineRequest');

Route::get('/friends', 'FriendController@getFriends');

