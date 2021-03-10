<?php

namespace App\Http\Controllers;

use App\Exports\StockExport;
use App\Exports\TransactionExport;
use App\Stock;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:stock-list', ['only' => ['stockList']]);
        $this->middleware('permission:stock-summary-list', ['only' => ['stockSummaryList']]);
        $this->middleware('permission:stock-low-list', ['only' => ['stockLowList']]);
    }
    public function allStockList(Request $request){
        //dd($request->all());

        $stores = Store::latest()->get();
        $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';

        return view('backend.stock.all-stock', compact('stores','start_date','end_date'));
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

    public function stockSummaryList(){
        $stores = Store::latest()->get();
        return view('backend.stock.stock_summary', compact('stores'));
    }

    public function stockLowList(){
        $stores = Store::latest()->get();
        return view('backend.stock.stock_low', compact('stores'));
    }
    public function stockDateWise(Request $request){
        //dd($request->all());
        $start_date = $request->start_date ? $request->start_date : '';
        $end_date = $request->end_date ? $request->end_date : '';
        $stores = Store::all();
        return view('backend.stock.all-stock', compact('stores','start_date','end_date'));
    }
}
