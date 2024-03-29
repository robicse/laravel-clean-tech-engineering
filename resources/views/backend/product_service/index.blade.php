@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Product Service</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productService.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product Service</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Product Service Table</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">SL NO</th>
                                <th width="15%">Product Name</th>
                                <th width="15%">Total Year From Start Date</th>
                                <th width="15%">Status</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productServices as $key => $productService)
                                <tr @if($productService->status == '2') style="background-color:red;" @endif>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $productService->product->name}}</td>
                                    <td>{{ $productService->total_year_from_start_date}}</td>
                                    <td>{{ $productService->status == '1' ? 'Active' : 'Inactive'}}</td>
                                    <td>
                                        <a href="{{ route('productService.edit',$productService->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px" title="Edit Product Year And Active Inactive"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('productService.show',$productService->id) }}" class="btn btn-sm btn-success float-left" style="margin-left: 5px" title="Show And Edit Product Service Month And Active Inactive"><i class="fa fa-eye"></i></a>
                                    </td>
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


