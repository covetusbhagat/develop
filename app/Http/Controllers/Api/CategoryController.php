<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Subcategory;

use Validator;
use DB;

use App\Mail\Forgetpassword;
use Illuminate\Support\Facades\Mail;

class CategoryController extends Controller
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
    public function all_category_subcategory()
    {           
        
        $result = array();
        $category = category::where('status',1)->get();
        foreach ($category as $key => $value) {
            
            $result[$key] = $value;
            $result[$key]->category_image = (!empty($value->category_image))?url('storage/app').'/'.$value->category_image:'';
            $result[$key]['subcategory'] = Subcategory::where('category_id',$value->id)->get();
            $result[$key]['subcategory']->subcategory_image = (!empty($value->subcategory_image))?url('storage/app').'/'.$value->subcategory_image:'';
        }

        /*$user_record = user::where('id',$user_id)->get();*/

        return response()->json([
            'status'=>'200',
            'message' => 'All Category with Subcategory.',
            'results'=> $result                    
        ], 200);
    }


     /**
     * Create user
     *
     */
    public function subcategory_by_category($id)
    {           
        
        $subcategory = DB::table("tbl_subcategory")->where('status',1)->where('category_id',$id)->pluck("subcategory_name","id");
        return response()->json($subcategory);
    }
    
}