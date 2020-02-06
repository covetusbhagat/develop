<?php

namespace App\Http\Controllers\Website\Coupon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Coupon;

use App\User;
use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;

use Illuminate\Support\Facades\Mail;

class DiscountController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.coupon.discount');
    }

    public function getrecord()
    { 

        $record = Coupon::select()->where('status',1)->get();
        return datatables()->of($record)->toJson();
    }


    public function create()
    { 
        return view('Website.coupon.discount_add');
    }


    public function store(Request $request)
    { 
        try {
            
            $validator = Validator::make($request->all(), [
                'coupon_code' => 'required|unique:tbl_coupon',
                'coupon_uses_time' => 'required|numeric',
                'start_date' => 'required',
                'end_date' => 'required',
                'coupon_percentage' => 'required|numeric',
                'maximum_limit' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                //return redirect()->route('website.discount')->withErrors($validator);
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = [
                'coupon_code' => $request->coupon_code,
                'coupon_uses_time' => $request->coupon_uses_time,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'coupon_percentage' => $request->coupon_percentage,
                'maximum_limit' => $request->maximum_limit
            ];

            $dataset = Coupon::create($data);
            if($dataset)
            {

                $user_record =  User::select('email')->where('role_id',3)->where('status',1)->get();
                foreach ($user_record as $key => $value) {
                
                    $data['coupon_code'] = $request->coupon_code;
                    $data['coupon_uses_time'] = $request->coupon_uses_time;
                    $data['start_date'] = Carbon::parse($request->start_date)->format('d/m/Y');
                    $data['end_date'] = Carbon::parse($request->end_date)->format('d/m/Y');
                    $data['coupon_percentage'] = $request->coupon_percentage;
                    $data['maximum_limit'] = $request->maximum_limit;
                    $request->subject = "Information about New offer from RentoTree.";
                    $request->adminemail = 'rentotree@gmail.com';
                    $request->email = $value->email;

                    $result = Mail::send('emails.info_offer',$data, function($message) use ($request) {
                        $message->from($request->adminemail);
                        $message->to($request->email);
                        $message->subject($request->subject);
                        $message->replyTo($request->adminemail);
                    });

                }

                /*send token on mail - close*/
                return redirect()->route('website.discount')->with('success','Record Insert successfully');
            }else{
                return redirect()->route('website.discount')->with('error','Record Not Inserted !!');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.discount')->with('error',$e->getMessage());   
        }   
    }


    public function edit($id)
    { 
        $discount_record = Coupon::find($id);
        return view('Website.coupon.discount_edit',compact('discount_record'));
    }


    public function update(Request $request, $id)
    { 
        try {

            $validator = Validator::make($request->all(), [
                /*'coupon_code' => 'required|unique:tbl_coupon',*/
                /*'coupon_uses_time' => 'required|numeric',*/
                'start_date' => 'required',
                'end_date' => 'required',
                /*'coupon_percentage' => 'required|numeric',
                'maximum_limit' => 'required|numeric',*/
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.discount')->withErrors($validator);
            }



            if($request->start_date > $request->end_date){

                return redirect()->route('website.discount')->with('error','End date can not beyond start date');
            }

            $group = Coupon::find($id);           
            /*$group->coupon_code =  $request->get('coupon_code');
            $group->coupon_uses_time =  $request->get('coupon_uses_time');*/
            $group->start_date =  $request->get('start_date');
            $group->end_date =  $request->get('end_date');
            /*$group->coupon_percentage =  $request->get('coupon_percentage');
            $group->maximum_limit =  $request->get('maximum_limit');*/
            $group->save();

            return redirect()->route('website.discount')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.discount')->with('error',$e->getMessage());   
        } 
    }


    public function deleted($id)
    { 
        try {
            Coupon::where('id',$id)->delete();
            return redirect()->route('website.discount')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.discount')->with('error',$e->getMessage());   
        }
    }
    
}