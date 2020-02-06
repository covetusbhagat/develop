<?php

namespace App\Http\Controllers\Website\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Inventory;

use App\User;
use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;


class ProductController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        

        return view('Website.product.product');

    }

    public function getrecord()
    { 
        $record = Product::select('tbl_product.id as productId',
                                    'tbl_product.created_by_user_id as createuserId',
                                    'tbl_product.category_id as categoryId',
                                    'tbl_product.subcategory_id as subcategoryId',
                                    'tbl_product.product_name as productname',
                                    'tbl_product.brand as productbrand',
                                    'tbl_product.purchase_cost as productpurchasecost',
                                    'tbl_product.mrp as productmrp',
                                    'tbl_product.purchase_date as productpurchesdate',
                                    'tbl_product.rate as productrate',
                                    'tbl_product.rating as productrating',
                                    'tbl_product.description as productdescription',
                                    'tbl_product.size as productsize',
                                    'tbl_product.color as productcolor',
                                    'tbl_product.featured_status as productfeaturedstatus',
                                    'tbl_product.material as productmaterial',
                                    'tbl_product.created_at as productcreatedat',
                                    'tbl_product.updated_at as productupdatedat',
                                    'tbl_product.status as productstatus',
                                    'tbl_category.category_name as productcategoryname',
                                    'tbl_subcategory.subcategory_name as productsubcategoryname',
                                    'users.first_name as productcreatefirstname',
                                    'users.last_name as productcreatelastname')
                    ->join('tbl_category', 'tbl_product.category_id', '=', 'tbl_category.id')
                    ->join('tbl_subcategory', 'tbl_product.subcategory_id', '=', 'tbl_subcategory.id')
                    ->join('users', 'tbl_product.created_by_user_id', '=', 'users.id')
                    ->get();
        foreach ($record as $key => $value) {
            $record[$key]->featured = ($value->productfeaturedstatus == 1)?"YES":"NO";
            $record[$key]->roleid = Session::get('role_id');
        }
        return datatables()->of($record)->toJson();
    }


    public function create()
    { 
        $category_record = Category::where('status',1)->get();
        return view('Website.product.product_add',compact('category_record'));
    }


    public function store(Request $request)
    { 

        $user_id = Auth::user()->id;
        try {
            $validator = Validator::make($request->all(), [
                'category_id' => 'required|int',
                'subcategory_id' => 'required|int',
                'product_name' => 'required|string',
                'brand' => 'required',
                'purchase_cost' => 'required|numeric',
                'purchase_date' => 'required',
                'mrp' => 'required|numeric',
                'rate' => 'required|numeric',
                'size' => 'required',
                'color' => 'required',
                'material' => 'required',
                'featured_status' => 'required',
                'description' => 'required'
            ]);

            if ($validator->fails()) {
                //return redirect()->route('website.product')->withErrors($validator);
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = [
                'created_by_user_id' => $user_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_name' => $request->product_name,
                'brand' => $request->brand,
                'purchase_cost' => $request->purchase_cost,
                'purchase_date' => $request->purchase_date,
                'mrp' => $request->mrp,
                'rate' => $request->rate,
                'size' => $request->size,
                'color' => $request->color,
                'material' => $request->material,
                'featured_status' => $request->featured_status,
                'description' => $request->description,
            ];

            $dataset = Product::create($data);
            if($dataset)
            {
                
                $pro_id = $dataset->id;
                if(!empty($request->product_image))
                {
                    $image_counter = count($request->product_image);
                    for ($x = 0; $x < $image_counter; $x++) {
                        $product_img_name = Storage::put('product_image', $request->product_image[$x]);
                        if($product_img_name){
                            Product_image::create(['product_id' => $pro_id,'product_image' => $product_img_name]);
                        }
                    }
                }
                return redirect()->route('website.product')->with('success','Record Insert successfully');
            }else{
                return redirect()->route('website.product')->with('error','Record Not Inserted !!');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.product')->with('error',$e->getMessage());   
        }
    }


    public function edit($id)
    { 
        
        $product_record = Product::find($id);
        $subcategory = Subcategory::where('category_id',$product_record->category_id)->where('status',1)->get();
        $category = Category::where('status',1)->get();
        $product_image = Product_image::where('product_id',$id)->get();
        return view('Website.product.product_edit',compact('product_record','category','subcategory','product_image'));
    }


    public function update(Request $request, $id)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'category_id' => 'required|int',
                'subcategory_id' => 'required|int',
                'product_name' => 'required|string',
                'brand' => 'required',
                'purchase_cost' => 'required|numeric',
                'purchase_date' => 'required',
                'mrp' => 'required|numeric',
                'rate' => 'required|numeric',
                'size' => 'required',
                'color' => 'required',
                'material' => 'required',
                'featured_status' => 'required|numeric',
                'description' => 'required',
                'status' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.product')->withErrors($validator);
            }

            $group = Product::find($id);
            $group->category_id =  $request->get('category_id');
            $group->subcategory_id =  $request->get('subcategory_id');
            $group->product_name =  $request->get('product_name');
            $group->brand =  $request->get('brand');
            $group->purchase_cost =  $request->get('purchase_cost');
            $group->purchase_date =  $request->get('purchase_date');
            $group->mrp =  $request->get('mrp');
            $group->rate =  $request->get('rate');
            $group->size =  $request->get('size');
            $group->color =  $request->get('color');
            $group->material =  $request->get('material');
            $group->featured_status =  $request->get('featured_status');
            $group->description =  $request->get('description');
            $group->status =  $request->get('status');
            $group->save();


            /*Product Image Upload start*/
            if(!empty($request->product_image))
            {
                $image_counter = count($request->product_image);
                for ($x = 0; $x < $image_counter; $x++) {
                    $product_img_name = Storage::put('product_image', $request->product_image[$x]);
                    if($product_img_name){
                        Product_image::create(['product_id' => $id,'product_image' => $product_img_name]);
                    }
                }
            }
            /*Product Image Upload Close*/

            return redirect()->back()->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->back()->with('error',$e->getMessage());   
        }
    }


    public function deleted($id)
    {
        try {
            Product::where('id',$id)->delete();
            return redirect()->route('website.product')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.product')->with('error',$e->getMessage());   
        }
    }


    public function image_remove($id)
    {
        try {
            $product = Product_image::select('product_image')->where('id',$id)->first();
                if(!empty($product->product_image)){
                    Storage::delete('pro_image', $product->product_image);
                }
            Product_image::where('id',$id)->delete();
            return redirect()->back()->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->back()->with('error',$e->getMessage());   
        }
    }


    public function display($id)
    { 
        try {
            $product_record = Product::select('tbl_product.id as productId',
                                    'tbl_product.created_by_user_id as createuserId',
                                    'tbl_product.category_id as categoryId',
                                    'tbl_product.subcategory_id as subcategoryId',
                                    'tbl_product.product_name as productname',
                                    'tbl_product.brand as productbrand',
                                    'tbl_product.purchase_cost as productpurchasecost',
                                    'tbl_product.mrp as productmrp',
                                    'tbl_product.purchase_date as productpurchesdate',
                                    'tbl_product.rate as productrate',
                                    'tbl_product.rating as productrating',
                                    'tbl_product.description as productdescription',
                                    'tbl_product.size as productsize',
                                    'tbl_product.color as productcolor',
                                    'tbl_product.material as productmaterial',
                                    'tbl_product.featured_status as productfeaturedstatus',
                                    'tbl_product.created_at as productcreatedat',
                                    'tbl_product.updated_at as productupdatedat',
                                    'tbl_product.status as productstatus',
                                    'tbl_category.category_name as productcategoryname',
                                    'tbl_subcategory.subcategory_name as productsubcategoryname',
                                    'users.first_name as productcreatefirstname',
                                    'users.last_name as productcreatelastname')
                    ->join('tbl_category', 'tbl_product.category_id', '=', 'tbl_category.id')
                    ->join('tbl_subcategory', 'tbl_product.subcategory_id', '=', 'tbl_subcategory.id')
                    ->join('users', 'tbl_product.created_by_user_id', '=', 'users.id')
                    ->where('tbl_product.id',$id)
                    ->first();
            $product_image = Product_image::where('product_id',$id)->get();

            $product_inventory = Inventory::select('tbl_inventory.*','users.first_name as shopkeeperfirstname','users.last_name as shopkeeperlastname')
                    ->join('users', 'tbl_inventory.shopkeeper_id', '=', 'users.id')
                    ->where('tbl_inventory.product_id',$id)
                    ->get();

            return view('Website.product.product_view',compact('product_record','product_image','product_inventory'));
        }catch (\Exception $e) { 
            return redirect()->route('website.product')->with('error',$e->getMessage());
        }
    }



    public function report()
    {
        try {

            $filter['month'] = Input::get('month');
            $filter['year'] = Input::get('year');
            $query = Product::select('tbl_product.*',
                                    'tbl_category.category_name as productcategoryname',
                                    'tbl_subcategory.subcategory_name as productsubcategoryname',
                                    'users.first_name as productcreatefirstname',
                                    'users.last_name as productcreatelastname')
                    ->join('tbl_category', 'tbl_product.category_id', '=', 'tbl_category.id')
                    ->join('tbl_subcategory', 'tbl_product.subcategory_id', '=', 'tbl_subcategory.id')
                    ->join('users', 'tbl_product.created_by_user_id', '=', 'users.id');
                    if(!empty($filter['month'])){
                        $query->whereRaw('MONTH(tbl_product.created_at) = ?',[$filter['month']]);
                    }
                    if(!empty($filter['year'])){
                        $query->whereRaw('YEAR(tbl_product.created_at) = ?',[$filter['year']]);
                    }
                    $product_record = $query->get();

            foreach ($product_record as $key => $value) {
                //$product_record[$key]->product_age =  Carbon::parse($value->created_at)->age;
                $product_record[$key]->product_age =  Carbon::parse($value->created_at)->diff(Carbon::now())->format('%y years, %m months and %d days');
            }
            return view('Website.product.product_report',compact('product_record','filter'));
        }catch (\Exception $e) { 
            return redirect()->route('website.product')->with('error',$e->getMessage());
        }
    }

    
}
