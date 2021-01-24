@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Monthly Service</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('service.create') !!}" class="btn btn-sm btn-primary" type="button">Add Service</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
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
                            <th width="15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($saleServices as $key=>$saleService)
                            <tr>
                                <td width="5%" >{{$key+1}}</td>
                                <td width="20%"> {{$saleService->service->name}}</td>
                                <td width="20%"> {{$saleService->date}}</td>
{{--                                <td width="20%">{{$saleService->product_sale_details->productsale->party->name}} </td>--}}
                                <td width="20%">
                                    @php

                                        //$customer = DB::table('product_sale_details')
                                           // ->join('product_sale_details', 'sale_services.product_sale_detail_id', '=', 'product_sale_details.id')
                                           // ->join('product_sales', 'product_sale_details.product_sale_id' , '=',' product_sales.id')
                                            //->leftJoin('parties', ' parties.id', '=', 'product_sales.party_id')
                                            //->where('product_sales.product_sale_id', '=', 'product_sales.id')
                                            //->select('parties.id as parties_id','parties.name','parties.phone')
                                            //->select('sale_services.*')
                                            //->get();


//dd($customer)
                                    @endphp
                                </td>
                                <td width="20%"> </td>
                                <td width="20%">
                                    <select class="form-control select2" required>
                                        <option value="">Select  Service</option>
                                        @foreach($serviceProviders as $serviceProvider)
                                            <option value="{{$serviceProvider->id}}" >{{$serviceProvider->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td width="20%"> <a href="" class="btn btn-sm btn-primary float-left" style="margin-left: 5px">send</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection


