<?php

namespace App\Http\Controllers\Website\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
    
use App\User;
use App\Models\Product;
use App\Models\Inventory;

use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;

class InventoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.inventory.inventory');
    }

    public function getdata()
    {
        
        $record = Inventory::select('tbl_inventory.*','tbl_product.product_name as productname','users.first_name as shopkeeperfirstname','users.last_name as shopkeeperlastname')
                    ->join('tbl_product', 'tbl_inventory.product_id', '=', 'tbl_product.id')
                    ->join('users', 'tbl_inventory.shopkeeper_id', '=', 'users.id')
                    ->get();
        foreach ($record as $key => $value) {
            $record[$key]->shopkeeperfullname = $value->shopkeeperfirstname.' '.$value->shopkeeperlastname;
        }
        return datatables()->of($record)->toJson();
    }


    public function create()
    { 
        $shopkeeper = User::select('id','first_name','last_name')->where('role_id',2)->where('status',1)->get();
        $product = Product::select('id','product_name')->where('status',1)->get();
        return view('Website.inventory.inventory_add',compact('shopkeeper','product'));
    }


    public function store(Request $request)
    { 
        
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|int',
                'shopkeeper_id' => 'required|int',
                'total_quantity' => 'required|int',
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.inventory')->withErrors($validator);
            }

            $check = Inventory::where('product_id', $request->product_id)->where('shopkeeper_id',$request->shopkeeper_id)->doesntExist();

            if($check){
                $data = [
                    'product_id' => $request->product_id,
                    'shopkeeper_id' => $request->shopkeeper_id,
                    'total_quantity' => $request->total_quantity,
                    'lost_quantity' => 0,
                    'damage_quantity' => 0,
                    'on_rent_quantity' => 0,
                    'available_quantity' => $request->total_quantity
                ];

                $dataset1 = Inventory::create($data);
                if($dataset1)
                {
                    return redirect()->route('website.inventory')->with('success','Record Insert successfully');
                }else{
                    return redirect()->route('website.inventory')->with('error','Record Not Inserted !!');
                }
            }else{

                $old_record = Inventory::where('product_id', $request->product_id)->where('shopkeeper_id',$request->shopkeeper_id)->first();

                $data = [
                    'total_quantity' => ($old_record->total_quantity + $request->total_quantity),
                    'available_quantity' => ($old_record->available_quantity + $request->total_quantity)
                ];

                $dataset2 = Inventory::where('id',$old_record->id)->update($data);
                if($dataset2)
                {
                    return redirect()->route('website.inventory')->with('warning','Listing already available in our record, we have increase inventory in your old listing');
                }else{
                    return redirect()->route('website.inventory')->with('error','Something went wrong !!');
                }
            }

        }catch (\Exception $e) { 
            return redirect()->route('website.inventory')->with('error',$e->getMessage());   
        }
    }


    public function edit($id)
    { 
        $inventory_record = Inventory::select('tbl_inventory.*','tbl_product.product_name as productname','users.first_name as shopkeeperfirstname','users.last_name as shopkeeperlastname')
                    ->join('tbl_product', 'tbl_inventory.product_id', '=', 'tbl_product.id')
                    ->join('users', 'tbl_inventory.shopkeeper_id', '=', 'users.id')
                    ->where('tbl_inventory.id',$id)
                    ->first();

        return view('Website.inventory.inventory_edit',compact('inventory_record'));
    }


    public function update(Request $request, $id)
    { 
        
        try {

            $validator = Validator::make($request->all(), [
                'status' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.inventory')->withErrors($validator);
            }

            $group = Inventory::find($id);
            $group->status = $request->get('status');
            $group->save();

            return redirect()->route('website.inventory')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.inventory')->with('error',$e->getMessage());   
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
                return redirect()->route('website.inventory')->withErrors($validator);
            }


            $old_record = Inventory::where('id',$id)->first();

            if($request->opration == 1){

                $calculation = $old_record->available_quantity - $request->quantity;
                if($calculation >= 0){

                    $data = [
                        'total_quantity' => $old_record->total_quantity - $request->quantity,
                        'available_quantity' => $old_record->available_quantity - $request->quantity
                    ];

                    $dataset1 = Inventory::where('id',$id)->update($data);
                    if($dataset1)
                    {
                        return redirect()->route('website.inventory')->with('success','Record Update Successfully');
                    }else{
                        return redirect()->route('website.inventory')->with('error','Something went wrong');
                    }
                }else{
                    return redirect()->back()->with('error','Enter Currect Value');
                }
                
            }elseif($request->opration == 2){

                $calculation = $old_record->available_quantity - $request->quantity;
                if($calculation >= 0){

                    $data = [
                        'lost_quantity' => $old_record->lost_quantity + $request->quantity,
                        'available_quantity' => $old_record->available_quantity - $request->quantity
                    ];

                    $dataset1 = Inventory::where('id',$id)->update($data);
                    if($dataset1)
                    {
                        return redirect()->route('website.inventory')->with('success','Record Update Successfully');
                    }else{
                        return redirect()->route('website.inventory')->with('error','Something went wrong');
                    }
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
                    if($dataset1)
                    {
                        return redirect()->route('website.inventory')->with('success','Record Update Successfully');
                    }else{
                        return redirect()->route('website.inventory')->with('error','Something went wrong');
                    }
                }else{
                    return redirect()->back()->with('error','Enter Currect Value');
                }
            }
        }catch (\Exception $e) { 
            return redirect()->back()->with('error',$e->getMessage());   
        }
    }




    public function deleted($id)
    { 
        try {
            Inventory::where('id',$id)->delete();
            return redirect()->route('website.inventory')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.inventory')->with('error',$e->getMessage());
        }
    }


    public function display($id)
    { 
        $inventory_record = Inventory::select('tbl_inventory.*','tbl_product.product_name as productname','users.first_name as shopkeeperfirstname','users.last_name as shopkeeperlastname')
                    ->join('tbl_product', 'tbl_inventory.product_id', '=', 'tbl_product.id')
                    ->join('users', 'tbl_inventory.shopkeeper_id', '=', 'users.id')
                    ->where('tbl_inventory.id',$id)
                    ->first();

        return view('Website.inventory.inventory_view',compact('inventory_record'));
    }

    
}
