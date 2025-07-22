<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\StoreTransferPICRequest;
use App\Http\Requests\UpdateHoldRequestProgress;
use App\Models\User;
use App\Models\WONotification;
use App\Models\WorkOrder;
use App\Models\WorkOrderLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\DB;
use NumConvert;
class HoldRequestController extends Controller
{
    public function index()
    {
        return view('holdRequest.holdRequest-index');
    }
    public function getHoldRequest()
    {
        $data = WorkOrder::with(['picName','picSupportName','departementName','categoryName'])
                            // ->where(function($query){
                            //     $query->whereIn('hold_progress', [1,2])
                            //           ->orWhere('transfer_pic',1);
                            // })
                            ->whereIn('hold_progress', [1,2])
                            ->orderBy('id', 'desc')
                            ->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function getWOActive()
    {
        $data = WorkOrder::whereBetween('status_wo',[1,4])->where('transfer_pic', 0)->where(function ($query) {
            $query->where('status_approval', 2)
                  ->orWhere('status_approval', 0);
        })->get();
        $pic = User::where('departement', auth()->user()->departement)->get();
        return response()->json([
            'data'=>$data,
            'pic'=>$pic,
        ]);
    }
    public function getWODetail(Request $request)
    {
        $detail = WorkOrderLog::with(['userPIC','userPICSupport','departementName','categoryName','problemTypeName'])->where('request_code', $request->requestCode)->orderBy('id','desc')->first();
        return response()->json([
            'detail'=>$detail,
            ]);
    }
    public function updateHoldRequest(Request $request, UpdateHoldRequestProgress $updateHoldRequestProgress)
    {
        try {
            $updateHoldRequestProgress->validated();
            $rfm = WorkOrder::where('request_code', $request->request_code)->first();
            $workOrderStatus    =   WorkOrderLog::where('request_code', $rfm->request_code)
                                    ->orderBy('created_at','desc')
                                    ->first();
            $timeBeforePost     =   $workOrderStatus->created_at;
            $timeBefore         =   Carbon::createFromFormat('Y-m-d H:i:s', $timeBeforePost);
            $timeNow            =   Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $totalDuration      =   $timeBefore->diffInMinutes($timeNow);
          
            $post=[
                'hold_progress'=>$request->hold_progress,
            ];
            $postLog=[
                    'request_code'=>$request->request_code,
                    'request_type'=>$workOrderStatus->request_type,
                    'departement_id'=>$workOrderStatus->departement_id,
                    'add_info'=>$workOrderStatus->add_info,
                    'user_id'=>$workOrderStatus->user_id,
                    'assignment'=>$workOrderStatus->assignment,
                    'status_wo'=>$workOrderStatus->status_wo,
                    'priority'=>$workOrderStatus->priority,
                    'category'=>$workOrderStatus->category,
                    'follow_up'=>$workOrderStatus->follow_up,
                    'status_approval'=>$workOrderStatus->status_approval,
                    'user_id_support'=>$workOrderStatus->user_id_support,
                    'subject'=>$workOrderStatus->subject,
                    'problem_type'=>$workOrderStatus->problem_type,
                    'comment'=>$request->holdComment,
                    'creator'=>auth()->user()->id,
                    'duration'=>$totalDuration,
                    'hold_progress'=>$request->hold_progress,
                    'transfer_pic'=>$workOrderStatus->transfer_pic,
                    'request_id'=>$workOrderStatus->request_id,
            ];
            $assign = $request->hold_progress == 2 ? 'accept' : 'reject';
            $postHead  =[
                'message'=>auth()->user()->name.' has '.$assign.' to hold your wo transaction with request code : '.$request->request_code,
                'subject'=>'Hold Request',
                'status'=>0,
                'link'=>'work_order_list',
                'userId'=>$workOrderStatus->user_id_support,
                'created_at'=>date('Y-m-d H:i:s')
            ];
          
            $postUser  =[
                'message'=>'your WO transaction with request code : '.$request->request_code.' has been hold',
                'subject'=>'Hold Request',
                'status'=>0,
                'link'=>'work_order_list',
                'userId'=>$workOrderStatus->user_id,
                'created_at'=>date('Y-m-d H:i:s')
            ];  
            
            DB::transaction(function() use($post,$request, $postHead, $postLog, $postUser) {
                WorkOrder::where('request_code', $request->request_code)->update($post);
                WorkOrderLog::create($postLog);
                WONotification::create($postHead);
                if($request->hold_progress == 2){
                    WONotification::create($postUser);
                }
            });
            return ResponseFormatter::success(
                $post,
                'Category successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Category failed to add',
                500
            );
        }
    }
    public function updateResumeRequest(Request $request)
    {
       
            $rfm = WorkOrder::where('request_code', $request->request_code)->first();
            
            $workOrderStatus    =   WorkOrderLog::where('request_code', $rfm->request_code)
                                    ->orderBy('created_at','desc')
                                    ->first();
            $timeBeforePost     =   $workOrderStatus->created_at;
            $timeBefore         =   Carbon::createFromFormat('Y-m-d H:i:s', $timeBeforePost);
            $timeNow            =   Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $totalDuration      =   $timeBefore->diffInMinutes($timeNow);
            $status = 500;
            $message = "WO is failed to update";
            $post=[
                'hold_progress'=>4,
            ];
            $postLog=[
                    'request_code'=>$request->request_code,
                    'request_type'=>$workOrderStatus->request_type,
                    'departement_id'=>$workOrderStatus->departement_id,
                    'add_info'=>$workOrderStatus->add_info,
                    'user_id'=>$workOrderStatus->user_id,
                    'assignment'=>$workOrderStatus->assignment,
                    'status_wo'=>$workOrderStatus->status_wo,
                    'priority'=>$workOrderStatus->priority,
                    'category'=>$workOrderStatus->category,
                    'follow_up'=>$workOrderStatus->follow_up,
                    'status_approval'=>$workOrderStatus->status_approval,
                    'user_id_support'=>$workOrderStatus->user_id_support,
                    'subject'=>$workOrderStatus->subject,
                    'problem_type'=>$workOrderStatus->problem_type,
                    'comment'=>'Work Order can be processed again',
                    'creator'=>auth()->user()->id,
                    'duration'=>0,
                    'hold_progress'=>4,
                    'transfer_pic'=>$workOrderStatus->transfer_pic,
                    'request_id'=>$workOrderStatus->request_id,
            ];
            $postHead  =[
                'message'=>auth()->user()->name.' has resume your wo transaction with request code : '.$request->request_code,
                'subject'=>'Hold Request',
                'status'=>0,
                'link'=>'work_order_list',
                'userId'=>$workOrderStatus->user_id_support,
                'created_at'=>date('Y-m-d H:i:s')
            ];
          
            $postUser  =[
                'message'=>'your WO transaction with request code : '.$request->request_code.' is on progress again',
                'subject'=>'Hold Request',
                'status'=>0,
                'link'=>'work_order_list',
                'userId'=>$workOrderStatus->user_id,
                'created_at'=>date('Y-m-d H:i:s')
            ];
            DB::transaction(function() use($post,$request, $postHead, $postLog, $postUser) {
                WorkOrder::where('request_code', $request->request_code)->update($post);
                WorkOrderLog::create($postLog);
                WONotification::create($postHead);
                WONotification::create($postUser);
            });

            $checkStatus =  WorkOrder::where('request_code', $request->request_code)->first();
            if($checkStatus->hold_progress == 4){
                $status =200;
                $message ='Data successfully updated';
            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                ]);
    }
    public function saveTransferPIC(Request $request, StoreTransferPICRequest $storeTransferPICRequest)
    {
        try {
            $storeTransferPICRequest->validated();
            $increment_code= WorkOrder::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $exRequestCode = explode('/', $request->requestCode);
           
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $ticket_code = '1/'.$exRequestCode[1].'/'.$request[2].'/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/', $increment_code->request_code,-1);
              
                if($month_convert != $month_before[3]){
                    $ticket_code = '1/'.$month_before[1].'/'.$month_before[2].'/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/'.$month_before[1].'/'.$month_before[2].'/'.$month_convert.'/'.$year;
                }   
            }
         
