<?php

namespace App\Http\Controllers;

use App\Offer;
use App\Party;
use App\Product;
use App\SaleService;
use App\Service;
use App\Store;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

  public function __construct()
    {
//        $this->middleware('auth');
//        //dd(Auth::User()->getRoleNames()[0]);
//        if(Auth::User()->getRoleNames()[0] == 'Customer'){
//            return redirect()->route('user.dashboard');
//        }
//        if(Auth::User()->getRoleNames()[0] == 'Service Provider'){
//            return redirect()->route('user.dashboard');
//        }

//        if(Auth::User()->getRoleNames()[0] == 'Service Executive'){
//            return redirect()->route('user.dashboard');
//        }
    }

    /*function __construct()
    {
        $this->middleware('permission:home-list', ['only' => ['index']]);
    }*/


    public function index()

    {
        //dd('f');
        //return view('home');
        //return view('backend._partial.home',['customers'=>$customer,'totalDue'=>$totalDue,'todaySell'=>$todaySell,'todayDue'=>$todayDue,'todaPaid'=>$todayPaid,'todayInvoice'=>$todayInvoice]);

//        Toastr::success('welcome Dashboard Successfully', 'warning');
        $current_year = date('Y');
        $current_month = date('m');
        $custom_date_start = $current_year . "-" . $current_month . "-01";
        $custom_date_end = $current_year . "-" . $current_month . "-31";
        $stores = Store::all();
        $customer = Party::where('type','customer')->get()->count();
        $servise_executive = User::where('type','executive')->get()->count();
        $service_provider = User::where('type','provider')->get()->count();
        $product = Product::all()->count();
        $service = Service::all()->count();
        $offers = Offer::all()->count();
        $saleServices = SaleService::orderBy('start_date','ASC')
            ->where('start_date','>=',$custom_date_start)
            ->where('end_date','<=',$custom_date_end)
            ->get()
            ->count();
        //dd($saleServices);
        return view('backend._partial.home', compact('product','stores','customer','service_provider','servise_executive','service','offers','saleServices'));
    }
}
