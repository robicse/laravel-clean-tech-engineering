@extends('backend._partial.dashboard')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class=""></i>Receipt Payment</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Receipt Payment</h3>
                <div class="tile-body tile-footer">
                    @if(session('response'))
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    @endif
                    <h3>Previous</h3>
                    <form method="post" action="{{ route('account.receipt.payment_view.previous') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">From</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control-sm" name="date_from" required>
                                @if ($errors->has('date_from'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_from') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 text-right">To</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control-sm" name="date_to" required>
                                @if ($errors->has('date_to'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_to') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row" style="display:none;">
                            <label class="control-label col-md-3 text-right">Chart Of Account</label>
                            <div class="col-md-8">
                                <select class="form-control account_id select2" name="account_id[]" id="account_id_1">
                                    @foreach($bankbooks as $account)
                                        <option value="{{$account->id}}">{{$account->group_1}}.{{$account->group_2}}.{{$account->group_3}}.{{$account->group_4}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('general_ledger'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('general_ledger') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row" style="display:none;">
                            <label class="control-label col-md-3 text-right">General Ledger Head</label>
                            <div class="col-md-8">
                                <select class="form-control ledger_id select2" name="ledger_id" id="ledger_id_1">
                                    @foreach($ledgers as $ledger)
                                        <option value="{{$ledger->id}}">{{$ledger->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('general_ledger'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('general_ledger') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-fw fa-lg fa-check-circle"></i>View
                                </button>
                            </div>
                        </div>
                    </form>
<hr/>
                        <h3>New</h3>
                        <form method="post" action="{{ route('account.receipt.payment_view.new') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="control-label col-md-3 text-right">From</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control-sm" name="date_from" required>
                                    @if ($errors->has('date_from'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_from') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3 text-right">To</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control-sm" name="date_to" required>
                                    @if ($errors->has('date_to'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date_to') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            {{--                        <div class="form-group row" style="display:none;">--}}
                            {{--                            <label class="control-label col-md-3 text-right">Chart Of Account</label>--}}
                            {{--                            <div class="col-md-8">--}}
                            {{--                                <select class="form-control account_id select2" name="account_id[]" id="account_id_1">--}}
                            {{--                                    @foreach($bankbooks as $account)--}}
                            {{--                                        <option value="{{$account->id}}">{{$account->group_1}}.{{$account->group_2}}.{{$account->group_3}}.{{$account->group_4}}</option>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </select>--}}
                            {{--                                @if ($errors->has('general_ledger'))--}}
                            {{--                                    <span class="invalid-feedback" role="alert">--}}
                            {{--                                        <strong>{{ $errors->first('general_ledger') }}</strong>--}}
                            {{--                                    </span>--}}
                            {{--                                @endif--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                            {{--                        <div class="form-group row" style="display:none;">--}}
                            {{--                            <label class="control-label col-md-3 text-right">General Ledger Head</label>--}}
                            {{--                            <div class="col-md-8">--}}
                            {{--                                <select class="form-control ledger_id select2" name="ledger_id" id="ledger_id_1">--}}
                            {{--                                    @foreach($ledgers as $ledger)--}}
                            {{--                                        <option value="{{$ledger->id}}">{{$ledger->name}}</option>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </select>--}}
                            {{--                                @if ($errors->has('general_ledger'))--}}
                            {{--                                    <span class="invalid-feedback" role="alert">--}}
                            {{--                                        <strong>{{ $errors->first('general_ledger') }}</strong>--}}
                            {{--                                    </span>--}}
                            {{--                                @endif--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                            <div class="form-group row">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-8">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-fw fa-lg fa-check-circle"></i>View
                                    </button>
                                </div>
                            </div>
                        </form>
                </div>
                <div class="tile-footer">
                </div>
            </div>
        </div>
    </main>
    <!-- select2-->
    <script>
        // ajax
        function getval(row,sel)
        {
            var current_row = row;
            var current_chart_of_account_id = sel.value;

            $.ajax({
                url : "{{URL('ledger-data')}}",
                method : "get",
                data : {
                    current_chart_of_account_id : current_chart_of_account_id
                },
                success : function (res){
                    console.log(res.data)
                    $("#ledger_id_"+current_row).html(res.data.ledgerOptions);
                },
                error : function (err){
                    console.log(err)
                }
            })
        }

        // ajax
        function getvalgroup2(sel)
        {
            var current_chart_of_group_2 = sel.value;
            $.ajax({
                url : "{{URL('ledger-data-group2')}}",
                method : "get",
                data : {
                    current_chart_of_group_2 : current_chart_of_group_2
                },
                success : function (res){
                    console.log(res.data)
                    $("#group_3").html(res.data.group3Options);

                },
                error : function (err){
                    console.log(err)
                }
            })
        }

    </script>
    <script src="{!! asset('backend/js/plugins/select2.min.js') !!}"></script>
@endsection


