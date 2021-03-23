@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Change In Equity Statement</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">Month of from {{ $date_from }} to {{ $date_to }}</h3>
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
                    <tr style="background-color: #83b735;color: white" >
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
                    <tr style="background-color: #83b735;color: white" >
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
                    <tr>
                        <td>Retained Earning: </td>
                        <td>{{$total_profit}}</td>
                        <td>{{$total_profit}}</td>
                        <td></td>
                    </tr>
                    @php
                        $total_equity=$total_capital+$total_profit;
                    @endphp
                    <tr style="background-color: #313a95;color: white" #83b735>
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
                <a href="{{ url('account/trial-balance-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>
            </div>
        </div>
    </main>
@endsection


