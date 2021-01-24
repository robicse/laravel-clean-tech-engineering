<?php

namespace App\Http\Controllers;

use App\SaleService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    public function dashboard(){
       return view('backend.user-dashboard.dashboard');
    }
    public function editProfile(){
       return view('backend.user-dashboard.profile');
    }
    public function productHistory()
    {
        $productHistory = \App\ProductSale::where('party_id', Auth::User()->party_id)->latest()->get();
        //dd($productHistory);
//        $product = DB::table('product_sale_details')
//            //->join('product_sales','product_sale_details.product_sale_id','product_sales.id')
//            ->join('products','product_sale_details.product_id','=','products.id')
//            ->select('products.id','products.name')
//            ->first();
        //dd($product);
        //$product_name = $product ;
        //dd($product_name);
        $saleService = SaleService::latest()->get();
        return view('backend.user-dashboard.product-history', compact('product','productHistory','saleService'));
    }
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
//            'mobile_number'=> 'required',
        ]);
        $user = \App\User::findOrFail(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
//        $user->mobile_number = $request->mobile_number;
        $user->save();

        Toastr::success('Profile Updated Successfully','Success');
        return redirect()->back();
    }
    public function changedPassword()
    {
        return view('backend.user-dashboard.edit-password');
    }

    public function changedPasswordUpdated(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $hashedPassword = Auth::user()->password;
        // dd($hashedPassword);
        if (Hash::check($request->old_password, $hashedPassword)) {
            //dd('okk');
            if (!Hash::check($request->password, $hashedPassword)) {
                $user = \App\User::find(Auth::id());
                //dd($user);
                $user->password = Hash::make($request->password);
                dd($user);
                $user->save();
                Toastr::success('Password Updated Successfully','Success');
                Auth::logout();
                return redirect()->route('login');
            } else {
                Toastr::error('New password cannot be the same as old password.', 'Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Current password not match.', 'Error');
            return redirect()->back();
        }

    }
}
