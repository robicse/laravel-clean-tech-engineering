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
        $current_year = date('Y');
        $current_month = date('m');
        $custom_date_start = $current_year . "-" . $current_month . "-01";
        $custom_date_end = $current_year . "-" . $current_month . "-31";
        //dd($current_year);
        $saleServices = SaleService::orderBy('date','ASC')
            ->where('date','>=',$custom_date_start)
            ->where('date','<=',$custom_date_end)
            ->get();;
        //dd($saleServices);
        $serviceProviders = User::where('name','!=','Admin')->where('store_id',NULL)->where('party_id',NULL)->get();
        $users=User::where('party_id', NULL)->where('store_id', NULL)->latest()->get();
//        $id = $users->id;
//        dd($id);

        return view('backend.monthly-service.index',compact('users','saleServices','serviceProviders','current_month'));
    }

    public function sendSMS(Request $request){

       // dd($request->all());
        //$text = "Dear ".$user->name.", Your Prevent Care OTP is ".$verCode->code;
       // $provider_id= $request->row_id;
       // dd($request->service_id);
        //$sale_service_id = $request->service_id;
        //dd($sale_service_id);
        $sale_service = SaleService::find($request->row_id);
        $sale_service->provider_id =  $request->service_provider_id;
        //dd($sale_service);
        $sale_service->update();
       // dd($sale_service);
        $service= DB::table('sale_services')
                    ->join('services','services.id','=','sale_services.service_id')
                     ->where('services.id','=',$request->service_id)
                    ->select('services.name')
                    ->first();
        //dd($service);
       $service_name = $service->name;


        $service_provider= DB::table('users')
                                //->where('name','!=','Admin')
                                //->where('store_id',NULL)
                                //->where('party_id',NULL)
                                ->where('id',$request->service_provider_id)
                                ->select('users.name','users.phone')
                                ->first();
//dd($service_provider);
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
        $text_for_customer = "Dear,Customer $customer_name ,Your service given by $service_provider_name.$service_provider_name Number: $service_provider_phone,nnnAnd Your Service Name is $service_name";
        //dd($text_for_customer);
        //$text_for_provider = "Dear,  robi,Your next work with $customer_name.$customer_name's Mobile No: is $customer_phone,Address: $customer_address,And Service Name is:$service_name";
        $text_for_provider = "Dear,Service Provider $service_provider_name,Your next work with $customer_name. $customer_name's Mobile No: is $customer_phone,Address: $customer_address,And Your Service Name is:$service_name";
        //dd($text_for_provider);
        UserInfo::smsAPI("88".$customer_phone,$text_for_customer);
        UserInfo::smsAPI("88".$service_provider_phone,$text_for_provider);
        //UserInfo::smsAPI("8801703500587",$text_for_customer);
        //UserInfo::smsAPI("8801703500587",$text_for_provider);
        return redirect()->back();
    }
}
