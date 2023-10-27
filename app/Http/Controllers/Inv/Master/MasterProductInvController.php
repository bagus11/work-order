<?php

namespace App\Http\Controllers\inv\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterProductInvController extends Controller
{
    function index() {
        return view('inv.master.category.master_category-index');
    
    }
}
