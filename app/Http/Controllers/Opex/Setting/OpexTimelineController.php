<?php

namespace App\Http\Controllers\Opex\Setting;

use App\Http\Controllers\Controller;
use App\Models\Opex\OpexHeader;
use Illuminate\Http\Request;

class OpexTimelineController extends Controller
{
    function index() {
        return view('opex.transaction.opex_timeline.opex-index');
    }
    function getOPex() {
        $data = OpexHeader::with(['locationRelation'])->get();
        return response()->json([
            'data'=>$data
        ]);
    }
}
