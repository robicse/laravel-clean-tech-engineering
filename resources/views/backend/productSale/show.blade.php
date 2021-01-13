@extends('backend._partial.dashboard')
<style>
    .btn .fa{font-size: 18px!important;

        margin-right: 0px!important;
        margin-top: 2px!important;
    }
</style>
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Product Sales And Details</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productSales.index') !!}" class="btn btn-sm btn-primary" type="button">Back</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
{{--                <ul class="app-breadcrumb breadcrumb">--}}
{{--                    <li class="breadcrumb-item" style="margin-left: 88%"> <a href="{!! route('productSales-invoice',$productSale->id) !!}" class="btn btn-sm btn-primary"  type="button">Print Invoice Page</a></li>--}}
{{--                </ul>--}}
                <h3 class="tile-title">Product Sales</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>User</th>
                            <td>{{$productSale->user->name}}</td>
                        </tr>
                        <tr>
                            <th>Store</th>
                            <td>{{$productSale->store->name}}</td>
                        </tr>
                        <tr>
                            <th>Party</th>
                            <td>{{$productSale->party->name}}</td>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <td>{{$productSale->date}}</td>
                        </tr>
                        @if($transaction->payment_type == 'Check')
                            <tr>
                                <th>Check Number</th>
                                <td>{{$transaction->check_number}}</td>
                            </tr>
                        @endif
    {{--                    <tr>--}}
    {{--                        <th>Delivery Service</th>--}}
    {{--                        <td>{{$productSale->delivery_service}}</td>--}}
    {{--                    </tr>--}}
                        <tr>
                            <th>Discount Type</th>
                            <td>{{$productSale->discount_type}}</td>
                        </tr>
                        <tr>
                            <th>Discount Amount</th>
                            <td>{{$productSale->discount_amount}}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>{{$productSale->total_amount}}</td>
                        </tr>
                        <tr>
                            <th>Paid Amount</th>
                            <td>{{$productSale->paid_amount}}</td>
                        </tr>
                        <tr>
                            <th>Due Amount</th>
                            <td>{{$productSale->due_amount}}</td>
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
                <h3 class="tile-title">Product Sales Details</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Return Condition</th>
                            <th>Product Image</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Sub Total</th>
                            <th>Add Services</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productSaleDetails as $productSaleDetail)
                            <tr>
                                <td>{{$productSaleDetail->product->product_category->name}}</td>
                                <td>{{$productSaleDetail->product->product_brand->name}}</td>
                                <td>{{$productSaleDetail->return_type}}</td>
                                <td>
                                    <img src="{{asset('uploads/product/'.$productSaleDetail->product->image)}}" width="50" height="50" />
                                </td>
                                <td>{{$productSaleDetail->product->name}}</td>
                                <td>{{$productSaleDetail->qty}}</td>
                                <td>{{$productSaleDetail->price}}</td>
                                <td>{{$productSaleDetail->sub_total}}</td>
                                <td><div class="col-md-3"><a type="button" class="test btn btn-primary btn-sm" href="{{route('productSales-addServices',$productSale->id)}}"><i class="fa fa-plus"></i></a></div></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="tile-footer">
                        <ul class="app-breadcrumb breadcrumb">
                            <li class="breadcrumb-item" style="margin-left: 83%"> <a href="{!! route('productSales-invoice-edit',$productSale->id) !!}" class="btn btn-sm btn-success"  type="button">Print Invoice Edit Page</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('js')

@endpush
