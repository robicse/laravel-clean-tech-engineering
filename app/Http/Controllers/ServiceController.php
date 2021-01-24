<?php

namespace App\Http\Controllers;

use App\SaleService;
use App\Service;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:service-list|service-create|service-edit|service-delete', ['only' => ['index','show']]);
        $this->middleware('permission:service-create', ['only' => ['create','store']]);
        $this->middleware('permission:service-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:service-delete', ['only' => ['destroy']]);
    }
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
    public function monthlyService()

    {
        $saleServices = SaleService::all();
        $serviceProviders = User::where('name','!=','Admin')->where('store_id',NULL)->where('party_id',NULL)->get();
        //$customer = DB::table('sale_services')
                    //->join('product_sale_details', 'sale_services.product_sale_detail_id', '=', 'product_sale_details.id')
                    //->leftJoin('product_sales', 'product_sale_details.product_sale_id' , '=',' product_sales.id')
                    //->where('product_sale_details.product_sale_id', '=', 'product_sales.id')
                    //->select('product_sales.id.*')
                    //->get();
            //dd($customer);
        return view('backend.monthly-service.index',compact('saleServices','serviceProviders','customer'));
    }
}
