@extends('backend._partial.dashboard')


@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Stock</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><a class="btn btn-warning" href="{{ route('stock.export') }}">Export Data</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Stock Table</h3>
                <form class="form-inline" action="{{ route('stock-purchase.allStock') }}">
                    <div class="form-group col-md-4">
                        <label for="start_date">Start Date:</label>
                        <input type="date" name="start_date" class="form-control" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="end_date">End Date:</label>
                        <input type="date" name="end_date" class="form-control" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{!! route('stock-purchase.allStock') !!}" class="btn btn-primary" type="button">Reset</a>
                    </div>
                </form>

                <br/>

                @if(!empty($stores))
                    @foreach($stores as $store)
                        <div class="col-md-12">
                            <h1 class="text-center">{{$store->name}}</h1>
                        </div>
{{--                        <div class="col-md-12">--}}
{{--                            <h1 class="text-center">--}}
{{--                                {{$store->name}}--}}
{{--                                <a href="{{ route('stock_sync') }}" class="btn btn-sm btn-success float-right p-2" role="button">Stock Synchronize</a>--}}
{{--                            </h1>--}}
{{--                        </div>--}}
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SL NO</th>
{{--                                    <th>Product Type</th>--}}
                                    <th>Brand</th>
                                    <th>Product</th>
{{--                                    <th>Party</th>--}}
                                    <th>Stock Type</th>
                                    <th>Previous Stock</th>
                                    <th>Stock In</th>
                                    <th>Stock Out</th>
                                    <th>Current Stock</th>
                                    <th style="width: 15%">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $custom_start_date = $start_date;
                                    $custom_end_date = $end_date;
                                    //dd($custom_start_date);
                                         $auth_user_id = Auth::user()->id;
                                         $auth_user = Auth::user()->roles[0]->name;
                                         //dd($auth_user);
                                         if($start_date  != '' && $end_date  != '') {
                                                if ($auth_user == "Admin") {
                                                    $stocks = \App\Stock::where('date', '>=', $custom_start_date)->where('date', '<=', $custom_end_date)->where('store_id',$store->id)->latest('id','desc')->get();
                                                //dd($stocks);
                                                } else {
                                                    $stocks = \App\Stock::where('date', '>=', $custom_start_date)->where('date', '<=', $custom_end_date)->where('store_id',$store->id)->latest('id','desc')->get();
                                                }
                                            }
                                               else{
                                                 $stocks = \App\Stock::where('store_id',$store->id)->latest()->get();
                                               }
                                @endphp
                                @foreach($stocks as $key => $stock)
                                    <tr>
{{--                                        <td>{{ $key+1 }}</td>--}}
                                        <td>{{ $stock->id }}</td>
{{--                                        <td>{{ $stock->product->product_type}}</td>--}}
                                        <td>{{ $stock->product->product_brand->name}}</td>
                                        <td>{{ $stock->product->name}}</td>
{{--                                        <td>--}}
{{--                                            @php--}}
{{--                                                if($stock->stock_type == 'purchase'){--}}
{{--                                                    echo $party_name = DB::table('stocks')--}}
{{--                                                    ->join('product_purchases','stocks.ref_id','product_purchases.id')--}}
{{--                                                    ->join('parties','product_purchases.party_id','parties.id')--}}
{{--                                                    ->where('stocks.id',$stock->id)--}}
{{--                                                    ->pluck('parties.name')--}}
{{--                                                    ->first();--}}
{{--                                                }elseif($stock->stock_type == 'sale'){--}}
{{--                                                    echo $party_name = DB::table('stocks')--}}
{{--                                                    ->join('product_sales','stocks.ref_id','product_sales.id')--}}
{{--                                                    ->join('parties','product_sales.party_id','parties.id')--}}
{{--                                                    ->where('stocks.id',$stock->id)--}}
{{--                                                    ->pluck('parties.name')--}}
{{--                                                    ->first();--}}
{{--                                                }elseif($stock->stock_type == 'sale return'){--}}
{{--                                                    echo $party_name = DB::table('stocks')--}}
{{--                                                    ->join('product_sale_returns','stocks.ref_id','product_sale_returns.id')--}}
{{--                                                    ->join('parties','product_sale_returns.party_id','parties.id')--}}
{{--                                                    ->where('stocks.id',$stock->id)--}}
{{--                                                    ->pluck('parties.name')--}}
{{--                                                    ->first();--}}
{{--                                                }elseif($stock->stock_type == 'replace'){--}}
{{--                                                    echo $party_name = DB::table('stocks')--}}
{{--                                                    ->join('product_sale_replacements','stocks.ref_id','product_sale_replacements.id')--}}
{{--                                                    ->join('parties','product_sale_replacements.party_id','parties.id')--}}
{{--                                                    ->where('stocks.id',$stock->id)--}}
{{--                                                    ->pluck('parties.name')--}}
{{--                                                    ->first();--}}
{{--                                                }else{--}}
{{--                                                    echo $party_name = DB::table('parties')--}}
{{--                                                    ->where('type','own')--}}
{{--                                                    ->pluck('name')--}}
{{--                                                    ->first();--}}
{{--                                                }--}}
{{--                                            @endphp--}}
{{--                                        </td>--}}
                                        <td>
                                            {{ $stock->stock_type}}
                                        </td>
                                        <td>{{ $stock->previous_stock}}</td>
                                        <td>{{ $stock->stock_in}}</td>
                                        <td>{{ $stock->stock_out}}</td>
                                        <td>{{ $stock->current_stock}}</td>
                                        <td>{{ $stock->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="tile-footer">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </main>
@endsection


