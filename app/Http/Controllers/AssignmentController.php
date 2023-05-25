<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\MasterDepartement;
use App\Models\MasterPriority;
use App\Models\User;
use App\Models\WONotification;
use App\Models\WorkOrder;
use App\Models\WorkOrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
   public function index()
   {
        return view('assignment.assignment-index');
   }
   public function get_assignment()
   {
        $data = DB::table('work_orders')
        ->select('work_orders.*', 'users.name as username','master_categories.name as categories_name','master_departements.name as departement_name')
        ->join('users','users.id','=','work_orders.user_id')
        ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
        ->leftJoin('master_departements','master_departements.id','=','work_orders.departement_id')
        ->whereNull('work_orders.priority')
        ->where('status_wo','!=','5')
        ->orderBy('work_orders.status_wo','asc')
        ->get();
        return response()->json([
            'data'=>$data,

        ]);
   }
   public function detail_wo(Request $request)
   {
          $detail = DB::table('work_orders')
                              ->select('work_orders.*', 'users.name as username','master_categories.name as categories_name','master_departements.name as departement_name','problem_types.name as problem_type_name')
                              ->join('users','users.id','=','work_orders.user_id')
                              ->join('master_categories','master_categories.id','=','work_orders.category')
                              ->join('problem_types','problem_types.id','=','work_orders.problem_type')
                              ->join('master_departements','master_departements.id','=','work_orders.departement_id')
                              ->where('work_orders.id',$request->id)
                              ->first();
      
          $data_log = DB::table('work_order_logs')
                              ->select('work_order_logs.*','users.name as username')
                              ->leftJoin('users', 'users.id','=', 'work_order_logs.creator')
                              ->where('work_order_logs.request_code',$detail->request_code)
                              ->orderBy('work_order_logs.id','desc')
                              ->first();
        $pic = WorkOrder::select('users.name as username')->join('users','users.id','work_orders.user_id_support')->where('work_orders.id',$request->id)->first();
        $data = User::where('departement',auth()->user()->departement)
                    ->where('id','!=',auth()->user()->id)
                    ->where('id','!=',$detail->user_id)
                    ->get();
        $priority = MasterPriority::all();
        return response()->json([
            'detail'=>$detail,
            'data_log'=>$data_log,
            'priority'=>$priority,
            'data'=>$data,
            'pic'=>$pic,

        ]);
   }
   public function approve_assignment(Request $request)
   {
          $user_pic = $request->user_pic;
          $approve = $request->approve;
          $priority = $request->priority;
          $status = 500;
          $message="Data failed to save";
          $validator = Validator::make($request->all(),[
               'user_pic'=>'required',
               'priority'=>'required',
           
           ]);
               if($request->approve == 1){
                    if($validator->fails()){
                         return response()->json([
                         'message'=>$validator->errors(), 
                         'status'=>422
                         ]);
                    }else{
                         $log_wo = WorkOrder::find($request->id);
                         $username = User::find($log_wo->user_id_support);
                         if($log_wo->status_wo == 0){
                              $post=[
                                   'user_id_support'=>$user_pic,
                                   'priority'=>$priority,
                                   'status_wo'=>$approve == 1?1:5,
                                   'assignment'=>$approve,
                              ];
                              $post_log = [
                                   'request_code'=>$log_wo->request_code,
                                   'request_type'=>$log_wo->request_type,
                                   'departement_id'=>$log_wo->departement_id,
                                   'problem_type'=>$log_wo->problem_type,
                                   'add_info'=>$log_wo->add_info,
                                   'user_id'=>$log_wo->user_id,
                                   'assignment'=>$approve,
                                   'status_wo'=>$approve == 1?1:5,
                                   'category'=>$log_wo->category,
                                   'follow_up'=>$log_wo->follow_up,
                                   'status_approval'=>$log_wo->status_approval,
                                   'user_id_support'=>$user_pic,
                                   'subject'=>$log_wo->subject,
                                   'comment'=>$request->note,
                                   'priority'=>$request->priority,
                                   'creator'=>auth()->user()->id,
                                   'duration'=>0
                              ];
                              $picName = User::find($user_pic);
                              $userPost =[
                                   'message'=>$picName->name.' has assign work order transaction with request code :'.$log_wo->request_code,
                                   'subject'=>'Assignment WO',
                                   'status'=>0,
                                   'link'=>'work_order_list',
                                   'userId'=>$log_wo->user_id,
                                   'created_at'=>date('Y-m-d H:i:s')
                              ]; 
                              $picPost =[
                                   'message'=>auth()->user()->name.' has assign work order transaction with request code :'.$log_wo->request_code.' to you',
                                   'subject'=>'Assignment WO',
                                   'status'=>0,
                                   'link'=>'work_order_list',
                                   'userId'=>$user_pic,
                                   'created_at'=>date('Y-m-d H:i:s')
                              ];
                              DB::transaction(function() use($post,$request, $post_log,$userPost,$picPost) {
                                   WorkOrder::find($request->id)->update($post);
                                   WorkOrderLog::create($post_log);
                                   WONotification::create($userPost);
                                   WONotification::create($picPost);
                    
                              });
                              $validasi = WorkOrder::where('request_code',$log_wo->request_code)->first();
                              if($validasi->assignment == $approve){
                                   $status = 200;
                                   $message = "Data successfully inserted";
                              }
                         }else{
                              $status = 500;
                              $message="Data telah diassign oleh $username->name, silahkan refresh kembali"; 
                         }
               }
           }else{
               $log_wo = WorkOrder::find($request->id);
               $username = User::find($log_wo->user_id_support);
               if($log_wo->status_wo == 0){
                    $post=[
                         'user_id_support'=>$user_pic,
                         'priority'=>$priority,
                         'status_wo'=>$approve == 1?1:5,
                         'assignment'=>$approve,
                    ];
                    $post_log = [
                         'request_code'=>$log_wo->request_code,
                         'request_type'=>$log_wo->request_type,
                         'departement_id'=>$log_wo->departement_id,
                         'problem_type'=>$log_wo->problem_type,
                         'add_info'=>$log_wo->add_info,
                         'user_id'=>$log_wo->user_id,
                         'assignment'=>$approve,
                         'status_wo'=>$approve == 1?1:5,
                         'category'=>$log_wo->category,
                         'follow_up'=>$log_wo->follow_up,
                         'status_approval'=>$log_wo->status_approval,
                         'user_id_support'=>'',
                         'subject'=>$log_wo->subject,
                         'comment'=>$request->note,
                         'priority'=>$request->priority,
                         'creator'=>auth()->user()->id,
                         'duration'=>0
                    ];
                    $picName = User::find($user_pic);
                    $userPost =[
                         'message'=>auth()->user()->name.' has reject your work order transaction with request code :'.$log_wo->request_code,
                         'subject'=>'Assignment WO',
                         'status'=>0,
                         'link'=>'work_order_list',
                         'userId'=>$log_wo->user_id,
                         'created_at'=>date('Y-m-d H:i:s')
                    ]; 
                   
                    DB::transaction(function() use($post,$request, $post_log,$userPost) {
                         WorkOrder::find($request->id)->update($post);
                         WorkOrderLog::create($post_log);
                         WONotification::create($userPost);
          
                    });
                    $validasi = WorkOrder::where('request_code',$log_wo->request_code)->first();
                    if($validasi->assignment == $approve){
                         $status = 200;
                         $message = "Data successfully inserted";
                    }
               }else{
                    $status = 500;
                    $message="Data telah diassign oleh $username->name, silahkan refresh kembali"; 
               }
     
           }
          return response()->json([
               'status'=>$status,
               'message'=>$message,
   
           ]);
   }
   public function updateLevel(Request $request)
   {
     $status =500;
     $message = "Data failed to update";
     $priority = $request->select_level_priority;
     $request_code = $request->request_code;
          try {
               $pic = WorkOrder::where('request_code',$request_code)->first();
               $postNotif =[
                    'message'=>auth()->user()->name.' has set priority to work order transaction with request code :'.$request_code,
                    'subject'=>'Update Priority',
                    'status'=>0,
                    'link'=>'work_order_list',
                    'userId'=>$pic->user_id_support,
                    'created_at'=>date('Y-m-d H:i:s')
               ];
               $sendNotif = WONotification::create($postNotif);
               if($sendNotif){
                    $update = WorkOrder::where('request_code',$request_code)->update([
                         'priority'=>$priority
                    ]);
               }
               return ResponseFormatter::success(
               $update,
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
}
