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
                <h1><i class=""></i> Show Product's Services Details</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productSales.index') !!}" class="btn btn-sm btn-primary" type="button">Back</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Show Product's Services Details</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
{{--                            <th>Product</th>--}}
{{--                            <th>Brand</th>--}}
{{--                            <th>Qty</th>--}}
{{--                            <th>Price</th>--}}
{{--                            <th>Sub Total</th>--}}
                            <th>Services</th>
                            <th>Date</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($saleServices as $saleService)
                            <tr>
{{--                                <td>{{$productSaleDetail->product->product_category->name}}</td>--}}
{{--                                <td>{{$productSaleDetail->product->product_brand->name}}</td>--}}
{{--                                <td>{{$productSaleDetail->return_type}}</td>--}}
{{--                                <td>--}}
{{--                                    <img src="{{asset('uploads/product/'.$productSaleDetail->product->image)}}" width="50" height="50" />--}}
{{--                                </td>--}}
{{--                                <td>{{$productSaleDetail->product->name}}</td>--}}
{{--                                <td>{{$productSaleDetail->qty}}</td>--}}
{{--                                <td>{{$productSaleDetail->price}}</td>--}}
                                <td>{{$saleService->service->name}}</td>
                                <td>{{$saleService->date}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </main>
@endsection

@push('js')

@endpush
