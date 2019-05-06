<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductSellReportController extends Controller
{
    public function index(){

        return view('reports.product_sell_report');
    }
}
