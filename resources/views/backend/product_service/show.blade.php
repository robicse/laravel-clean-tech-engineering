@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Product Service Detail</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productService.create') !!}" class="btn btn-sm btn-primary" type="button">Add Service</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Service Detail</h3>
                <form method="post" action="{{ route('productServiceDetail.update',$productService->id) }}">
                    @csrf
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">SL NO</th>
                                <th width="15%">Product Name</th>
                                <th width="15%">Service Name</th>
                                <th width="15%">Service Month Duration</th>
                                <th width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productServiceDetails as $key => $productServiceDetail)
                                <tr @if($productServiceDetail->status == '2') style="background-color:red;" @endif>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $productService->product->name}}</td>
                                    <td>{{ $productServiceDetail->service->name}}</td>
                                    <td>
                                        <input type="hidden" id="product_service_detail_id" name="product_service_detail_id[]" value="{{ $productServiceDetail->id }}"  class="form-control">
                                        <input type="number" id="service_month_duration" name="service_month_duration[]" value="{{ $productServiceDetail->service_month_duration }}"  class="form-control">
                                    </td>
                                    <td>
                                        <select name="status[]" id="status" class="form-control">
                                            <option value="1" {{ $productServiceDetail->status == 1 ? 'selected' : '' }}>active</option>
                                            <option value="2" {{ $productServiceDetail->status == 2 ? 'selected' : '' }}>inactive</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form-group row">
                        <div class="form-group row" style="margin-top: 20px">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit"><i
                                        class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </main>
@endsection


