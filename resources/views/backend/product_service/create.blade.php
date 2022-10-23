@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Add Product Service</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('productService.index') }}" class="btn btn-sm btn-primary col-sm" type="button">All Service</a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Add Product Service</h3>
                <div class="tile-body tile-footer">
                    @if (session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('productService.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">Product <small class="text-danger">*</small></label>
                            <div class="col-md-5">
                                <select class="form-control select2" name="product_id" id="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <input type="button" class="btn btn-primary add " style="margin-left: 804px; margin-bottom: 10px;" value="Add More Product">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th >ID</th>
                                        <th>Service <small class="requiredCustom">*</small></th>
                                        <th>Total Day From Start Date <small class="requiredCustom">*</small></th>
                                        <th>Service Month duration <small class="requiredCustom">*</small></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="neworderbody">
                                    <tr>
                                        <td width="5%" class="no">1</td>
                                        <td width="20%">
                                            <select class="form-control select2 service_id" name="service_id[]" id="service_id_1" required>
                                                <option value="">Select Service</option>
                                                @foreach($services as $service)
                                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td width="10%">
                                            <input type="text" min="1" max="" class="form-control" name="total_day_from_start_date[]" required >
                                        </td>
                                        <td width="10%">
                                            <input type="text" min="1" max="" class="form-control" name="service_month_duration[]" required >
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            <div class="form-group row">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-8">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
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
@push('js')
    <script>
        $(function () {
            $('.add').click(function () {
                var service = $('.service_id').html();
                var n = ($('.neworderbody tr').length - 0) + 1;
                var tr = '<tr><td class="no">' + n + '</td>' +
                    '<td><select class="form-control select2 service_id" name="service_id[]" id="service_id_'+n+'" required>'+ service +'</select></td>' +
                    '<td><input type="text" min="1" max="" class="form-control" name="total_day_from_start_date[]" required></td>' +
                    '<td><input type="text" min="1" max="" class="form-control" name="service_month_duration[]" required></td>' +
                    '<td><input type="button" class="btn btn-danger delete" value="x"></td></tr>';
                $('.neworderbody').append(tr);
                $('.select2').select2();
            });
        });

    </script>
    @endpush



