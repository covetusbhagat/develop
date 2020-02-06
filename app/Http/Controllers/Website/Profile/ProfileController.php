<?php

namespace App\Http\Controllers\Website\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\User;

use App\Models\States;
use App\Models\User_address;

use Carbon\Carbon;
use Session;
use DataTables;

class ProfileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $user_record = user::select('first_name','last_name','doc_image')->where('id',$user_id)->first();
        $state = States::select('state_name','id')->where('country_id',101)->get();
        $address_list = User_address::select('tbl_user_address.*',
                            'tbl_master_states.state_name as state_name',
                                    'tbl_master_cities.city_name as city_name')
                    ->join('tbl_master_states', 'tbl_user_address.state_id', '=', 'tbl_master_states.id')
                    ->join('tbl_master_cities', 'tbl_user_address.city_id', '=', 'tbl_master_cities.id')
                    ->where('users_id',$user_id)->get();

        return view('Website.profile.profile',compact('user_record','state','address_list'));
    }



    public function add_address(Request $request)
    { 

        try {

            $user_id = Auth::user()->id;
            $check = User_address::where('users_id',$user_id)->exists();
            if($check){
                return redirect()->route('website.profile')->with('warning','You can add only one address, if you want to add another address please remove your old Address first');
            }
            $validator = Validator::make($request->all(), [
                'state_id' => 'required|int',
                'city_id' => 'required|int',
                'pincode' => 'required',
                'house_no' => 'required|string',
                'land_mark' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.profile')->withErrors($validator);
            }

            $data = [
                'users_id' => $user_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'pincode' => $request->pincode,
                'house_no' => $request->house_no,
                'land_mark' => $request->land_mark,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ];

            $dataset = User_address::create($data);
            if($dataset)
            {
                return redirect()->route('website.profile')->with('success','Record Insert successfully');
            }else{
                return redirect()->route('website.profile')->with('error','Record Not Inserted !!');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.profile')->with('error',$e->getMessage());   
        }
    }



    public function update(Request $request)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.profile')->withErrors($validator);
            }

            $user_id = Auth::user()->id;           
            $group = User::find($user_id);
            $group->first_name =  $request->get('first_name');
            $group->last_name =  $request->get('last_name');
            $group->save();

            /* Document image upload start */
            if(!empty($request->doc_image))
            {
                $document_image = user::select('doc_image')->where('id',$user_id)->first();
                if(!empty($document_image->doc_image)){
                    Storage::delete('doc_image', $document_image->doc_image);
                }
                $doc_img_name = Storage::put('doc_image', $request->doc_image);
                if($doc_img_name){
                    user::where('id', $user_id)->update(['doc_image' => $doc_img_name]);
                }
            }
            /* Document image upload close */

            /* Document image upload start */
            if(!empty($request->profile_image))
            {

                $pro_image = user::select('profile_image')->where('id',$user_id)->first();
                if(!empty($pro_image->profile_image && $pro_image->profile_image != "pro_image/default.jpeg")){
                    Storage::delete('pro_image', $pro_image->profile_image);
                }
                $pro_img_name = Storage::put('pro_image', $request->profile_image);
                if($pro_img_name){
                    user::where('id', $user_id)->update(['profile_image' => $pro_img_name]);
                    session::put('profile_image', $pro_img_name);
                }
            }
            /* Document image upload close */

            return redirect()->route('website.profile')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.profile')->with('error',$e->getMessage());   
        }
    }



    public function reset_password(Request $request)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.profile')->withErrors($validator);
            }

            $user_id = Auth::user()->id;
            $user = user::where('id',$user_id)->first();
            $check = Hash::check($request->old_password, $user->password);
            if($check){
                $check2 = user::where('id', $user_id)->update(['password'=> Hash::make($request->new_password)]);
                if($check2)
                {
                    return redirect()->route('website.profile')->with('success','Password Update Successfully');
                }else{

                    return redirect()->route('website.profile')->with('error','Something went wrong! Please Try Again');
                }   
            }else{

                return redirect()->route('website.profile')->with('error','Old password Does not match');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.profile')->with('error',$e->getMessage());   
        }
    }


    public function remove_address($id)
    {
        try {
            User_address::where('id',$id)->delete();
            return redirect()->back()->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->back()->with('error',$e->getMessage());   
        }
    }

}
