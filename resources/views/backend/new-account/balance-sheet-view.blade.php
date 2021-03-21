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
                @php
                echo $date_from;
                @endphp
                <h3 class="tile-title text-center">Date Of {{$date_from}}</h3>
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



                    @endphp
                    <tr style="background-color: #117a8b;color: white">
                        <td>ASSETS</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Fixed Assets:</td>
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
                    </tr>
                    <tr>
                        <td> Total</td>
                        <td> @php echo  $fixed_assets =$tangible_assets+$tangible_assets_vehicle+$tangible_assets_furniture_and_fixture+$tangible_assets_plant_and_machinery;
                            @endphp
                        </td>
                        <td> @php echo  $fixed_assets =$tangible_assets+$tangible_assets_vehicle+$tangible_assets_furniture_and_fixture+$tangible_assets_plant_and_machinery;
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
                <a href="{{ url('account/trial-balance-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>
            </div>
        </div>
    </main>
@endsection


