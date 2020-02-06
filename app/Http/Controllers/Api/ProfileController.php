<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Models\User_address;
use App\Models\Notification;

use App\Models\States;
use App\Models\Cities;

use Carbon\Carbon;
use Validator;
use DB; 

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    
    /**
     * Create user and create token
     *
     */
    public function index()
    {           

        $user_id = Auth::user()->id;
        $user_record = user::where('id',$user_id)->first();
        $user_record->doc_image = (!empty($user_record->doc_image))?url('storage/app').'/'.$user_record->doc_image:'';
        $user_record->profile_image = (!empty($user_record->profile_image))?url('storage/app').'/'.$user_record->profile_image:'';

        $address = User_address::where('users_id', $user_id)->get();
        if(!empty($address)){
            foreach ($address as $key => $value) {
                $state_id = $value->state_id;
                $states = States::where("id",$state_id)->first();
                $value->state_name = $states->state_name;

                $city_id = $value->city_id;
                $cities = Cities::where("id",$city_id)->first();
                $value->city_name = $cities->city_name  ;
            }
        }
        $data['user_record'] = $user_record;
        $data['user_Address'] = $address;

        return response()->json([
            'status'=>'200',
            'message' => 'User profile with address',
            'results'=> $data                    
        ], 200);

    }
    

    public function update_profile(Request $request)
    {           
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'profile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'doc_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{

            $user_id = Auth::user()->id;
            $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name
            ];


            $check = user::where('id',$user_id)->update($data);
            if($check){

                /* Document image upload start */
                if(!empty($request->doc_image))
                {
                    
                    $document_image = user::select('doc_image')->where('id',$user_id)->first();
                    if(!empty($document_image->doc_image)){
                        Storage::delete('doc_image', $document_image->doc_image);
                    }

                    $doc_img_name = Storage::put('doc_image', $request->doc_image);
                    if($doc_img_name){
                       $check = user::where('id', $user_id)->update(['doc_image' => $doc_img_name]);
                    
                       if($check){
                        
                            /*send token on mail - start*/

                        $link = url('customer/display').'/'.$user_id;
                        $message1 = $request->first_name.' '.$request->last_name.' Add New Document';

                            $sender_record = User::select('email')->where('role_id',1)->orwhere('role_id',2)->where('status',1)->get();

                            foreach ($sender_record as $key => $value) {
                                $data['link'] = $request->first_name.' '.$request->last_name;
                                $data['link2'] = $link = url('customer/display').'/'.$user_id;
                                $request->subject = "Customer document verification from RentoTree.";
                                $request->adminemail = 'rentotree@gmail.com';
                                $request->email = $value->email;

                                $result = Mail::send('emails.document_varification',$data, function($message) use ($request) {
                                    $message->from($request->adminemail);
                                    $message->to($request->email);
                                    $message->subject($request->subject);
                                    $message->replyTo($request->adminemail);
                                });

                                Notification::create(['by_id' => $user_id, 'to_id' => $value->id, 'massage' => $message1, 'displaylink' => $link ]);
                            }
                            
                            /*send token on mail - close*/
                            $doc_status = [
                                'doc_aprove_status' => 0,
                                'doc_aprove_by_id' => 0
                            ];
                            user::where('id', $user_id)->update($doc_status);

                       }

                    }
                }
                /* Document image upload close */

                /* Document image upload start */
                if(!empty($request->profile_image))
                {
                    
                    $pro_image = user::select('profile_image')->where('id',$user_id)->first();
                    if(!empty($pro_image->profile_image  && $pro_image->profile_image != "pro_image/default.jpeg")){
                        Storage::delete('pro_image', $pro_image->profile_image);
                    }
                    $pro_img_name = Storage::put('pro_image', $request->profile_image);
                    if($pro_img_name){
                        user::where('id', $user_id)->update(['profile_image' => $pro_img_name]);
                    }
                }
                /* Document image upload close */

                $user_record = user::where('id',$user_id)->first();
                $user_record->doc_image = url('storage/app').'/'.$user_record->doc_image;
                $user_record->profile_image = url('storage/app').'/'.$user_record->profile_image;   

                return response()->json([
                    'status'=>'200',
                    'message' => 'Profile Update Successfully',
                    'results'=> $user_record                  
                ], 200);

            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong! Please Try Again',
                    'results' => array()
                ], 200); 
            }
        }
    }


    public function get_states()
    {           

        $states = States::select('id','state_name')->where('country_id', 101)->get();
        return response()->json([
            'status'=>'200',
            'message' => 'All state of india',
            'results'=> $states                    
        ], 200);
    }


    public function get_city_by_state(Request $request)
    {           
        $validator = Validator::make($request->all(), [
            'state_id' => 'required|int'
        ]);
        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            
            $cities = Cities::select('id','city_name','state_id')->where('state_id', $request->state_id)->get();
            return response()->json([
                'status'=>'200',
                'message' => 'All cities of states',
                'results'=> $cities
            ], 200);
        }
    }

    public function add_address(Request $request)
    {           
        $validator = Validator::make($request->all(), [
            'house_no' => 'required|string',
            //'land_mark' => 'required',
            'state_id' => 'required|int',
            'city_id' => 'required|int',
            'pincode' => 'required|numeric',
            //'latitude' => 'required',
            //'longitude' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = Auth::user()->id;
            
            $data = [
                'users_id' => $user_id,
                'house_no' => $request->house_no,
                'land_mark' => $request->land_mark,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'pincode' => $request->pincode,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ];

            $check = User_address::create($data);
            if($check){
                return response()->json([
                    'status'=>'200',
                    'message' => 'Address Add Successfully',
                    'results'=> array()                    
                ], 200);

            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong! Please Try Again',
                    'results' => array()
                ], 200); 
            }
        }
    }


    public function remove_address(Request $request)
    {           
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|int',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = Auth::user()->id;

            $data = User_address::where('users_id',$user_id)->where('id',$request->address_id)->first();
            if(!empty($data)){

                $check = User_address::where('id',$request->address_id)->delete();
                if($check){
                    return response()->json([
                        'status'=>'200',
                        'message' => 'Address Delete Successfully',
                        'results'=> array()                    
                    ], 200);
                }else{
                    return response()->json([
                        'status' => '400',
                        'message' => 'Something went wrong! Please Try Again',
                        'results' => array()
                    ], 200); 
                }
            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong! Please Try Again',
                    'results' => array()
                ], 200); 
            }
        }
    }

    public function change_password(Request $request)
    {           
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{

            $user_id = Auth::user()->id;
            $user = user::where('id',$user_id)->first();
            $check = Hash::check($request->old_password, $user->password);
            if($check){
                $check2 = user::where('id', $user_id)->update(['password'=> Hash::make($request->new_password)]);
                if($check2)
                {
                    return response()->json([
                        'status'=>'200',
                        'message' => 'Password Update Successfully',
                        'results'=> array()                    
                    ], 200);
                }else{
                    return response()->json([
                        'status' => '400',
                        'message' => 'Something went wrong! Please Try Again',
                        'results' => array()
                    ], 200);
                }   
            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Old password Does not match',
                    'results' => array()
                ], 200);
            } 
        }
    }



    public function city_by_state($id)
    {           
        
        $city = DB::table("tbl_master_cities")->where('state_id',$id)->pluck("city_name","id");
        return response()->json($city);
    }
}