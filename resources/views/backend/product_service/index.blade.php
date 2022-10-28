@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Product Service</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productService.create') !!}" class="btn btn-sm btn-primary" type="button">Add Service</a></li>
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
                                        <a href="{{ route('productService.edit',$productService->id) }}" class="btn btn-sm btn-primary float-left" style="margin-left: 5px"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('productService.show',$productService->id) }}" class="btn btn-sm btn-success float-left" style="margin-left: 5px"><i class="fa fa-eye"></i></a>
                                        <a  class=" btn btn-info btn-sm float-left"  style="margin-left: 5px" onclick="modal_customer()" data-toggle="modal"><i class="fa fa-plus"></i></a>
                                    </td>
                                </tr>

                                <!-- Credit Sale -->
                                <div id="customar_modal" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:green; color: white">
                                                <h4>Add more service</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="customerErrr3" class="alert hide"> </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <div class="panel panel-bd lobidrag">
                                                            <div class="panel-body">
                                                                <form method="post" action="{{ route('productServiceDetail.store') }}">
                                                                    @csrf
                                                                    <div class="form-group row">
                                                                        <label class="control-label col-md-3 text-right">Service <small class="text-danger">*</small></label>
                                                                        <div class="col-md-9">
                                                                            <select class="form-control select2" name="service_id" id="service_id" required style="width: 80%">
                                                                                <option value="">Select Service</option>
                                                                                @foreach($services as $service)
                                                                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="control-label col-md-3 text-right">Service Month Duration <small class="text-danger">*</small></label>
                                                                        <div class="col-md-9">
                                                                            <input type="hidden" class="form-control" name="product_id" value="{{ $productService->product_id }}">
                                                                            <input type="hidden" class="form-control" name="product_service_id" value="{{ $productService->id }}">
                                                                            <input type="text" min="1" max="" class="form-control" name="service_month_duration" required  style="width: 80%">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="control-label col-md-3 text-right">&nbsp;</label>
                                                                        <div class="col-md-5">
                                                                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
@push('js')
    <script>
        function modal_customer(){
            $('#customar_modal').modal('show');
        }
    </script>
@endpush

