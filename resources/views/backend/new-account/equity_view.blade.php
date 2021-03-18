@extends('backend._partial.dashboard')

@section('content')
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
                    <tr>
                        <td>Sale</td>
                        <td></td>
                        <td>10000</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Service</td>
                        <td></td>
                        <td>10000</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Direct expense</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> expense</td>
                        <td>10000</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> expense</td>
                        <td>10000</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> expense</td>
                        <td>10000</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td> expense</td>
                        <td>10000</td>
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
                <a href="{{ url('account/trial-balance-print/'.$date_from.'/'.$date_to) }}" target="_blank" class="btn btn-sm btn-primary float-left">Print</a>
            </div>
        </div>
    </main>
@endsection


