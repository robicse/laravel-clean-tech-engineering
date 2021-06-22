<?php

use Illuminate\Support\Facades\DB;






if (!function_exists('current_stock_row')) {
    function current_stock_row($store_id,$stock_type,$product_id)
    {
        return $current_stock_row = \App\Stock::where('store_id',$store_id)
            ->where('stock_type',$stock_type)
           // ->where('stock_product_type',$stock_product_type)
            ->where('product_id',$product_id)
            ->latest()->first();
    }
}


function sales_income_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Received againts Sales')
        ->groupBy('group_3')
        ->first();

    //dd($gl_pre_valance_data);


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('posting_form_details.group_3','Received againts Sales')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();
    //dd($general_ledger_infos);

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function service_income_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Received againts Services')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Received againts Services')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function inventory_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Inventory')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Inventory')
      //  ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
      ->where('posting_date', '<=',$date_from)
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function closing_inventory_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Inventory')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Inventory')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
      //->where('posting_date', '<=',$date_from)
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function purchase_account_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Purchase Account')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Purchase Account')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function purchase_installation_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Product Installation')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Product Installation')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function service_expense_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Service Expenses')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Service Expenses')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function carrying_expense_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Carrying Expenses')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Carrying Expenses')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function godwon_storage_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Godwon & Storage')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Godwon & Storage')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function miscellaneous_expense($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Miscellaneous Expense')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Miscellaneous Expense')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function admin_expense_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Admin Expense')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Admin Expense')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function selling_MKT_Expense1_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Selling & MKT Expense(Com/Ins)')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Selling & MKT Expense(Com/Ins)')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function selling_MKT_Expense_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Selling & MKT Expense')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Selling & MKT Expense')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function finance_charges_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Finance Charges')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Finance Charges')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function finance_expense_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Finance Expenses')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Finance Expenses')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}


