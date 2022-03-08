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
            <div id="">
                <style>
                    .panel-body {
                        min-height: 1000px !important;
                        font-size: 16px !important;
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
                        margin: 0;
                    }

                    .footer_div {
                        position:sticky;
                        bottom: 0 !important;
                        width:100%;
                        font-size: 10px !important;
                        padding-bottom: 20px;
                    }

                    .header-border {

                        height: 160px!important;
                        margin-top: 18px;
                        border-bottom: 5px solid black;
                    }

                    @page {
                        size: A4;
                        margin: 16px 50px !important;
                    }

                </style>
                <div class="">
                    <div class="row " >
                        <div class="col-md-6 float-left" style="">
                            <h2 style="font-size:20px" >{{$stock->store->name}}</h2>
                            <p style="margin: 0px;font-size: 16px">Corporate Office :{{$stock->store->address}}</p>
                            <p style="margin: 0px;font-size: 16px"><b>Phone</b>: {{$stock->store->phone}} </p>
                            <p style="margin: 0px;font-size: 16px"> <b>Email</b>: {{$stock->store->email}}</p>
                            <p style="margin: 0px;font-size: 16px"> <b>Website</b>:{{$stock->store->website}}</p>
                            <p style="margin: 0px;font-size: 16px"> Find us on {{$stock->store->page}}</p>
                        </div>
                        <div class="col-md-6 float-right" style="margin-top: -117px;">
                            <div class="invoice-to"  style="float: right;">
                                <table>
                                    <tr>
                                        <td style="font-size: 16px;"><b>Invoice Copy: 1</b></td>
                                        <td style="font-size: 16px;">{{$stock->invoice_no}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 16px;"><b>Date:</b></td>
                                        <td style="font-size: 16px;">{{$stock->created_at->format('d/m/Y')}}</td>
                                    </tr>
                                    {{--                                    <tr>--}}
                                    {{--                                        <td style="text-align: right;font-size: 16px;"><b> Phone NO:</b> </td>--}}
                                    {{--                                        <td style="text-align: right;font-size: 16px;">{{$party->phone}}</td>--}}
                                    {{--                                    </tr>--}}
                                    <tr>
                                        <td style="font-size: 16px;"><b>Served By:</b></td>
                                        {{--                                        <td style="text-align: right;font-size: 16px;">{{$stock->user->name}}</td>--}}
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
{{--                    <div>&nbsp;--}}
{{--                        <div class=" callout-info" style="">--}}
{{--                            <h3 style="text-align: center;padding: 12px;width: 96%;background-color: #d2d2d2;border-width:1px; border-style:dotted"> Purchase Invoice</h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <br/>

                    <table class="invoice" style="margin-top: 130px;">
                        <thead>
                        <tr style="background-color: #dddddd">
                            <th >SL NO.</th>
                            <th>Product Information</th>
                            <th>Current Stock</th>
                            <th>Individual Price BDT</th>
                            <th>Total Price BDT</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                        $productDetails = \App\ProductPurchaseDetail::where('product_id',$stock->product_id)->first();

                        $indivisualPrice = $productDetails->price / $productDetails->qty;
                        @endphp
                            <tr>
                                <td>1</td>
                                <td>{{$stock->product->name}}</td>
                                <td>{{$stock->current_stock}}</td>
                                <td> {{number_format($indivisualPrice,2,".",",")}}</td>
                                <td> {{number_format($indivisualPrice * $stock->current_stock,2,".",",")}}</td>

                            </tr>

                        <tr >
                            <td colspan="3" style="border: none">&nbsp;</td>
                            <td style="border: none">&nbsp;</td>
                            <td style="border: none">&nbsp;</td>
                        </tr>
                        <tr >
                            <th colspan="3"  style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right;font-size: 16px">Subtotal:</th>
                            <th  style="border: none"> </th>
                        </tr> <tr >
                            <th colspan="3"  style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right;font-size: 16px">Transport/Labour ::</th>
{{--                            <th  style="border: none"> {{number_format($productPurchase->transport_cost,2,".",",")}}</th>--}}
                        </tr>

                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th  style="border: none;text-align: right;font-size: 16px">Discount:</th>
{{--                            @if($productPurchase->discount_type == 'flat' )--}}

{{--                                <td style="border: none">- {{$productPurchase->discount_amount}}</td>--}}
{{--                            @else--}}
{{--                                <td style="border: none">-{{number_format($total_discount, 2, '.', '')}}</td>--}}
{{--                            @endif--}}
                        </tr>

                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;;text-align: right;font-size: 16px">Total Amount</th>
{{--                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;">{{number_format($productPurchase->total_amount,2,".",",")}}</th>--}}
                        </tr>
                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th style="border: none;text-align: right">Paid Amount:</th>
{{--                            <th style="border: none">{{number_format($productPurchase->paid_amount,2,".",",")}}</th>--}}
                        </tr>

                        <tr>
                            <th colspan="3" style="border: none">&nbsp;</th>
                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;text-align: right;font-size: 16px">Due Amount:</th>
{{--                            <th style="border-top: 2px solid black;border-bottom:none;border-left: none;border-right: none;"> {{number_format($productPurchase->due_amount,2,".",",")}}</th>--}}
                        </tr>
                        </tbody>
                    </table>
                    <div class="write">
{{--                        @php--}}
{{--                            $get_amount= numberTowords($productPurchase->total_amount);--}}
{{--                               // echo "<p align='center' class='text-danger'>".$get_amount."</p>";--}}
{{--                                    echo   "<p class='lead'>" ."In Word :" .$get_amount. "Only" ."</p>";--}}
{{--                        @endphp--}}
                        {{--                        <p class="lead"><b>In Word : {{ucwords($digit->format($productPurchase->total_amount))}} Only </b></p>--}}

                    </div>
<!--                    --><?php
//
//                    function numberTowords(float $amount)
//                    {
//                        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
//                        // Check if there is any number after decimal
//                        $amt_hundred = null;
//                        $count_length = strlen($num);
//                        $x = 0;
//                        $string = array();
//                        $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
//                            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
//                            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
//                            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
//                            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
//                            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
//                            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
//                            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
//                            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
//                        $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
//                        while( $x < $count_length ) {
//                            $get_divider = ($x == 2) ? 10 : 100;
//                            $amount = floor($num % $get_divider);
//                            $num = floor($num / $get_divider);
//                            $x += $get_divider == 10 ? 1 : 2;
//                            if ($amount) {
//                                $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
//                                $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
//                                $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.'
//         '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. '
//         '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
//                            }else $string[] = null;
//                        }
//                        $implode_to_Rupees = implode('', array_reverse($string));
//                        $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . "
//   " . $change_words[$amount_after_decimal % 10]) . ' Paisa' : '';
//                        return ($implode_to_Rupees ? $implode_to_Rupees . 'Taka ' : '') . $get_paise;
//                    }
//
//                    ?>
                    <div class="row" style="margin-top: 150px">
                        <!-- accepted payments column -->
                        <div class="col-md-6">
                            <table width="70%">
                                <tr>
                                    <td style="font-size: 18px;"><b>Notes</b>*</td>
                                    <td style="font-size: 16px;"></td>
                                </tr>
                                <tr>
{{--                                    <td style="font-size: 18px;">*{{$productPurchase->note}}</td>--}}
                                    <td style="font-size: 16px;"></td>
                                </tr>
                                {{--                                <tr>--}}
                                {{--                                    <td style="font-size: 18px;"></td>--}}
                                {{--                                    <td style="font-size: 16px;"> </td>--}}
                                {{--                                </tr>--}}


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
                                <span>Print Date:  Computer Generated Invoice</span>
                            </div>
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


