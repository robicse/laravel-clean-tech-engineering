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
                        font-size: 14px !important;
                        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                        font-weight: inherit;
                    }
                    .panel-body p {
                        font-size: 14px !important;

                    }
                    .invoice {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    .invoice th {
                        /*border-top: 1px solid #000;*/
                        /*border-bottom: 1px solid #000;*/
                        border: 1px solid #000;
                    }

                    .invoice td {
                        text-align: center;
                        font-size: 16px;
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
                        border-top: 1px solid #000000;
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
                        margin-top: 8px;
                        border-bottom: 5px solid black; /* for demo */
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
                        <div class="page-header col-md-4" style="text-align: left">
                            <img src="{{ asset('uploads/invoice.png') }}" width="180px" height="150px" alt="header img">
                        </div>
                        <div class="col-md-8" style="text-align: left; margin-left: 180px;margin-top: -150px">
                            <h2>CleanTech Engineering</h2>
                            <p style="margin: 0px">Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216</p>
                            <p style="margin: 0px"><b>Phone</b>: 02-58052342, 01701-666 606, 01701-666 601, 01711-991 851. </p>
                            <p style="margin: 0px"> <b>Email</b>: info@cleantech.com.bd</p>
                            <p style="margin: 0px"> <b>Website</b>:www.cleantech.com.bd</p>
                            <p style="margin: 0px"> Find us on www.facebook.com/cleantechbd</p>
                        </div>
                    </div>
                    <div>&nbsp;
                        <div class=" callout-info" style="">
                            <h3 style="text-align: center;padding: 12px;width: 96%;background-color: #d2d2d2;border-width:1px; border-style:dotted"> Challan</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="width: 60%; float: left;display: inline-block">
                            <strong>Customer ID:</strong>
                            <strong>C0{{$party->id}}</strong><br>
                            <strong>Customer Name:</strong>
                            <strong>{{$party->name}}</strong><br>
                            <strong>Address:</strong>
                            <strong>{{$party->address}}</strong><br>
                            <strong>Contact No:</strong>
                            <strong>{{$party->phone}}</strong><br>
                        </div>
                        <div class="col-md-6" style="text-align: right; width: 40%; display: inline-block">
                            <div class="invoice-to">
                                <table>
                                    <tr>
                                        <td style="text-align: right;font-size: 14px;"><b>Invoice:</b></td>
                                        <td style="text-align: right;font-size: 14px;">#{{$productSale->invoice_no}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;font-size: 14px;"><b>DateTime:</b></td>
                                        <td style="text-align: right;font-size: 16px;">{{$party->created_at->format('d/m/Y')}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;font-size: 14px;"><b> Phone NO:</b> </td>
                                        <td style="text-align: right;font-size: 14px;">{{$party->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;font-size: 14px;"><b>Served By:</b></td>
                                        <td style="text-align: right;font-size: 14px;">{{\Illuminate\Support\Facades\Auth::user()->name}}</td>
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
                            <th>SL NO.</th>
                            <th>Product Information</th>
                            <th>Qty</th>
                            <th>Unit Price BDT</th>
                            <th>Amount BDT</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $sum_sub_total = 0;
                        @endphp
                        @foreach($productSaleDetails as $key => $productSaleDetail)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$productSaleDetail->product->name}}</td>
                                <td>{{$productSaleDetail->qty}}</td>
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
                            <th  style="border: none;text-align: right">Subtotal:</th>
                            <th  style="border: none"></th>
                        </tr>
                        <tr>
                            <th colspan="3"  style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right">Transport/Labour :</th>
                            <th  style="border: none"></th>
                        </tr>
                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right">Discount:</th>
                            <th style="border: none">-</th>
                        </tr>
                        @php
                        $totalAmount =( $productSale->total_amount +$productSale->transport_cost)
                        @endphp
                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;;text-align: right">Total Amount</th>
                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;"></th>
                        </tr>
                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th style="border: none;text-align: right">Paid Amount:</th>
                            <th style="border: none"></th>
                        </tr>

                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;text-align: right">Due Amount:</th>
                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;"></th>
                        </tr>
                        </tbody>
                    </table>
                    <div class="write">
                        <p class="lead"><b>In Word : </b></p>
                    </div>
                    <div class="row" style="">
                        <!-- accepted payments column -->
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <td style="text-align: right;font-size: 16px;"><b>Notes</b></td>
                                    <td style="text-align: left;font-size: 14px;">*One year electrical parts warranty</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left;font-size: 14px;">*Warranty will void if the machine used over the capacity</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left;font-size: 14px;">*No warranty for filter cartidge,faucet,Tank. </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left;font-size: 14px;">*Warranty will not apply in case of electrical equipment are operated at fluctuating voltage</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: left;font-size: 14px;">*We do not provide any electrical or plumbing work.</td>
                                </tr>
                            </table>

                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row" style="margin-top: 210px">
                        <div class="col-md-6" style="width: 60%; float: left;display: inline-block;">
                            <strong style="border-top: solid 1px #000;text-align: center;width:400px">Customer signature</strong><br>
                        </div>
                        <div class="col-md-6" style="text-align: right; float: right;width: 40%; display: inline-block;">
                            <strong style="border-top: solid 1px #000;">Authorize Signature</strong><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="width: 60%; float: left;display: inline-block;">
                            <p style="text-align: left;width:400px">** THANK YOU FOR YOUR BUSINESS **</p><br>
                        </div>
                    </div>
                    <hr style="border-top:1px dotted black;width: 100%;height:1px;">
                    <div class="row" >
                        <div class="col-md-6" style="width: 60%; float: left;display: inline-block;">
                            <span style="text-align: left;width:400px">Print Date:{{$productSale->created_at}}</span>
                            <span style="text-align: left;width:400px">Printed By: {{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>

<script type="text/javascript">
    window.addEventListener("load", window.print());
</script>

