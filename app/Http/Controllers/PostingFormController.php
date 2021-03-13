<?php

namespace App\Http\Controllers;

use App\ChartOfAccount;
use App\Ledger;
use App\PostingForm;
use App\VoucherType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class PostingFormController extends Controller
{

    public function index()
    {
        $postingForms = PostingForm::all();
        return view('backend.postingForm.index',compact('postingForms'));
    }


    public function create()
    {
        $voucherTypes=VoucherType::all();
        $chartOfAccounts = ChartOfAccount::all();
        $ledgers = Ledger::all();

        return view('backend.postingform.create',compact('voucherTypes','chartOfAccounts','ledgers'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'chart_of_account_id'=> 'required',
        ]);

        $check_voucher_no_exists = PostingForm::where('voucher_no',$request->voucher_no)->where('voucher_type_id',$request->voucher_type_id)->latest()->pluck('voucher_no')->first();
        //dd($check_voucher_no_exists);
        if($check_voucher_no_exists){
            Toastr::warning('Voucher NO Already Exists!', 'Warning');
            return redirect()->route('postingForm.create');
        }

        $row_count = count($request->account_id);
        $total_amount = 0;
        for($i=0; $i<$row_count;$i++)
        {
            $total_amount += $request->amount[$i];
        }

        for ($i = 0; $i < $row_count; $i++) {
            $debit = NULL;
            $credit = NULL;
            $debit_or_credit = $request->debit_or_credit[$i];
            if($debit_or_credit == 'debit'){
                $debit = $request->amount[$i];
            }
            if($debit_or_credit == 'credit'){
                $credit = $request->amount[$i];
            }

            $account_id = $request->account_id[$i];
            $accounts = Account::where('id',$account_id)->first();


            $transactions = new Posting();
            $transactions->voucher_type_id = $request->voucher_type_id;
            $transactions->voucher_no = $request->voucher_no ;
            $transactions->date = $request->date;
            $transactions->account_id = $account_id;
            $transactions->account_name = $accounts->HeadName;
            $transactions->parent_account_name = $accounts->PHeadName;
            $transactions->account_no = $accounts->HeadCode;
            $transactions->account_type = $accounts->HeadType;
            $transactions->debit = $debit;
            $transactions->credit = $credit;
            $transactions->transaction_description = $request->transaction_description;
            //dd($transactions);
            $transactions->save();

        }
        Toastr::success('Posting Created Successfully', 'Success');
        return redirect()->route('posting.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
    public function ledgerRelationData(Request $request){
        $chartOfAccount_id = $request->current_chart_of_account_id;
        $ledger_id = Ledger::where('chart_of_account_id',$chartOfAccount_id)->pluck('id')->first();
        //dd($ledger_id);
        $options = [
            'ledgerOptions' => '',

        ];
        if($ledger_id){
            $ledgers = Ledger::where('id',$ledger_id)->get();
            if(count($ledgers) > 0){
                $options['ledgerOptions'] = "<select class='form-control' name='ledger_id[]'>";
                foreach($ledgers as $ledger){
                    $options['ledgerOptions'] .= "<option value='$ledger->id'>$ledger->name</option>";
                }
                $options['ledgerOptions'] .= "</select>";
            }
        }else{
            $options['ledgerOptions'] = "<select class='form-control' name='ledger_id[]' readonly>";
            $options['ledgerOptions'] .= "<option value=''>No Data Found!</option>";
            $options['ledgerOptions'] .= "</select>";
        }

        return response()->json(['success'=>true,'data'=>$options]);
    }
}
