<?php

namespace App\Http\Controllers\REST;

use App\Friend;
use App\Http\Controllers\Controller;
use App\Invite;
use Illuminate\Http\Request;

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

        $model = new Invite();
        $model->user_id_sent = $idSent;
        $model->user_id_receive = $idReceive;
        $model->status = $status;
        $model->save();

        return ['created', 'model' => $model];
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

        // find invitation
        $invite = Invite::where('user_id_receive', '=', $idReceive)
            ->where('user_id_sent', '=', $idSent)
            ->first();

        // set to Approved
        $invite->status = self::STATUS_APPROVED;
        $invite->save();

        // create friend object
        $friend = new Friend();
        $friend->main_user = $idSent;
        $friend->friend_id = $idReceive;
        $friend->save();

        return ['Successfully updated invitation & created friend', 'friend' => $friend];

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

        // find invitation
        $invite = Invite::where('user_id_receive', '=', $idReceive)
            ->where('user_id_sent', '=', $idSent)
            ->first();

        // set to Declined
        $invite->status = self::STATUS_DECLINED;
        $invite->save();

        return ['Invitation is declined', 'invite' => $invite];
    }
}
