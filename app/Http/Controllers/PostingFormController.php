<?php

namespace App\Http\Controllers;

use App\ChartOfAccount;
use App\Ledger;
use App\PostingForm;
use App\PostingFormDetails;
use App\VoucherType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostingFormController extends Controller
{

    public function index()
    {
        $postingForms = PostingForm::all();
        return view('backend.postingform.index',compact('postingForms'));
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
//        $this->validate($request, [
//            'chart_of_account_id'=> 'required',
//        ]);

        $check_voucher_no_exists = PostingForm::where('voucher_no',$request->voucher_no)->where('voucher_type_id',$request->voucher_type_id)->latest()->pluck('voucher_no')->first();
        //dd($check_voucher_no_exists);
        if($check_voucher_no_exists){
            Toastr::warning('Voucher NO Already Exists!', 'Warning');
            return redirect()->route('postingForm.create');
        }

        $row_count = count($request->account_id);
       // dd($row_count);
        $total_amount = 0;
        for($i=0; $i<$row_count;$i++)
        {
            $total_amount += $request->amount[$i];
        }
            $postingForms = new PostingForm();
            $postingForms ->user_id = Auth::id();
            $postingForms->voucher_type_id = $request->voucher_type_id;
            $postingForms->voucher_no = $request->voucher_no ;
            $postingForms->description = $request->description;
            $postingForms->posting_date = $request->date;
            $postingForms->save();
            $insert_id= $postingForms->id;
            if($insert_id)
            {
                for($i=0; $i<$row_count;$i++) {
                    $debit = NULL;
                    $credit = NULL;
                    $debit_or_credit = $request->debit_or_credit[$i];
                    if($debit_or_credit == 'debit'){
                        $debit = $request->amount[$i];
                    }
                    if($debit_or_credit == 'credit'){
                        $credit = $request->amount[$i];
                    }


                    $chart_of_account_id = $request->account_id[$i];

                    $chart_of_account_details = ChartOfAccount::find($chart_of_account_id);
                    $group_1=$chart_of_account_details->group_1;
                    $group_2=$chart_of_account_details->group_2;
                    $group_3=$chart_of_account_details->group_3;
                    $group_4=$chart_of_account_details->group_4;
                    $head_type=$chart_of_account_details->head_type;

                    $ledger_id = $request->ledger_id[$i];
                    $ledger_id_details = Ledger::find($ledger_id);
                    $ledger_name = $ledger_id_details->name;

                    $postingFormDetails = new PostingFormDetails();
                    $postingFormDetails->posting_form_id = $insert_id;
                    $postingFormDetails->chart_of_account_id = $request->account_id[$i];
                    $postingFormDetails->group_1 = $group_1;
                    $postingFormDetails->group_2 = $group_2;
                    $postingFormDetails->group_3 = $group_3;
                    $postingFormDetails->head_type = $head_type;
                    $postingFormDetails->group_4 = isset($group_4) ? $group_4 : NULL;
                    $postingFormDetails->ledger_id = $request->ledger_id[$i];
                    $postingFormDetails->ledger_name = $ledger_name;
                    $postingFormDetails->debit = $debit;
                    $postingFormDetails->credit = $credit;

                  //  dd($postingFormDetails);
                    $postingFormDetails->save();
                }
            }
        Toastr::success('Posting Created Successfully', 'Success');
        return redirect()->route('postingForm.index');
    }


    public function show($id)
    {
        //
    }


    public function postingEdit( $voucher_type_id, $voucher_no)
    {
        //dd($voucher_no);
        $voucherTypes=VoucherType::all();
        $ledgers = Ledger::all();
        $chartOfAccounts = ChartOfAccount::all();
        $postingForms= PostingForm::where('voucher_type_id',$voucher_type_id)->where('voucher_no',$voucher_no)->get();
        $postingFormsId= PostingForm::where('voucher_type_id',$voucher_type_id)->where('voucher_no',$voucher_no)->first();
        //dd($postingForms->id);
        $postingFormsDetails= PostingFormDetails::where('posting_form_id',$postingFormsId->id)->get();
        //dd($postingFormsDetails);
        return view('backend.postingform.edit',compact('chartOfAccounts','voucherTypes','ledgers','postingForms','postingFormsDetails'));
    }


    public function postingUpdate(Request $request, $voucher_type_id, $voucher_no)
    {

        //dd($request->all());

        //$check_voucher_no_exists = PostingForm::where('voucher_no',$request->voucher_no)->where('voucher_type_id',$request->voucher_type_id)->latest()->pluck('voucher_no')->first();
        //dd($check_voucher_no_exists);
//        if($check_voucher_no_exists){
//            Toastr::warning('Voucher NO Already Exists!', 'Warning');
//            return redirect()->route('postingForm.create');
//        }

        $row_count = count($request->account_id);
        // dd($row_count);
        $total_amount = 0;
        for($i=0; $i<$row_count;$i++)
        {
            $total_amount += $request->amount[$i];
        }
            $postingForms_id = $request->posting_form_id;

          // dd($postingForms_id);
            $postingForms =  PostingForm::find($postingForms_id);
            $postingForms ->user_id = Auth::id();
            $postingForms->voucher_type_id = $request->voucher_type_id;
            $postingForms->voucher_no = $request->voucher_no ;
            $postingForms->description = $request->description;
            $postingForms->posting_date = $request->date;
            $postingForms->update();
            $insert_id= $postingForms->id;
            if($insert_id)
            {
                for($i=0; $i<$row_count;$i++) {
                    $debit = NULL;
                    $credit = NULL;
                    $debit_or_credit = $request->debit_or_credit[$i];
                    if($debit_or_credit == 'debit'){
                        $debit = $request->amount[$i];
                    }
                    if($debit_or_credit == 'credit'){
                        $credit = $request->amount[$i];
                    }
                    $postingFormDetails_id = $request->posting_form_details_id[$i];
                    $postingFormDetails = PostingFormDetails::find($postingFormDetails_id);
                    $postingFormDetails->posting_form_id = $insert_id;
                    $postingFormDetails->chart_of_account_id = $request->account_id[$i];
                    $postingFormDetails->ledger_id = $request->ledger_id[$i];
                    $postingFormDetails->debit = $debit;
                    $postingFormDetails->credit = $credit;
                   // dd($postingFormDetails);
                    $postingFormDetails->update();
                }
            }



//        }
        Toastr::success('Posting Updated Successfully', 'Success');
        return redirect()->route('postingForm.index');
    }


    public function postingDelete($voucher_type_id, $voucher_no,$id){

        if (empty($voucher_type_id || $voucher_no)){
            return response()->json(['success'=> 0]);
        }
        $posting=  PostingForm::find($id);
        $posting->delete();
        DB::table('posting_form_details')->where('posting_form_id',$id)->delete();

        Toastr::success('Posting Deleted Successfully', 'Success');
        return redirect()->route('postingForm.index');
    }

    public function ledgerRelationData(Request $request){
        $chartOfAccount_id = $request->current_chart_of_account_id;
        $ledgers = Ledger::where('chart_of_account_id',$chartOfAccount_id)->get();
        //dd($ledger_id);
        $options = [
            'ledgerOptions' => '',

        ];
        if($ledgers){
            //$ledgers = Ledger::where('id',$ledger_id)->get();
            if(count($ledgers) > 0){
                $options['ledgerOptions'] = "<select class='form-control' name='ledger_id[]'>";
                $options['ledgerOptions'] .= "<option value=''>Select One</option>";
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

    public function group2RelationData(Request $request){
        $current_chart_of_group_2 = $request->current_chart_of_group_2;
        $currentChartOfGroup3s = ChartOfAccount::where('group_2',$current_chart_of_group_2)->select('group_3')->groupBy('group_3')->get();
        //dd($ledger_id);
        $options = [
            'group3Options' => '',

        ];
        if($currentChartOfGroup3s){
            //$ledgers = Ledger::where('id',$ledger_id)->get();
            if(count($currentChartOfGroup3s) > 0){
                $options['group3Options'] = "<select class='form-control' name='ledger_id[]'>";
                $options['group3Options'] .= "<option value=''>Select One</option>";
                foreach($currentChartOfGroup3s as $currentChartOfGroup3){
                    $options['group3Options'] .= "<option value='$currentChartOfGroup3->group_3'>$currentChartOfGroup3->group_3</option>";
                }
                $options['group3Options'] .= "</select>";
            }
        }else{
            $options['group3Options'] = "<select class='form-control' name='ledger_id[]' readonly>";
            $options['group3Options'] .= "<option value=''>No Data Found!</option>";
            $options['group3Options'] .= "</select>";
        }

        return response()->json(['success'=>true,'data'=>$options]);
    }

    public function getVoucherNumber(Request $request){

        $current_voucher_type_id = $request->current_voucher_type_id;
        $current_voucher_no = DB::table('posting_forms')
            ->where('voucher_type_id',$current_voucher_type_id)
            ->latest()
            ->pluck('voucher_no')
            ->first();
        // dd($current_voucher_no);
        if(!empty($current_voucher_no)){
            $voucher_no = $current_voucher_no + 1;
        }else{
            $voucher_no = 1;
        }

        return response()->json(['success'=>true,'data'=>$voucher_no]);
    }
}
