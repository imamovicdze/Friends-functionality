<?php

namespace App\Http\Controllers\REST;

use App\Friend;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class FriendController extends Controller
{
    /**
     * All friends for currently logged in user
     *
     * @return JsonResponse
     */
    public function friends()
    {
        $currentId = Auth::id();

        $friends = DB::table('users')
            ->join('friends', 'friends.friend_id', '=', 'users.id')
            ->where('main_user', '=', $currentId)
            ->select('users.*')
            ->get();

        return response()->json($friends, 200);
    }
}
