<?php

namespace App\Http\Controllers\Website\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Models\States;
use App\Models\Cities;

use App\Models\User_address;

use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.user.customer');

    }

    public function getData()
    { 
        $record = User::select()->where('role_id',3)->get();
        foreach ($record as $key => $value) {
            $record[$key]->fullname = $value->first_name.' '.$value->last_name;
            if($value->doc_aprove_status == 1){
                $record[$key]->doc_aprove = "YES";
            }elseif($value->doc_aprove_status == 2){
                $record[$key]->doc_aprove = "REJECT";
            }else{
                 $record[$key]->doc_aprove = "NO";
            }
        }
        return datatables()->of($record)->toJson();
    }


    public function create()
    { 
        return view('Website.user.customer_add');
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
                'role_id' => 3,
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
                
                return redirect()->route('website.customer')->with('success','Record Insert successfully');
            }else{
                return redirect()->route('website.customer')->with('error','Record Not Inserted !!');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.customer')->with('error',$e->getMessage());   
        }
    }


    public function edit($id)
    { 
        $user_record = user::find($id);
        return view('Website.user.customer_edit',compact('user_record'));
    }

    public function edit_address($id)
    { 
        $user_address_record = User_address::find($id);
        $state = States::select('state_name','id')->where('country_id',101)->get();
        $city = Cities::select('city_name','id')->where('id',$user_address_record->city_id)->get();
        return view('Website.user.customer_edit_address',compact('user_address_record','state','city'));
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
                return redirect()->route('website.customer')->withErrors($validator);
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

            return redirect()->route('website.customer')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.customer')->with('error',$e->getMessage());   
        }
    }


    public function update_address(Request $request, $id)
    { 

        try {

            $validator = Validator::make($request->all(), [
                'house_no' => 'required|string',
                'land_mark' => 'required|string',
                'state_id' => 'required|numeric',
                'city_id' => 'required|numeric',
                'pincode' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.customer')->withErrors($validator);
            }

            $group = User_address::find($id);   
            $group->house_no =  $request->get('house_no');
            $group->land_mark =  $request->get('land_mark');
            $group->state_id =  $request->get('state_id');
            $group->city_id =  $request->get('city_id');
            $group->pincode =  $request->get('pincode');
            $group->save();

            return redirect()->route('website.customer')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.customer')->with('error',$e->getMessage());
        }
    }



    public function deleted($id)
    { 
        try {
            User::where('id',$id)->delete();
            return redirect()->route('website.customer')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.customer')->with('error',$e->getMessage());   
        }
    }


    public function display($id)
    { 
        try {
            $user_record = user::find($id);
            if($user_record->doc_aprove_status == 1){
                $user_record->doc_aprove = "YES";
            }elseif($user_record->doc_aprove_status == 2){
                $user_record->doc_aprove = "REJECT";
            }else{
                $user_record->doc_aprove = "NO";
            }
            if($user_record->doc_aprove_status != 0){

                $user_data = user::select('first_name','last_name','id')->where('id',$user_record->doc_aprove_by_id)->first();

                $user_record->doc_aprove_by = $user_data->first_name.' '.$user_data->last_name;

            }
            $address_list = User_address::select('tbl_user_address.*',
                            'tbl_master_states.state_name as state_name',
                                    'tbl_master_cities.city_name as city_name')
                    ->join('tbl_master_states', 'tbl_user_address.state_id', '=', 'tbl_master_states.id')
                    ->join('tbl_master_cities', 'tbl_user_address.city_id', '=', 'tbl_master_cities.id')
                    ->where('users_id',$id)->get();
            return view('Website.user.customer_view',compact('user_record','address_list'));
        }catch (\Exception $e) { 
            return redirect()->route('website.customer')->with('error',$e->getMessage());   
        }
    }


    public function aprove_doc($id)
    {
        try {
           
            $user_id = Auth::user()->id;

            $data = [
                'doc_aprove_status' => 1,
                'doc_aprove_by_id' => $user_id
            ];

            user::where('id',$id)->update($data);
            return redirect()->back()->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->back()->with('error',$e->getMessage());   
        }
    }

    public function reject_doc($id)
    {
        try {
            $user_id = Auth::user()->id;
            $data = [
                'doc_aprove_status' => 2,
                'doc_aprove_by_id' => $user_id
            ];
            user::where('id',$id)->update($data);
            return redirect()->back()->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->back()->with('error',$e->getMessage());   
        }
    }

    
}
