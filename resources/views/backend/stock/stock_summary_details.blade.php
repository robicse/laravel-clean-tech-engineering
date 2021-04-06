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
                <h3 class="tile-title">Stock Details</h3>
                <div class="col-md-12"></div>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>

                            <th width="5%">#Id</th>
                            <th width="10%">Store</th>
                            <th width="15%">date</th>
                            <th width="12%">Brand</th>
                            <th width="12%">Product</th>
                            <th width="12%">Current Stock</th>
                            <th width="12%"> Price</th>



                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $total_price = 0;
                        @endphp
                        @foreach($stocks as $key => $stock)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $stock->store->name}}</td>
                                <td>{{ $stock->date}}</td>
                                <td>{{ $stock->product->product_brand->name}}</td>
                                <td>{{ $stock->product->name}}</td>
                                @php

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

                                        }
                                            }
                                         $total_price += $sum_price;
                                            //dd($total_price);
                                @endphp
                                <td>{{ $stock->current_stock}}</td>
                                <td>{{$stock->current_stock*$product_avrg_price}}</td>

                            </tr>
                        @endforeach
                        <tr style="color: red">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>total</td>
                            <td>{{$total_price}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="tile-footer">
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection


