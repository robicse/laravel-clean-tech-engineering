<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquityController extends Controller
{
    public function equityForm(){
        return view('backend.new-account.equity');
    }
    public function viewEquity(){
        return view('backend.new-account.equity-view');
    }
}
