@extends('backend.user-dashboard.master')
@section('title','Dashboard')
@push('css')

    <style>
        .cards{
            /*border-radius: 21%;*/
            padding: 4%;
            width: 35%;
            }
        .row{
            border-radius: 14px;
        }
        .text-white{
            color: #FFFFFF!important;
        }
        .bg-dark{
            background-color: #1c2d3f;
        }
        .bg-primary{
            background-color: #0f3e68;
        }
        .bg-warning{
            background-color: #8d2d5e;
        }
        @media only screen and (min-width: 992px) {
            .c-layout-header-fixed .c-layout-page{
                margin-top: 0px!important;
            }
        }
        @media only screen and (max-width: 700px) {
            .cards{
                margin-left:20px!important;
                width: 25%!important;
            }
            .c-layout-header-fixed .c-layout-page{
                margin-top: 0px!important;
            }
        }

    </style>
@endpush
@section('content')
    <div class="c-layout-page">
        <!-- BEGIN: LAYOUT/BREADCRUMBS/BREADCRUMBS-2 -->
        <div class="c-layout-breadcrumbs-1 c-subtitle c-fonts-uppercase c-fonts-bold c-bordered c-bordered-both">
            <div class="container">
                <div class="c-page-title c-pull-left">
                    <h3 class="c-font-uppercase c-font-sbold"> Dashboard</h3>
                </div>
                <ul class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular">
                    <li><a href="#"> Dashboard</a></li>
                </ul>
            </div>
{{--            @php--}}
{{--                echo '<pre>';--}}
{{--    print_r(Auth::User()->getRoleNames()[0]);--}}
{{--                echo '</pre>';--}}
{{--            @endphp--}}
        </div><!-- END: LAYOUT/BREADCRUMBS/BREADCRUMBS-2 -->
        <div class="container">
            <div class="c-layout-sidebar-menu c-theme ">
                <!-- BEGIN: LAYOUT/SIDEBARS/SHOP-SIDEBAR-DASHBOARD -->
                <div class="c-sidebar-menu-toggler">
                    <h3 class="c-title c-font-uppercase c-font-bold">My Profile</h3>
                    <a href="javascript:;" class="c-content-toggler" data-toggle="collapse" data-target="#sidebar-menu-1">
                        <span class="c-line"></span> <span class="c-line"></span> <span class="c-line"></span>
                    </a>
                </div>

                @include('backend.user-dashboard.sidebar')
            </div>
            <div class="c-layout-sidebar-content ">
                <!-- BEGIN: PAGE CONTENT -->
                <!-- BEGIN: CONTENT/SHOPS/SHOP-CUSTOMER-DASHBOARD-1 -->
                <div class="c-content-title-1">
                    <h3 class="c-font-uppercase c-font-bold">My Dashboard</h3>
                    <div class="c-line-left"></div>
                </div>
                @if (Auth::User()->getRoleNames()[0] == 'Customer')
{{--                    @php--}}
{{--                        $products = DB::table('product_sales')--}}
{{--                             ->join('product_sale_details', 'product_sales.id', '=', 'product_sale_details.product_sale_id')--}}
{{--                             ->join('products', 'products.id', '=', 'product_sale_details.product_id')--}}
{{--                             ->where('product_sale_details.product_sale_id', $productHistory->id)--}}
{{--                             ->select('products.id','products.name')--}}
{{--                             ->get();--}}
{{--dd($products);--}}
{{--                    @endphp--}}
                @php
                    $total_order = $productHistory->count();
                   $product_sales =\App\ProductSale::where('party_id', Auth::User()->party_id)->latest()->get();
                    if(!empty($product_sales)){
                            foreach($product_sales as $key => $product_sale)
                            {
                    $products = \Illuminate\Support\Facades\DB::table('product_sale_details')
                                                                ->join('product_sales','product_sales.id','=','product_sale_details.product_sale_id')
                                                                 ->where('product_sale_details.product_sale_id',$product_sale->id)
                                                                //->join()
                                                                   ->select('product_sale_details.product_id')
                                                               ->get();
                                                                //->count();


//dd($products);

                            }

                            }

                @endphp
                <div class="row">
                    <a class="text-white" href="">
                        <div class="cards col-md-3 col-sm-3 col-xs-3">
                            <div class="row bg-primary">
                                <h3 class="text-center text-white">Total Order Amount of Order</h3>
                                <div class="col-md-12 text-center text-white">
                                    <h1 class="text-white">{{$total_order}}</h1>
                                </div>
                            </div>
                        </div>
                    </a>
{{--                    <a class="text-white" href="">--}}
{{--                        <div class="cards col-md-3 col-sm-3 col-xs-3">--}}
{{--                            <div class="row bg-dark">--}}
{{--                                <h3 class="text-center text-white">Total Amount of Product</h3>--}}
{{--                                <div class="col-md-12 text-center text-white">--}}
{{--                                    <h1 class="text-white"> {{$product_count}}</h1>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
                </div>


            @elseif (Auth::User()->getRoleNames()[0] == 'Service Provider')
                    <div class="row">
                        {{--                    <a class="text-white" href="">--}}
                        {{--                        <div class="cards col-md-3 col-sm-3 col-xs-3">--}}
                        {{--                            <div class="row bg-primary">--}}
                        {{--                                <h3 class="text-center text-white">Total Order Amount of products</h3>--}}
                        {{--                                <div class="col-md-12 text-center text-white">--}}
                        {{--                                    <h1 class="text-white">tk</h1>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                    </a>--}}
                        <a class="text-white" href="">
                            <div class="cards col-md-3 col-sm-3 col-xs-3">
                                <div class="row bg-dark">
                                    <h3 class="text-center text-white">Total Amount of service</h3>
                                    <div class="col-md-12 text-center text-white">
                                        <h1 class="text-white"> service </h1>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

            @endif

                    <!-- END: CONTENT/SHOPS/SHOP-CUSTOMER-DASHBOARD-1 -->
                <!-- END: PAGE CONTENT -->
            </div>
        </div>
    </div>
@stop
@push('js')
@endpush
