<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Invite;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class InviteController extends Controller
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
     * Send friend request to another user
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

        return Redirect::back()->with('success','Request successfully sent!');
    }

    /**
     * Get all pending requests for current user
     *
     * @param Request $request
     * @return Factory|View
     */
    public function getRequests(Request $request)
    {
        $currentId = Auth::id();

        $requests = Invite::all()
            ->where('user_id_receive', '=', $currentId)
            ->where('status', '=', 'Pending')
            ->all();

        return view('requests', ['requests' => $requests]);
    }

    /**
     * Accept request
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function acceptRequest(Request $request)
    {
        $currentId = Auth::id();
        $idRequest = $request->route('id');

        // find invitation
        $invite = Invite::where('user_id_receive', '=', $currentId)
            ->where('user_id_sent', '=', $idRequest)
            ->first();

        // set to Approved
        $invite->status = "Approved";
        $invite->save();

        // create friend object
        $friend = new Friend();
        $friend->main_user = $currentId;
        $friend->friend_id = $idRequest;
        $friend->save();

        return Redirect::back()->with('success', 'you are now friends!');
    }
}
