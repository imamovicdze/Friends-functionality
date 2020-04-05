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

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('users', 'REST\UserController@users');

    Route::get('send-request/{id}', 'REST\InviteController@sendRequest');
    Route::get('requests', 'REST\InviteController@getRequests');
    Route::get('accept/{id}', 'REST\InviteController@acceptRequest');
    Route::get('decline/{id}', 'REST\InviteController@declineRequest');

    Route::get('friends', 'REST\FriendController@friends');
});
