<?php

namespace App\Http\Controllers;

use App\Service;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function index()
    {
        $services = Service::latest()->get();
        return view('backend.service.index',compact('services'));
    }


    public function create()
    {
        return view('backend.service.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'name' => 'required|unique:services,name',

        ]);
        $services = new Service();
        $services->name = $request->name;
        $services->status = $request->status;
        $services->save();
        Toastr::success('Service Created Successfully', 'Success');
        return redirect()->route('service.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $services = Service::find($id);
        return view('backend.service.edit',compact('services'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [

            //'name' => 'required|unique:services,name',

        ]);
        $services = Service::find($id);
        $services->name = $request->name;
        $services->status = $request->status;
        $services->save();
        Toastr::success('Service Created Successfully', 'Success');
        return redirect()->route('service.index');
    }

    public function destroy($id)
    {
        $services = Service::find($id);
        $services->delete();
        Toastr::success('Service Deleted Successfully', 'Success');
        return redirect()->route('service.index');
    }
    public function checkName(Request $request )
    {
       $name = $request->name;
       $exist_name = Service::where('name',$name)->get();
       if(count ($exist_name) >0){
           $check_name = 'Found';
       }else{
           $check_name = 'Not Found';
       }
        return response()->json(['success'=>true,'data'=>$check_name]);
    }
}
