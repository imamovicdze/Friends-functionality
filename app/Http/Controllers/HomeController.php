<?php

namespace App\Http\Controllers;

use App\Friend;
use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show all users and their status except friends
     *
     * @return Renderable
     */
    public function users()
    {
        $users = DB::select("select users.*, invites.status AS status, (select COUNT(*) from friends where friends.main_user = " . Auth::id() .
            " and friends.friend_id = users.id) AS is_friend from users left join invites on (invites.user_id_sent = " . Auth::id() .
            " and invites.user_id_receive = users.id) where users.id <> ". Auth::id());

        // don't show friends
        $users = collect($users)->filter(function ($friend) {
            return $friend->is_friend == 0;
        });

        return view('users', ['users' => $users]);
    }
}
