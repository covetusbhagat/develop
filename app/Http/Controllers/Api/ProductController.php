<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Inventory;
use App\Models\Slider;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Complaint;
use App\Models\Product_image;
use App\Models\ProductReviews;
use App\Models\Notification;
use App\Models\Chatsupport;
use App\Models\Referral_allot_user;
use App\Models\Coupon;
use App\Models\Coupon_user_mapping;
use App\Models\Order;


use App\User;
use Carbon\Carbon;
use Validator;
use DB; 
use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    function __construct()
    {
        //$this->middleware('auth', ['except' => 'featured_product_list']);
    }
    
    public function index()
    {
        echo otp_genrater(0);
        die();
    }       

    /**
     * Create user and create token
     *
     */
    public function product_by_subcategory(Request $request)
    {           
        
        $validator = Validator::make($request->all(), [
            'subcategory_id' => 'required',         
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{

            $pro_record = product::where('subcategory_id',$request->subcategory_id)->where('status',1)->get();
            if(!empty($pro_record)){
                foreach ($pro_record as $key1 => $value1) {
                    $record[$key1] = $value1;
                    $pro_image = Product_image::where('product_id',$value1->id)->get();
                    foreach ($pro_image as $key2 => $value2) {
                        $pro_image_record[$key2] = $value2;
                        $pro_image_record[$key2]->product_image =  url('storage/app').'/'.$value2->product_image;
                    }
                    $record[$key1]['image'] = $pro_image_record;
                    
                }
                return response()->json([
                    'status'=>'200',
                    'message' => 'Subcategory With Product',
                    'results'=> $record                    
                ], 200);
            }else{

                return response()->json([
                    'status'=>'400',
                    'message' => 'Product Not found',
                    'results'=> array()                    
                ], 200);
            }
        }
    }


    public function product_detail(Request $request)
    {           
        
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',         
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{

            $pro_record = product::where('id',$request->product_id)->get();
            if($pro_record->count() >0){
                foreach ($pro_record as $key1 => $value1) {
                    $record[$key1] = $value1;

                    $record[$key1]['is_wishlist'] = false;
                    $record[$key1]['is_cart'] = false;
                    $user_id = $request->user_id;
                    if(!empty($user_id)){  
                        $pro_wishlist = Wishlist::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_wishlist)){
                            $record[$key1]['is_wishlist'] = true;
                        }
                        $pro_cart = Cart::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_cart)){
                            $record[$key1]['is_cart'] = true;
                        }
                    }
                    $reviews = ProductReviews::select(DB::raw('pr.*, u.first_name , u.last_name, u.profile_image'))
		                ->from('tbl_product_reviews as pr' )
		                ->leftjoin('users as u','pr.user_id', '=','u.id')
                		->where("pr.product_id",$value1->id)
                		->get();

                	if($reviews->count() > 0){
		            	foreach($reviews as $key => $value) {
		            		$value->profile_image = (!empty($value->profile_image))?url('storage/app').'/'.$value->profile_image:'';		            		
		            	}
		                
		                $record[$key1]['reviews'] = $reviews;

		            }else{
		            	$record[$key1]['reviews'] = $reviews;
		            }
                    
                    $pro_image = Product_image::where('product_id',$value1->id)->get();
                    foreach ($pro_image as $key2 => $value2) {
                        $pro_image_record[$key2] = $value2;
                        $pro_image_record[$key2]->product_image =  url('storage/app').'/'.$value2->product_image;
                    }
                    $record[$key1]['image'] = $pro_image_record;
                }
                return response()->json([
                    'status'=>'200',
                    'message' => 'Product List',
                    'results'=> $record                    
                ], 200);
            }else{

                return response()->json([
                    'status'=>'400',
                    'message' => 'Product Not found',
                    'results'=> array()                    
                ], 200);
            }
        }
    }

   

    public function get_slider_list(Request $request)
    {   
        $results = Slider::where('status',1)->get();
        if(!empty($results)){
            
            foreach($results as $key2 => $value2) {
               $value2->slider_image =  url('storage/app').'/'.$value2->slider_image;
            }
                
            
            return response()->json([
                'status'=>'200',
                'message' => 'Slider List',
                'results'=> $results                    
            ], 200);
        }else{

            return response()->json([
                'status'=>'400',
                'message' => 'Slider Not found',
                'results'=> array()                    
            ], 200);
        }
        
    }

    public function search_product_suggestion(Request $request)
    {           
      
        $validator = Validator::make($request->all(), [
            'search_key' => 'required',         
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $search_key = $request->search_key;
            $pro_record = product::select(DB::raw('p.*, c.category_name , subc.subcategory_name'))
                ->from( 'tbl_product as p' )
                ->leftjoin('tbl_category as c','p.category_id', '=','c.id')
                ->leftjoin('tbl_subcategory as subc','p.subcategory_id', '=','subc.id')
                ->where('p.brand', 'like','%'.$search_key.'%')
                ->orWhere('p.product_name', 'like','%'.$search_key.'%')
                ->orWhere('c.category_name', 'like','%'.$search_key.'%')
                ->orWhere('subc.subcategory_name', 'like','%'.$search_key.'%')
                ->get();
            if(!empty($pro_record)){
                $record = array();
                $i = 0;
                foreach ($pro_record as $key1 => $value1) {
                    $search_key = $value1->category_name." for ".$value1->subcategory_name;
                    if(!in_array($search_key,$record)){                   
                        $record[$i] = $value1->category_name." for ".$value1->subcategory_name;
                        $i++;
                    }
                    
                }
                return response()->json([
                    'status'=>'200',
                    'message' => 'search result With Product',
                    'results'=> $record                    
                ], 200);
            }else{

                return response()->json([
                    'status'=>'400',
                    'message' => 'Product Not found',
                    'results'=> array()                    
                ], 200);
            }
        }
    }

    public function search_product(Request $request)
    {           
      
        $validator = Validator::make($request->all(), [
            'search_key' => 'required',         
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $search_key = $request->search_key;
            $search_key_arr = explode(" for ", $search_key);
            $search_cat = $search_key_arr[0]; 
            $search_subcat = $search_key_arr[1];

            $pro_record = product::select(DB::raw('p.*, c.category_name , subc.subcategory_name'))
                ->from( 'tbl_product as p' )
                ->leftjoin('tbl_category as c','p.category_id', '=','c.id')
                ->leftjoin('tbl_subcategory as subc','p.subcategory_id', '=','subc.id')                           
                ->where('c.category_name', $search_cat)
                ->where('subc.subcategory_name', $search_subcat)
                ->orWhere('p.product_name', 'like','%'.$search_key.'%')
                ->orWhere('p.brand', 'like','%'.$search_key.'%')     
                ->get();
            $record = array();    
            if(!empty($pro_record)){
                foreach ($pro_record as $key1 => $value1) {
                    $record[$key1] = $value1;

                    $record[$key1]['is_wishlist'] = false;
                    $record[$key1]['is_cart'] = false;
                    $user_id = $request->user_id;
                    if(!empty($user_id)){  
                        $pro_wishlist = Wishlist::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_wishlist)){
                            $record[$key1]['is_wishlist'] = true;
                        }
                        $pro_cart = Cart::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_cart)){
                            $record[$key1]['is_cart'] = true;
                        }
                    }

                    $pro_image = Product_image::where('product_id',$value1->id)->get();
                    foreach ($pro_image as $key2 => $value2) {
                        $pro_image_record[$key2] = $value2;
                        $pro_image_record[$key2]->product_image =  url('storage/app').'/'.$value2->product_image;
                    }
                    $record[$key1]['image'] = $pro_image_record;
                    
                }
                return response()->json([
                    'status'=>'200',
                    'message' => 'search result With Product',
                    'results'=> $record                    
                ], 200);
            }else{

                return response()->json([
                    'status'=>'400',
                    'message' => 'Product Not found',
                    'results'=> array()                    
                ], 200);
            }
        }
    }

    public function product_short_by(Request $request)
    { 
        $sort_list = array("p_low_high"=>"Price: Low To High","p_high_low"=>"Price:  High To Low","Desending"=>"Newest List");

        return response()->json([
                    'status'=>'200',
                    'message' => 'Product Sorting By List',
                    'results'=> $sort_list                    
                ], 200);

    }

    public function filter_list(Request $request)
    { 
        if(empty($request->search_key)){
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',         
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'search_key' => 'required',         
            ]);
        }
        

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $filter_list = array(
                "0"=>array("title"=>"Category","field_type"=>"checkbox","list"=>array()),
                "1"=>array("title"=>"Brand","field_type"=>"checkbox","list"=>array()),
                "2"=>array("title"=>"Size","field_type"=>"checkbox","list"=>array()),
                "3"=>array("title"=>"Color","field_type"=>"checkbox","list"=>array()),                
                "4"=>array("title"=>"Price","field_type"=>"range","list"=>array()),
                "5"=>array("title"=>"Material","field_type"=>"checkbox","list"=>array()),
            );

            $search_key = $request->search_key;
            if(!empty($search_key)){
                $search_key_arr = explode(" for ", $search_key);
                if(!empty($search_key_arr)){
                    $search_cat = $search_key_arr[0]; 
                    $category = Category::where("category_name","=",$search_cat)->first();
                    $category_id = $category->id;
                }
            }else{
                $category_id = $request->category_id;
            }
            

            /*start get subcategory List*/
            $Subcategory_list =  product::select(DB::raw('subc.*'))
                ->from( 'tbl_product as p' )
                ->leftjoin('tbl_subcategory as subc','p.subcategory_id', '=','subc.id')
                ->where('p.category_id', '=',$category_id)
                ->where('subc.status', '=',1)
                ->groupBy('subc.id')
                ->get();
            if(!empty($Subcategory_list)){
                $filter_list['0']['list'] = $Subcategory_list;
            }else{
                unset($filter_list['0']);
            }
            /*end get subcategory List*/

            /*start get brand List*/
            $brand_list =  product::select(DB::raw('brand'))
                ->where('category_id', '=',$category_id)
                ->where('status', '=',1)
                ->groupBy('brand')
                ->get();
            if(!empty($brand_list)){
                $filter_list['1']['list'] = $brand_list;
            }else{
                unset($filter_list['1']);
            }
            /*end get brand List*/

            /*start get size List*/
            $size_list =  product::select(DB::raw('size'))
                ->where('category_id', '=',$category_id)
                ->where('status', '=',1)
                ->groupBy('size')
                ->get();
            if(!empty($size_list)){
                $filter_list['2']['list'] = $size_list;
            }else{
                unset($filter_list['2']);
            }
            /*end get size List*/

            /*start get color List*/
            $color_list =  product::select(DB::raw('color'))
                ->where('category_id', '=',$category_id)
                ->where('status', '=',1)
                ->groupBy('color')
                ->get();
            if(!empty($color_list)){
                $filter_list['3']['list'] = $color_list;
            }else{
                unset($filter_list['3']);
            }
            /*end get size List*/

            /*start get price List*/
            $price_list =  product::select(DB::raw("MIN(rate) as min_price") , DB::raw("MAX(rate) as max_price"))
                ->where('category_id', '=',$category_id)
                ->where('status', '=',1)
                ->get();
            if(!empty($price_list)){
                $filter_list['4']['list'] = $price_list;
            }else{
                unset($filter_list['4']);
            }
            /*end get price List*/

            /*start get material List*/
            $material_list =  product::select(DB::raw('material'))
                ->where('category_id', '=',$category_id)
                ->where('status', '=',1)
                ->groupBy('material')
                ->get();
            if(!empty($material_list)){
                $filter_list['5']['list'] = $material_list;
            }else{
                unset($filter_list['5']);
            }
            /*end get material List*/

            return response()->json([
                'status'=>'200',
                'message' => 'filter List',
                'results'=> $filter_list                    
            ], 200);


        }
    }

    public function filter_product_list(Request $request)
    {           
        
        if(empty($request->search_key)){
            $validator = Validator::make($request->all(), [
                'category_id' => 'required',         
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'search_key' => 'required',         
            ]);
        }
       

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
 
            $search_key = $request->search_key;
            if(!empty($search_key)){
                $search_key_arr = explode(" for ", $search_key);
                if(count($search_key_arr)>1){
                    $search_cat = $search_key_arr[0]; 
                    $search_subcat = $search_key_arr[1];
                }
               
                $pro_record = product::select(DB::raw('distinct(p.id),p.*, c.category_name , subc.subcategory_name'))
                    ->from( 'tbl_product as p' )
                    ->rightjoin('tbl_inventory as inv','p.id', '=','inv.product_id')
                    ->leftjoin('tbl_category as c','p.category_id', '=','c.id')
                    ->leftjoin('tbl_subcategory as subc','p.subcategory_id', '=','subc.id');
                if(count($search_key_arr)>1){                           
                    $pro_record = $pro_record->where('c.category_name','like' ,'%'.$search_cat.'%');
                    $pro_record = $pro_record->where('subc.subcategory_name', 'like' ,'%'.$search_subcat.'%');
                   
                }else{
                    $pro_record = $pro_record->where('c.category_name', 'like','%'.$search_key.'%');
                    $pro_record = $pro_record->orWhere('subc.subcategory_name', 'like','%'.$search_key.'%') ;
                }
                $pro_record = $pro_record->orWhere('p.product_name', 'like','%'.$search_key.'%');
                $pro_record = $pro_record->orWhere('p.brand', 'like','%'.$search_key.'%') ;
                
            }else{
                $category_id = $request->category_id;
                $subcategory_id = !empty($request->subcategory_id)?explode(",", $request->subcategory_id):'';
                $size = !empty($request->size)?explode(",", $request->size):'';
                $color = !empty($request->color)?explode(",", $request->color):'';
                $brand = !empty($request->brand)?explode(",", $request->brand):'';
                $material = !empty($request->material)?explode(",", $request->material):'';
                $min_price = !empty($request->min_price)?$request->min_price:'';
                $max_price = !empty($request->max_price)?$request->max_price:'';

                $pro_record = product::select(DB::raw('p.*, c.category_name , subc.subcategory_name'))
                    ->from( 'tbl_product as p' )
                    ->leftjoin('tbl_category as c','p.category_id', '=','c.id')
                    ->leftjoin('tbl_subcategory as subc','p.subcategory_id', '=','subc.id')
                    ->where('p.category_id', '=',$category_id);
                if(!empty($subcategory_id)){
                   $pro_record =$pro_record->WhereIn('p.subcategory_id', $subcategory_id); 
                }
                if(!empty($size)){
                   $pro_record =$pro_record->WhereIn('p.size', $size); 
                }
                if(!empty($color)){
                   $pro_record =$pro_record->WhereIn('p.color', $color); 
                }
                if(!empty($brand)){
                   $pro_record =$pro_record->WhereIn('p.brand', $brand); 
                }
               
                if(!empty($material)){
                   $pro_record =$pro_record->WhereIn('p.material', $material); 
                }

                if(!empty($min_price)){
                   $pro_record =$pro_record->where('p.rate','>=', $min_price); 
                }
                if(!empty($max_price)){
                   $pro_record =$pro_record->where('p.rate','<=', $max_price); 
                }            

                
            }
            $sort_list = array("p_low_high"=>"Price: Low To High","p_high_low"=>"Price:  High To Low","Desending"=>"Newest List");
            $sort_by = array_key_exists($request->sort_by,$sort_list)? $request->sort_by:'Desending' ;
            if($sort_by == "p_low_high"){
               $pro_record = $pro_record->orderBy('p.rate', 'asc'); 
            }
            if($sort_by == "p_high_low"){
               $pro_record = $pro_record->orderBy('p.rate', 'desc'); 
            }
            /*if($sort_by == "rating"){
               $pro_record = $pro_record->orderBy('rating', 'desc'); 
            }*/
           
            if($sort_by == "Desending"){
               $pro_record = $pro_record->orderBy('p.id', 'desc'); 
            }
           
            $pro_record = $pro_record->get(); 
           
            if($pro_record->count() >0){
                $record = array();
                foreach($pro_record as $key1 => $value1) {
                    $record[$key1] = $value1;

                    $record[$key1]['is_wishlist'] = false;
                    $record[$key1]['is_cart'] = false;
                    $user_id = $request->user_id;
                    if(!empty($user_id)){  
                        $pro_wishlist = Wishlist::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_wishlist)){
                            $record[$key1]['is_wishlist'] = true;
                        }
                        $pro_cart = Cart::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_cart)){
                            $record[$key1]['is_cart'] = true;
                        }
                    }

                    $pro_image = Product_image::where('product_id',$value1->id)->get();
                    $pro_image_record = array();
                    foreach ($pro_image as $key2 => $value2) {
                        $pro_image_record[$key2] = $value2;
                        $pro_image_record[$key2]->product_image =  url('storage/app').'/'.$value2->product_image;
                    }
                    $record[$key1]['image'] = $pro_image_record;
                    
                }
                return response()->json([
                    'status'=>'200',
                    'message' => 'filter result With Product',
                    'results'=> $record                    
                ], 200);
            }else{

                return response()->json([
                    'status'=>'400',
                    'message' => 'Product Not found',
                    'results'=> array()                    
                ], 200);
            }
        }
    }

   

    public function running_rental_product_list(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',         
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = $request->user_id;
            $pro_record = array();//product::where('featured_status',1)->where('status',1)->get();
            //if($pro_record->count() >0){
            if(!empty($pro_record)){
                $record = array();
                foreach($pro_record as $key1 => $value1) {
                    $record[$key1] = $value1;

                    $record[$key1]['is_wishlist'] = false;
                    $record[$key1]['is_cart'] = false;
                    $user_id = $request->user_id;
                    if(!empty($user_id)){  
                        $pro_wishlist = Wishlist::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_wishlist)){
                            $record[$key1]['is_wishlist'] = true;
                        }
                        $pro_cart = Cart::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_cart)){
                            $record[$key1]['is_cart'] = true;
                        }
                    }

                    $pro_image = Product_image::where('product_id',$value1->id)->get();
                    $pro_image_record = array();
                    foreach ($pro_image as $key2 => $value2) {
                        $pro_image_record[$key2] = $value2;
                        $pro_image_record[$key2]->product_image =  url('storage/app').'/'.$value2->product_image;
                    }
                    $record[$key1]['image'] = $pro_image_record;
                    
                }
                    
                
                return response()->json([
                    'status'=>'200',
                    'message' => 'Running rental Product List',
                    'results'=> $record                    
                ], 200);
            }else{

                return response()->json([
                    'status'=>'400',
                    'message' => 'Running rental Product Not found',
                    'results'=> array()                    
                ], 200);
            }
        }
        
    }

    public function featured_product_list(Request $request)
    {   
        /*$validator = Validator::make($request->all(), [
            'user_id' => 'required',         
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{*/
            $user_id = $request->user_id;

           // $pro_record = product::where('featured_status',1)->where('status',1)->get();
            $pro_record = product::select(DB::raw('distinct(p.id),p.*'))
                ->from('tbl_product as p' )
                ->rightjoin('tbl_inventory as inv','p.id', '=','inv.product_id')
                ->leftjoin('tbl_category as c','p.category_id', '=','c.id')
                //->leftjoin('tbl_subcategory as subc','p.subcategory_id', '=','subc.id')
                ->where('p.featured_status',1)
                ->where('p.status',1)
                ->where('c.status',1)
                ->get();

            if($pro_record->count() >0){ 
                $record = array();
                foreach($pro_record as $key1 => $value1) {
                    $record[$key1] = $value1;
                    $record[$key1]['is_wishlist'] = false;
                    $record[$key1]['is_cart'] = false;
                    if(!empty($user_id)){
                        $pro_wishlist = Wishlist::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_wishlist)){
                            $record[$key1]['is_wishlist'] = true;
                        }
                        $pro_cart = Cart::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_cart)){
                            $record[$key1]['is_cart'] = true;
                        }
                    }
                    $pro_image = Product_image::where('product_id',$value1->id)->get();
                    $pro_image_record = array();
                    foreach ($pro_image as $key2 => $value2) {
                        $pro_image_record[$key2] = $value2;
                        $pro_image_record[$key2]->product_image =  url('storage/app').'/'.$value2->product_image;
                    }
                    $record[$key1]['image'] = $pro_image_record;
                    
                }
                return response()->json([
                    'status'=>'200',
                    'message' => 'Featured Product List',
                    'results'=> $record                    
                ], 200);
            }else{

                return response()->json([
                    'status'=>'400',
                    'message' => 'Featured Product Not found',
                    'results'=> array()                    
                ], 200);
            }
        //}
        
    }

    public function add_and_remove_wishlist(Request $request)
    {          
        $validator = Validator::make($request->all(), [            
            'product_id' => 'required', 
            'status' => 'required',         
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = Auth::user()->id;
            $product_id = $request->product_id;
            $status = $request->status;
            $exits_record = Wishlist::where('user_id',$user_id)->where('product_id',$product_id)->first();
            if($status == 0 && !empty($exits_record)){               
                $check = Wishlist::where('user_id',$user_id)->where('product_id',$product_id)->delete();
                $result['is_wishlist'] = false;
                $message = "Product has been removed successfully.";
            }else if($status == 1 && empty($exits_record)){
                $data = [
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'status' => $status
                ];

                $check = Wishlist::create($data);
                $message = "Product has been added successfully.";
                $result['is_wishlist'] = true;
           }else if($status == 1 && !empty($exits_record)){
                $check = '1';
                $message = "Already added.";
                $result['is_wishlist'] = false;
            }
            

            if($check){
                return response()->json([
                    'status'=>'200',
                    'message' => $message,
                    'results'=> $result                   
                ], 200);

            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong! Please Try Again',
                    'results' => array()
                ], 200); 
            }
        }
        
    }

    public function wishlist_list(Request $request)
    {   
        $user_id = Auth::user()->id; 
        $wish_pro_record = Wishlist::where('user_id',$user_id)->where('status',1)->get();
       
        if($wish_pro_record->count() >0){
            $record = array();
            foreach($wish_pro_record as $key => $value) {
                $pro_record = product::where('id',$value->product_id)->get();
                
                foreach($pro_record as $key1 => $value1) {
                    $record[$key] = $value1;
                    $record[$key]['is_wishlist'] = false;
                    $record[$key]['is_cart'] = false;
                    //if(!empty(Auth::user())){
                        
                        $pro_wishlist = Wishlist::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_wishlist)){
                            $record[$key]['is_wishlist'] = true;
                        }
                        $pro_cart = Cart::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_cart)){
                            $record[$key]['is_cart'] = true;
                        }
                    //}
                    $pro_image = Product_image::where('product_id',$value1->id)->get();
                    $pro_image_record = array();
                    foreach ($pro_image as $key2 => $value2) {
                        $pro_image_record[$key2] = $value2;
                        $pro_image_record[$key2]->product_image =  url('storage/app').'/'.$value2->product_image;
                    }
                    $record[$key]['image'] = $pro_image_record;
                    
                }
            }
                
            
            return response()->json([
                'status'=>'200',
                'message' => 'Wishlist Product List',
                'results'=> $record                    
            ], 200);
        }else{

            return response()->json([
                'status'=>'400',
                'message' => 'Wishlist Product Not found',
                'results'=> array()                    
            ], 200);
        }
        
    }

    public function cart_list(Request $request)
    {   
        $user_id = Auth::user()->id; 
        $cart_pro_record = Cart::where('user_id',$user_id)->where('status',1)->get();
        /*echo "<pre>";
        print_r($cart_pro_record);
        die();*/
        if($cart_pro_record->count() >0){
            $record = array();
            foreach($cart_pro_record as $key => $value){
                $record[$key] = product::where('id',$value->product_id)->first();
                $record[$key]->quantity = $value->total_quantity;
                $record[$key]->start_date_time = $value->start_date_time;
                $record[$key]->end_date_time = $value->end_date_time;
                $record[$key]->inventory_id = $value->inventory_id;
                $pro_image = Product_image::where('product_id',$value->product_id)->get();
                $pro_image_record = array();
                foreach ($pro_image as $key1 => $value1){
                    $pro_image_record[$key1] = $value1;
                    $pro_image_record[$key1]->product_image =  url('storage/app').'/'.$value1->product_image;
                }
                $record[$key]['image'] = $pro_image_record;
            }

            return response()->json([
                'status'=>'200',
                'message' => 'Cart Product List',
                'results'=> $record                    
            ], 200);
        }else{

            return response()->json([
                'status'=>'400',
                'message' => 'Cart Product Not found',
                'results'=> array()                    
            ], 200);
        }
        
    }

    public function add_and_remove_cart(Request $request)
    {          
        $validator = Validator::make($request->all(), [            
            'product_id' => 'required', 
            'inventory_id' => 'required',
            //'start_date_time' => 'required', 
            //'end_date_time' => 'required', 
            'rate_per_item' => 'required', 
            'total_quantity' => 'required', 
            //'total_amount' => 'required', 
            'direct_buy_status' => 'required', 
            'status' => 'required',         
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = Auth::user()->id;
            $product_id = $request->product_id;
            $start_date_time = date("Y-m-d H:i:s");
            $end_date_time = date("Y-m-d H:i:s");
            $rate_per_item = $request->rate_per_item;
            $total_quantity = $request->total_quantity;
            $total_amount =  ($rate_per_item*$total_quantity);
            $direct_buy_status = $request->direct_buy_status;
            $status = $request->status;
            $inventory_id = $request->inventory_id;

            $exits_record = Cart::where('user_id',$user_id)->where('product_id',$product_id)->where('inventory_id',$inventory_id)->first();

            if($status == 0 && !empty($exits_record)){               
                $check = Cart::where('user_id',$user_id)->where('product_id',$product_id)->where('inventory_id',$inventory_id)->delete();
                $message = "Product has been removed successfully.";
                $result['is_cart'] = false;
            }else if($status == 1 && empty($exits_record)){
                $inventory_exist = Inventory::where('id',$inventory_id)->first();
                if(!empty( $inventory_exist) && $inventory_exist->available_quantity < $total_quantity){
                    $check = '1';
                    $message = "Max available product is ".$inventory_exist->available_quantity.",So please add less than this quantity.";
                    $result['is_cart'] = false;
                }else{
                    $data = [
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'inventory_id' => $inventory_id,
                        'start_date_time' => $start_date_time,
                        'end_date_time' => $end_date_time,
                        'rate_per_item' => $rate_per_item,
                        'total_quantity' => $total_quantity,
                        'total_amount' => $total_amount,
                        'direct_buy_status' => $direct_buy_status,
                        'status' => $status
                    ];

                    $check = Cart::create($data);
                    $message = "Product has been added successfully.";
                    $result['is_cart'] = true;
                }
           }else if($status == 1 && !empty($exits_record)){

                if($exits_record == $request->total_quantity){

                    $check = '1';
                    $message = "Already added.";
                    $result['is_cart'] = false;
                
                }elseif($request->total_quantity == 0){

                   $check = Cart::where('user_id',$user_id)->where('product_id',$product_id)->where('inventory_id',$inventory_id)->delete();
                    $message = "Product has been removed successfully.";
                    $result['is_cart'] = false;
                }else{
                    
                    $check = Cart::where('user_id',$user_id)->where('product_id',$product_id)->where('inventory_id',$inventory_id)->update(['total_quantity' => $request->total_quantity]);
                    $message = "Product quantity has been update successfully.";
                        $result['is_cart'] = true;
                }
            }
            
            if($check){
                return response()->json([
                    'status'=>'200',
                    'message' => $message,
                    'results'=> array()                    
                ], 200);

            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong! Please Try Again',
                    'results' => array()
                ], 200); 
            }
        }
        
    }

    public function home_category_by_product_list(Request $request)
    {   
        $category_list = Category::where('status',1)->get();
        
        if($category_list->count() >0){
             $product_list = array();
            foreach($category_list as $key => $value) {
                $product_list[$key]['category_id'] = $value->id;
                $product_list[$key]['category_name'] = $value->category_name;
                $product_list[$key]['product'] = array();

                //$pro_record = product::where('category_id',$value->id)->get();
                $pro_record = product::select(DB::raw('distinct(p.id),p.*'))
                        ->from('tbl_product as p' )
                        ->rightjoin('tbl_inventory as inv','p.id', '=','inv.product_id')
                        ->where('p.category_id',$value->id)
                        ->get();
                $record = array();                
                foreach($pro_record as $key1 => $value1) {

                    $record[$key1] = $value1;

                    $record[$key1]['is_wishlist'] = false;
                    $record[$key1]['is_cart'] = false;
                    $user_id = $request->user_id;
                    if(!empty($user_id)){                       
                        $pro_wishlist = Wishlist::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_wishlist)){
                            $record[$key1]['is_wishlist'] = true;
                        }
                        $pro_cart = Cart::where('user_id',$user_id)->where('product_id',$value1->id)->first();
                        if(!empty($pro_cart)){
                            $record[$key1]['is_cart'] = true;
                        }
                    }

                    $pro_image = Product_image::where('product_id',$value1->id)->get();
                    $pro_image_record = array();
                    foreach ($pro_image as $key2 => $value2) {
                        $pro_image_record[$key2] = $value2;
                        $pro_image_record[$key2]->product_image =  url('storage/app').'/'.$value2->product_image;
                    }
                    $record[$key1]['image'] = $pro_image_record;
                    
                }
                $product_list[$key]['product'] = $record;
            }
                
            
            return response()->json([
                'status'=>'200',
                'message' => 'Product List',
                'results'=> $product_list                    
            ], 200);
        }else{

            return response()->json([
                'status'=>'400',
                'message' => 'Product Not found',
                'results'=> array()                    
            ], 200);
        }
        
    }

    public function add_complaint(Request $request){
        $validator = Validator::make($request->all(), [            
            'subject' => 'required', 
            'complaint_text' => 'required',        
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = Auth::user()->id;
            $user_data = user::where('id',$user_id)->first();
            $subject = $request->subject;
            $complaint_text = $request->complaint_text;
           
            $data = [
                'complaint_by' => $user_id,
                'subject' => $subject,
                'complaint_text' => $complaint_text,                   
                'status' => 1
            ];

            $check = Complaint::create($data);
            $message = "Complaint has been sent successfully.";

            if($check){

                $link = url('complain/display').'/'.$check->id;
                $message = $user_data->first_name.' '.$user_data->last_name.' New Complaint Add';
                $note_value = Notification::create(['by_id' => $user_id, 'to_id' => 2, 'massage' => $message, 'displaylink' => $link]);

                return response()->json([
                    'status'=>'200',
                    'message' => $message,
                    'results'=> array()                    
                ], 200);

            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong! Please Try Again',
                    'results' => array()
                ], 200); 
            }
        }
    }

    public function complaint_list(Request $request){
        
            $user_id = Auth::user()->id;  

            $record = Complaint::where("complaint_by",$user_id)->get();
           
            if($record->count() > 0){
                return response()->json([
                    'status'=>'200',
                    'message' => "Complaint List.",
                    'results'=> $record                   
                ], 200);

            }else{
                return response()->json([
                    'status' => '200',
                    'message' => 'No complaint',
                    'results' => array()
                ], 200); 
            }
        
    }

    public function change_complaint_status(Request $request){
        $validator = Validator::make($request->all(), [            
            'status' => 'required', 
            'complaint_id' => 'required',        
        ]);
 
        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = Auth::user()->id;
            $status = $request->status;
            $complaint_id = $request->complaint_id;
           
            $data = [                  
                'status' =>$status
            ];

            $check = Complaint::where("id",$complaint_id)->update($data);
            $message = "Complaint status has benn changed successfully.";
          
            

            if($check){
                return response()->json([
                    'status'=>'200',
                    'message' => $message,
                    'results'=> array()                    
                ], 200);

            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong! Please Try Again',
                    'results' => array()
                ], 200); 
            }
        }
    }

    public function add_product_review(Request $request){
        $validator = Validator::make($request->all(), [            
            'product_id' => 'required', 
            'reviews' => 'required',        
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = Auth::user()->id;
            $product_id = $request->product_id;
            $reviews = $request->reviews;
           
            $data = [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'reviews' => $reviews,                   
                'status' => 1
            ];

            $check = ProductReviews::create($data);
            $message = "Review has been sent successfully.";

            if($check){
            	$reviews = ProductReviews::select(DB::raw('pr.*, u.first_name , u.last_name, u.profile_image'))
		                ->from('tbl_product_reviews as pr' )
		                ->leftjoin('users as u','pr.user_id', '=','u.id')
                		->where("pr.product_id",$product_id)
                		->first();

            	if(!empty($reviews)){
	            	
	            	$reviews->profile_image = (!empty($reviews->profile_image))?url('storage/app').'/'.$reviews->profile_image:'';		
	            }
                $res['reviews'] = $reviews;
                return response()->json([
                    'status'=>'200',
                    'message' => $message,
                    'results'=> $reviews                 
                ], 200);

            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong! Please Try Again',
                    'results' => array()
                ], 200); 
            }
        }
    }

    public function add_chat_message(Request $request){
    	$aa = array('receiver_id' => 'required','file_type' => 'required');
    	if($request->file_type == 'image' ){
    		$aa['file_name'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
    	}else if($request->file_type == 'doc'){
    		$aa['file_name'] = 'required|image|mimes:doc.docx|max:2048';
    	}else{
    		$aa['message'] = 'required';
    	}
        $validator = Validator::make($request->all(), $aa);

        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $sender_id = Auth::user()->id;
            $receiver_id = $request->receiver_id;
            $message = $request->message;            
            $file_type = $request->file_type;

            $new_file_name = '';
            //print_r($request->file_name);die;
            if(!empty($request->file_name))
            {
                
               /* $pro_image = user::select('file_name')->where('id',$user_id)->first();
                if(!empty($pro_image->profile_image)){
                    Storage::delete('pro_image', $pro_image->profile_image);
                }*/
                $new_file_name = Storage::put('chat_media', $request->file_name);


                
            }
           
            $data = [
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'message' => $message,
                'file_name' => $new_file_name,
                'file_type' => $file_type,                   
                'status' => 1
            ];

            $check = Chatsupport::create($data);
            $message = "Message has been sent successfully.";

            if($check){
                return response()->json([
                    'status'=>'200',
                    'message' => $message,
                    'results'=> $data                   
                ], 200);

            }else{
                return response()->json([
                    'status' => '400',
                    'message' => 'Something went wrong! Please Try Again',
                    'results' => array()
                ], 200); 
            }
        }
    }

    public function chat_message_list(Request $request){
        
            $user_id = Auth::user()->id;  

           

            $record = Chatsupport::select(DB::raw('cs.*, su.first_name , su.last_name, su.profile_image'))
                ->from( 'tbl_chat_support as cs' )
                ->leftjoin('users as su','cs.sender_id', '=','su.id')
                ->where("cs.sender_id",$user_id)
                ->orWhere("cs.receiver_id",$user_id)
                ->orderBy('cs.id', 'DESC')
                ->get();
           
            if($record->count() > 0){
            	foreach($record as $key => $value) {
            		$value->profile_image = (!empty($value->profile_image))?url('storage/app').'/'.$value->profile_image:'';
            		
            	}
                return response()->json([
                    'status'=>'200',
                    'message' => "Chat message List.",
                    'results'=> $record                   
                ], 200);

            }else{
                return response()->json([
                    'status' => '200',
                    'message' => 'No message',
                    'results' => array()
                ], 200); 
            }
        
    }

    public function product_shopkeeper_list(Request $request){
        $validator = Validator::make($request->all(), [            
            //'product_id' => 'required',
            'latitude' => 'required' ,
            'longitude' => 'required'       
        ]);
 
        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = Auth::user()->id;
            $product_id = !empty($request->product_id)?$request->product_id:'';
            $latitude = $request->latitude;
            $longitude = $request->longitude; 

            $record = Inventory::select(DB::raw('inv.id as inventory_id,inv.product_id,inv.shopkeeper_id,su.profile_image , su.first_name, su.last_name, ua.*, st_distance_sphere(POINT(ua.latitude, ua.longitude ), POINT('.$latitude.', '.$longitude.' ))/1000 as distance , s.state_name,city.city_name'))
                ->from('tbl_inventory as inv')
                ->leftjoin('users as su','inv.shopkeeper_id', '=','su.id')
                ->leftjoin('tbl_user_address as ua','inv.shopkeeper_id', '=','ua.users_id') 
                ->leftjoin('tbl_master_states as s','ua.state_id', '=','s.id') 
                ->leftjoin('tbl_master_cities as city','ua.city_id', '=','city.id');
            if(!empty($product_id)){
                $record = $record->where("inv.product_id",$product_id) ; 
            }          
                $record = $record->orderBy('distance', 'ASC')->get();
           
            if($record->count() > 0){
                foreach($record as $key => $value) {
                    $value->profile_image = (!empty($value->profile_image))?url('storage/app').'/'.$value->profile_image:'';

                    $value->address = "#".$value->house_no.",".$value->land_mark.",".$value->city_name.",".$value->state_name.",".$value->pincode;
                    
                }

                return response()->json([
                    'status'=>'200',
                    'message' => "Product shopkeeper List.",
                    'results'=> $record                   
                ], 200);

            }else{
                return response()->json([
                    'status' => '200',
                    'message' => 'No shopkeeper',
                    'results' => array()
                ], 200); 
            }
        }
        
    }

   
    public function coupan_apply_on_order(Request $request){
        $validator = Validator::make($request->all(), [            
            'coupon_id' => 'required',
            'coupon_type' => 'required'                 
        ]);
 
        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = Auth::user()->id;
            $coupon_id = $request->coupon_id;
            $coupon_type = $request->coupon_type;
             $check = $message = '';
            if($coupon_type == 'referral'){
                $referral_exist = Referral_allot_user::find($coupon_id);
                $check = $referral_exist->delete();
            }else if($coupon_type == 'coupon'){
               
                $coupon_exist = Coupon::find($coupon_id);

                $user_coupon = Coupon_user_mapping::where('coupon_id', '=', $coupon_id)->where('user_id', $user_id)->first();

                if(!empty($user_coupon)){
                    $used_coupon_id = $user_coupon->id;
                    $used_coupon_count = $user_coupon->used_count;
                    $data['used_count'] = $used_coupon_count+1;
                    if($used_coupon_count < $coupon_exist->coupon_uses_time){
                        $check = Coupon_user_mapping::where("id",$used_coupon_id)->update($data);

                    }else{
                        $message = 'Coupan has been used max time '.$coupon_exist->coupon_uses_time.' for each user.';
                    }
                }else{
                    $data['used_count'] = 1;
                    $data['coupon_id'] = $coupon_id;
                    $data['user_id'] = $user_id;
                    $check = Coupon_user_mapping::insert($data);
                    $message = 'Coupan code does not valid.';
                }

            }
           

            if($check){
                return response()->json([
                    'status' => '200',
                    'message' => 'Apply Coupon successfully.',
                    'results' => array()
                ], 200); 
            }else{
                return response()->json([
                    'status' => '200',
                    'message' => $message,
                    'results' => array()
                ], 200); 
            }
            
           
        }

    }

    public function add_order(Request $request){
        $validator = Validator::make($request->all(), [            
            'user_address' => 'required',
            'product_id' => 'required' ,
            'inventory_id' => 'required',
            'shopkeeper_id' => 'required' , 
            'estimate_start_datetime' => 'required',
            'estimate_end_datetime' => 'required' ,             
            'apply_rate' => 'required',
            'quantity' => 'required',
            'delivery_type' => 'required' , 
            'first_amount' => 'required' , 
            //'delivery_otp_verify' => 'required' , 
            //'return_type' => 'required',
            //'return_otp' => 'required' , 
            //'return_otp_verify' => 'required',
            ////'delivery_datetime' => 'required' ,
            //'return_datetime' => 'required',
           // 'extend_rate' => 'required' ,
            
            //'final_amount' => 'required'

        ]);
 
        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{
            $user_id = Auth::user()->id;
            $data['user_id'] = $user_id;
            $data['user_address'] = $request->user_address;
            $data['product_id'] = $request->product_id;
            $data['inventory_id'] = $request->inventory_id;
            $data['shopkeeper_id'] = $request->shopkeeper_id;
            $data['estimate_start_datetime'] =  date("Y-m-d H:i:s", strtotime($request->estimate_start_datetime));
            $data['estimate_end_datetime'] = date("Y-m-d H:i:s", strtotime($request->estimate_end_datetime));

            $data['apply_rate'] = $request->apply_rate;
            $data['quantity'] = $request->quantity;
            
            $data['delivery_type'] = $request->delivery_type;
            $data['delivery_otp'] = otp_genrater(4);
            $data['first_amount'] = $request->first_amount;

            $no_of_days = strtotime($data['estimate_end_datetime'])- strtotime($data['estimate_start_datetime']);

            $no_of_days = round($no_of_days / 86400);
            $data['total_amount'] =  ($data['apply_rate']*$data['quantity'] * $no_of_days);

            $check = Order::insert($data);  
               

            if($check){
                return response()->json([
                    'status' => '200',
                    'message' => 'order successfully.',
                    'results' => array()
                ], 200); 
            }else{
                return response()->json([
                    'status' => '200',
                    'message' => "Something went wrong.",
                    'results' => array()
                ], 200); 
            }
            
           
        }

    }

    public function update_order_status(Request $request){

        $validator = Validator::make($request->all(), [            
            'order_id' => 'required',
            'status' => 'required',
        ]);
 
        if($validator->fails()) {
            return response()->json([
                'status'=>'400',
                'message' => $validator->errors()->first(),
                'results'=>array()
            ], 200);    
        }else{   
            $order_id = $request->order_id;         
            $data['status'] =  $request->status;
            $check = Order::where("id",$order_id)->update($data);
            if($check){
                return response()->json([
                    'status' => '200',
                    'message' => 'status change successfully.',
                    'results' => array()
                ], 200); 
            }else{
                return response()->json([
                    'status' => '200',
                    'message' => "Something went wrong.",
                    'results' => array()
                ], 200); 
            }
        }
    }

    

}