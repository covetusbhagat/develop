<?php

namespace App\Http\Controllers\Website\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class DeliveryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.user.delivery');
    }

    public function getData()
    { 
        $record = User::select()->where('role_id',4)->get();
        foreach ($record as $key => $value) {
            $record[$key]->fullname = $value->first_name.' '.$value->last_name;
        }
        return datatables()->of($record)->toJson();
    }

    public function create()
    { 
        return view('Website.user.delivery_add');
    }


    public function store(Request $request)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|string|email|unique:users',
                'mobile' => 'required|numeric|unique:users',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'role_id' => 4,
                'password' => Hash::make($request->password),
                'email_token' => otp_genrater(4),
                'mobile_token' => otp_genrater(4)
            ];

            $dataset = User::create($data);
            if($dataset)
            {
                
                $id = $dataset->id;
                $user = User::where('id',$id)->first();

                $mobile_message = 'hello '.$request->first_name.' '.$request->last_name.' Welcome To Rentotree. Your mobile verification OTP is '.$user->mobile_token;
                send_sms($user->mobile,$mobile_message);

                /*send token on mail - start*/

                $data['link'] = $user->email_token;
                //$data['link2'] = $user->mobile_token;
                $request->subject = "Confirmed your acount from RentoTree.";
                $request->adminemail = 'rentotree@gmail.com';

                $result = Mail::send('emails.confirmed_account',$data, function($message) use ($request) {
                    $message->from($request->adminemail);
                    $message->to($request->email);
                    $message->subject($request->subject);
                    $message->replyTo($request->adminemail);
                });

                /*send token on mail - close*/
                
                return redirect()->route('website.delivery')->with('success','Record Insert successfully');
            }else{
                return redirect()->route('website.delivery')->with('error','Record Not Inserted !!');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.delivery')->with('error',$e->getMessage());   
        }
    }


    public function edit($id)
    { 
        $user_record = user::find($id);
        return view('Website.user.delivery_edit',compact('user_record'));
    }


    public function update(Request $request, $id)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'status' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.delivery')->withErrors($validator);
            }
            
            $group = user::find($id);           
            $group->first_name =  $request->get('first_name');
            $group->last_name =  $request->get('last_name');
            /*$group->email =  $request->get('email');
            $group->mobile =  $request->get('mobile');*/
            $group->status =  $request->get('status');
            $group->save();

            $group->password =  $request->get('set_password');

            /* Document image upload start */
                if(!empty($request->set_password))
                {
                    user::where('id', $id)->update(['password' => Hash::make($request->set_password)]); 
                }
                /* Document image upload close */

            return redirect()->route('website.delivery')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.delivery')->with('error',$e->getMessage());   
        }
    }


    public function delete($id)
    { 
        try {
            User::where('id',$id)->delete();
            return redirect()->route('website.delivery')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.delivery')->with('error',$e->getMessage());   
        }
    }


    public function display($id)
    { 
        try {
            $user_record = user::find($id);
            return view('Website.user.delivery_view',compact('user_record'));
        }catch (\Exception $e) { 
            return redirect()->route('website.delivery')->with('error',$e->getMessage());   
        }
    }

}