function additional_capital($date_from, $date_to){



    $income_sale =0;
    $income_service =0;

    $inventory =0;
    $purchase_account =0;
    $closing_inventory =0;
    $purchase_installation =0;
    $service_expense =0;
    $carrying_expense =0;
    $godwon_storage =0;
    $admin_expense =0;
    $selling_MKT_Expense1 =0;
    $selling_MKT_Expense =0;
    $finance_charges =0;
    $finance_expense =0;

    $get_sales_income_statement = sales_income_statement($date_from,$date_to);
    //dd($get_sales_income_statement);
    $income_sale +=$get_sales_income_statement['PreBalance'];
    //dd($income_sale);

    $get_service_income_statement = service_income_statement($date_from,$date_to);
    $income_service +=$get_service_income_statement['PreBalance'];

    $income =$income_service+$income_sale;

    $get_inventory_statement = inventory_statement($date_from,$date_to);
    $inventory +=$get_inventory_statement['PreBalance'];

    $get_purchase_account_statement = purchase_account1_statement($date_from,$date_to);
    if(!empty($get_purchase_account_statement))
    $purchase_account +=$get_purchase_account_statement->debit;

    $get_closing_inventory_statement = closing_inventory_statement($date_from,$date_to);
    $closing_inventory +=$get_closing_inventory_statement['PreBalance'];

    $inventory_purchase = $inventory + $purchase_account;
    $closing =  $inventory_purchase - $closing_inventory;

    $get_purchase_installation_statement = purchase_installation_statement($date_from,$date_to);
    $purchase_installation +=$get_purchase_installation_statement['PreBalance'];

    $get_service_expense_statement = service_expense_statement($date_from,$date_to);
    $service_expense +=$get_service_expense_statement['PreBalance'];

    $get_carrying_expense_statement = carrying_expense_statement($date_from,$date_to);
    $carrying_expense +=$get_carrying_expense_statement['PreBalance'];

    $get_godwon_storage_statement = godwon_storage_statement($date_from,$date_to);
    $godwon_storage +=$get_godwon_storage_statement['PreBalance'];

    $expense =$closing+$purchase_installation+$service_expense+$carrying_expense+$godwon_storage;
    $gross_profit =$income-$expense;
   // dd($expense);
    $get_admin_expense_statement = admin_expense_statement($date_from,$date_to);
    $admin_expense +=$get_admin_expense_statement['PreBalance'];

    $get_selling_MKT_Expense1_statement = selling_MKT_Expense1_statement($date_from,$date_to);
    $selling_MKT_Expense1 +=$get_selling_MKT_Expense1_statement['PreBalance'];

    $get_selling_MKT_Expense_statement = selling_MKT_Expense_statement($date_from,$date_to);
    $selling_MKT_Expense +=$get_selling_MKT_Expense_statement['PreBalance'];

    $get_finance_charges_statement = finance_charges_statement($date_from,$date_to);
    $finance_charges +=$get_finance_charges_statement['PreBalance'];

    $get_finance_expense_statement = finance_expense_statement($date_from,$date_to);
    $finance_expense +=$get_finance_expense_statement['PreBalance'];

    $indirecExpense = $admin_expense+$selling_MKT_Expense1+$selling_MKT_Expense+$finance_charges+$finance_expense;
    $net_profit =$gross_profit-$indirecExpense;





    $income_sale_for_equity =0;
    $income_service_for_equity =0;

    $purchase_account_for_equity =0;
    $purchase_installation_for_equity =0;
    $service_expense_for_equity =0;
    $carrying_expense_for_equity =0;
    $godwon_storage_for_equity =0;
    $admin_expense_for_equity =0;
    $selling_MKT_Expense1_for_equity =0;
    $selling_MKT_Expense_for_equity =0;
    $finance_charges_for_equity =0;
    $finance_expense_for_equity =0;

    $get_sales_income_statement_for_equity = sales_income_statement_for_equity($date_from,$date_to);
    $income_sale_for_equity +=$get_sales_income_statement_for_equity['PreBalance'];

    $get_service_income_statement_for_equity = service_income_statement_for_equity($date_from,$date_to);
    $income_service_for_equity +=$get_service_income_statement_for_equity['PreBalance'];

    $income_for_equity =$income_service_for_equity+$income_sale_for_equity;

    $get_purchase_account_statement_for_equity = purchase_account_statement_for_equity($date_from,$date_to);
    $purchase_account_for_equity +=$get_purchase_account_statement_for_equity['PreBalance'];

    $get_purchase_installation_statement_for_equity = purchase_installation_statement_for_equity($date_from,$date_to);
    $purchase_installation_for_equity +=$get_purchase_installation_statement_for_equity['PreBalance'];

    $get_service_expense_statement_for_equity = service_expense_statement_for_equity($date_from,$date_to);
    $service_expense_for_equity +=$get_service_expense_statement_for_equity['PreBalance'];

    $get_carrying_expense_statement_for_equity = carrying_expense_statement_for_equity($date_from,$date_to);
    $carrying_expense_for_equity +=$get_carrying_expense_statement_for_equity['PreBalance'];

    $get_godwon_storage_statement_for_equity = godwon_storage_statement_for_equity($date_from,$date_to);
    $godwon_storage_for_equity +=$get_godwon_storage_statement_for_equity['PreBalance'];

    $expense_for_equity =$purchase_account_for_equity+$purchase_installation_for_equity+$service_expense_for_equity+$carrying_expense_for_equity+$godwon_storage_for_equity;
    $gross_profit_for_equity =$income_for_equity-$expense_for_equity;

    $get_admin_expense_statement_for_equity = admin_expense_statement_for_equity($date_from,$date_to);
    $admin_expense_for_equity +=$get_admin_expense_statement_for_equity['PreBalance'];

    $get_selling_MKT_Expense1_statement_for_equity = selling_MKT_Expense1_statement_for_equity($date_from,$date_to);
    $selling_MKT_Expense1_for_equity +=$get_selling_MKT_Expense1_statement_for_equity['PreBalance'];

    $get_selling_MKT_Expense_statement_for_equity = selling_MKT_Expense_statement_for_equity($date_from,$date_to);
    $selling_MKT_Expense_for_equity +=$get_selling_MKT_Expense_statement_for_equity['PreBalance'];

    $get_finance_charges_statement_for_equity = finance_charges_statement_for_equity($date_from,$date_to);
    $finance_charges_for_equity +=$get_finance_charges_statement_for_equity['PreBalance'];

    $get_finance_expense_statement_for_equity = finance_expense_statement_for_equity($date_from,$date_to);
    $finance_expense_for_equity +=$get_finance_expense_statement_for_equity['PreBalance'];

    $indirecExpense_for_equity = $admin_expense_for_equity+$selling_MKT_Expense1_for_equity+$selling_MKT_Expense_for_equity+$finance_charges_for_equity+$finance_expense_for_equity;
    $net_profit_for_equity =$gross_profit_for_equity-$indirecExpense_for_equity;



    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<=',$date_from)
        ->where('group_3','Capital Account')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr',
        'get_data' => $net_profit,
        'from_data' => $net_profit_for_equity,
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Capital Account')
        ->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

           // if($preDebCre == 'De/Cr' && $flag == 0)
            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


            $data['PreBalance'] = $PreBalance;
            $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
function opening_statement($date_from, $date_to){

    $gl_pre_valance_data = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->select('group_3', DB::raw('SUM(debit) as debit, SUM(credit) as credit'))
        ->where('posting_date', '<',$date_from)
        ->where('group_3','Capital Account')
        ->groupBy('group_3')
        ->first();


    $data = [
        'PreBalance' => 0,
        'preDebCre' => 'De/Cr'
    ];

//    $PreBalance=0;
//    $preDebCre = 'De/Cr';

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

    $sum_debit = 0;
    $sum_credit = 0;
    $final_debit_credit = 0;
    $preDebCre = 0;
    $PreBalance = 0;
    $flag = 0;
    $first_day = date('Y-m-01',strtotime($date_from));
    $last_day = date('Y-m-t',strtotime($date_from));


    $general_ledger_infos = DB::table('posting_form_details')
        ->leftJoin('posting_forms', 'posting_forms.id', '=', 'posting_form_details.posting_form_id')
        ->where('group_3','Capital Account')
        //->whereBetween('posting_forms.posting_date',[$date_from, $date_to])
        ->where('posting_date', '<',$date_from)
        ->select('posting_forms.voucher_type_id','posting_forms.voucher_no', 'posting_forms.posting_date', 'posting_forms.description', 'posting_form_details.debit', 'posting_form_details.credit')
        ->get();

    //return $general_ledger_infos;

    if(count($general_ledger_infos) > 0){
        foreach($general_ledger_infos as $key => $general_ledger_info){
            $debit = $general_ledger_info->debit;
            $credit = $general_ledger_info->credit;

            $sum_debit  += $debit;
            $sum_credit += $credit;

            if($debit > $credit)
                $curRowDebCre = 'De';
            else
                $curRowDebCre = 'Cr';

            if($preDebCre == 'De/Cr' && $flag == 0)
            {
                $preDebCre = $curRowDebCre;
                $flag = 1;
            }

            if($preDebCre == 'De' && $curRowDebCre == 'De')
            {
                $PreBalance += $debit;
                $preDebCre = 'De';
            }elseif($preDebCre == 'De' && $curRowDebCre == 'Cr'){
                if($PreBalance > $credit)
                {
                    $PreBalance = $PreBalance - $credit;
                    $preDebCre = 'De';
                }else{
                    $PreBalance = $credit - $PreBalance;
                    $preDebCre = 'Cr';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'De'){
                if($PreBalance > $debit)
                {
                    $PreBalance = $PreBalance - $debit;
                    $preDebCre = 'Cr';
                }else{
                    $PreBalance = $debit - $PreBalance;
                    $preDebCre = 'De';
                }
            }elseif($preDebCre == 'Cr' && $curRowDebCre == 'Cr'){
                $PreBalance += $credit;
                $preDebCre = 'Cr';
            }else{

            }
        }


        $data['PreBalance'] = $PreBalance;
        $data['preDebCre'] = $preDebCre;

    }

    //return $data['PreBalance'];
    return $data;
}
?>
