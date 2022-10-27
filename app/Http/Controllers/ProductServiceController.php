<?php

namespace App\Http\Controllers;

use App\Product;
use App\Service;
use App\ProductService;
use App\ProductServiceDetail;
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
        $services = Service::where('status',1)->get();
        return view('backend.product_service.index',compact('productServices','services'));
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
            'total_year_from_start_date' => 'required',
            'service_id*' => 'required',
            'service_month_duration*' => 'required'
        ]);

        $row_count = count($request->service_id);
        $productService = new ProductService();
        $productService->product_id = $request->product_id;
        $productService->total_year_from_start_date = $request->total_year_from_start_date;
        $productService->status = 1;
        $productService->save();
        $insert_id = $productService->id;
        if($insert_id){
            for($i=0; $i<$row_count; $i++){
                $check_exists = ProductServiceDetail::join('product_services','product_services.id','product_service_details.product_service_id')
                ->where('product_services.product_id',$request->product_id)->where('product_service_details.service_id',$request->service_id[$i])->first();
                if($check_exists){
                    Toastr::warning('This Product Service Already Exists!', 'Warning');
                    return redirect()->route('productService.create');
                }

                $productService = new ProductServiceDetail();
                $productService->product_service_id = $insert_id;
                $productService->service_id = $request->service_id[$i];
                $productService->service_month_duration = $request->service_month_duration[$i];
                $productService->status = 1;
                $productService->save();
            }
        }

        Toastr::success('Product Service Created Successfully', 'Success');
        return redirect()->route('productService.index');
    }

    public function show($id)
    {
        $productService = ProductService::find($id);
        $productServiceDetails = ProductServiceDetail::where('product_service_id',$id)->get();
        $products = Product::where('status',1)->get();
        $services = Service::where('status',1)->get();
        return view('backend.product_service.show', compact('productService','products','services','productServiceDetails'));
    }

    public function edit($id)
    {
        $productService = ProductService::find($id);
        $products = Product::where('status',1)->get();
        return view('backend.product_service.edit', compact('productService','products'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'total_year_from_start_date' => 'required',
            'status' => 'required',
        ]);

        $productService = ProductService::findOrFail($id);
        $productService->product_id = $request->product_id;
        $productService->total_year_from_start_date = $request->total_year_from_start_date;
        $productService->status = $request->status;
        $productService->save();
        Toastr::success('Product Service Created Successfully', 'Success');
        return redirect()->route('productService.index');
    }

    public function ProductServiceDetailUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'product_service_detail_id*' => 'required',
            'service_month_duration*' => 'required',
            'status*' => 'required',
        ]);

        $row_count = count($request->product_service_detail_id);
        for($i=0; $i<$row_count; $i++){
            $productServiceDetail = ProductServiceDetail::findOrFail($request->product_service_detail_id[$i]);
            $productServiceDetail->service_month_duration = $request->service_month_duration[$i];
            $productServiceDetail->status = $request->status[$i];
            $productServiceDetail->save();
        }
        Toastr::success('Product Service Created Successfully', 'Success');
        return redirect()->route('productService.index');
    }

    public function ProductServiceDetailStore(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'product_service_id' => 'required',
            'service_month_duration' => 'required',
        ]);

        $check_exists = ProductServiceDetail::join('product_services','product_services.id','product_service_details.product_service_id')
                ->where('product_services.product_id',$request->product_id)->where('product_service_details.service_id',$request->service_id)->first();
        if($check_exists){
            Toastr::warning('This Product Service Already Exists!', 'Warning');
            return redirect()->route('productService.create');
        }

        $productServiceDetail = new ProductServiceDetail();
        $productServiceDetail->product_service_id = $request->product_service_id;
        $productServiceDetail->service_id = $request->service_id;
        $productServiceDetail->service_month_duration = $request->service_month_duration;
        $productServiceDetail->status = 1;
        $productServiceDetail->save();

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
