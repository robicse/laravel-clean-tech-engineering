@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> All Product Service Detail</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"> <a href="{!! route('productService.create') !!}" class="btn btn-sm btn-primary" type="button">Add Product Service</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title float-left">
                    Product Service Detail
                </h3>
                <h3 class="tile-title float-right">
                    Add More Services?
                    <a  class=" btn btn-info btn-sm float-left"  style="margin-left: 5px" onclick="modal_add_more()" data-toggle="modal" title="Add More Services"><i class="fa fa-plus"></i></a>
                </h3>
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
                                    <td>
                                        <span  style="margin-left: 5px">{{ $productServiceDetail->service->name}}</span>
                                        <span>
                                        @php
                                            $check_already_service_entry = check_already_service_entry($productService->product->id,$productServiceDetail->service->id)
                                        @endphp
                                        @if(count( $check_already_service_entry) == 0)
                                            <a class=" btn btn-danger btn-sm float-left"  style="margin-left: 5px"  onclick="deleteService({{ $productServiceDetail->id }})" data-toggle="modal" title="Are you sure you want to delete This Service?"><i class="fa fa-minus"></i></a>
                                        @endif
                                        </span>
                                    </td>
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

            <!-- Credit Sale -->
            <div id="add_more_modal" class="modal fade" role="dialog">
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
                                                        <input type="hidden" class="form-control" name="product_id" id="product_id" value="{{ $productService->product_id }}">
                                                        <input type="hidden" class="form-control" name="product_service_id" id="product_service_id" value="{{ $productService->id }}">
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

        </div>
    </main>
@endsection

@push('js')
    <script>
        function deleteService(rowId) {
            if (confirm("Are you sure, delete this Service!")) {
                $.ajax({
                    url: "{{ URL('/productServiceDetailRemove') }}/" + rowId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        console.log(data)
                        window.location.reload();
                    },
                    error: function (err) {
                        console.log(err)
                    }
                });
            }
        }

        function modal_add_more(){
            $('#add_more_modal').modal('show');
        }

        $('#service_id').on('change',function (){
            var current_service_id = $('#service_id').val();
            var current_product_id = $('#product_id').val();

            $.ajax({
                url : "{{URL('check-product-service-exists')}}",
                method : "get",
                data : {
                    current_service_id : current_service_id,
                    current_product_id : current_product_id,
                },
                success : function (res){
                    console.log(res.data)
                    if(res.data == 1){
                        alert('Already added this service for this product! Please another service.');

                        $("#service_id").val("");
                    }
                },
                error : function (err){
                    console.log(err)
                }
            })

        });
    </script>
@endpush


