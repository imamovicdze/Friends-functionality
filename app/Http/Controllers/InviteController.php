<?php

namespace App\Http\Controllers;

use App\Invite;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class InviteController extends Controller
{
    /**
     * Show all users.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendRequest(Request $request)
    {
        $currentId = Auth::id();
        $idRequest = $request->route('id');


        $model = new Invite();
        $model->user_id_sent = $currentId;
        $model->user_id_receive = $idRequest;
        $model->status = "Pending";

        $model->save();

        return Redirect::back()->with('success','Request successfully sent !');
    }
}
