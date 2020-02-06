<?php

namespace App\Http\Controllers\Website\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Warehouse;
use Redirect;
use DataTables;

class WarehouseController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.warehouse.warehouse');
    }

    public function getData()
    { 
        $record = Warehouse::select()->get();
        return datatables()->of($record)->toJson();
    }


    public function create()
    { 
        return view('Website.warehouse.warehouse_add');
    }


    public function store(Request $request)
    { 
        try {
            $validator = Validator::make($request->all(), [
                'warehouse_name' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $check = Warehouse::create(['warehouse_name' => $request->warehouse_name]);
            if($check)
            {   
                return redirect()->route('website.warehouse')->with('success','Record Insert successfully');
            }else{
                return redirect()->route('website.warehouse')->with('error','Record Not Inserted !!');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.warehouse')->with('error',$e->getMessage());   
        }
    }


    public function edit($id)
    { 
        $warehouse_record = Warehouse::find($id);
        return view('Website.warehouse.warehouse_edit',compact('warehouse_record'));
    }


    public function update(Request $request, $id)
    { 
        try {
            $group = Warehouse::find($id);
            $group->status = $request->get('warehouse_name');           
            $group->status = $request->get('status');
            $group->save();

            return redirect()->route('website.warehouse')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.warehouse')->with('error',$e->getMessage());   
        }
    }


    public function deleted($id)
    { 
        try {
            Warehouse::where('id',$id)->delete();
            return redirect()->route('website.warehouse')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.warehouse')->with('error',$e->getMessage());   
        }
    }

    
}
