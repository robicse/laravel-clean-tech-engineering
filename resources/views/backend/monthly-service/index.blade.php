@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Monthly Service</h1>
            </div>
{{--            <ul class="app-breadcrumb breadcrumb">--}}
{{--                <li class="breadcrumb-item"> <a href="{!! route('service.create') !!}" class="btn btn-sm btn-primary" type="button">Add Service</a></li>--}}
{{--            </ul>--}}
        </div>
        <div class="col-md-12">
            <div class="tile">
                @php

                   $date = DB::table("product_sale_details")
                           ->join('sale_services','sale_services.product_sale_detail_id', '=', 'product_sale_details.id')
                           //->whereMonth('date', '=', $date_id)
                            ->select('sale_services.date')
                            ->whereMonth('sale_services.date', '=' ,'01')
                           ->get();
                   dd($date);
                @endphp
                <h2 class="tile-title" style="text-align: center">January month Services</h2>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">SL NO</th>
                            <th width="15%">Service Name</th>
                            <th width="15%">Date </th>
                            <th width="15%">Customer Name</th>
                            <th width="15%">Customer Phone</th>
                            <th width="15%">Service Provider </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($saleServices as $key=>$saleService)

                            <tr>
                                <td width="5%" >{{$key+1}}</td>
                                <td width="20%"> {{$saleService->service->name}}</td>
                                <td width="20%"> {{$saleService->date}}</td>
                                <td width="20%">
                                    @php

                                        $product_sale_detail_id = $saleService->product_sale_detail_id;
//dd($product_sale_detail_id);
                                        $customer = DB::table('product_sales')
                                            ->join('product_sale_details', 'product_sales.id', '=', 'product_sale_details.product_sale_id')
                                            ->join('parties', 'parties.id', '=', 'product_sales.party_id')
                                            ->where('product_sale_details.id', $product_sale_detail_id)
                                            ->select('parties.name','parties.phone','parties.id')
                                            ->first();

                                    if(!empty($customer)){
                                        $customer_id = $customer->id;
                                        $customer_name = $customer->name;
                                        $customer_phone = $customer->phone;
                                    }else{
                                        $customer_id = '';
                                        $customer_name = '';
                                        $customer_phone = '';
                                    }

                                    @endphp
                                    {{$customer_name}}
                                </td>
                                <td width="20%">{{$customer_phone}}</td>
                                <td width="20%">
                                    <form action="{{route('send.mail')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="customer_id" value="{{$customer_id}}">
                                        <input type="hidden" name="row_id" value="{{$saleService->id}}">
                                        <input type="hidden" name="service_id" value="{{$saleService->service->id}}">
                                        <select class="form-control select2" name="service_provider_id"  required>
                                            <option value="">Select  Service Provider</option>
                                            @foreach($serviceProviders as $serviceProvider)
                                                <option value="{{$serviceProvider->id}}" {{$serviceProvider->id == $saleService
->provider_id ? 'selected' : '' }}>{{$serviceProvider->name}}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Send</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection


