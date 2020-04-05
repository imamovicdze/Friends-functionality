<?php

namespace App\Http\Controllers\REST;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
            " and invites.user_id_receive = users.id) where users.id <> " . Auth::id());

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
    public function register(Request $request)
    {
        $isExist = User::where('email', $request->post('email')) -> first();

      if (empty($isExist)) {
          $validator = Validator::make($request->all(), [
              'name' => 'required',
              'email' => 'required|email',
              'password' => 'required',
              'c_password' => 'required|same:password',
          ]);

          if ($validator->fails()) {
              return response()->json(['error' => $validator->errors()], 401);
          }

          $user = User::forceCreate([
              'name' => $request->post('name'),
              'email' => $request->post('email'),
              'password' => Hash::make($request->post('password')),
              'api_token' => Str::random(80),
          ]);
          return response()->json(['success' => $user], 200);
      } else {
          return ['Email already exist!'];
      }
    }

    /**
     * Login user
     *
     * @param Request $request
     * @return array|JsonResponse
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->post('email'), 'password' => $request->post('password')])) {
            $user = Auth::user();
            return response()->json(['success' => $user], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
