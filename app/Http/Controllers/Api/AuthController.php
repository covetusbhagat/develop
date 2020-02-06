<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

use App\User;
use App\Models\Referral;
use App\Models\Notification;
use App\Models\Referral_allot_user;

use Carbon\Carbon;
use Validator;

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    
    public function index()
    {
        echo otp_genrater(0);
        die();
    }       

    /**
     * Create user and create token
     *
     * @param  [string] first_name
     * @param  [string] last_name
     * @param  [string] email
     * @param  [number] mobile
     * @param  [string] password
     * @param  [file] doc_image
     * @return [string] message
     */
    

    public function signup(Request $request)
    {        
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'mobile' => 'required|numeric|unique:users',
            'password' => 'required|string',
            'doc_image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200); 
        }else{
            $user = new User([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'email_token' => otp_genrater(4),
                'mobile_token' => otp_genrater(4),
                'role_id' => 3,
                'friend_referral_code' => (!empty($request->friend_referral_code))?$request->friend_referral_code:""
            ]);
            $user->save();
            $mobile_no = $request->mobile; 
            /* Document image upload start */
            if(!empty($request->doc_image))
            {
                $img_name = Storage::put('doc_image', $request->doc_image);
                if($img_name){
                    user::where('id', $user->id)->update(['doc_image' => $img_name]);
                }
            }
            /* Document image upload close */
            /*send token on mail - start*/
            
            $mobile_message = 'hello '.$request->first_name.' '.$request->last_name.' Welcome To Tentotree. Your mobile verification OTP is '.$user->mobile_token;
            send_sms($mobile_no,$mobile_message);

            $data['link'] = $user->email_token;
            //$data['link2'] = $user->mobile_token;
            $request->subject = "Confirmed your acount from RentoTree.";
            $request->adminemail = 'eriplphp@gmail.com';

            $result = Mail::send('emails.confirmed_account',$data, function($message) use ($request) {
                $message->from($request->adminemail);
                $message->to($request->email);
                $message->subject($request->subject);
                $message->replyTo($request->adminemail);
            });
            /*send token on mail - close*/

            /*Automatic login after registration - start*/

            $credentials = [
                'mobile' => $request->mobile, 
                'password' => $request->password
            ];

            if(Auth::attempt($credentials)){
                $user = Auth::user();
                $result = user::where('id',$user->id)->first(); 


                $result->doc_image = (!empty($result->doc_image))?url('storage/app').'/'.$result->doc_image:'';
                $result->profile_image = (!empty($result->profile_image))?url('storage/app').'/'.$result->profile_image:'';

                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                $token->save();

                $result->access_token = 'Bearer '.$tokenResult->accessToken;
                
                return response()->json([
                    'status'=>'200',
                    'message' => 'Successfully created user and check your email for active your account!',
                    'results'=> $result
                ], 200);
            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong! Please Try Again',
                    'results' => array()
                ], 200); 
            }
            

            /*if(count(Mail::failures()) <1){                
                return response()->json([
                    'status'=>'200',
                    'message' => 'Successfully created user and check your email for active your account!',
                    'results'=>array()
                ], 200);  
            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong!',
                    'results' => array()
                ], 200); 
            }*/   
        }
    }

    public function resent_email_otp(Request $request)
    {           
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200); 
        }else{
            
            $record = user::select('id','email')->where('email', $request->email)->first();
            if($record){

                $check = user::where('id',$record->id)->update(['email_token' => otp_genrater(4)]);

                if($check){

                    $user = user::select('email_token','email')->where('id',$record->id)->first();
                    $result1 = [
                        'email' => $user->email, 
                        'email_token' => $user->email_token
                    ];

                    /*send token on mail - start*/
                    $data['link'] = $user->email_token;
                    $data['link2'] = '';
                    $request->subject = "resend email OTP for your acount from RentoTree.";
                    $request->adminemail = 'eriplphp@gmail.com';
                    $result = Mail::send('emails.confirmed_account',$data, function($message) use ($request) {
                        $message->from($request->adminemail);
                        $message->to($request->email);
                        $message->subject($request->subject);
                        $message->replyTo($request->adminemail);
                    });
                    /*send token on mail - close*/
                    return response()->json([
                        'status'=>'200',
                        'message' => 'OTP resend Successfully please check your email for active your account!',
                        'results'=> $result1
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
                    'message' => 'Email Not Register With us',
                    'results' => array()
                ], 200);
            }
        }
    }


    public function resent_mobile_otp(Request $request)
    {           
        
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200); 
        }else{
            
            $record = user::select('id','mobile')->where('mobile', $request->mobile)->first();
            if($record){

                $check = user::where('id',$record->id)->update(['mobile_token' => otp_genrater(4)]);

                if($check){

                    $user = user::select('mobile_token','mobile')->where('id',$record->id)->first();
                    $result = [
                        'mobile' => $user->mobile,
                        'mobile_token' => $user->mobile_token
                    ];

                    return response()->json([
                        'status'=>'200',
                        'message' => 'OTP resend Successfully please check your SMS for active your account!',
                        'results'=> $result
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
                    'message' => 'Mobile Not Register With us',
                    'results' => array()
                ], 200);
            }
        }
    }


    
    public function confirmed_user_account(Request $request)
    {           
        $validator = Validator::make($request->all(), [
            'mobile_otp' => 'required|numeric',         
            'email_otp' => 'required|numeric'         
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{

            $user_id = Auth::user()->id;
            $user_record = user::select('email_token','mobile_token','mobile','friend_referral_code','email_verify_status','mobile_verify_status')->where('id',$user_id)->first();

            if(($user_record->email_verify_status != 1) && ($user_record->mobile_verify_status != 1)){
                if(($user_record->email_token == $request->email_otp) && ($user_record->mobile_token == $request->mobile_otp)){

                    $data = [
                        'email_verify_status' => 1, 
                        'mobile_verify_status' => 1, 
                        'email_verified_at' => Carbon::now(), 
                        'mobile_verified_at' => Carbon::now(),
                        'my_referral_code' => base64_encode($user_record->mobile)
                    ];

                    $check = user::where('id', $user_id)->update($data);
                    $user_data = user::where('id',$user_id)->first();
                    // $user_data->doc_image = url('storage/app').'/'.$user_data->doc_image;
                    $user_data->doc_image = (!empty($user_data->doc_image))?url('storage/app').'/'.$user_data->doc_image:'';
                    $user_data->profile_image = (!empty($user_data->profile_image))?url('storage/app').'/'.$user_data->profile_image:'';        

                    if($check){

                        /* Add referral - start*/
                        $friend_user_id = user::select('id')->where('my_referral_code',$user_record->friend_referral_code)->first();
                        if(!empty($friend_user_id)){

                            $current_referral_condation = Referral::where('status',1)->first();
                            if(!empty($current_referral_condation)){
                                $Referral_data_friend = [
                                    'referral_code' => $current_referral_condation->referral_code,
                                    'user_id' => $friend_user_id->id,
                                    'referral_percentage' => $current_referral_condation->referral_percentage,
                                    'expired_at' => Carbon::now()->add($current_referral_condation->use_days, 'day'),
                                    'maximum_limit' => $current_referral_condation->maximum_limit
                                ];
                                Referral_allot_user::create($Referral_data_friend);
                                $Referral_data_self = [
                                    'referral_code' => $current_referral_condation->referral_code,
                                    'user_id' => $user_id,
                                    'referral_percentage' => $current_referral_condation->referral_percentage,
                                    'expired_at' => Carbon::now()->add($current_referral_condation->use_days, 'day'),
                                    'maximum_limit' => $current_referral_condation->maximum_limit
                                ];
                                Referral_allot_user::create($Referral_data_self);
                            }
                        }
                        /* Add referral - close*/
                        $link = url('customer/display').'/'.$user_data->id;
                        $message = $user_data->first_name.' '.$user_data->last_name.' New Customer Add';

                        /*send token on mail - start*/

                            $sender_record = User::select('email','id')->where('role_id',1)->orwhere('role_id',2)->where('status',1)->get();

                            

                            foreach ($sender_record as $key => $value) {

                                if($user_data->doc_image != ""){


                                    $data['link'] = $request->first_name.' '.$request->last_name;
                                    $data['link2'] = $link = url('customer/display').'/'.$user_id;;
                                    $request->subject = "Customer document verification from RentoTree.";
                                    $request->adminemail = 'eriplphp@gmail.com';
                                    $request->email = $value->email;

                                    $result = Mail::send('emails.document_varification',$data, function($message) use ($request) {
                                        $message->from($request->adminemail);
                                        $message->to($request->email);
                                        $message->subject($request->subject);
                                        $message->replyTo($request->adminemail);
                                    });

                                }

                                Notification::create(['by_id' => $user_id, 'to_id' => $value->id, 'massage' => $message, 'displaylink' => $link ]);
                            }

                        return response()->json([
                            'status'=>'200',
                            'message' => 'Successfully confirm and active your account!',
                            'results'=> $user_data
                        ], 200);

                    }else{
                        return response()->json([
                            'status'=>'400',
                            'message' => 'Something went wrong!',
                            'results'=>array()
                        ], 200);  
                    }
                }else{
                    return response()->json([
                        'status'=>'400',
                        'message' => 'Please Enter Right OTP',
                        'results'=>array()
                    ], 200);
                }
            }else{
                return response()->json([
                    'status'=>'400',
                    'message' => 'Email and Mobile Already Verified',
                    'results'=>array()
                ], 200);
            }
        }
    }

  
    /**
     * Login user
     *
     * @param  [string] username
     * @param  [string] password
     */
    public function login(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string'  
        ]);

        //'device_token' => 'required',

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200); 
        }else{

            if(is_numeric($request->get('username')))
            {
                $credentials = [                    
                    'mobile' => $request->username, 
                    'password' => $request->password
                ];
            }else{
                $credentials = [
                    'email' => $request->username, 
                    'password' => $request->password
                ];
            }

            if(!Auth::attempt($credentials)){
                return response()->json([
                    'status'=>'400',
                    'message' => 'Please enter valid email and password!',
                    'results'=>array()
                ], 200);
            }else{

                $user = Auth::user();     
                if($user->status == 0){
                    return response()->json([
                        'status'=>'400',
                        'message' => 'Your account has been Deactivated.',
                        'results'=>array()                    
                    ], 200);
                    
                }else{
                    $tokenResult = $user->createToken('Personal Access Token');
                    $token = $tokenResult->token; 
                    $token->save();

                    $result = user::where('id',$user->id)->first();
                    $result->device_token = $request->device_token;
                        $result->save();

                    $result->doc_image = (!empty($result->doc_image))?url('storage/app').'/'.$result->doc_image:'';
                    $result->profile_image = (!empty($result->profile_image))?url('storage/app').'/'.$result->profile_image:'';    

                    $result->access_token = 'Bearer '.$tokenResult->accessToken;

                    if(($user->email_verify_status != 1) && ($user->mobile_verify_status != 1)){
                        return response()->json([
                            'status'=>'204',
                            'message' => 'Please verify your Mobile number and Email',
                            'results'=>$result                
                        ], 200);
                    }else{

                        return response()->json([
                            'status'=>'200',
                            'message' => 'Login Successfully.',
                            'results'=>$result                    
                        ], 200);
                    }
                }
            }
        }
    }

  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $a = $request->user()->token()->revoke();       
        if($a){
            return response()->json([
                'status'=>'200',
                'message' => 'Successfully logged out',
                'results'=>array()       
            ], 200);   
        }else{
            return response()->json([
                'status'=>'400',
                'message' => 'Please login.',
                'results'=>array()       
            ], 200);   
        }      
    }


  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user()
    {

        $user_id = Auth::user()->id;
        $user_record = user::where('id',$user_id)->get();

        return response()->json([
            'status'=>'200',
            'message' => 'User Current Status.',
            'results'=> $user_record                    
        ], 200);        
    }



    public function forget_password(Request $request)
    {           
        $validator = Validator::make($request->all(), [
            'username' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);  
        }else{ 

            $user_res = User::where('email', $request->username)->orwhere('mobile', $request->username)->where('status',1)->first();
            if(!empty($user_res)){
                
                /*send mail*/
                $user_id = ($user_res->id);

                $remember_token = md5(otp_genrater(9));
                user::where('id',$user_id)->update(['remember_token' => $remember_token]);
                $data['link'] = url('/reset_password').'?code='.$remember_token;
                $request->email = $user_res->email;
                $request->subject = "Forget Password from RentroTree.";               
                $result = Mail::send('emails.forget_password',$data, function($message) use ($request) {
                        $message->from('eriplphp@gmail.com');
                        $message->to($request->email);
                        $message->subject($request->subject);
                        $message->replyTo($request->email);
                    }
                );
               
                if(count(Mail::failures()) <1){
                    
                    return response()->json([
                        'status'=>'200',
                        'message' => ('Please check your Mail account for reset new password.'),
                        'results'=>array()       
                    ], 200);

                }else{
                    return response()->json([
                        'status'=>'400',
                        'message' => ('Something went wrong.'),
                        'results'=>array()       
                    ], 200);
                }
            }else{
                 
                return response()->json([
                    'status'=>'400',
                    'message' => ('invalid Email-id or Mobile Number.'),
                    'results'=>array()       
                ], 200);
            }
        }
       
    }

    
   

}