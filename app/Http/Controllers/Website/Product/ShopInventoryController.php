<?php

namespace App\Http\Controllers\Website\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
    
use App\User;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Notification;

use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;

class ShopInventoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.shopinventory.shopinventory');
    }

    public function getdata()
    { 
        $user_id = Auth::user()->id;
        $record = Inventory::select('tbl_inventory.*','tbl_product.product_name as productname','users.first_name as shopkeeperfirstname','users.last_name as shopkeeperlastname')
                    ->join('tbl_product', 'tbl_inventory.product_id', '=', 'tbl_product.id')
                    ->join('users', 'tbl_inventory.shopkeeper_id', '=', 'users.id')
                    ->where('tbl_inventory.shopkeeper_id',$user_id)
                    ->get();
        foreach ($record as $key => $value) {
            $record[$key]->shopkeeperfullname = $value->shopkeeperfirstname.' '.$value->shopkeeperlastname;
        }
        return datatables()->of($record)->toJson();
    }


    public function create()
    { 
        $product = Product::select('id','product_name')->where('status',1)->get();
        return view('Website.shopinventory.shopinventory_add',compact('product'));
    }


    public function store(Request $request)
    { 
        
        $user_id = Auth::user()->id;
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|int',
                'total_quantity' => 'required|int',
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.shopinventory')->withErrors($validator);
            }

            $check = Inventory::where('product_id', $request->product_id)->where('shopkeeper_id',$user_id)->doesntExist();

            if($check){
                $data = [
                    'product_id' => $request->product_id,
                    'shopkeeper_id' => $user_id,
                    'total_quantity' => $request->total_quantity,
                    'lost_quantity' => 0,
                    'damage_quantity' => 0,
                    'on_rent_quantity' => 0,
                    'available_quantity' => $request->total_quantity
                ];

                $dataset1 = Inventory::create($data);
                if($dataset1)
                {
                    return redirect()->route('website.shopinventory')->with('success','Record Insert successfully');
                }else{
                    return redirect()->route('website.shopinventory')->with('error','Record Not Inserted !!');
                }
            }else{

                $old_record = Inventory::where('product_id', $request->product_id)->where('shopkeeper_id',$user_id)->first();

                $data = [
                    'total_quantity' => ($old_record->total_quantity + $request->total_quantity),
                    'available_quantity' => ($old_record->available_quantity + $request->total_quantity)
                ];

                $dataset2 = Inventory::where('id',$old_record->id)->update($data);
                if($dataset2)
                {
                    return redirect()->route('website.shopinventory')->with('warning','Listing already available in our record, we have increase inventory in your old listing');
                }else{
                    return redirect()->route('website.shopinventory')->with('error','Something went wrong !!');
                }
            }

        }catch (\Exception $e) { 
            return redirect()->route('website.shopinventory')->with('error',$e->getMessage());   
        }
    }


    public function edit($id)
    { 
        $inventory_record = Inventory::select('tbl_inventory.*','tbl_product.product_name as productname','users.first_name as shopkeeperfirstname','users.last_name as shopkeeperlastname')
                    ->join('tbl_product', 'tbl_inventory.product_id', '=', 'tbl_product.id')
                    ->join('users', 'tbl_inventory.shopkeeper_id', '=', 'users.id')
                    ->where('tbl_inventory.id',$id)
                    ->first();

        return view('Website.shopinventory.shopinventory_edit',compact('inventory_record'));
    }


    public function update(Request $request, $id)
    { 

        /* add condation it's update on his entry*/
        
        try {

            $validator = Validator::make($request->all(), [
                'status' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.shopinventory')->withErrors($validator);
            }

            $group = Inventory::find($id);
            $group->status = $request->get('status');
            $group->save();

            return redirect()->route('website.shopinventory')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.shopinventory')->with('error',$e->getMessage());   
        }

    }



    public function update_quantity(Request $request, $id)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'quantity' => 'required|int',
                'opration' => 'required|int'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.shopinventory')->withErrors($validator);
            }

            $old_record = Inventory::where('id',$id)->first();

            if($request->opration == 2){

                $calculation = $old_record->available_quantity - $request->quantity;
                if($calculation >= 0){

                    $data = [
                        'lost_quantity' => $old_record->lost_quantity + $request->quantity,
                        'available_quantity' => $old_record->available_quantity - $request->quantity
                    ];

                    $dataset1 = Inventory::where('id',$id)->update($data);
                }else{
                    return redirect()->back()->with('error','Enter Currect Value');
                }

            }elseif($request->opration == 3){

                $calculation = $old_record->available_quantity - $request->quantity;
                if($calculation >= 0){

                    $data = [
                        'damage_quantity' => $old_record->damage_quantity + $request->quantity,
                        'available_quantity' => $old_record->available_quantity - $request->quantity
                    ];

                    $dataset1 = Inventory::where('id',$id)->update($data);
                    
                }else{
                    return redirect()->back()->with('error','Enter Currect Value');
                }
            }


            if($dataset1)
            {

                $new_record = Inventory::select('tbl_inventory.*','tbl_product.product_name as product_name')->join('tbl_product', 'tbl_inventory.product_id', '=', 'tbl_product.id')->where('tbl_inventory.id',$id)->first();
                
                 if($new_record->available_quantity < 5){
                    

                    $link = url('shopinventory/display').'/'.$new_record->id;
                    $message = $new_record->product_name.' Inventory Short';
                    Notification::create(['by_id' => $new_record->shopkeeper_id, 'to_id' => $new_record->shopkeeper_id, 'massage' => $message, 'displaylink' => $link ]);
                }

                return redirect()->route('website.shopinventory')->with('success','Record Update Successfully');
            }else{
                return redirect()->route('website.shopinventory')->with('error','Something went wrong');
            }
        }catch (\Exception $e) { 
            return redirect()->back()->with('error',$e->getMessage());   
        }
    }


    public function display($id)
    { 
        $inventory_record = Inventory::select('tbl_inventory.*','tbl_product.product_name as productname','users.first_name as shopkeeperfirstname','users.last_name as shopkeeperlastname')
                    ->join('tbl_product', 'tbl_inventory.product_id', '=', 'tbl_product.id')
                    ->join('users', 'tbl_inventory.shopkeeper_id', '=', 'users.id')
                    ->where('tbl_inventory.id',$id)
                    ->first();

        return view('Website.shopinventory.shopinventory_view',compact('inventory_record'));
    }

    
}
