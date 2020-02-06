<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Referral_allot_user;
use App\Models\Coupon;

use Carbon\Carbon;
use Validator;

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class CouponController extends Controller
{
    
    public function index()
    {
        echo otp_genrater(0);
        die();
    }       

    /**
     * Create user and create token
     *
     */
    public function all_active_coupon()
    {           
        
        $user_id = Auth::user()->id;
        $current_date = Carbon::now()->toDateString();
        $coupon['discount'] = Coupon::where('end_date', '>=', $current_date)
                            ->where('start_date', '<=', $current_date)
                            ->where('status', 1)
                            ->get();

        $coupon['referral'] = Referral_allot_user::where('expired_at', '>=', '$current_date')
                            ->where('user_id', $user_id)
                            ->where('status', 1)
                            ->get();

        /*$user_record = user::where('id',$user_id)->get();*/

        return response()->json([
            'status'=>'200',
            'message' => 'All Coupon Code.',
            'results'=> $coupon                    
        ], 200);
    }
    


    public function apply_coupon(Request $request)
    {           
        $validator = Validator::make($request->all(), [
            'coupon' => 'required|numeric',         
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{

            

        }
    }
}