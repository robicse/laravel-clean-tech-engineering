@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
            </ul>

        </div>
        <div class="row">
            @php
            //echo '<pre>';
            //print_r(Auth::User()->getRoleNames()[0]);
            //echo '</pre>';
            @endphp
            @if(Auth::User()->getRoleNames()[0] == "Admin")
            <div class="col-md-12">
                <h1 class="text-center">All Branch</h1>
            </div>
            @php

                @endphp
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon" ><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4><a href="{{route('party.index')}}"> Total Customer</a></h4>
                        <p><b>{{$customer}} </b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon" ><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4> Total Service Executive</h4>
                        <p><b>{{$servise_executive}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon" ><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4> Total Service Providers</h4>
                        <p><b>{{$service_provider}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-basket "></i>
                    <div class="info">
                        <a href="{{route('products.index')}}"><h4>Total Products</h4></a>
                        <p><b>{{$product}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-basket "></i>
                    <div class="info">
                        <a href="{{route('service.index')}}"></a><h4>Total Services</h4>
                        <p><b>{{$service}}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-basket "></i>
                    <div class="info">
                        <a href="{{route('offers.index')}}"><h4>Offers</h4></a>
                        <p><b>{{$offers}}</b></p>
                    </div>
                </div>
            </div>
                <div class="col-md-4">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-basket "></i>
                    <div class="info">
                        <a href="{{route('monthly.services')}}"><h4>Total Monthly Service</h4></a>
                        <p><b>{{$saleServices}}</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if(!empty($stores))
                @foreach($stores as $store)
                    <div class="col-md-12">
                        <h1 class="text-center" style="margin: 50px 0 50px 0">{{$store->name}}</h1>
                    </div>

                    @php
                        $sum_purchase_price = 0;
                        $sum_sale_price = 0;
                        $sum_sale_return_price = 0;
                        $sum_production_price = 0;
                        $sum_profit_amount = 0;
                        $sum_loss_amount = 0;
                        $sum_discount_amount = 0;

                        $productPurchaseDetails = DB::table('product_purchase_details')
                            ->join('product_purchases','product_purchases.id','=','product_purchase_details.product_purchase_id')
                            ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                            ->where('product_purchases.store_id',$store->id)
                            //->where('product_purchases.ref_id',NULL)
                            //->where('product_purchases.purchase_product_type','Finish Goods')
                            ->groupBy('product_id')
                            ->groupBy('product_category_id')
                            ->groupBy('product_sub_category_id')
                            ->groupBy('product_brand_id')
                            ->get();
                                       // dd($productPurchaseDetails);
                        if(!empty($productPurchaseDetails)){

                            foreach($productPurchaseDetails as $key => $productPurchaseDetail){
                                $purchase_average_price = $productPurchaseDetail->sub_total/$productPurchaseDetail->qty;
                                $sum_purchase_price += $productPurchaseDetail->sub_total;
//dd($productPurchaseDetail->sub_total);
                                // sale
                                $productSaleDetails = DB::table('product_sale_details')
                                   ->join('product_sales','product_sales.id','=','product_sale_details.product_sale_id')
                                    ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                    ->where('product_sales.store_id',$store->id)
                                    ->where('product_id',$productPurchaseDetail->product_id)
                                    ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                    ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                    ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                    ->groupBy('product_id')
                                    ->groupBy('product_category_id')
                                    ->groupBy('product_sub_category_id')
                                    ->groupBy('product_brand_id')
                                    ->first();
//dd($productSaleDetails);
                                if(!empty($productSaleDetails))
                                {
                                    $sale_total_qty = $productSaleDetails->qty;
                                    $sum_sale_price += $productSaleDetails->sub_total;
                                    $sale_average_price = $sum_sale_price / (int) $sale_total_qty;
 //dd($sale_average_price);
                                    if($sale_total_qty > 0){
                                        $amount = ($sale_average_price*$sale_total_qty) - ($purchase_average_price*$sale_total_qty);
                                        if($amount > 0){
                                            $sum_profit_amount += $amount;
                                        }else{
                                            $sum_loss_amount -= $amount;
                                        }
//dd($amount);
                                    }
                                }

                            }
                        }

                    $total_expense = \App\Transaction::where('store_id',$store->id)->where('transaction_type','expense')->sum('amount');
                    //$final_loss_or_profit = $sum_loss_or_profit - $total_expense;
                    if($total_expense > 0){
                        $sum_profit_amount -= $total_expense;
                    }else{
                        $sum_loss_amount += $total_expense;
                    }

                    // discount
                    $productSaleDiscount = DB::table('product_sales')
                        ->select( DB::raw('SUM(discount_amount) as total_discount'))
                        ->first();
                    @endphp

                    <div class="col-md-4">
                        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                            <div class="info">
                                <h4>Total Purchase</h4>
                                <p><b>{{number_format($sum_purchase_price, 2, '.', '')}}</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-small danger coloured-icon"><i class="icon fas fa-money-check-alt "></i>
                            <div class="info">
                                <h4>Total Sell</h4>
                                <p><b>{{number_format($sum_sale_price, 2, '.', '')}}</b></p>
                            </div>
                        </div>
                    </div>
{{--                    <div class="col-md-3">--}}
{{--                        <div class="widget-small danger coloured-icon"><i class="icon fa fa-sort-amount-asc"></i>--}}
{{--                            <div class="info">--}}
{{--                                <h4>FINAL LOSS/PROFIT</h4>--}}
{{--                                <p><b>{{number_format($sum_sale_price, 2, '.', '')}}</b></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                @endforeach
            @endif
        </div>

        @else
            <h1>
                Only Admin can show At a Glance! User can only Sale permission.
                <a href="{!! route('productSales.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product Sales</a>
            </h1>
        @endif
    </main>
@endsection


@section('footer')

@endsection
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Swal.fire({
    //     title: 'Custom animation with Animate.css',
    //     showClass: {
    //         popup: 'animate__animated animate__fadeInDown'
    //     },
    //     hideClass: {
    //         popup: 'animate__animated animate__fadeOutUp'
    //     }
    // })
    //sweet alert
    function deletePost() {
        swal("Here's the title!", "...and here's the text!");
    }
</script>
