@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Product Purchases And Details</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productPurchases.index') !!}" class="btn btn-sm btn-primary" type="button">Back</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Purchases</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Created By User</th>
                            <td>{{$productPurchase->user->name}}</td>
                        </tr>
                        @if($productPurchase->updated_by_user_id)
                            <tr>
                                <th>Updated By User</th>
                                <td>{{user_name($productPurchase->updated_by_user_id)}}</td>
                            </tr>
                            <tr>
                                <th>Updated Date Time</th>
                                <td>{{$productPurchase->updated_at}}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Store</th>
                            <td>{{$productPurchase->store->name}}</td>
                        </tr>
                        <tr>
                            <th>Party</th>
                            <td>{{$productPurchase->party->name}}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{$productPurchase->date}}</td>
                        </tr>
                        <tr>
                            <th>Payment Type</th>
                            <td>{{$transaction->payment_type ? 'cash' : 'check' }}</td>
                        </tr>
{{--                        @foreach($transactions as $transaction)--}}
{{--                            <tr>--}}
{{--                                <th>Payment Type</th>--}}

{{--                                <td>{{$transaction->payment_type }} -{{$transaction->amount }} <span style="font-size: 22px;font-weight: 33">৳</span></td>--}}
{{--                                <td></td>--}}

{{--                            </tr>--}}
{{--                        @endforeach--}}
                        @if($transaction->payment_type == 'check')
                            <tr>
                                <th>Check Number</th>
                                <td>{{$transaction->check_number}}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Total Amount</th>
                            <td>{{$productPurchase->total_amount}}</td>
                        </tr>
                        <tr>
                            <th>Due Amount</th>
                            <td>{{$productPurchase->due_amount}}</td>
                        </tr>
                        <tr>
                            <th>Paid Amount</th>
                            <td>{{$productPurchase->paid_amount}}</td>
                        </tr>

                        </tbody>
                    </table>
                    <div class="tile-footer">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Purchases Details</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Category</th>
{{--                            <th>Sub Category</th>--}}
                            <th>Brand</th>
                            <th>Product Image</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
{{--                            <th>MRP Price</th>--}}
                            <th>Sub Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($productPurchaseDetails as $productPurchaseDetail)
                                <tr>
                                    <td>{{$productPurchaseDetail->product->product_category->name}}</td>
{{--                                    <td>--}}
{{--                                        {{$productPurchaseDetail->product->product_sub_category ? $productPurchaseDetail->product->product_sub_category->name : ''}}--}}
{{--                                    </td>--}}
                                    <td>{{$productPurchaseDetail->product->product_brand->name}}</td>
                                    <td>
                                        <img src="{{asset('uploads/product/'.$productPurchaseDetail->product->image)}}" width="50" height="50" />
                                    </td>
                                    <td>{{$productPurchaseDetail->product->name}}</td>
                                    <td>{{$productPurchaseDetail->qty}}</td>
                                    <td>{{$productPurchaseDetail->price}}</td>
{{--                                    <td>{{$productPurchaseDetail->mrp_price}}</td>--}}
                                    <td>{{$productPurchaseDetail->sub_total}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="tile-footer">
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


