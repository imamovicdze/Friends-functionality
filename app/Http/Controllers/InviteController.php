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
    const STATUS_PENDING = "Pending";
    const STATUS_APPROVED = "Approved";
    const STATUS_DECLINED = "Declined";

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
        $model->status = self::STATUS_PENDING;

        $model->save();

        return Redirect::back()->with('success', 'Request successfully sent!');
    }

    /**
     * All pending requests for currently logged in user
     *
     * @param Request $request
     * @return Factory|View
     */
    public function getRequests(Request $request)
    {
        $currentId = Auth::id();

        $users = DB::table('users')
            ->join('invites', 'invites.user_id_sent', '=', 'users.id')
            ->where('user_id_receive', '=', $currentId)
            ->where('status', '=', self::STATUS_PENDING)
            ->select('users.*')
            ->get();

        return view('requests', ['users' => $users]);
    }

    /**
     * Accept request. If Invite exists, set it to Approved and create Friend objects.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function acceptRequest(Request $request)
    {
        $currentId = Auth::id();
        $idRequest = $request->route('id');

        // Find invitation
        $invite = Invite::where('user_id_receive', '=', $currentId)
            ->where('user_id_sent', '=', $idRequest)
            ->where('status', '=', self::STATUS_PENDING)
            ->first();

        // Set to Approved
        $invite->status = self::STATUS_APPROVED;
        $invite->save();

        // Create friend object
        $mainFriend = new Friend();
        $mainFriend->main_user = $idRequest;
        $mainFriend->friend_id = $currentId;
        $mainFriend->save();

        $friend = new Friend();
        $friend->main_user = $currentId;
        $friend->friend_id = $idRequest;
        $friend->save();

        return Redirect::back()->with('success', 'Congratulations! You became friends!');
    }

    /**
     * Decline request. If Invite exists, set it to Declined.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function declineRequest(Request $request)
    {
        $currentId = Auth::id();
        $idRequest = $request->route('id');

        // Find invitation
        $invite = Invite::where('user_id_receive', '=', $currentId)
            ->where('user_id_sent', '=', $idRequest)
            ->where('status', '=', self::STATUS_PENDING)
            ->orderBy('created_at', 'desc')
            ->first();

        // Set to Declined
        $invite->status = self::STATUS_DECLINED;
        $invite->save();

        return Redirect::back()->with('info', 'You declined request!');
    }
}
