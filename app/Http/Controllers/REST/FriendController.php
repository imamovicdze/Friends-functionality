<?php

namespace App\Http\Controllers\REST;

use App\Friend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class FriendController extends Controller
{
    /**
     * Get Friends
     *
     */
    public function friends()
    {
        return response()->json(Friend::all(), 200);
    }
}
