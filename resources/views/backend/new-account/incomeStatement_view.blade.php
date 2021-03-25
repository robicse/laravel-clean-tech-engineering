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
                <h1><i class=""></i> Income Statement</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">Month of from {{ $date_from }} to {{ $date_to }}</h3>
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="40%">Revenue</th>
                        <th width="30%">Amount</th>
                        <th width="30%">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                    $income_sale =0;
                    $income_service =0;

                    $purchase_account =0;
                    $purchase_installation =0;
                    $service_expense =0;
                    $carrying_expense =0;
                    $godwon_storage =0;
                    $admin_expense =0;
                    $selling_MKT_Expense1 =0;
                    $selling_MKT_Expense =0;
                    $finance_charges =0;
                    $finance_expense =0;
                    @endphp
                    <tr>
                        <td>Received againts Sales</td>
                        <td>
                            @php
                                $get_data = sales_income_statement($date_from,$date_to);
                                //dd($get_data);

                            @endphp
{{--                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}--}}
                        </td>
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $income_sale +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Received againts Services</td>
                        <td> @php
                                $get_data = service_income_statement($date_from,$date_to);
                                //dd($get_data);

                            @endphp</td>
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $income_service +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>  @php echo  $income =$income_service+$income_sale;
                            @endphp</td>

                    </tr>
                    <tr>
                        <td>Direct expense</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Purchase Account</td>
                             @php

                                $get_data = purchase_account_statement($date_from,$date_to);
                                //dd($get_data);

                            @endphp
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $purchase_account +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Product Installation</td>
                        @php
                            $get_data = purchase_installation_statement($date_from,$date_to);

                        @endphp
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $purchase_installation +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Service Expenses</td>
                        @php
                            $get_data = service_expense_statement($date_from,$date_to);
                        @endphp
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $service_expense +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Carrying Expenses</td>
                        @php
                            $get_data = carrying_expense_statement($date_from,$date_to);
                        @endphp
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $carrying_expense +=$get_data['PreBalance'];
                            @endphp
                            </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Godwon & Storage</td>
                        @php
                            $get_data = godwon_storage_statement($date_from,$date_to);
                        @endphp
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $godwon_storage +=$get_data['PreBalance'];
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total : @php echo  $expense =$purchase_account+$purchase_installation+$service_expense+$carrying_expense+$godwon_storage;
                            @endphp  </td>
                        <td>@php echo  $expense =$purchase_account+$purchase_installation+$service_expense+$carrying_expense+$godwon_storage;
                            @endphp </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Gross Profit</td>
                        <td>@php echo  $gross_profit =$income-$expense;
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Indirect expense</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Admin Expense</td>
                        @php
                            $get_data = admin_expense_statement($date_from,$date_to);
                        @endphp
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $admin_expense +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>

                    </tr>
                    <tr>
                        <td> Selling & MKT Expense(Commission/Incentive)</td>
                        @php
                            $get_data = selling_MKT_Expense1_statement($date_from,$date_to);
                        @endphp
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $selling_MKT_Expense1 +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Selling & MKT Expense</td>
                        @php
                            $get_data = selling_MKT_Expense_statement($date_from,$date_to);
                        @endphp
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $selling_MKT_Expense +=$get_data['PreBalance'];
                            @endphp
                        </td>

                        <td></td>
                    </tr>
                    <tr>
                        <td> Finance Charges</td>
                        @php
                            $get_data = finance_charges_statement($date_from,$date_to);
                        @endphp
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $finance_charges +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> Finance Expenses</td>
                        @php
                            $get_data = finance_expense_statement($date_from,$date_to);
                        @endphp
                        <td>{{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $finance_expense +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total : @php echo $indirecExpense = $admin_expense+$selling_MKT_Expense1+$selling_MKT_Expense+$finance_charges+$finance_expense;
                            @endphp  </td>
                        <td>@php echo  $indirecExpense =  $admin_expense+$selling_MKT_Expense1+$selling_MKT_Expense+$finance_charges+$finance_expense;
                            @endphp </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Net Profit</td>
                        <td>@php echo  $net_profit =$gross_profit-$indirecExpense;
                            @endphp</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="tile-footer">
                </div>
            </div>
            <div class="text-center">
                <button onclick="window.print()" target="_blank"  id="printPageButton" class=" btn btn-sm btn-primary float-left">Print</button>
{{--                <a href="{{ url('account/trial-balance-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>--}}
            </div>
        </div>
    </main>
@endsection


