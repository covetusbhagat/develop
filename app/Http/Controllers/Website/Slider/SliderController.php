<?php

namespace App\Http\Controllers\Website\Slider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Slider;
use Redirect;
use DataTables;


class SliderController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.slider.slider');
    }

    public function getData()
    { 
        $record = Slider::select()->get();
        return datatables()->of($record)->toJson();
    }


    public function create()
    { 
        return view('Website.slider.slider_add');
    }


    public function store(Request $request)
    { 
        try {

            $validator = Validator::make($request->all(), [
                'slider_image' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('website.slider')->withErrors($validator);
            }

            /* Slider image upload start */
            
            
            $slider_img_name = Storage::put('slider_image', $request->slider_image);
            if($slider_img_name){
                $check = Slider::create(['slider_image' => $slider_img_name]);
                if($check)
                {   
                    return redirect()->route('website.slider')->with('success','Record Insert successfully');
                }else{
                    return redirect()->route('website.slider')->with('error','Record Not Inserted !!');
                }
            }else{
                    return redirect()->route('website.slider')->with('error','Record Not Inserted !!');
            }
            /* Slider image upload close */
            
        }catch (\Exception $e) { 
            return redirect()->route('website.slider')->with('error',$e->getMessage());   
        }
    }


    public function edit($id)
    { 
        $slider_record = Slider::find($id);
        return view('Website.slider.slider_edit',compact('slider_record'));
    }


    public function update(Request $request, $id)
    { 
        try {

            $group = slider::find($id);           
            $group->status = $request->get('status');
            $group->save();

            /* Slider image upload start */
            if(!empty($request->slider_image))
            {
                $slider_img_name = Slider::select('slider_image')->where('id',$id)->first();
                if(!empty($slider_img_name->slider_image)){
                    Storage::delete('slider_image', $slider_img_name->slider_image);
                }
                $slider_img_name = Storage::put('slider_image', $request->slider_image);
                if($slider_img_name){ 
                    Slider::where('id', $id)->update(['slider_image' => $slider_img_name]);
                }
            }
            /* Slider image upload close */

            return redirect()->route('website.slider')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.slider')->with('error',$e->getMessage());   
        }
    }


    public function deleted($id)
    { 
        try {
            Slider::where('id',$id)->delete();
            return redirect()->route('website.slider')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.slider')->with('error',$e->getMessage());   
        }
    }

    
}
