<?php

namespace App\Http\Controllers\Website\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Subcategory;
use App\Models\Category;
use Carbon\Carbon;
use Redirect;
use Session;
use DataTables;

class SubcategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.subcategory.subcategory');
    }

    public function getData()
    { 
        $record = Subcategory::select('tbl_subcategory.id as subcategoryId','tbl_subcategory.category_id as categoryId','tbl_subcategory.subcategory_name as subcategoryName','tbl_subcategory.subcategory_image as subcategoryImage','tbl_subcategory.created_at as subcategoryCreatedat','tbl_subcategory.updated_at as subcategoryUpdatedat','tbl_subcategory.status as subcategorystatus','tbl_category.category_name as categoryName','tbl_category.created_at as categoryCreatedAt','tbl_category.updated_at as categoryUpdatedAt')
                    ->join('tbl_category', 'tbl_subcategory.category_id', '=', 'tbl_category.id')
                    ->where('tbl_category.status',1)
                    ->orderBy('tbl_subcategory.id', 'desc')
                    ->get();
        return datatables()->of($record)->toJson();
    }


    public function create()
    { 
        $category_record = Category::where('status',1)->get();
        return view('Website.subcategory.subcategory_add',compact('category_record'));
    }


    public function store(Request $request)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'subcategory_name' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.subcategory')->withErrors($validator);
            }

            $data = [
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name

            ];

            $dataset = Subcategory::create($data);
            $subcategory_id = $dataset->id;

            /* subCategory image upload start */
            if(!empty($request->subcategory_image))
            {
                $subcategory_img_name = Storage::put('subcategory_image', $request->subcategory_image);
                if($subcategory_img_name){
                    Subcategory::where('id', $subcategory_id)->update(['subcategory_image' => $subcategory_img_name]);
                }
            }
            /* subCategory image upload close */

            if($dataset)
            {   
                return redirect()->route('website.subcategory')->with('success','Record Insert successfully');
            }else{
                return redirect()->route('website.subcategory')->with('error','Record Not Inserted !!');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.subcategory')->with('error',$e->getMessage());   
        }
    }


    public function edit($id)
    { 
        $subcategory_record = Subcategory::find($id);
        $category_record = Category::where('status',1)->get();

        return view('Website.subcategory.subcategory_edit',compact(['category_record','subcategory_record']));
    }


    public function update(Request $request, $id)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'subcategory_name' => 'required|string',
                'status' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.subcategory')->withErrors($validator);
            }

            $group = Subcategory::find($id);           
            $group->category_id =  $request->get('category_id');
            $group->subcategory_name =  $request->get('subcategory_name');
            $group->status =  $request->get('status');
            $group->save();

            /* subcategory image upload start */
            if(!empty($request->subcategory_image))
            {
                $subcategory_img_name = Subcategory::select('subcategory_image')->where('id',$id)->first();
                if(!empty($subcategory_img_name->subcategory_image) && $subcategory_img_name->subcategory_image != "subcategory_image/default.jpg"){
                    Storage::delete('subcategory_image', $subcategory_img_name->subcategory_image);
                }
                $subcategory_img_name = Storage::put('subcategory_image', $request->subcategory_image);
                if($subcategory_img_name){ 
                    Subcategory::where('id', $id)->update(['subcategory_image' => $subcategory_img_name]);
                }
            }
            /* subcategory image upload close */

            return redirect()->route('website.subcategory')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.subcategory')->with('error',$e->getMessage());   
        }
    }


    public function deleted($id)
    { 
        try {
            Subcategory::where('id',$id)->delete();
            return redirect()->route('website.subcategory')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.subcategory')->with('error',$e->getMessage());   
        }
    }

    
}
