<?php

namespace App\Http\Controllers;

use App\Helpers\UserInfo;
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
        $saleServices = SaleService::orderBy('date','ASC')->get();;
        $serviceProviders = User::where('name','!=','Admin')->where('store_id',NULL)->where('party_id',NULL)->get();

        return view('backend.monthly-service.index',compact('saleServices','serviceProviders'));
    }

    public function sendSMS(Request $request){

        //dd($request->all());
        //$text = "Dear ".$user->name.", Your Prevent Care OTP is ".$verCode->code;
        $service= DB::table('sale_services')
                    ->join('services', 'services.id', '=', 'sale_services.service_id')
                     ->where('services.id', '=', $request->service_id)
                    ->select('services.name')
                    ->first();
        $service_name = $service->name;

        $service_provider= DB::table('users')
                                //->where('name','!=','Admin')
                                //->where('store_id',NULL)
                                //->where('party_id',NULL)
                                ->where('id',$request->service_provider_id)
                                ->select('users.name','users.phone')
                                ->first();

        $service_provider_name = $service_provider->name;
        $service_provider_phone = $service_provider->phone;
        //dd($service_provider_phone);
        $customer = DB::table('parties')
            ->where('id',$request->customer_id)
            ->select('parties.name','parties.phone','parties.address','parties.id')
            ->first();
        if(!empty($customer)){
            $customer_name = $customer->name;
            $customer_phone = $customer->phone;
            $customer_address = $customer->address;
        }else{
            $customer_name = '';
            $customer_phone = '';
            $customer_address = '';
        }

        //dd($service_name);
        $text_for_customer = "Dear, $customer_name ,Your service given by $service_provider_name.$service_provider_name Number:, Address:,And Your Service Name is $service_name";
        //dd($text_for_customer);
        //$text_for_provider = "Dear,  robi,Your next work with $customer_name.$customer_name's Mobile No: is $customer_phone,Address: $customer_address,And Service Name is:$service_name";
        $text_for_provider = "Dear, $service_provider_name,Your next work with $customer_name. $customer_name's Mobile No: is $customer_phone,Address: $customer_address,And Your Service Name is:$service_name";
        //dd($text_for_provider);
        UserInfo::smsAPI("88".$customer_phone,$text_for_customer);
        UserInfo::smsAPI("88".$service_provider_phone,$text_for_provider);
        //UserInfo::smsAPI("8801703500587",$text_for_customer);
        //UserInfo::smsAPI("8801703500587",$text_for_provider);
        return redirect()->back();
    }
}
