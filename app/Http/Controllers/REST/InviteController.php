<?php

namespace App\Http\Controllers\REST;

use App\Friend;
use App\Http\Controllers\Controller;
use App\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InviteController extends Controller
{
    const STATUS_APPROVED = "Approved";
    const STATUS_DECLINED = "Declined";

    /**
     * Send Request
     * @param Request $request
     * @return array
     */
    public function sendRequest(Request $request)
    {
        $idSent = $request->route('idSent');
        $idReceive = $request->route('idReceive');
        $status = $request->route('status');

        $idSentUser = DB::table('users')->where('id', $idSent)->first();
        $idReceiveUser = DB::table('users')->where('id', $idReceive)->first();

        // check if exists user
        if (isset($idSentUser) && isset($idReceiveUser)) {
            $model = new Invite();
            $model->user_id_sent = $idSent;
            $model->user_id_receive = $idReceive;
            $model->status = $status;
            $model->save();

            return ['Request send', 'model' => $model];

        } else {
            return ['Cannot send this invitation!'];
        }
    }

    /**
     * Get all pending requests for current user
     *
     * @param Request $request
     * @return array
     */
    public function getRequests(Request $request)
    {
        $idReceive = $request->route('idReceive');
        $status = $request->route('status');

        $requests = Invite::all()
            ->where('user_id_receive', '=', $idReceive)
            ->where('status', '=', $status)
            ->all();

        return ['requests' => $requests];
    }

    /**
     * Accept request
     *
     * @param Request $request
     * @return array
     */
    public function acceptRequest(Request $request)
    {

        $idSent = $request->route('idSent');
        $idReceive = $request->route('idReceive');

        // Find invitation
        $invite = Invite::where('user_id_receive', '=', $idReceive)
            ->where('user_id_sent', '=', $idSent)
            ->first();

        // Set to Approved Invite
        if (isset($invite)) {
            $invite->status = self::STATUS_APPROVED;
            $invite->save();

            // Create friend object
            $friend = new Friend();
            $friend->main_user = $idSent;
            $friend->friend_id = $idReceive;
            $friend->save();

            return ['Successfully updated invitation & created friend', 'friend' => $friend];
        } else {
            return ['Cannot find this invitation!'];
        }
    }

    /**
     * Decline request
     *
     * @param Request $request
     * @return array
     */
    public function declineRequest(Request $request)
    {
        $idSent = $request->route('idSent');
        $idReceive = $request->route('idReceive');

        // Find invitation
        $invite = Invite::where('user_id_receive', '=', $idReceive)
            ->where('user_id_sent', '=', $idSent)
            ->orderBy('created_at', 'desc')
            ->first();

        // Set to Declined Invite
        if (isset($invite)) {
            $invite->status = self::STATUS_DECLINED;
            $invite->save();

            return ['Invitation is declined', 'invite' => $invite];
        } else {
            return ['Cannot find this invitation!'];
        }
    }
}
