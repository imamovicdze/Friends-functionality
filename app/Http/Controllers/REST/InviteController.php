<?php

namespace App\Http\Controllers\REST;

use App\Friend;
use App\Http\Controllers\Controller;
use App\Invite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InviteController extends Controller
{
    const STATUS_PENDING = "Pending";
    const STATUS_APPROVED = "Approved";
    const STATUS_DECLINED = "Declined";

    /**
     * Send friend request to another user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendRequest(Request $request)
    {
        $currentId = Auth::id();
        $idRequest = $request->route('id');

        $model = new Invite();
        $model->user_id_sent = $currentId;
        $model->user_id_receive = (int)$idRequest;
        $model->status = self::STATUS_PENDING;

        $model->save();

        return response()->json($model, 200);
    }

    /**
     * All pending requests for currently logged in user
     *
     * @return JsonResponse
     */
    public function getRequests()
    {
        $currentId = Auth::id();

        $requests = DB::table('users')
            ->join('invites', 'invites.user_id_sent', '=', 'users.id')
            ->where('user_id_receive', '=', $currentId)
            ->where('status', '=', self::STATUS_PENDING)
            ->select('users.*')
            ->get();

        return response()->json($requests, 200);
    }

    /**
     * Accept request. If Invite exists, set it to Approved and create Friend objects.
     *
     * @param Request $request
     * @return JsonResponse
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

        if (isset($invite)) {
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

            return response()->json($friend, 200);
        } else {
            return response()->json(['error' => 'Cannot find this invitation!'], 404);
        }
    }

    /**
     * Decline request. If Invite exists, set it to Declined.
     *
     * @param Request $request
     * @return JsonResponse
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

        if (isset($invite)) {
            // Set to Declined
            $invite->status = self::STATUS_DECLINED;
            $invite->save();

            return response()->json($invite, 200);
        } else {
            return response()->json(['error' => 'Cannot find this invitation!'], 404);
        }
    }
}