            $requestCodeOld= WorkOrder::where('request_code',$request->requestCode)->first();
            $userName = User::find($request->picId);
            $post =[
                'request_code'=>$ticket_code,
                'request_type'=>$requestCodeOld->request_type,
                'request_for'=>$requestCodeOld->request_for,
                'departement_id'=>$requestCodeOld->departement_id,
                'problem_type'=>$requestCodeOld->problem_type,
                'subject'=>$requestCodeOld->subject,
                'add_info'=>$requestCodeOld->add_info,
                'priority'=>$requestCodeOld->priority,
                'user_id'=>$requestCodeOld->user_id,
                'assignment'=>1,
                'status_wo'=>1,
                'category'=>$requestCodeOld->category,
                'follow_up'=>0,
                'status_approval'=>0,
                'user_id_support'=>$request->picId,
                'rating'=>0,
                'request_id'=>$request->requestCode,
                'created_at'=>date('Y-m-d H:i:s')
            ];
         
            $post_log =[
                'request_code'=>$ticket_code,
                'request_type'=>$requestCodeOld->request_type,
                // 'request_for'=>$requestCodeOld->request_for,
                'departement_id'=>$requestCodeOld->departement_id,
                'problem_type'=>$requestCodeOld->problem_type,
                'subject'=>$requestCodeOld->subject,
                'add_info'=>$requestCodeOld->add_info,
                'user_id'=>$requestCodeOld->user_id,
                'assignment'=>0,
                'status_wo'=>0,
                'category'=>$requestCodeOld->category,
                'follow_up'=>0,
                'status_approval'=>0,
                'user_id_support'=>$request->picId,
                // 'rating'=>0,
                'creator'=>auth()->user()->id,
                'created_at'=>date('Y-m-d H:i:s'),
                'comment'=>'Create Transfer PIC from request code :'.$request->requestCode
            ];
            $post_log2 =[
                'request_code'=>$ticket_code,
                'request_type'=>$requestCodeOld->request_type,
                // 'request_for'=>$requestCodeOld->request_for,
                'departement_id'=>$requestCodeOld->departement_id,
                'problem_type'=>$requestCodeOld->problem_type,
                'subject'=>$requestCodeOld->subject,
                'add_info'=>$requestCodeOld->add_info,
                'user_id'=>$requestCodeOld->user_id,
                'assignment'=>1,
                'status_wo'=>1,
                'category'=>$requestCodeOld->category,
                'follow_up'=>0,
                'status_approval'=>0,
                'user_id_support'=>$request->picId,
                'creator'=>auth()->user()->id,
                // 'rating'=>0,
                'created_at'=>date('Y-m-d H:i:s'),
                'comment'=>'Assign Work Order ticket to :'.$userName->name
            ];
            $post_log3 =[
                'request_code'=>$requestCodeOld->request_code,
                'request_type'=>$requestCodeOld->request_type,
                // 'request_for'=>$requestCodeOld->request_for,
                'departement_id'=>$requestCodeOld->departement_id,
                'problem_type'=>$requestCodeOld->problem_type,
                'subject'=>$requestCodeOld->subject,
                'add_info'=>$requestCodeOld->add_info,
                'user_id'=>$requestCodeOld->user_id,
                'assignment'=>1,
                'status_wo'=>4,
                'category'=>$requestCodeOld->category,
                'follow_up'=>0,
                'status_approval'=>1,
                'user_id_support'=>$request->picId,
                'creator'=>auth()->user()->id,
                // 'rating'=>0,
                'created_at'=>date('Y-m-d H:i:s'),
                'comment'=>'Take Over Work Order to '.$userName->name
            ];
          
