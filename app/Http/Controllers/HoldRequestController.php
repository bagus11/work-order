<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\UpdateHoldRequestProgress;
use App\Models\User;
use App\Models\WONotification;
use App\Models\WorkOrder;
use App\Models\WorkOrderLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\DB;

class HoldRequestController extends Controller
{
    public function index()
    {
        return view('holdRequest.holdRequest-index');
    }
    public function getHoldRequest()
    {
        $data = WorkOrder::with(['picName','picSupportName','departementName','categoryName'])
                            ->where(function($query){
                                $query->whereIn('hold_progress', [1,2])
                                      ->orWhere('transfer_pic',1);
                            })->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function getWOActive()
    {
        $data = WorkOrder::whereBetween('status_wo',[1,3])->get();
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
                    'duration'=>$totalDuration,
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
}
