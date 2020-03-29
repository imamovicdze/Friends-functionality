<?php

namespace App\Http\Controllers\REST;

use App\Http\Controllers\Controller;
use App\Invite;
use Illuminate\Http\Request;

class InviteController extends Controller
{
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
}
