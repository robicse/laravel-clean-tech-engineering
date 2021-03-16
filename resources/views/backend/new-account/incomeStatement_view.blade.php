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
                        <th width="40%">Accounts Head</th>
                        <th width="30%">Debit</th>
                        <th width="30%">Credit</th>
                        <th width="30%">Balance</th>
                    </tr>
                    </thead>
                    <tbody>

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


