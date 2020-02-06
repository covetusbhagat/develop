<?php

namespace App\Http\Controllers\Website\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Models\Inventory;
use App\Models\User_address;
use App\Models\States;
use App\Models\Cities;

use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class ShopkeeperController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {

        return view('Website.user.shopkeeper');
    }


    public function getData()
    { 
        $record = User::select()->where('role_id',2)->get();
        foreach ($record as $key => $value) {
            $record[$key]->fullname = $value->first_name.' '.$value->last_name;
        }
        return datatables()->of($record)->toJson();
    }

    public function create()
    { 
        $state = States::select('state_name','id')->where('country_id',101)->get();
        return view('Website.user.shopkeeper_add',compact('state'));
    }


    public function store(Request $request)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|string|email|unique:users',
                'mobile' => 'required|numeric|unique:users',
                'password' => 'required',
                'state_id' => 'required|int',
                'city_id' => 'required|int',
                'pincode' => 'required',
                'house_no' => 'required|string',
                'land_mark' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric'

            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'role_id' => 2,
                'password' => Hash::make($request->password),
                'email_token' => otp_genrater(4),
                'mobile_token' => otp_genrater(4)
            ];

            $dataset = User::create($data);
            $dataset->id;

            $data = [
                'users_id' => $dataset->id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'pincode' => $request->pincode,
                'house_no' => $request->house_no,
                'land_mark' => $request->land_mark,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ];

            $dataset1 = User_address::create($data);
            if($dataset1)
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
                
                return redirect()->route('website.shopkeeper')->with('success','Record Insert successfully');
            }else{
                return redirect()->route('website.shopkeeper')->with('error','Record Not Inserted !!');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.shopkeeper')->with('error',$e->getMessage());   
        }
    }


    public function edit($id)
    { 
        $user_record = user::find($id);
        $user_address_record = User_address::where('users_id',$id)->first();
        $state = States::select('state_name','id')->where('country_id',101)->get();
        $city = Cities::select('city_name','id')->where('id',$user_address_record->city_id)->get();
        return view('Website.user.shopkeeper_edit',compact('user_record','user_address_record','state','city'));
    }


    public function update(Request $request, $id)
    { 
        try {

             $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'status' => 'required|numeric',
                'state_id' => 'required|int',
                'city_id' => 'required|int',
                'pincode' => 'required',
                'house_no' => 'required|string',
                'land_mark' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric'

            ]);

            if ($validator->fails()) {
                return redirect()->route('website.shopkeeper')->withErrors($validator);
            }

            $group = user::find($id);           
            $group->first_name =  $request->get('first_name');
            $group->last_name =  $request->get('last_name');
            /*$group->email =  $request->get('email');
            $group->mobile =  $request->get('mobile');*/
            $group->status =  $request->get('status');
            $group->save();

            $group->id;
            
            $group->password =  $request->get('set_password');

            /* Document image upload start */
                if(!empty($request->set_password))
                {
                    user::where('id', $id)->update(['password' => Hash::make($request->set_password)]); 
                }
                /* Document image upload close */

            $data = [
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'pincode' => $request->pincode,
                'house_no' => $request->house_no,
                'land_mark' => $request->land_mark,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ];

            User_address::where('users_id', $id)->update($data);

            return redirect()->route('website.shopkeeper')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.shopkeeper')->with('error',$e->getMessage());   
        }
    }


    public function delete($id)
    { 
        try {
            User::where('id',$id)->delete();
            return redirect()->route('website.shopkeeper')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.shopkeeper')->with('error',$e->getMessage());   
        }
    }


    public function display($id)
    { 
        try {
            $user_record = user::find($id);

            $product_inventory = Inventory::select('tbl_inventory.*','users.first_name as shopkeeperfirstname','users.last_name as shopkeeperlastname','tbl_product.product_name as productname')
                    ->join('tbl_product', 'tbl_inventory.product_id', '=', 'tbl_product.id')
                    ->join('users', 'tbl_inventory.shopkeeper_id', '=', 'users.id')
                    ->where('users.id',$id)
                    ->get();

            $address_list = User_address::select('tbl_user_address.*',
                            'tbl_master_states.state_name as state_name',
                                    'tbl_master_cities.city_name as city_name')
                    ->join('tbl_master_states', 'tbl_user_address.state_id', '=', 'tbl_master_states.id')
                    ->join('tbl_master_cities', 'tbl_user_address.city_id', '=', 'tbl_master_cities.id')
                    ->where('users_id',$id)->first();

            return view('Website.user.shopkeeper_view',compact('user_record','product_inventory','address_list'));
        }catch (\Exception $e) { 
            return redirect()->route('website.shopkeeper')->with('error',$e->getMessage());   
        }
    }
    
    
}
