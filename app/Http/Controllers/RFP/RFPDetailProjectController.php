<?php

namespace App\Http\Controllers\RFP;

use App\Http\Controllers\Controller;
use App\Models\DailyActivity;
use App\Models\RFP\ChatModel;
use App\Models\RFPDetail;
use App\Models\RFPSubDetail;
use App\Models\RFPTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    function getChat(Request $request) {
        $chat   = ChatModel::with(['userRelation'])->where('detail_code',$request->detail_code)->orderBy('created_at','asc')->get(); 
        return response()->json([
            'chat'=>$chat,
        ]); 
    }
    function updateStatusSubDetail(Request $request){
        $status     = 500;
        $message    = 'Failed Update Progress, please contact ICT Dev';
        $subdetail  =  RFPSubDetail::find($request->id);
        $postUpdate =[
            'status'            => $request->status == 1 ? 0:1,
            'finish_date'       =>date('Y-m-d') > $request->status ? date('Y-m-d') :'',
        ];
        $activate = $request->status == 1 ?'inactive' :'active';
        $post =[
            'description'=>auth()->user()->name . ' has update progress subdetail with subdetail code : '. $subdetail->subdetail_code. ' ('.$subdetail->title.')',
            'status'=> $request->status == 1 ? 0:1,
            'userId'=>999,
            'activityCode'=>$subdetail->subdetail_code
        ];
        $post_chat = [
            'user_id'           => 999,
            'request_code'      => $subdetail->request_code,
            'detail_code'       => $subdetail->detail_code,
            'remark'            => auth()->user()->name . ' has '.$activate.' subdetail with subdetail code : '. $subdetail->subdetail_code. ' ('.$subdetail->title.')'
        ];
        $update = RFPSubDetail::find($request->id)->update($postUpdate);
        if($update){
            DailyActivity::create($post);
            ChatModel::create($post_chat);
            $statusDone     =   RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('detail_code',$subdetail->detail_code)->where('status',1)->first();
            $statusAll      =   RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('detail_code',$subdetail->detail_code)->first();
            $percentage     =   ($statusDone->percentage / $statusAll->percentage) * 100;
            $statusRFPDone  =   RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('request_code',$subdetail->request_code)->where('status',1)->first();
            $statusRFPAll   =   RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('request_code',$subdetail->request_code)->first();
            $percentageRFP  =   ($statusRFPDone->percentage / $statusRFPAll->percentage) * 100 ; 
            if($percentage == 100 ){
                if($percentageRFP == 100){
                   RFPTransaction::where('request_code',$subdetail->request_code)->update([
                    'progress'=>$percentageRFP,
                    'status'=>1
                   ]);
                }
                RFPDetail::where('detail_code', $subdetail->detail_code)->update([
                    'percentage'=>$percentage,
                    'status'=> 1
                ]);
            }else{
                RFPDetail::where('detail_code', $subdetail->detail_code)->update(['percentage'=>$percentage]);
                RFPTransaction::where('request_code',$subdetail->request_code)->update([
                    'progress'=>$percentageRFP
                ]);
            }
            $status = 200;
            $message ='Successfully Update Progress';
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]); 
    }
}
