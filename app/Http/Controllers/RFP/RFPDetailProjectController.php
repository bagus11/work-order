<?php

namespace App\Http\Controllers\RFP;

use App\Http\Controllers\Controller;
use App\Models\RFP\ChatModel;
use App\Models\RFPDetail;
use App\Models\RFPSubDetail;
use Illuminate\Http\Request;

class RFPDetailProjectController extends Controller
{
    function project($request_code) {
        $data =[
            'request_code' =>str_replace('_','/',$request_code)
        ];
        return view('rfp.rfp_kanban.rfp_detail',$data);
    }
    function getSubDetailKanban(Request $request) {
        $data   = RFPSubDetail::with(['userRelation', 'rfpDetailRelation'])->where('detail_code',$request->detail_code)->orderBy('start_date','asc')->get();                             
        $detail = RFPDetail::with(['userRelation'])->where('detail_code',$request->detail_code)->first();
        $chat   = ChatModel::with(['userRelation'])->where('detail_code',$request->detail_code)->orderBy('created_at','asc')->get();                             
        return response()->json([
            'data'=>$data,
            'chat'=>$chat,
            'detail'=>$detail,
        ]); 
    }
}
