@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i> Cash Flow</h1>
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
                    <h1>Cash Flow </h1>
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
                    @php
                        $sales_income_for_cashFlow_statement = 0;
                        $service_income_for_cashFlow_statement = 0;
                        $advancedReceivedAgaintsSales_for_cashFlow_statement = 0;


                        $loan_and_advances_AOR_for_cashFlow_statement = 0;
                        $loan_and_advances_AAP_for_cashFlow_statement = 0;
                        $purchase_account_for_cashFlow_statement = 0;
                        $purchase_installation_for_cashFlow_statement = 0;
                        $service_expense_for_cashFlow_statement = 0;
                        $carrying_expense_statement_for_cashFlow_statement = 0;
                        $godwon_storage_statement_for_cashFlow_statement = 0;


                    @endphp
                    <tr>
                        <td>Received Against Sale</td>
                        <td> @php
                                $get_data = sales_income_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $sales_income_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>

                    </tr>
                    <tr>
                        <td>Received Against Service</td>
                        <td>@php
                                $get_data = service_income_for_cashFlow_statement($date_from,$date_to);

                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $service_income_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Advanced Received Against Sales</td>
                        <td> @php
                                $get_data = advancedReceivedAgaintsSales_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $advancedReceivedAgaintsSales_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td>Cash Received From Customer</td>
                        <td>
                            @php echo
                            $cash_receive_from_customer =  $sales_income_for_cashFlow_statement+$service_income_for_cashFlow_statement+$advancedReceivedAgaintsSales_for_cashFlow_statement;
                            @endphp
                          </td>
                        <td> @php echo
                            $cash_receive_from_customer =  $sales_income_for_cashFlow_statement+$service_income_for_cashFlow_statement+$advancedReceivedAgaintsSales_for_cashFlow_statement;
                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Advanced Office Rent</td>
                        <td>@php
                                $get_data = loan_and_advances_AOR_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $loan_and_advances_AOR_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Advanced Againts Purchase</td>
                        <td>@php
                                $get_data = loan_and_advances_AAP_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $loan_and_advances_AAP_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Purchase Account</td>
                        <td>@php
                                $get_data = purchase_account_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $purchase_account_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Product Installation</td>
                        <td>@php
                                $get_data = purchase_installation_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $purchase_installation_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Service Expenses</td>
                        <td>@php
                                $get_data = service_expense_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $service_expense_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Carrying Expenses</td>
                        <td>@php
                                $get_data = carrying_expense_statement_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $carrying_expense_statement_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Godwon & Storage</td>
                        <td>@php
                                $get_data = godwon_storage_statement_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $godwon_storage_statement_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 17px;" >
                        <td>Cash Paid To Supplier</td>
                        <td>
                            @php
                            echo
                            - $total_cash_paid_to_supplier =
                             $loan_and_advances_AOR_for_cashFlow_statement + $loan_and_advances_AAP_for_cashFlow_statement +$purchase_account_for_cashFlow_statement +$purchase_installation_for_cashFlow_statement +
                        $service_expense_for_cashFlow_statement + $carrying_expense_statement_for_cashFlow_statement +$godwon_storage_statement_for_cashFlow_statement;

                            @endphp
                          </td>
                        <td> @php
                                echo
                               - $total_cash_paid_to_supplier =
                                 $loan_and_advances_AOR_for_cashFlow_statement + $loan_and_advances_AAP_for_cashFlow_statement +$purchase_account_for_cashFlow_statement +$purchase_installation_for_cashFlow_statement +
                            $service_expense_for_cashFlow_statement + $carrying_expense_statement_for_cashFlow_statement +$godwon_storage_statement_for_cashFlow_statement;

                            @endphp</td>
                        <td></td>
                    </tr>
                    @php
                        $admin_expense_for_cashFlow_statement = 0;
                        $selling_MKT_Expense1_for_cashFlow_statement = 0;
                        $selling_MKT_Expense_for_cashFlow_statement = 0;


                        $tangible_assets_plant_and_machinery_for_cashFlow_statement = 0;
                        $tangible_assets_furniture_and_fixture_for_cashFlow_statement = 0;
                        $tangible_assets_vehicle_for_cashFlow_statement = 0;
                        $tangible_assets_for_cashFlow_statement = 0;
                        $intangible_assets_for_cashFlow_statement = 0;
                    @endphp
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td><b>Others Operating Expenses: </b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Admin Expense</td>
                        <td>@php
                                $get_data = admin_expense_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $admin_expense_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Selling & MKT Expense(Sales Commission / incentive Expenses)</td>
                        <td>@php
                                $get_data = selling_MKT_Expense1_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $selling_MKT_Expense1_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Selling & MKT Expense</td>
                        <td>@php
                                $get_data = selling_MKT_Expense_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $selling_MKT_Expense_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 17px;" >
                        <td>Cash Paid For Others Operating Expenses</td>
                        <td>
                            @php
                                echo
                               - $total_cash_paid_for_expense =
                                  $admin_expense_for_cashFlow_statement + $selling_MKT_Expense1_for_cashFlow_statement + $selling_MKT_Expense_for_cashFlow_statement;

                            @endphp
                          </td>
                        <td> @php
                                echo
                               - $total_cash_paid_for_expense =
                                  $admin_expense_for_cashFlow_statement + $selling_MKT_Expense1_for_cashFlow_statement + $selling_MKT_Expense_for_cashFlow_statement;

                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td><b>Cashflow from  Operating Activities: </b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets(Plant & Machinery)</td>
                        <td>@php
                                $get_data = tangible_assets_plant_and_machinery_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $tangible_assets_plant_and_machinery_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets(Furniture & Fixture)</td>
                        <td>@php
                                $get_data = tangible_assets_furniture_and_fixture_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $tangible_assets_furniture_and_fixture_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets(Vehicle)</td>
                        <td>@php
                                $get_data = tangible_assets_vehicle_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $tangible_assets_vehicle_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Tangible Assets</td>
                        <td>@php
                                $get_data = tangible_assets_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $tangible_assets_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Intangible Assets</td>
                        <td>@php
                                $get_data = intangible_assets_for_cashFlow_statement($date_from,$date_to);
                            @endphp
                            {{$get_data['PreBalance']}} {{$get_data['preDebCre']}}
                            @php
                                $intangible_assets_for_cashFlow_statement +=$get_data['PreBalance'];
                            @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 17px;" >
                        <td>Cash Paid On</td>
                        <td>
                            @php
                                echo
                                - $total_cash_paid_on = $tangible_assets_plant_and_machinery_for_cashFlow_statement +
                                $tangible_assets_furniture_and_fixture_for_cashFlow_statement +
                                $tangible_assets_vehicle_for_cashFlow_statement +
                                $tangible_assets_for_cashFlow_statement +
                                $intangible_assets_for_cashFlow_statement ;

                            @endphp
                        </td>
                        <td>  @php
                                echo
                                - $total_cash_paid_on = $tangible_assets_plant_and_machinery_for_cashFlow_statement +
                                $tangible_assets_furniture_and_fixture_for_cashFlow_statement +
                                $tangible_assets_vehicle_for_cashFlow_statement +
                                $tangible_assets_for_cashFlow_statement +
                                $intangible_assets_for_cashFlow_statement ;

                            @endphp</td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td><b>Cashflow from Investment Activities: </b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Loan From Other</td>
                        <td>@php


                                @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Capital Account</td>
                        <td>@php


                                @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td><b>Cashflow from Financing Activities: </b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 18px;" >
                        <td><b>Cashflow from Financing Activities: </b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Cash in Hand</td>
                        <td>@php


                                @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Cash at Bank</td>
                        <td>@php


                                @endphp

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="table-secondary" style="color: black;font-size: 20px;font-style: italic" >
                        <td><b>Closing Cash And Cash Equivalent: </b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="tile-footer">
                </div>
            </div>
            <div class="text-center">
                <button onclick="window.print()" target="_blank" class=" btn btn-sm btn-primary float-left">Print</button>
{{--                <a href="{{ url('account/trial-balance-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>--}}
            </div>
        </div>
    </main>
@endsection


