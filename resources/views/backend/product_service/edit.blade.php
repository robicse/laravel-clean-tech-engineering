@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Edit Product Service</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('productService.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Service</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Edit Product Service</h3>
                <div class="tile-body tile-footer">
                    @if (session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('productService.update',$productService->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Product <small class="text-danger">*</small></label>
                            <div class="col-md-5">
                                <select class="form-control select2" name="product_id" id="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}" {{$product->id == $productService->product_id ? 'selected' : ''}}>{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Service <small class="text-danger">*</small></label>
                            <div class="col-md-5">
                                <select class="form-control select2" name="service_id" id="service_id" required>
                                    <option value="">Select Service</option>
                                    @foreach($services as $service)
                                        <option value="{{$service->id}}" {{$service->id == $productService->service_id ? 'selected' : ''}}>{{$service->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right ">Total Day From Start Date <small class="text-danger">*</small></label>
                            <div class="col-md-5">
                                <input type="number" id="total_day_from_start_date" name="total_day_from_start_date" value="{{ $productService->total_day_from_start_date }}"  class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right ">Service Month duration <small class="text-danger">*</small></label>
                            <div class="col-md-5">
                                <input type="number" id="service_month_duration" name="service_month_duration" value="{{ $productService->service_month_duration }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Status <small class="text-danger">*</small></label>
                            <div class="col-md-5">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $productService->status == 1 ? 'selected' : '' }}>active</option>
                                    <option value="2" {{ $productService->status == 2 ? 'selected' : '' }}>inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group row" style="margin-top: 20px">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-8">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>
@endsection
