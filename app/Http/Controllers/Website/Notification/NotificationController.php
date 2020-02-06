<?php

namespace App\Http\Controllers\Website\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\Notification;
use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;


class NotificationController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.notification.notification');
    }

    public function getData()
    { 
        
        $user_id = Auth::user()->id;
        $notification = Notification::where('to_id',$user_id)->get();
        return datatables()->of($notification)->toJson();
        
    }

    
}
