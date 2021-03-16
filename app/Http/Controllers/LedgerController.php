<?php

namespace App\Http\Controllers;

use App\ChartOfAccount;
use App\Ledger;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function general_ledger_form()
    {

        // $account_id = $request->account_id[$i];
        // $accounts = Account::where('id',$account_id)->first();
        //$general_ledger_account_nos = DB::table('postings')->where('account_id', '$accounts')->Orderby('account_no', 'asc')->get();
        //$general_ledger_account_nos =Transaction::Orderby('account_no', 'asc')->get();
        //$general_ledger_account_nos = DB::table('accounts')->where('IsGL', '1')->Orderby('HeadName', 'asc')->get();
        //dd($general_ledger_account_nos);
        $chartOfAccounts = ChartOfAccount::all();
        $ledgers = Ledger::all();
        return view('backend.new-account.general_ledger_form', compact('chartOfAccounts','ledgers'));
    }

    public function view_general_ledger(Request $request)
    {
        $general_ledger = $request->ledger_id;
       //dd($general_ledger);
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        if( (!empty($general_ledger)) && (!empty($date_from)) && (!empty($date_to)) )
        {
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('ledger_id',$general_ledger)
                ->groupBy('ledger_id')
                ->first();
        }else{
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->groupBy('ledger_id')
                ->first();
        }
        //dd($gl_pre_valance_data);

        $PreBalance=0;
        $preDebCre = 'De/Cr';
        if(!empty($gl_pre_valance_data))
        {
            //echo 'ok';exit;
            $debit = $gl_pre_valance_data->debit;
            $credit = $gl_pre_valance_data->credit;
            if($debit > $credit)
            {
                $PreBalance = $debit - $credit;
                $preDebCre = 'De';
            }else{
                $PreBalance = $credit - $debit;
                $preDebCre = 'Cr';
            }
        }


        if( (!empty($general_ledger)) && (!empty($date_from)) && (!empty($date_to)) )
        {
            //echo 'okk';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
               // ->where('postings.account_no',$general_ledger)
                ->where('ledger_id',$general_ledger)
                ->whereBetween('posting_forms.posting_date', [$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }else{
            //echo 'noo';exit;
            $general_ledger_infos = DB::table('posting_form_details')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->whereBetween('posting_forms.posting_date', [$date_from, $date_to])
                //->select('postings.voucher_type_id','postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.new-account.general_ledger_view', compact('general_ledger_infos','PreBalance', 'preDebCre', 'general_ledger', 'date_from', 'date_to'));
    }
    public function general_ledger_print($transaction_head,$date_from,$date_to)
    {
        //dd($transaction_head);
        //echo ($transaction_head->account_no);
        //exit;
        if( (!empty($transaction_head)) && (!empty($date_from)) && (!empty($date_to)) )
        {
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->where('ledger_id',$transaction_head)
                ->groupBy('ledger_id')
                ->first();
        }else{
            $gl_pre_valance_data = DB::table('posting_form_details')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->select('ledger_id', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
                ->where('posting_date', '<',$date_from)
                ->groupBy('ledger_id')
                ->first();
//            $gl_prevalance_data = DB::table('postings')
//                ->select('account_no', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
//                ->where('date', '<',$date_from)
//                ->groupBy('account_no')
//                ->first();
        }

        $PreBalance=0;
        $preDebCre = 'De/Cr';
        if(!empty($gl_prevalance_data))
        {
            //echo 'ok';exit;
            $debit = $gl_prevalance_data->debit;
            $credit = $gl_prevalance_data->credit;
            if($debit > $credit)
            {
                $PreBalance = $debit - $credit;
                $preDebCre = 'De';
            }else{
                $PreBalance = $credit - $debit;
                $preDebCre = 'Cr';
            }
        }


        if( (!empty($transaction_head)) && (!empty($date_from)) && (!empty($date_to)) )
        {
            //echo 'okk';exit;
//            $general_ledger_infos = DB::table('postings')
//                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
//                ->leftJoin('accounts', 'postings.account_no', '=', 'accounts.HeadCode')
//                ->where('postings.account_no',$transaction_head)
//                ->whereBetween('postings.date', [$date_from, $date_to])
//                ->select('postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
//                ->get();
            $general_ledger_infos = DB::table('posting_form_details')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                // ->where('postings.account_no',$general_ledger)
                ->where('ledger_id',$transaction_head)
                ->whereBetween('posting_forms.posting_date', [$date_from, $date_to])
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }else{
            //echo 'noo';exit;
//            $general_ledger_infos = DB::table('postings')
//                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
//                ->leftJoin('accounts', 'postings.account_no', '=', 'accounts.HeadCode')
//                ->whereBetween('postings.date', [$date_from, $date_to])
//                ->select('postings.voucher_no',  'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
//                ->get();
            $general_ledger_infos = DB::table('posting_form_details')
                //->join('accounts', 'postings.id', '=', 'accounts.user_id')
                ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
                ->whereBetween('posting_forms.posting_date', [$date_from, $date_to])
                //->select('postings.voucher_type_id','postings.voucher_no', 'postings.date', 'postings.account_no', 'postings.transaction_description', 'postings.debit', 'postings.credit', 'accounts.HeadName', 'accounts.PHeadName', 'accounts.HeadType')
                ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
                ->get();
        }

        //dd($general_ledger_infos);

        return view('backend.new-account.general_ledger_print', compact('general_ledger_infos','PreBalance', 'preDebCre', 'transaction_head', 'date_from', 'date_to'));
    }
}
