<?php

namespace App\Http\Controllers;

use App\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * All friends for currently logged in user
     *
     */
    public function getFriends()
    {
        $currentId = Auth::id();

        $users = DB::table('users')
            ->join('friends', 'friends.friend_id', '=', 'users.id')
            ->where('main_user', '=', $currentId)
            ->select('users.*')
            ->get();

        return view('friends', ['users' => $users]);
    }
}
