<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellPaymentReportController extends Controller
{
    public function index(){

        return view('reports.sell_payment_report');
    }
}
