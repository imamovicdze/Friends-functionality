<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('friends', 'REST\FriendController@friends');

Route::get('send-request&{idSent}&{idReceive}&{status}', 'REST\InviteController@sendRequest');
Route::get('requests&{idReceive}&{status}', 'REST\InviteController@getRequests');
Route::get('accept&{idSent}&{idReceive}', 'REST\InviteController@acceptRequest');
Route::get('decline&{idSent}&{idReceive}', 'REST\InviteController@declineRequest');
