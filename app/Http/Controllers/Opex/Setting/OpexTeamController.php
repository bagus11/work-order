<?php

namespace App\Http\Controllers\Opex\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OpexTeamController extends Controller
{
    function index() {
        return view('opex.setting.opex_team-index');
    }
}
