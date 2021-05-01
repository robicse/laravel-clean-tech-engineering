<?php

namespace App\Http\Controllers;

use App\Exports\StockExport;
use App\Exports\TransactionExport;
use App\Product;
use App\Stock;
use App\Store;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:stock-list', ['only' => ['stockList']]);
        $this->middleware('permission:stock-summary-list', ['only' => ['stockSummaryList']]);
        $this->middleware('permission:stock-low-list', ['only' => ['stockLowList']]);
    }

    function product_store_stock_sync($product_id,$store_id){

        $stock_data = Stock::where('product_id',$product_id)->where('store_id',$store_id)->get();
        $row_count = count($stock_data);
        if($row_count > 0){
            $store_previous_row_current_stock = null;
            $stock_in_flag = 0;
            $stock_out_flag = 0;

            foreach ($stock_data as $key => $data){

                $id = $data->id;
                $previous_stock = $data->previous_stock;
                $stock_in = $data->stock_in;
                $stock_out = $data->stock_out;
                $current_stock = $data->current_stock;

                if($key == 0){
//                    echo 'row_id =>'.$id.'<br/>';
//                    echo 'product_id =>'.$product_id.'<br/>';
//                    echo 'store_id =>'.$store_id.'<br/>';
//
//                    echo 'store_previous_row_current_stock '.$store_previous_row_current_stock.'<br/>';
//                    echo 'this_row_current_stock =>'.$current_stock.'<br/>';
//                    echo '<br/>';


                    $stock = Stock::find($id);
                    $stock->previous_stock = 0;
                    $stock->current_stock = $stock_in;
                    $affectedRow = $stock->update();
                    if($affectedRow){
//                        echo 'this_row_current_stock => updated => '.$stock_in.'<br/>';
//                        echo '<br/>';
                        $current_stock = $stock->current_stock;
                    }

                }else{
//                    echo 'row_id =>'.$id.'<br/>';
//                    echo 'product_id =>'.$product_id.'<br/>';
//                    echo 'store_id =>'.$store_id.'<br/>';
//
//                    echo 'store_previous_row_current_stock '.$store_previous_row_current_stock.'<br/>';
//                    echo 'this_row_current_stock =>'.$current_stock.'<br/>';
//                    echo '<br/>';

                    // update part
                    if($stock_in > 0){
                        if($stock_in_flag == 1){
                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock + $stock_in;
                            $affectedRow = $stock->update();
                            if($affectedRow){
//                                echo 'this_row_current_stock => updated => '.$stock_in.'<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        }else if($previous_stock != $store_previous_row_current_stock){
                            $stock_in_flag = 1;

                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock + $stock_in;
                            $affectedRow = $stock->update();
                            if($affectedRow){
//                                echo 'this_row_current_stock => updated => '.$stock_in.'<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        }else{
//                            echo 'this_row_current_stock => nothing => '.$stock_in.'<br/>';
//                            echo '<br/>';
                        }
                    }else if($stock_out > 0){
                        if($stock_out_flag == 1) {
                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock - $stock_out;
                            $affectedRow = $stock->update();
                            if ($affectedRow) {
//                                echo 'This Row('.$id.') Current Stock => updated => ' . $stock_out . '<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        }else if($previous_stock != $store_previous_row_current_stock) {
                            $stock_out_flag = 1;

                            $stock = Stock::find($id);
                            $stock->previous_stock = $store_previous_row_current_stock;
                            $stock->current_stock = $store_previous_row_current_stock - $stock_out;
                            $affectedRow = $stock->update();
                            if ($affectedRow) {
//                                echo 'This Row('.$id.') Current Stock => updated =>' . $stock_out . '<br/>';
//                                echo '<br/>';
                                $current_stock = $stock->current_stock;
                            }
                        }else{
//                            echo 'this_row_current_stock => nothing => '.$stock_out.'<br/>';
//                            echo '<br/>';
                        }
                    }else{
//                        echo 'this_row_current_stock => nothing<br/>';
//                        echo '<br/>';
                    }
//                    echo '<br/>';
                }
                $store_previous_row_current_stock = $current_stock;
            }
        }else{
//            echo 'no found!'.'<br/>';
        }
    }
    function stock_sync(){
        $stock_data = Stock::whereIn('id', function($query) {
            $query->from('stocks')->groupBy('store_id')->groupBy('product_id')->selectRaw('MIN(id)');
        })->get();

        $row_count = count($stock_data);
        if($row_count > 0){
            foreach ($stock_data as $key => $data){
                $product_id = $data->product_id;
                $store_id = $data->store_id;
                $this->product_store_stock_sync($product_id,$store_id);
            }
            Toastr::success('Stock Synchronize Successfully Updated!', 'Success');
        }
        return redirect()->back();
    }

    public function allStockList(Request $request){
        //dd($request->all());

//        $stores = Store::latest()->get();
//        $start_date = $request->start_date ? $request->start_date : '';
//        $end_date = $request->end_date ? $request->end_date : '';
//        $product_id = Input::get('product_id') ? Input::get('product_id') : '';
//        $products =Product::latest()->get();
//

//        return view('backend.stock.all-stock', compact('stores','start_date','end_date','products','product_id'));

        $stores = Store::all();
        //dd($stores);
        return view('backend.stock.all-stock', compact('stores'));
    }


    public function stockDetails(Request $request,$store_id){
            $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';
        $stocks = Stock::where('store_id',$store_id)->latest()->get();
        $stores = Store::all();
        return view('backend.stock.details', compact('stocks','start_date','end_date','stores'));
    }

    public function stockList(){
        $stores = Store::latest()->get();
        return view('backend.stock.sale-list', compact('stores'));
    }
    public function stockPurchaseList(){
        $stores = Store::latest()->get();
        return view('backend.stock.purchase-list', compact('stores'));
    }
    public function export()
    {
        //return Excel::download(new UsersExport, 'users.xlsx');
        return Excel::download(new StockExport, 'stock.xlsx');
    }

    public function stockPurchaseDetails($store_id)
    {
        $stocks = Stock::where('store_id',$store_id)->where('stock_type','=','purchase')->latest()->get();
        $stores = Store::latest()->get();
        return view('backend.stock.purchase-details', compact('stores','stocks'));
    }
    public function stockSaleDetails($store_id){
        $stocks = Stock::where('store_id',$store_id)->where('stock_type','=','sale')->latest()->get();
        $stores = Store::latest()->get();
        return view('backend.stock.sale-details', compact('stocks','stores'));
    }

    public function stockSummaryList(){
        $stores = Store::latest()->get();
        return view('backend.stock.stock_summary', compact('stores'));
    }
    public function stockSummary($store_id){
//        $stocks = Stock::where('store_id',$store_id)
//            ->whereIn('id', function($query) {
//                $query->from('stocks')->groupBy('product_id')->selectRaw('MAX(id)');
//            })->latest('id')->get();

        $stock_id = DB::table('stocks')->where('store_id',$store_id)->groupBy('product_id')->selectRaw('MAX(id)');
        $stock_qyery = Stock::where('store_id',$store_id);
        $stock_qyery->whereIn('id',$stock_id);
        $stock_qyery->latest('id');
        $stocks = $stock_qyery->get();
        //dd($stocks);

        return view('backend.stock.stock_summary_details', compact('stocks'));
    }
    public function stockLowList(){
        $stores = Store::latest()->get();
        return view('backend.stock.stock_low', compact('stores'));
    }
    public function stockLowListDEtails($store_id){
        $stocks = \App\Stock::where('store_id',$store_id)
            ->whereIn('id', function($query) {
                $query->from('stocks')->where('current_stock','<', 10)->groupBy('product_id')->selectRaw('MAX(id)');
            })->latest('id')->get();
        $stores = Store::latest()->get();
        return view('backend.stock.stock_low_details', compact('stores','stocks'));
    }
    public function stockDateWise(Request $request){
        //dd($request->all());
        $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';
        $stores = Store::all();
        return view('backend.stock.all-stock', compact('stores','start_date','end_date'));
    }
}
