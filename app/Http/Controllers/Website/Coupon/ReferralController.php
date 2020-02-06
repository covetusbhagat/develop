<?php

namespace App\Http\Controllers\Website\Coupon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Referral;

use App\User;
use Carbon\Carbon;
use Session;
use DataTables;

class ReferralController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.coupon.referral');
    }

    public function getData()
    { 
        $record = Referral::select()->where('status',1)->get();
        return datatables()->of($record)->toJson();
    }


    public function edit($id)
    { 
        $referral_record = Referral::find($id);
        return view('Website.coupon.referral_edit',compact('referral_record'));
    }


    public function update(Request $request, $id)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'referral_code' => 'required',
                'referral_percentage' => 'required|numeric',
                'use_days' => 'required|numeric',
                'maximum_limit' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.referral')->withErrors($validator);
            }

            $group = Referral::find($id);           
            $group->referral_code =  $request->get('referral_code');
            $group->referral_percentage =  $request->get('referral_percentage');
            $group->use_days =  $request->get('use_days');
            $group->maximum_limit =  $request->get('maximum_limit');
            $group->save();

            return redirect()->route('website.referral')->with('success','Record Update successfully');
        } catch (\Exception $e) { 
            
            return redirect()->route('website.referral')->with('error',$e->getMessage());

        }
    }

    
    
}
