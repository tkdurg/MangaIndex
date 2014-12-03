<?php

class UsersController extends BaseController {

    public function __construct() {
        parent::__construct();

        if(!Auth::user()) {
            App::abort(403);
        }
    }

    public function notifications() {
        $user = Auth::user();

        $notifications = $user
            ->notifications()
            ->join('path_records', 'path_records.id', '=', 'notifications.path_record_id')
            ->select('notifications.*')
            ->with('pathRecord')
            ->orderBy('notifications.dismissed', 'asc')
            ->orderBy('path_records.modified', 'desc')
            ->paginate(20);

        $watched = $user->series()->with('pathRecords')->get();

        $params = array(
            'notifications' => $notifications,
            'watched' => $watched,
            'pageTitle' => 'Notifications'
        );

        return View::make('notifications', $params);
    }

    public function dismiss() {
        $notifyId = Input::get('notification');
        $notify = Notification::findOrFail($notifyId);

        $user = Auth::user();
        if($notify->user_id !== $user->id) {
            App::abort(403, 'Unauthorized.');
        }

        $notify->dismiss();

        return Redirect::to('user/notifications');
    }

    public function toggleWatch() {
        $seriesId = Input::get('series');
        $series = Series::findOrFail($seriesId);
        $user = Auth::user();

        if(!$series || !$user) {
            if(Request::ajax()) {
                return Response::json(array('result' => false, 'message' => 'Invalid params'));
            }
            else {
                throw new Exception('Invalid params');
            }
        }
        else {
            $watching = $user->watchSeries($series);

            if(Request::ajax()) {  
                return Response::json(array('result' => true, 'watching' => $watching));
            }
            else {
                return Redirect::back();
            }
        }
    }

    public function downloadDismiss(Notification $notification) {
        $user = Auth::user();
        if($notification->user_id !== $user->id) {
            App::abort(403, 'Unauthorized.');
        }

        $notification->dismiss();

        $path = $notification->pathRecord->getPath();
        return $this->download($path);
    }

}