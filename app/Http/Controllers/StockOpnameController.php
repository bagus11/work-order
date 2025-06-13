<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    function index() {
        return view('stock_opname.stock_opname-index');
    }
}
