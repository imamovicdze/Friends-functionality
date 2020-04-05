<?php

namespace App\Http\Controllers\REST;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Show all users and their status except friends
     *
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

        return response()->json($users, 200);
    }

    /**
     * Register user
     *
     * @param Request $request
     * @return array|JsonResponse
     */
    public function register(Request $request) {

        $isExist = User::where('email', $request->post('email')) -> first();

        if (empty($isExist)) {

            $user = User::forceCreate([
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'password' => Hash::make($request->post('password')),
                'api_token' => Str::random(80),
            ]);

            return (!empty($user)) ? response()->json($user, 200) : (['Cannot register user!']);
        } else {
            return ['Email already exist!'];
        }
    }
}
