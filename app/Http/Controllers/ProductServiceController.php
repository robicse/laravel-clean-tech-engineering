<?php

namespace App\Http\Controllers;

use App\Product;
use App\Service;
use App\ProductService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductServiceController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:product-service-list', ['only' => ['index','show']]);
        // $this->middleware('permission:product-service-create', ['only' => ['create','store']]);
        // $this->middleware('permission:product-service-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:product-service-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $productServices = ProductService::orderBy('product_id','asc')->get();
        return view('backend.product_service.index',compact('productServices'));
    }

    public function create()
    {
        $products = Product::where('status',1)->get();
        $services = Service::where('status',1)->get();
        return view('backend.product_service.create', compact('products','services'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'service_id*' => 'required',
            'total_day_from_start_date*' => 'required',
            'service_month_duration*' => 'required'
        ]);

        $row_count = count($request->service_id);

        for($i=0; $i<$row_count; $i++){
            $check_exists = ProductService::where('product_id',$request->product_id)->where('service_id',$request->service_id[$i])->first();
            if($check_exists){
                Toastr::warning('This Product Service Already Exists!', 'Warning');
                return redirect()->route('productService.create');
            }

            $productService = new ProductService();
            $productService->product_id = $request->product_id;
            $productService->service_id = $request->service_id[$i];
            $productService->total_day_from_start_date = $request->total_day_from_start_date[$i];
            $productService->service_month_duration = $request->service_month_duration[$i];
            $productService->status = 1;
            $productService->save();
        }

        Toastr::success('Product Service Created Successfully', 'Success');
        return redirect()->route('productService.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $productService = ProductService::find($id);
        $products = Product::where('status',1)->get();
        $services = Service::where('status',1)->get();
        return view('backend.product_service.edit', compact('productService','products','services'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'service_id' => 'required',
            'total_day_from_start_date' => 'required',
            'service_month_duration' => 'required',
            'status' => 'required',
        ]);

        $productService = ProductService::findOrFail($id);
        $check_exists = ProductService::where('product_id',$request->product_id)->where('service_id',$request->service_id)->first();
        if( $check_exists && ($productService->id != $check_exists->id) ){
            Toastr::warning('This Product Service Already Exists!', 'Warning');
            return redirect()->route('productService.create');
        }
        $productService->product_id = $request->product_id;
        $productService->service_id = $request->service_id;
        $productService->total_day_from_start_date = $request->total_day_from_start_date;
        $productService->service_month_duration = $request->service_month_duration;
        $productService->status = $request->status;
        $productService->save();
        Toastr::success('Product Service Created Successfully', 'Success');
        return redirect()->route('productService.index');
    }

    public function destroy($id)
    {
        $productService = ProductService::find($id);
        $productService->delete();
        Toastr::success('Service Deleted Successfully', 'Success');
        return redirect()->route('productService.index');
    }
}
