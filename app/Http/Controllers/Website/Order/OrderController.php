<?php

namespace App\Http\Controllers\Website\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\Order;
use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.order.order');
    }

    public function getData()
    { 
        
        $order = Order::select('tbl_order.*',
                                'tbl_product.product_name as ProductName',
                                'users.doc_aprove_status as doc_aprove_status',
                                'users.first_name as customerFirstname',
                                'users.last_name as customerLastname')
                ->join('users', 'tbl_order.user_id', '=', 'users.id')
                ->join('tbl_product', 'tbl_order.product_id', '=', 'tbl_product.id')
                ->get();

        foreach ($order as $key => $value) {
            $order[$key]->Customerfullname = $value->customerFirstname.' '.$value->customerLastname;
            $order[$key]->delivery_type_status = ($value->delivery_type == 1)? "by delivery boy" : "self on shop";
            $order[$key]->doc_aprove = ($value->doc_aprove_status == 1)? "YES" : "NO";
        }
        return datatables()->of($order)->toJson();
    }


    public function deleted($id)
    { 
        try {
            Order::where('id',$id)->delete();
            return redirect()->route('website.order')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.order')->with('error',$e->getMessage());   
        }
    }


    public function display($id)
    { 
        try {

            /*$order_record = Order::find($id);*/
            
            $order = Order::select('tbl_order.*',
                                'tbl_product.product_name as ProductName',
                                'users.doc_aprove_status as doc_aprove_status',
                                'users.first_name as customerFirstname',
                                'users.last_name as customerLastname',
                                'usr.first_name as shopkeeperFirstname',
                                'usr.last_name as shopkeeperLastname')
                ->join('users', 'tbl_order.user_id', '=', 'users.id')
                ->join('users as usr', 'tbl_order.shopkeeper_id', '=', 'usr.id')
                ->join('tbl_product', 'tbl_order.product_id', '=', 'tbl_product.id')
                ->where('tbl_order.id',$id)
                ->first();

            $order->Customerfullname = $order->customerFirstname.' '.$order->customerLastname;
            $order->Shopkeeperfullname = $order->shopkeeperFirstname.' '.$order->shopkeeperLastname;
            $order->delivery_type_status = ($order->delivery_type == 1)? "by delivery boy" : "self on shop";
            $order->doc_aprove = ($order->doc_aprove_status == 1)? "YES" : "NO";

            return view('Website.order.order_view',compact('order'));
        }catch (\Exception $e) { 
            return redirect()->route('website.order')->with('error',$e->getMessage());   
        }
    }

    
}
