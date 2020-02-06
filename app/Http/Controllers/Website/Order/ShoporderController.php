<?php

namespace App\Http\Controllers\Website\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Models\Order;
use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class ShoporderController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.shoporder.shoporder');
    }

    public function getData()
    { 
        $user_id = Auth::user()->id;
        $order = Order::select('tbl_order.*',
                                'tbl_product.product_name as ProductName',
                                'users.doc_aprove_status as doc_aprove_status',
                                'users.first_name as customerFirstname',
                                'users.last_name as customerLastname')
                ->join('users', 'tbl_order.user_id', '=', 'users.id')
                ->join('tbl_product', 'tbl_order.product_id', '=', 'tbl_product.id')
                ->where('tbl_order.shopkeeper_id',$user_id)
                ->get();

        foreach ($order as $key => $value) {
            $order[$key]->Customerfullname = $value->customerFirstname.' '.$value->customerLastname;
            $order[$key]->delivery_type_status = ($value->delivery_type == 1)? "by delivery boy" : "self on shop";
            $order[$key]->doc_aprove = ($value->doc_aprove_status == 1)? "YES" : "NO";
        }
        return datatables()->of($order)->toJson();
    }


    public function start($id)
    { 
        $order_detail = Order::find($id);
        return view('Website.shoporder.shoporder_start',compact('order_detail'));
    }


    public function delivery_process(Request $request, $id)
    { 
        try {

            $user_id = Auth::user()->id;
            $validator = Validator::make($request->all(), [
                'order_otp' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.shoporder')->withErrors($validator);
            }

            $order_record = Order::select('tbl_order.*',
                                            'users.doc_aprove_status as doc_aprove_status')
                            ->join('users', 'tbl_order.user_id', '=', 'users.id')
                            ->where('tbl_order.id',$id)
                            ->where('tbl_order.shopkeeper_id',$user_id)
                            ->first();

            if($order_record->doc_aprove_status){

                if($order_record->delivery_otp == $request->order_otp){

                    echo "OK";
                    die();

                }else{
                    return redirect()->back()->with('error','Delivery OTP dose not match');
                }
            }else{
                return redirect()->route('website.shoporder')->with('error','Please Verify Document First !!');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.shoporder')->with('error',$e->getMessage());   
        }
    }

    public function display($id)
    { 
        try {

            /*$order_record = Order::find($id);*/
            
            $user_id = Auth::user()->id;
            $order = Order::select('tbl_order.*',
                                'tbl_product.product_name as ProductName',
                                'users.doc_aprove_status as doc_aprove_status',
                                'users.first_name as customerFirstname',
                                'users.last_name as customerLastname')
                ->join('users', 'tbl_order.user_id', '=', 'users.id')
                ->join('tbl_product', 'tbl_order.product_id', '=', 'tbl_product.id')
                ->where('tbl_order.id',$id)
                ->where('tbl_order.shopkeeper_id',$user_id)
                ->first();

            $order->Customerfullname = $order->customerFirstname.' '.$order->customerLastname;
            $order->delivery_type_status = ($order->delivery_type == 1)? "by delivery boy" : "self on shop";
            $order->doc_aprove = ($order->doc_aprove_status == 1)? "YES" : "NO";

            return view('Website.shoporder.shoporder_view',compact('order'));
        }catch (\Exception $e) { 
            return redirect()->route('website.shoporder')->with('error',$e->getMessage());   
        }
    }

    
}
