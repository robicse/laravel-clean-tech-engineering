@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Stock Summary</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
{{--                <li class="breadcrumb-item"><a class="btn btn-warning" href="{{ route('stock.export') }}">Export Data</a></li>--}}
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Stock Summary</h3>
                @if(!empty($stores))
                    @foreach($stores as $store)
                        <div class="col-md-12">
                            <h1 class="text-center">{{$store->name}}</h1>
                        </div>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">#Id</th>
                                    <th width="12%">Brand</th>
                                    <th width="12%">Product</th>
                                    <th width="12%">Current Stock</th>
                                    <th width="12%"> Price</th>
{{--                                    <th width="12%">Date</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    //$stocks = \App\Stock::where('store_id',$store->id)->latest()->groupBy('product_id')->get();

                                    $stocks = \App\Stock::where('store_id',$store->id)
                                    ->whereIn('id', function($query) {
                                           $query->from('stocks')->groupBy('product_id')->selectRaw('MAX(id)');
                                        })->latest('id')->get();
                                    //dd($stocks)

                                @endphp
                                @foreach($stocks as $key => $stock)
{{--                                    @php--}}
{{--                                     echo '<pre>';--}}
{{--                                        echo print_r($stock);--}}
{{--                                     echo '</pre>';--}}
{{--                                    @endphp--}}

                                    <tr>

                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $stock->product->product_brand->name}}</td>
                                        <td>{{ $stock->product->name}}</td>
                                        @php
                                            $total_price = 0;
                                            $productPurchaseDetails = DB::table('product_purchase_details')
                                                            //->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                                                            ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                                            ->where('product_purchase_details.product_id',$stock->product_id)
                                                            ->groupBy('product_id')
                                                            ->groupBy('product_category_id')
                                                            ->groupBy('product_sub_category_id')
                                                            ->groupBy('product_brand_id')
                                                            ->get();
                                             //dd($productPurchaseDetails);
                                                if(!empty($productPurchaseDetails)){
                                                    foreach($productPurchaseDetails as $key => $productPurchaseDetail){
                                                      // $purchase_average_price = $productPurchaseDetail->sub_total*$productPurchaseDetail->qty;
                                                        //dd($productPurchaseDetail);
                                                        //$sum_purchase_price += $productPurchaseDetail->sub_total;
                                                        $product_avrg_price = $productPurchaseDetail->sub_total/$productPurchaseDetail->qty;
                                                        $sum_price = $stock->current_stock*$product_avrg_price;
                                                        //dd($sum_price);
                                                        $total_price += $sum_price;
                                                        //    dd($total_price);
                                                    }
                                                }



                                        @endphp
                                        <td>{{ $stock->current_stock}}</td>
                                        <td>{{$stock->current_stock*$product_avrg_price}}</td>
{{--                                        <td>{{ $stock->date}}</td>--}}
                                    </tr>

                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
{{--                                    <td>total</td>--}}
                                    <td></td>
                                </tr>
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


