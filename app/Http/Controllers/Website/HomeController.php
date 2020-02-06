<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Notification;
use App\Models\Inventory;
use App\Models\Complaint;
use App\Models\Chatsupport;
use DB;


use App\User;
use Carbon\Carbon;
use Redirect;
use Session;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $data = array();
        if(Auth::User()->role_id == 1){
            //$data['complain'] = Complaint::all();

            $complain = DB::select('select year(created_at) as year,
                                            month(created_at) as month,
                                            MONTHNAME(created_at) as monthname,
                                            count(id) as total 
                                            from tbl_complaint
                                            WHERE created_at <= NOW()
                                            group by year(created_at),month(created_at),MONTHNAME(created_at)
                                            order by year ASC, month ASC 
                                            limit 12');
            foreach ($complain as $key => $value) {
                $data['complain'][$key][0] = '('.$value->year.') '.$value->monthname;
                $data['complain'][$key][1] = $value->total;
            }
            return view('Website.dashboard.Admindashboard',compact('data'));
        }
        return view('Website.dashboard.dashboard');
    }


    public function logout()
    {   
        Session::flush(); //clears out all the exisiting sessions
        Auth::logout();
        return Redirect::route('login');
    }


    public function show_verify()
    {
        /*return view('home');*/
        return view('Website.otp_verify');
    }


    public function check_verify(Request $request)
    {
        
        try {

            $validator = Validator::make($request->all(), [
                'email_token' => 'required|numeric',
                'mobile_token' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->route('login')->withErrors($validator);
            }

            $user_id = Auth::User()->id;
            $user_record = User::select('first_name','last_name','email_token','mobile_token')->where('id', $user_id)->where('status',1)->first();
            if(!empty($user_record)){
                if(($user_record->email_token == $request->email_token) && ($user_record->mobile_token == $request->mobile_token)){

                    $data = [
                        'email_verify_status' => 1, 
                        'mobile_verify_status' => 1, 
                        'email_verified_at' => Carbon::now(),
                        'mobile_verified_at' => Carbon::now()
                    ];

                    $check = user::where('id', $user_id)->update($data);
                    if($check){

                        $link = url('shopkeeper/display').'/'.$user_id;
                        $message = $user_record->first_name.' '.$user_record->last_name.' New Shopkeeper Add';
                        Notification::create(['by_id' => $user_id, 'to_id' => 2, 'massage' => $message, 'displaylink' => $link ]);

                        return Redirect::route('login');
                    }else{
                        return Redirect::route('login')->with('error','something Wrong, please Try Again');   
                    }
                }else{
                    return Redirect::route('login')->with('error','Wrong Login Details');   
                }
            }else{
                return Redirect::route('login')->with('error','Your account are inactivate');
            }

        }catch (\Exception $e) { 
            return back()->with('error',$e->getMessage());   
        }
    }



    public function get_notification()
    {   
        try {
            $user_id = Auth::User()->id;

            /*echo url()->current();*/
            /*echo url()->previous();*/

            $current_url = url()->previous();
            Notification::where('to_id',$user_id)->where('displaylink',$current_url)->update(['status' => 0]);
            $user_notification = Notification::select()->where('to_id', $user_id)->where('status',1)->orderBy('id', 'desc')->get();
            return response()->json([
                'status'=>'200',
                'message' => 'All notification.',
                'results'=> json_encode($user_notification)                    
            ], 200);

        }catch (\Exception $e) { 
            return back()->with('error',$e->getMessage());   
        }
    }

    public function get_chat_user()
    {
        
        try {
            $user_id = Auth::User()->id;
            $user_chat = Chatsupport::select('tbl_chat_support.*',
                                'users.first_name',
                                'users.last_name',
                                'users.profile_image')
                        ->join('users', 'tbl_chat_support.sender_id', '=', 'users.id')
                        ->where('tbl_chat_support.status',1)
                        ->where('tbl_chat_support.receiver_id',$user_id)
                        ->groupBy('tbl_chat_support.sender_id')
                        ->orderBy('tbl_chat_support.id','DESC')
                        ->get();
            return response()->json([
                'status'=>'200',
                'message' => 'All user.',
                'results'=> json_encode($user_chat)                
            ], 200);

        }catch (\Exception $e) { 
            return back()->with('error',$e->getMessage());   
        }
    }

}
