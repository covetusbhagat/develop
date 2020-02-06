<?php

namespace App\Http\Controllers\Website\Complain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\Complaint;
use Carbon\Carbon;
use Session;
use DataTables;

class ComplainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Website.complain.complain');
    }



    public function getData()
    { 
        $record = Complaint::select('tbl_complaint.*','users.first_name as customerfirstname','users.last_name as customerlastname')
                    ->join('users', 'tbl_complaint.complaint_by', '=', 'users.id')
                    ->get();
        foreach ($record as $key => $value) {
            $record[$key]->customerfullname = $value->customerfirstname.' '.$value->customerlastname;
        }
        return datatables()->of($record)->toJson();
    }



    public function edit($id)
    { 
        $complain_record = Complaint::find($id);
        return view('Website.complain.complain_edit',compact('complain_record'));
    }


    public function update(Request $request, $id)
    { 
        try {

            $group = Complaint::find($id);           
            $group->status = $request->get('status');
            $group->save();

            return redirect()->route('website.complain')->with('success','Record Update successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.complain')->with('error',$e->getMessage());   
        }
    }

    
    public function deleted($id)
    {
        try {
            Complaint::where('id',$id)->delete();
            return redirect()->route('website.complain')->with('success','Record Delete successfully');
        }catch (\Exception $e) { 
            return redirect()->route('website.complain')->with('error',$e->getMessage());   
        }
    }


    public function display($id)
    { 
    
        $complain_record = Complaint::select('tbl_complaint.*','users.first_name as customerfirstname','users.last_name as customerlastname')
                    ->join('users', 'tbl_complaint.complaint_by', '=', 'users.id')
                    ->where('tbl_complaint.id',$id)
                    ->first();
        return view('Website.complain.complain_view',compact('complain_record'));
    }

}
