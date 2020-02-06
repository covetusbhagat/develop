<?php

namespace App\Http\Controllers\Website\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\Chatsupport;

use Carbon\Carbon;
use Redirect;

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class ChatController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id = '')
    {

        $user_id = Auth::User()->id;
        $admin = user::select('id','first_name','last_name','profile_image')->where('role_id',1)->where('id','!=',$user_id)->where('status',1)->get();
    	$shopkeeper = user::select('id','first_name','last_name','profile_image')->where('role_id',2)->where('id','!=',$user_id)->where('status',1)->get();
    	$customer = user::select('id','first_name','last_name','profile_image')->where('role_id',3)->where('id','!=',$user_id)->where('status',1)->get();
    	$delivery = user::select('id','first_name','last_name','profile_image')->where('role_id',4)->where('id','!=',$user_id)->where('status',1)->get();

    	if(!empty($id) && is_numeric($id)){

  			
    		$user_chat = Chatsupport::select('tbl_chat_support.*',
                                'users.first_name',
                                'users.last_name',
                                'users.profile_image')
                        ->join('users', 'tbl_chat_support.sender_id', '=', 'users.id')
                        ->where(function($query) use ($id,$user_id) {
					          $query->where('tbl_chat_support.sender_id',$id);
					          $query->Where('tbl_chat_support.receiver_id',$user_id);
					      })
                        ->orwhere(function($query) use ($id,$user_id) {
					          $query->where('tbl_chat_support.sender_id',$user_id);
					          $query->Where('tbl_chat_support.receiver_id',$id);
					      })
                        //->limit(20)
                        ->get();
            Chatsupport::where('sender_id',$id)->where('receiver_id',$user_id)->update(['status' => 0]);
            $receiver_detail = user::select('id','first_name','last_name','profile_image')->where('id',$id)->first();

            /*echo "<pre>";
            print_r($user_chat);
            die();*/
    		return view('Website.chat.chat',compact('user_chat','receiver_detail','admin','shopkeeper','customer','delivery'));
    	}else{
    		return view('Website.chat.alluser',compact('admin','shopkeeper','customer','delivery'));
    	}
    }


    public function store(Request $request)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'sender_id' => 'required',
                'receiver_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            $extention="message";
            if($request->attachment){
                    $file_name=$request->attachment->getClientOriginalName();               
                    $extention=$request->file('attachment')->extension();
                    $name=time().'_'.$file_name;
                    //$file_location = Storage::put('chat_media', $request->attachment);
                    $file_location= $request->file('attachment')->storeAs('chat_media', $name);                 
              }
              if(empty($request->message)){
                $message=$file_name;
              }else{
                 $message=$request->message;
              }
            $data = [
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'file_name' =>@$file_name,
                'file_type'=> @$extention,
                'message' =>@$message,
                'file_location'=>@$file_location
            ];
            //$data['file_type'] = "message";
            $dataset = Chatsupport::create($data);
            if($dataset)
            {
                $id = $dataset->id;
                /*send token on mail - close*/                
                return redirect()->back();
            }else{
                return redirect()->back()->with('error','Record Not Inserted !!');
            }
        }catch (\Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());   
        }
    }

    
}
