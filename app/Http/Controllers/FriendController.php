<?php

namespace App\Http\Controllers;

use App\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Get all friends for current user
     *
     */
    public function getFriends()
    {
        $currentId = Auth::id();

        // find invitation
        $friends = Friend::all()
            ->where('main_user', '=', $currentId)
            ->all();

        return view('friends', ['friends' => $friends]);
    }
}
