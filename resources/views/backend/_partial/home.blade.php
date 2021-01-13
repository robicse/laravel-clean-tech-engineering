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
            @if(Auth::User()->getRoleNames()[0] == "Admin")
                @if(!empty($stores))
                    @foreach($stores as $store)
                        <div class="col-md-12">
                            <h1 class="text-center">{{$store->name}}</h1>
                        </div>

                        @php
                            $sum_purchase_price = 0;
                            $sum_sale_price = 0;
                            $sum_sale_return_price = 0;
                            $sum_production_price = 0;
                            $sum_profit_amount = 0;
                            $sum_loss_amount = 0;

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

                            if(!empty($productPurchaseDetails)){
                                foreach($productPurchaseDetails as $key => $productPurchaseDetail){
                                    $purchase_average_price = $productPurchaseDetail->sub_total/$productPurchaseDetail->qty;
                                    $sum_purchase_price += $productPurchaseDetail->sub_total;

                                    // sale
                                    $productSaleDetails = DB::table('product_sale_details')
                                        ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                        ->where('product_id',$productPurchaseDetail->product_id)
                                        ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                        ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                        ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                        ->groupBy('product_id')
                                        ->groupBy('product_category_id')
                                        ->groupBy('product_sub_category_id')
                                        ->groupBy('product_brand_id')
                                        ->first();

                                    if(!empty($productSaleDetails))
                                    {
                                        $sale_total_qty = $productSaleDetails->qty;
                                        $sum_sale_price += $productSaleDetails->sub_total;
                                        $sale_average_price = $productSaleDetails->sub_total/ (int) $productSaleDetails->qty;

                                        if($sale_total_qty > 0){
                                            $amount = ($sale_average_price*$sale_total_qty) - ($purchase_average_price*$sale_total_qty);
                                            if($amount > 0){
                                                $sum_profit_amount += $amount;
                                            }else{
                                                $sum_loss_amount -= $amount;
                                            }

                                        }
                                    }

                                    // sale return
                                    $productSaleReturnDetails = DB::table('product_sale_return_details')
                                        ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'))
                                        ->where('product_id',$productPurchaseDetail->product_id)
                                        ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                        ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                        ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                        ->groupBy('product_id')
                                        ->groupBy('product_category_id')
                                        ->groupBy('product_sub_category_id')
                                        ->groupBy('product_brand_id')
                                        ->first();

                                    if(!empty($productSaleReturnDetails))
                                    {
                                        $sale_return_total_qty = $productSaleReturnDetails->qty;
                                        $sale_return_total_amount = $productSaleReturnDetails->price;
                                        $sum_sale_return_price += $productSaleReturnDetails->price;
                                        $sale_return_average_price = $sale_return_total_amount/$productSaleReturnDetails->qty;

                                        if($sale_return_total_qty > 0){
                                            $amount = $sale_return_average_price - ($purchase_average_price*$sale_return_total_qty);
                                            if($amount > 0){
                                                $sum_profit_amount -= $amount;
                                            }else{
                                                $sum_loss_amount += $amount;
                                            }
                                        }
                                    }

                                    // product production
                                    $productProductionDetails = DB::table('product_production_details')
                                        ->select('product_id','product_category_id','product_sub_category_id','product_brand_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as price'), DB::raw('SUM(sub_total) as sub_total'))
                                        ->where('product_id',$productPurchaseDetail->product_id)
                                        ->where('product_category_id',$productPurchaseDetail->product_category_id)
                                        ->where('product_sub_category_id',$productPurchaseDetail->product_sub_category_id)
                                        ->where('product_brand_id',$productPurchaseDetail->product_brand_id)
                                        ->groupBy('product_id')
                                        ->groupBy('product_category_id')
                                        ->groupBy('product_sub_category_id')
                                        ->groupBy('product_brand_id')
                                        ->first();

                                    if(!empty($productProductionDetails))
                                    {
                                        $production_total_qty = $productProductionDetails->qty;
                                        $sum_production_price += $productProductionDetails->sub_total;
                                        $production_average_price = $productProductionDetails->sub_total/$productProductionDetails->qty;

                                        if($production_total_qty > 0){
                                            $amount = ($production_average_price*$production_total_qty) - ($purchase_average_price*$production_total_qty);
                                            if($amount > 0){
                                                $sum_profit_amount += $amount;
                                            }else{
                                                $sum_loss_amount -= $amount;
                                            }
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
                        @endphp


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
