<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- Printable area end -->
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4></h4>
                </div>
            </div>
            <div id="printArea">
                <style>
                    .panel-body {
                        min-height: 1000px !important;
                        font-size: 13px !important;
                        font-family:"Times New Roman";
                        font-weight: inherit;
                    }
                    .panel-body p {
                        font-size: 13px !important;

                    }
                    .invoice {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    .invoice th {
                        /*border-top: 1px solid #000;*/
                        /*border-bottom: 1px solid #000;*/
                        border: 1px solid #000;
                        font-size: 13px;
                    }

                    .invoice td {
                        text-align: center;
                        font-size: 12px;
                        border: 1px solid #000;
                    }

                    .invoice-logo{
                        margin-right: 0;
                    }

                    .invoice-logo > img, .invoice-logo > span {
                        float: right !important;
                    }

                    .invoice-to{
                        /*border: 1px solid black;*/
                        margin: 0;
                    }

                    .footer_div {
                        position:absolute;
                        bottom: 0 !important;
                        /*border-top: 1px solid #000000;*/
                        width:100%;
                        font-size: 10px !important;
                        padding-bottom: 20px;
                    }

                    .header-border {
                        /*position: fixed;*/
                        /*top: 0mm;*/
                        /*left: 0;*/
                        width: 100%;
                        height: 160px!important;
                        margin-top: 18px;
                        border-bottom: 3px solid black; /* for demo */
                        /*background: yellow;*/ /* for demo */
                    }
                    /* default settings */
                    /*.page {*/
                    /*    page-break-after: always;*/
                    /*}*/

                    @page {
                        size: A4;
                        /*size: Letter;*/
                        /*margin: 0px !important;*/
                        /*margin: 16px 100px !important;*/
                        margin: 16px 50px !important;
                    }


                    /*@media print {*/
                    /*    table { page-break-inside:auto }*/
                    /*    tr    { page-break-inside:auto; page-break-after:auto }*/
                    /*    thead { display:table-header-group }*/
                    /*    tfoot { display:table-footer-group }*/
                    /*    button {display: none;}*/
                    /*    body {margin: 0;}*/
                    /*}*/
                    /* default settings */

                </style>
                <div class="panel-body">
                    <div class="row  header-border" >
                        {{--                        <div class="page-header col-md-4" style="text-align: left">--}}
                        {{--                            <img src="{{ asset('uploads/invoice.png') }}" width="180px" height="150px" alt="header img">--}}
                        {{--                        </div>--}}
                        <div class="col-md-12" style="text-align: left;">
                            <h2 style="font-size:20px" >{{$store->name}}</h2>
                            <p style="margin: 0px;font-size: 16px">Corporate Office :{{$store->address}}</p>
                            <p style="margin: 0px;font-size: 16px"><b>Phone</b>: {{$store->phone}} </p>
                            <p style="margin: 0px;font-size: 16px"> <b>Email</b>: {{$store->email}}</p>
                            <p style="margin: 0px;font-size: 16px"> <b>Website</b>:{{$store->website}}</p>
                            <p style="margin: 0px;font-size: 16px"> Find us on {{$store->page}}</p>
                        </div>
                    </div>
                    <div>&nbsp;
                        <div class=" callout-info" style="">
                            <h3 style="text-align: center;padding: 12px;width: 96%;background-color: #d2d2d2;border-width:1px; border-style:dotted"> CHALLAN</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="width: 50%; float: left;display: inline-block">
                            <strong>Customer ID:</strong>
                            <strong>CTE0{{$party->id}}</strong><br>
                            <strong>Customer Name:</strong>
                            <strong>{{$party->name}}</strong><br>
                            <strong>Address:</strong>
                            <strong>{{$party->address}}</strong><br>
                            <strong>Contact No:</strong>
                            <strong>{{$party->phone}}</strong><br><br>
                            @if(!empty($productSale->onlinePlatForm->name))
                                <strong style="font-size: 16px">{{($productSale->onlinePlatForm->name)}}.Invoice {{$productSale->online_platform_invoice_no}}</strong><br>
                            @endif
                            <strong style="font-size: 16px">Delivery Address: {{$productSale->transport_area}}</strong><br>
                        </div>
                        <div class="col-md-6" style="text-align: right; width: 50%; display: inline-block">
                            <div class="invoice-to" style="float: right;">
                                <table>
                                    <tr>
                                        <td style="text-align: right;font-size: 14px;"><b>Challan No :</b></td>
                                        <td style="text-align: right;font-size: 14px;">CH{{$productSale->invoice_no}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;font-size: 14px;"><b>Invoice:</b></td>
                                        <td style="text-align: right;font-size: 14px;">{{$productSale->date}}{{$productSale->invoice_no}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;font-size: 14px;"><b>Date:</b></td>
                                        <td style="text-align: right;font-size: 16px;">{{$productSale->date}}</td>
                                    </tr>


{{--                                    <tr>--}}
{{--                                        <td style="text-align: right;font-size: 14px;"><b> Phone:</b> </td>--}}
{{--                                        <td style="text-align: right;font-size: 14px;">{{$party->phone}}</td>--}}
{{--                                    </tr>--}}
                                    <tr>
                                        <td style="text-align: right;font-size: 14px;"><b>Served By:</b></td>
                                        <td style="text-align: right;font-size: 14px;">{{$productSale->user->name}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                    <table class="invoice">
                        <thead>
                        <tr style="background-color: #dddddd">
                            <th style="font-size: 18px">SL NO.</th>
                            <th style="font-size: 18px">Product Information</th>
                            <th style="font-size: 18px">Qty</th>
                            <th style="font-size: 18px">Unit Price BDT</th>
                            <th style="font-size: 18px">Amount BDT</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $sum_sub_total = 0;
                        @endphp
                        @foreach($productSaleDetails as $key => $productSaleDetail)
                            <tr>
                                <td style="font-size: 16px">{{$key+1}}</td>
                                <td style="font-size: 16px">{{$productSaleDetail->product->name}}</td>
                                <td style="font-size: 16px">{{$productSaleDetail->qty}}</td>
                                <td></td>
                                <td>

                                </td>
                            </tr>
                        @endforeach
                        <tr >
                            <td colspan="3" style="border: none">&nbsp;</td>
                            <td style="border: none">&nbsp;</td>
                            <td style="border: none">&nbsp;</td>
                        </tr>
                        <tr >
                            <th colspan="3"  style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right;font-size: 16px">Subtotal:</th>
                            <th  style="border: none"></th>
                        </tr>
                        <tr>
                            <th colspan="3"  style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right;font-size: 16px">Transport/Labour :</th>
                            <th  style="border: none"></th>
                        </tr>
                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right;font-size: 16px">Discount:</th>
                            <th style="border: none">-</th>
                        </tr>
                        @php
                            $totalAmount =( $productSale->total_amount +$productSale->transport_cost)
                        @endphp
                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;;text-align: right;font-size: 16px">Total Amount</th>
                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;"></th>
                        </tr>
                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th style="border: none;text-align: right">Paid Amount:</th>
                            <th style="border: none"></th>
                        </tr>

                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;text-align: right;font-size: 16px">Due Amount:</th>
                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;"></th>
                        </tr>
                        </tbody>
                    </table>
                    {{--                    <table class="invoice" style="width: 40%;">--}}
                    {{--                        <thead>--}}
                    {{--                        <tr style="background-color: #dddddd">--}}
                    {{--                            <th>SL NO.</th>--}}
                    {{--                            <th>Free Product</th>--}}
                    {{--                        </tr>--}}
                    {{--                        </thead>--}}
                    {{--                        <tbody>--}}
                    {{--                        @if(!empty($free_products->free_product_id))--}}
                    {{--                            @foreach($free_products as $key => $p)--}}
                    {{--                                <tr>--}}
                    {{--                                    <td width="10%">{{$key+1}}</td>--}}
                    {{--                                    <td width="50%"> {{$p->freeProduct->name}}</td>--}}
                    {{--                                </tr>--}}
                    {{--                            @endforeach--}}
                    {{--                        @endif--}}
                    {{--                        </tbody>--}}
                    {{--                    </table>--}}
                    {{--                    <div class="write">--}}
                    {{--                        <p class="lead"><b>Previous Due </b> :0.00 </p>--}}
                    {{--                        <p class="lead"><b>Invoice Due </b> :0.00 </p>--}}
                    {{--                        <p class="lead"  style="border-top: solid 2px #000;width: 264px"> </p>--}}
                    {{--                        <p class="lead"  ><b>Total Due </b> :0.00 </p>--}}
                    {{--                    </div>--}}
{{--                    <div class="write">--}}
{{--                        <p class="lead"><b>In Word : {{ucwords($digit->format($totalAmount))}} Only</b></p>--}}
{{--                    </div>--}}
                    <div class="row" style="margin-top: 50px">
                        <!-- accepted payments column -->
                        <div class="col-md-6">
                            <table width="70%">
                                <tr>
                                    <td style="text-align: left;font-size: 18px;"><b>Notes:</b></td>
                                    <td style="text-align: left;font-size: 18px;">{{$productSale->note}}</td>

                                </tr>
                                @if($productSale->sale_type == 'Retail Sale')
                                <tr>
                                    <td style="font-size: 15px;"><b>Conditions</b>*</td>
                                    <td style="font-size: 15px;">One year electrical parts replacement warranty.</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;font-size: 18px;">*</td>
                                    <td style="text-align: left;font-size: 15px;">Warranty will void if the machine used over the capacity.</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;font-size: 18px;">*</td>
                                    <td style="text-align: left;font-size: 15px;">No warranty for filter cartidge,faucet,Tank,UV lamp. </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;font-size: 18px;">*</td>
                                    <td style="text-align: left;font-size: 15px;">Warranty will not applicable in case of electrical equipment are operated at fluctuating voltage.</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;font-size: 18px;">*</td>
                                    <td style="text-align: left;font-size: 15px;">We do not provide any electrical or plumbing work.</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;font-size: 18px;">*</td>
                                    <td style="text-align: left;font-size: 15px;">Warranty will void if the machine is not installed or serviced by CleanTech.</td>
                                </tr>
                                @endif
                            </table>


                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row footer_div" style="margin-top: 210px;display: block" >
                        <div class="row">
                            <div class="col-md-6" style="width: 50%; float: left;display: inline-block;">
                                <strong style="border-top: solid 1px #000;text-align: center;width:400px;margin-top: -42px;font-size: 16px">Customer signature</strong><br>
                            </div>
                            <div class="col-md-6" style="text-align:right;float: right;width: 30%;margin-right: 10px; display: inline-block;">
                                <strong style="border-top: solid 1px #000;font-size: 16px">Authorize Signature</strong><br>
                            </div>
                        </div>
                        <hr style="border-top:1px dotted black;width: 100%;height:1px;">
                        <div class="row" >
                            <div class="col-md-6" style="text-align:right;float:right;margin-right: 10px;">
                                <span>Print Date: {{$productSale->created_at}} Computer Generated Invoice</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{{--<footer style="margin-top:200px;display: block">--}}
{{--    <div class="row" >--}}
{{--        <div class="col-md-6" style="width: 60%; float: left;display: inline-block;margin-top: -42px">--}}
{{--            <strong style="border-top: solid 1px #000;text-align: center;width:400px">Customer signature</strong><br>--}}
{{--        </div>--}}
{{--        <div class="col-md-6" style="text-align: right; float: right;width: 40%; display: inline-block;margin-top: -42px">--}}
{{--            <strong style="border-top: solid 1px #000;">Authorize Signature</strong><br>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-6" style="width: 60%; float: left;display: inline-block;">--}}
{{--            <p style="text-align: left;width:400px">** THANK YOU FOR YOUR BUSINESS **</p><br>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <hr style="border-top:2px dotted black;width: 100%;height:1px;">--}}
{{--    <div class="row" >--}}
{{--        <div class="col-md-6" style="width: 500%; float: left;">--}}
{{--            <span style="text-align: left;width:400px">Print Date:{{$productSale->created_at}}</span>--}}
{{--            <span style="text-align: left;width:400px">Printed By: {{\Illuminate\Support\Facades\Auth::user()->name}}</span>--}}
{{--        </div>--}}
{{--        <div class="col-md-6" style="width: 50%; float: right;margin-right: -240px;">--}}
{{--            <span style="text-align: left;width:400px">Computer Generated Invoice</span>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</footer>--}}
<!-- jQuery -->
<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>


