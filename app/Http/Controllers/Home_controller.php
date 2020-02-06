<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Session;
use Redirect;
use DB;

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class Home_controller extends Controller
{

    public function index()
    {          
        return view('auth.login');
    }


   	public function login(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('login')->withErrors($validator);
            }
            
            $credentials = array();
            if(is_numeric($request->get('username')))
            {
            	$credentials = [
            					
            		'mobile' => $request->username, 
            		'password' => $request->password
            	];
            }
            else{
            	$credentials = [
            		'email' => $request->username, 
            		'password' => $request->password
            	];
            }

            if(!empty($credentials)){
            	if(Auth::attempt($credentials)){
                    $user = Auth::User();

                   /* print_r(expression)*/

                    /* code if user not admin or shopkeeper - Start */
                    $user_record = User::select('role_id','profile_image','status')->where('id', $user->id)->first();
                    if(($user_record->role_id != 1) && ($user_record->role_id != 2)){
                        Session::flush(); //clears out all the exisiting sessions
                        Auth::logout();
                        if($user_record->role_id == 3){ 
                            return Redirect::route('login')->with('error','Please Login with Customer App');
                        }else{
                            return Redirect::route('login')->with('error','Please Login with Delivery App');
                        }
                    }
                    if($user_record->status == 0){
                        Session::flush(); //clears out all the exisiting sessions
                        Auth::logout();
                        return Redirect::route('login')->with('error','Your account are Inactive');
                    }

                    /* code if user not admin or shopkeeper - Close */

    	           	Session::put('first_name', $user->first_name);
            		Session::put('last_name', $user->last_name);
            		Session::put('email', $user->email);
            		Session::put('mobile', $user->mobile);
                    Session::put('role_id', $user->role_id);
                    Session::put('profile_image', $user_record->profile_image);
           			Session::put('id', $user->id);

    	           	//return redirect('home');
                    return Redirect::route('home');
                    
            	}else{

                    //Session::flash('message', 'This is a message!');
                    return Redirect::route('login')->with('error','Wrong Login Details');  
                 	//return back()->with('message','Wrong Login Details');   
            	}
            }
        }catch (\Exception $e) { 
            return Redirect::route('login')->with('error',$e->getMessage());   
        }
    }

    public function get_credentials()
    {          
        return view('auth.get_credentials');
    }


    public function forget_password(Request $request)
    {           
        try { 

            $validator = Validator::make($request->all(), [
                'username' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('login')->withErrors($validator);
            }

           /* \DB::connection()->enableQueryLog();*/ 
            $user_res = User::where('status', 1)->where('email', $request->username)->orwhere('mobile', $request->username)->first();
             /*$queries = \DB::getQueryLog();
                    dd($queries);*/ 

            /*echo "</pre>";
            print_r($user_res);
            die();*/


            if(!empty($user_res)){
                
                /*send mail*/
                $user_id = ($user_res->id);

                $remember_token = md5(otp_genrater(9));
                user::where('id',$user_id)->update(['remember_token' => $remember_token]);
                $data['link'] = url('/reset_password').'?code='.$remember_token;
                $request->email = $user_res->email;
                $request->subject = "Forget Password from RentroTree.";               
                $result = Mail::send('emails.forget_password',$data, function($message) use ($request) {
                        $message->from('rentotree@gmail.com');
                        $message->to($request->email);
                        $message->subject($request->subject);
                        $message->replyTo($request->email);
                    }
                );
               
                if(count(Mail::failures()) <1){
                    
                    return Redirect::route('login')->with('success','Please check your mail account for activation link');

                }else{

                    return Redirect::route('login')->with('error','Something went Wrong');
                }
            }else{
                 
                return Redirect::route('login')->with('error','invalid Email-id or Mobile Number');
            }
        }catch (\Exception $e) { 
            return Redirect::route('login')->with('error',$e->getMessage());   
        }
       
    }


    public function reset_password()
    {
        return view('auth.reset_password');
    }


    public function update_password(Request $request)
    {           
        try {

            $validator = Validator::make($request->all(), [
                'code' => 'required',
                'new_password' => 'required',
                'conform_password' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('login')->withErrors($validator);
            }

            $user_res = User::where('remember_token', $request->code)->first();
            if(!empty($user_res)){
                
                /*send mail*/
                $user_id = ($user_res->id);

                $remember_token = md5(otp_genrater(9));
                $check = user::where('id',$user_id)->update(['remember_token' => $remember_token, 'password' => Hash::make($request->conform_password)]);
                if($check){
                    
                    return Redirect::route('login')->with('success','your Password Reset successfully.');

                }else{

                    return back()->with('error','Something went Wrong. Please Try after sometime');
                }
            }else{
                 
                return back()->with('error','Your link has expired');
            }
        }catch (\Exception $e) { 
            return back()->with('error',$e->getMessage());   
        }
       
    }
    
}