            $postUser  =[
                'message'=>'your WO transaction with request code : '.$request->requestCode.' has been taken over to '.$userName->name,
                'subject'=>'Hold Request',
                'status'=>0,
                'type'=>1,
                'link'=>'work_order_list',
                'userId'=>$requestCodeOld->user_id,
                'created_at'=>date('Y-m-d H:i:s')
            ];
            $postSupport  =[
                'message'=>'your WO transaction with request code : '.$request->requestCode.' has been taken over to '.$userName->name,
                'subject'=>'Hold Request',
                'status'=>0,
                'type'=>1,
                'link'=>'work_order_list',
                'userId'=>$requestCodeOld->user_id_support,
                'created_at'=>date('Y-m-d H:i:s')
            ];

            $postSupport2  =[
                'message'=>auth()->user()->name.' has assign work order transaction with request code :'.$ticket_code.' to you',
                'subject'=>'Hold Request',
                'status'=>0,
                'type'=>1,
                'link'=>'work_order_list',
                'userId'=>$request->picId,
                'created_at'=>date('Y-m-d H:i:s')
            ];
         
            DB::transaction(function() use($post,$request,$post_log,$post_log2,$post_log3,$postUser,$postSupport,$postSupport2) {
                $sumofDuration = WorkOrderLog::select(DB::raw('SUM(duration) as sumOfDuration'))->where('request_code',$request->requestCode)->first();
                WorkOrder       ::where('request_code',$request->requestCode)->update([
                    'transfer_pic'          => 1,
                    'status_wo'             => 4,
                    'status_approval'       => 1,
                    'duration'              =>$sumofDuration->sumOfDuration
                ]);
                WorkOrder       ::create($post);
                WorkOrderLog    ::create($post_log);
                WorkOrderLog    ::create($post_log2);
                WorkOrderLog    ::create($post_log3);
                WONotification  ::create($postUser);
                WONotification  ::create($postSupport);
                WONotification  ::create($postSupport2);
            });
            return ResponseFormatter::success(
                $requestCodeOld,
                'Transfer PIC successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Transfer PIC failed to add',
                500
            );
        }
    }
}
