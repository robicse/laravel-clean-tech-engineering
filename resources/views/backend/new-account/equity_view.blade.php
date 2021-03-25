@extends('backend._partial.dashboard')

@section('content')
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Change In Equity Statement</h1>
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
                    <h1>Change In Equity </h1>
                </div>
                <div class="col-sm-4" style="text-align: right; width: 33.33333333%; float: left;">
                    From Date : {{ $date_from }}
                    <br/>
                    To Date : {{ $date_to }}
                    <br>
                </div>
{{--                <h3 class="tile-title text-center">Month of from {{ $date_from }} to {{ $date_to }}</h3>--}}
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="60%">Particulars</th>
                        <th width="20%">Amount</th>
                        <th width="20%">Balance</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @php
                            $opening_capital = 0;
                            $additional_capital = 0;
                            $opening_profit = 0;
                            $net_profit = 0;

                        @endphp
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
                    <tr>
                        <td>Addition</td>
                        <td> @php

                                $get_data = additional_capital($date_from,$date_to);
                                //dd($get_data);

                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $additional_capital +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td>Total Capital:</td>
                        <td>
                            @php
                                $total_capital = $additional_capital+$opening_capital;
                            @endphp
                            {{$total_capital}}</td>
                        <td>{{$total_capital}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Opening Profit</td>
                        <td>@php

                                $get_data = additional_capital($date_from,$date_to);
                              // dd($get_data);

                            @endphp
                            {{$get_data['from_data']}}
                            @php
                                $opening_profit +=$get_data['from_data'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Net Profit</td>
                        <td>@php

                                $get_data = additional_capital($date_from,$date_to);
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
                        $total_profit =$opening_profit+$net_profit;
                    @endphp
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td>Retained Earning: </td>
                        <td>{{$total_profit}}</td>
                        <td>{{$total_profit}}</td>
                        <td></td>
                    </tr>
                    @php
                        $total_equity=$total_capital+$total_profit;
                    @endphp
                    <tr style="color: black;font-size: 20px;font-style: italic" >
                        <td> </td>
                        <td><b>Total Equity:</b></td>
                        <td>{{$total_equity}}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="tile-footer">
                </div>
            </div>
            <div class="text-center">
                <button onclick="window.print()" target="_blank"  id="printPageButton" class="btn btn-sm btn-primary float-left">Print</button>
{{--                <a href="{{ url('account/trial-balance-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>--}}
            </div>
        </div>
    </main>
@endsection


