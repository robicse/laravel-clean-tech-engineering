@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i>Balance Sheet</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <div class="col-sm-4" style="width: 33.33333333%;height:180px; float: left;">
                    <h2>Clean Tech Engineering</h2>
                    <p style="margin: 0px">Corporate Office :Corporate Office :Corporate Office : House-1, Road-16, Section-10, Block-C, Mirpur, Dhaka-1216</p>
                    <p style="margin: 0px"><b>Phone</b>:02-58052342, 01701-666 606, 01701-666 601, 01711-991 851 </p>
                    <p style="margin: 0px"> <b>Email</b>: info@cleantech.com.bd</p>
                </div>

                <div class="col-sm-4" style="text-align: center; width: 33.33333333%; float: left;">
                    <h2>Balance Sheet</h2>
                </div>
                <div class="col-sm-4" style="text-align: right; width: 33.33333333%; float: left;">
                   <h5> Date Of {{$date_from}}</h5>
                    <br/>
                </div>
{{--                <h3 class="tile-title text-center">Date Of {{$date_from}}</h3>--}}
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="40%">Particulars</th>
                        <th width="30%">Amount</th>
                        <th width="30%">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                    $tangible_assets_plant_and_machinery =0;
                    $tangible_assets_furniture_and_fixture =0;
                    $tangible_assets_vehicle =0;
                    $tangible_assets =0;
                    $intangible_assets =0;
                    $cash_in_hands_assets = 0;
                    $cash_at_bank_assets = 0;
                    $cash_at_bank_FDR_assets = 0;
                    $loan_and_advances_AOR_assets = 0;
                    $loan_and_advances_AAP_assets = 0;
                    $loan_and_advances_AAS_assets = 0;
                    $loan_and_advances_assets = 0;


                    $loan_from_owner = 0;
                    $loan_from_other = 0;
                    $advanced_receive_against_sale = 0;


                    $opening_capital = 0;
                    $additional_capital = 0;
                    $opening_profit = 0;
                    $net_profit = 0;

                    @endphp
                    <tr class="table-secondary" style="color: black;font-style: italic;font-size: 20px">
                        <td><b>ASSETS</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr  style="color: black;font-size: 17px">
                        <td><b>Fixed Assets:</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets(Plant & Machinery):</td>
                        <td>
                            @php
                                $get_data = tangible_assets_plant_and_machinery($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $tangible_assets_plant_and_machinery +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets(Furniture & Fixture):</td>
                        <td> @php
                                $get_data = tangible_assets_furniture_and_fixture($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}</td>
                        @php
                            $tangible_assets_furniture_and_fixture +=$get_data['PreBalance'];
                        @endphp
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets(Vehicle)</td>
                             @php

                                $get_data = tangible_assets_vehicle($date_from);
                                //dd($get_data);

                            @endphp
                        <td>
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $tangible_assets_vehicle +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Tangible Assets</td>
                        @php
                            $get_data = tangible_assets($date_from);
  //dd($get_data);
                        @endphp
                        <td> {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}

                            @php
                                $tangible_assets +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Intangible Assets</td>
                        @php
                            $get_data = intangible_assets($date_from);
  //dd($get_data);
                        @endphp
                        <td> {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}

                            @php
                                $intangible_assets +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="color: black;font-size: 17px">
                        <td> Total Fixed Assets</td>
                        <td> @php echo  $fixed_assets =$intangible_assets+$tangible_assets+$tangible_assets_vehicle+$tangible_assets_furniture_and_fixture+$tangible_assets_plant_and_machinery;
                            @endphp
                        </td>
                        <td> @php echo  $fixed_assets =$intangible_assets+$tangible_assets+$tangible_assets_vehicle+$tangible_assets_furniture_and_fixture+$tangible_assets_plant_and_machinery;
                            @endphp </td>
                        <td></td>
                    </tr>
                    <tr style="color: black;font-size: 17px">
                        <td><b>Current Assets:</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Cash In Hand</td>
                        <td>
                            @php
                                $get_data = cash_in_hands_assets($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $cash_in_hands_assets +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Cash At Bank</td>
                        <td>
                            @php
                                $get_data = cash_at_bank_assets($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $cash_at_bank_assets +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Cash At Bank(FDR) </td>
                        <td>
                            @php
                                $get_data = cash_at_bank_FDR_assets($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $cash_at_bank_FDR_assets +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loans & Advances(Advanced office rent)</td>
                        <td>
                            @php
                                $get_data = loan_and_advances_AOR_assets($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $loan_and_advances_AOR_assets +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loans & Advances(Advanced Againts Purchase)</td>
                        <td>
                            @php
                                $get_data = loan_and_advances_AAP_assets($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $loan_and_advances_AAP_assets +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loans & Advances(Advanced Againts Salary)</td>
                        <td>
                            @php
                                $get_data = loan_and_advances_AAS_assets($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $loan_and_advances_AAS_assets +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loans & Advances(Loan To Owner)</td>
                        <td>
                            @php
                                $get_data = loan_and_advances_assets($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $loan_and_advances_assets +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="color: black;font-size: 17px">
                        <td> Total Current Assets:</td>
                        <td> @php echo  $current_assets =$loan_and_advances_assets+$loan_and_advances_AAS_assets+$loan_and_advances_AAP_assets+$loan_and_advances_AOR_assets+$cash_at_bank_FDR_assets+$cash_at_bank_assets+$cash_in_hands_assets;
                            @endphp
                        </td>
                        <td> @php echo  $current_assets =$loan_and_advances_assets+$loan_and_advances_AAS_assets+$loan_and_advances_AAP_assets+$loan_and_advances_AOR_assets+$cash_at_bank_FDR_assets+$cash_at_bank_assets+$cash_in_hands_assets;
                            @endphp </td>
                        <td></td>
                    </tr>
                    <tr style="color: black;font-size: 17px">
                        <td><b> Total Assets:</b></td>
                        <td> @php echo  $total_assets =$current_assets+$fixed_assets;
                            @endphp
                        </td>
                        <td> @php echo $total_assets =$current_assets+$fixed_assets;
                            @endphp </td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-style: italic;font-size: 20px">
                        <td><b>Equity And Liabilities</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="color: black;font-size: 17px">
                        <td><b>Equity</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="display:none;">
                        <td>Opening Capitals</td>
                        <td>@php

                                $get_data = opening_statement($date_from,$date_to);
//dd($get_data);

                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $opening_capital +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="display:none;">
                        <td>Addition</td>
                        <td> @php

                                $get_data = additional_capital_for_balanceSheet($date_from,$date_to);
                              // dd($get_data);

                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $additional_capital +=$get_data['PreBalance'];
//dd($additional_capital);
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Total Capital:</td>
                        <td>
                            @php
                               // $total_capital =$additional_capital+$opening_capital;
                                $total_capital =$additional_capital;

                            @endphp
                            {{$total_capital}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="display:none;">
                        <td>Opening Profit</td>
                        <td>@php

                                $get_data = additional_capital_for_balanceSheet($date_from);
                               //dd($get_data);

                            @endphp
                            {{$get_data['from_data']}}
                            @php
                                $opening_profit +=$get_data['from_data'];

                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="display:none;">
                        <td>Net Profit</td>
                        <td>@php

                                $get_data = additional_capital_for_balanceSheet($date_from);
                                //dd($get_data);

                            @endphp
                            {{$get_data['get_data']}}
                            @php
                                $net_profit +=$get_data['get_data'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php
                        //$total_profit =$opening_profit+$net_profit;
                        $total_profit =$net_profit;

                    @endphp
                    <tr>
                        <td>Retained Earning: </td>
                        <td>{{$total_profit}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php
                        $total_equity=$total_capital+$total_profit;
                    @endphp
                    <tr style="color: black;font-size: 17px">
                        <td><b>Total Equity:</b></td>
                        <td>{{$total_equity}}</td>
                        <td>{{$total_equity}}</td>
                        <td></td>

                    </tr>
                    <tr>
                        <td>Current Liabilities</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loan From Owners</td>
                        <td>
                            @php
                                $get_data = loan_from_owner($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $loan_from_owner +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loan From Other</td>
                        <td>
                            @php
                                $get_data = loan_from_other($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $loan_from_other +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Advanced Received Against Sales</td>
                        <td>
                            @php
                                $get_data = advanced_receive_against_sale($date_from);
                                //dd($get_data);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $advanced_receive_against_sale +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr  style="color: black;font-size: 17px">
                        <td> <b>Total Liabilities</b></td>
                        <td> @php echo  $liabilities=$advanced_receive_against_sale+$loan_from_other+$loan_from_owner;
                            @endphp
                        </td>
                        <td> @php echo  $liabilities=$advanced_receive_against_sale+$loan_from_other+$loan_from_owner;
                            @endphp </td>
                        <td></td>
                    </tr>
                    <tr  style="color: black;font-size: 17px">
                        <td> <b>Total Equity & Liabilities</b></td>
                        <td> @php echo  $totalEquityAndLiabilities=$liabilities+$total_equity;
                            @endphp
                        </td>
                        <td> @php echo $totalEquityAndLiabilities=$liabilities+$total_equity;
                            @endphp </td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="tile-footer">
                </div>
            </div>
            <div class="text-center">

                <button onclick="window.print()">Print</button>
{{--                <a href="{{ url('account/trial-balance-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>--}}
            </div>
        </div>
    </main>
@endsection


{{--<script type="text/javascript">--}}
{{--    window.addEventListener("load", window.print());--}}
{{--</script>--}}
