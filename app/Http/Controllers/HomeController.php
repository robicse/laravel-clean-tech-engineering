<?php

namespace App\Http\Controllers;

use App\Offer;
use App\Party;
use App\Product;
use App\Service;
use App\Store;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
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

        $stores = Store::all();
        $customer = Party::where('type','customer')->get()->count();
        $servise_executive = User::where('type','executive')->get()->count();
        $service_provider = User::where('type','provider')->get()->count();
        $product = Product::all()->count();
        $service = Service::all()->count();
        $offers = Offer::all()->count();
        return view('backend._partial.home', compact('product','stores','customer','service_provider','servise_executive','service','offers'));
    }
}
