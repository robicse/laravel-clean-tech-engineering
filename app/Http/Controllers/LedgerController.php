<?php

namespace App\Http\Controllers;

use App\ChartOfAccount;
use App\Ledger;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class LedgerController extends Controller
{

    public function index()
    {
        $ledgers = Ledger::latest()->get();
        return view('backend.ledger.index',compact('ledgers'));
    }


    public function create()
    {
        $chartOfAccounts = ChartOfAccount::all();
        return view('backend.ledger.create',compact('chartOfAccounts'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $row_count = count($request->chart_of_account_id);
        //dd($row_count);
        for($i = 0; $i < $row_count; $i++) {

           // $account_id = $request->chart_of_account_id;
            //$accounts = ChartOfAccount::where('id',$account_id)->first();
            $ledgers = new Ledger();
            $ledgers->chart_of_account_id = $request->chart_of_account_id[$i];
            $ledgers->name = $request->name[$i];;
      //dd($ledgers->chart_of_account_id);
            $ledgers->save();
        }
        Toastr::success('Ledger Created Successfully', 'Success');
        return redirect()->route('Ledger.index');

    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $chartOfAccounts = ChartOfAccount::all();
        $ledgers = Ledger::find($id);
       //dd($chartOfAccounts);
        return view('backend.ledger.edit',compact('chartOfAccounts','ledgers'));
    }


    public function update(Request $request, $id)
    {
        $ledgers = Ledger::find($id);
        $ledgers->chart_of_account_id = $request->chart_of_account_id;
        $ledgers->name = $request->name;;
        //dd($ledgers->chart_of_account_id);
        $ledgers->save();
        Toastr::success('Ledger Updated Successfully', 'Success');
        return redirect()->route('Ledger.index');
    }


    public function destroy($id)
    {
        $ledgers = Ledger::find($id);
        $ledgers->delete();
        Toastr::success('Ledger Deleted Successfully', 'Success');
        return redirect()->route('Ledger.index');
    }
}
