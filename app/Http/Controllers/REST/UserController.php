<?php

namespace App\Http\Controllers\REST;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get All Users
     *
     */
    public function users()
    {
        return response()->json(User::all(), 200);
    }
}
