<?php

namespace App\Http\Controllers\Website\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;
use Redirect;
use DataTables;


class CategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // $record = Category::select()->get();
        // echo "<pre>";
        // print_r($record);
        return view('Website.category.category');

    }

    public function getData()
    { 
        $record = Category::select()->get();
        return datatables()->of($record)->toJson();
    }


    public function create()
    { 
        return view('Website.category.category_add');
    }


    public function store(Request $request)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'category_name' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.category')->withErrors($validator);
            }

            $data = [
                'category_name' => $request->category_name
            ];

            $dataset = Category::create($data);
            $category_id = $dataset->id;

            /* Category image upload start */
            if(!empty($request->category_image))
            {
                $category_img_name = Storage::put('category_image', $request->category_image);
                if($category_img_name){
                    Category::where('id', $category_id)->update(['category_image' => $category_img_name]);
                }
            }
            /* Category image upload close */

            if($dataset)
            {   
                return redirect()->route('website.category')->with('success','Record Insert successfully');
            }else{
                return redirect()->route('website.category')->with('error','Record Not Inserted !!');
            }
        }catch (\Exception $e) { 
            return redirect()->route('website.category')->with('error',$e->getMessage());   
        }
    }


    public function edit($id)
    { 
        $category_record = Category::find($id);
        return view('Website.category.category_edit',compact('category_record'));
    }


    public function update(Request $request, $id)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'category_name' => 'required|string'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.category')->withErrors($validator);
            }

            $group = Category::find($id);           
            $group->category_name =  $request->get('category_name');
            $group->status =  $request->get('status');
            $group->save();

            /* Category image upload start */
            if(!empty($request->category_image))
            {
                $category_img_name = Category::select('category_image')->where('id',$id)->first();
                if(!empty($category_img_name->category_image) && $category_img_name->category_image != "category_image/default.jpg"){
                    Storage::delete('category_image', $category_img_name->category_image);
                }
                $category_img_name = Storage::put('category_image', $request->category_image);
                if($category_img_name){ 
                    Category::where('id', $id)->update(['category_image' => $category_img_name]);
                }
            }
            /* Category image upload close */

            return redirect()->route('website.category')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.category')->with('error',$e->getMessage());   
        }
    }


    public function deleted($id)
    { 
        try {
            Category::where('id',$id)->delete();
            return redirect()->route('website.category')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.category')->with('error',$e->getMessage());   
        }
    }

    
}
