<?php

namespace App\Http\Controllers;

use App\Models\MasterCategory;
use App\Models\MasterDepartement;
use App\Models\WorkOrder;
use App\Models\WorkOrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use NumConvert;
use App\Mail\SendMail;
use App\Models\ProblemType;
use App\Models\User;

class WorkOrderController extends Controller
{
    public function index()
    {
        return view('work-order.work_order-index');
    }
    public function get_work_order_list(Request $request)
    {
        if(auth()->user()->hasPermissionTo('get-all-work_order_list'))
        {
            $data = DB::table('work_orders')
            ->select('work_orders.*', 'users.name as username','master_categories.name as categories_name','master_departements.name as departement_name','master_kantor.name as kantor_name')
            ->join('users','users.id','=','work_orders.user_id')
            ->join('master_categories','master_categories.id','=','work_orders.category')
            ->join('master_departements','master_departements.id','=','work_orders.departement_id')
            ->join('master_kantor','master_kantor.id','=','users.kode_kantor')
            ->where('master_kantor.id','like','%'.$request->officeFilter.'%')
            ->where('work_orders.status_wo','like','%'.$request->statusFilter.'%')
            ->orderBy('status_wo', 'asc')
            ->get();
        }else{
            $data = DB::table('work_orders')
            ->select('work_orders.*', 'users.name as username','master_categories.name as categories_name','master_departements.name as departement_name','master_kantor.name as kantor_name')
            ->join('users','users.id','=','work_orders.user_id')
            ->join('master_categories','master_categories.id','=','work_orders.category')
            ->join('master_departements','master_departements.id','=','work_orders.departement_id')
            ->join('master_kantor','master_kantor.id','=','users.kode_kantor')
            ->where('master_kantor.id','like','%'.$request->officeFilter.'%')
            ->where('work_orders.status_wo','like','%'.$request->statusFilter.'%')
            ->where(function($query){
                $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id)->orWhere('status_wo', 0); 
            })
            ->orderBy('status_wo', 'asc')
            ->get();
        }
       return response()->json([
        'data'=>$data
        ]);
    }
    public function get_categories_name(Request $request){
      
        $data = MasterCategory::with('departement')->where('departement_id',$request->departement_id)->where('flg_aktif',1)->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function save_wo(Request $request)
    {
        $status =500;
        $message ="Data gagal disimpan";
        $request_type = $request->request_type;
        $categories = $request->categories;
        $problem_type = $request->problem_type;
        $subject = $request->subject;
        $add_info = $request->add_info;
        $departement_for = $request->departement_for;
        $validator = Validator::make($request->all(),[
            'request_type'=>'required',
            'categories'=>'required',
            'problem_type'=>'required',
            'subject'=>'required',
            'add_info'=>'required',
            'departement_for'=>'required',
        ],[
            'request_type.required'=>'Tipe request tidak boleh kosong',
            'categories.required'=>'Kategori tidak boleh kosong',
            'problem_type.required'=>'Tipe problem tidak boleh kosong',
            'subject.required'=>'Subject tidak boleh kosong',
            'add_info.required'=>'Keterangan tidak boleh kosong',
            'departement_for.required'=>'Departement tidak boleh kosong',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $increment_code= WorkOrder::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $ticket_code = '1/'.$request_type.'/'.$departement_for.'/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->request_code,-1);
                if($month_convert != $month_before[3]){
                    $ticket_code = '1/'.$request_type.'/'.$departement_for.'/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/'.$request_type.'/'.$departement_for.'/'.$month_convert.'/'.$year;
                }   
            }
            $post =[
                'request_code'=>$ticket_code,
                'request_type'=>$request_type,
                'request_for'=>$departement_for,
                'departement_id'=>auth()->user()->departement,
                'problem_type'=>$problem_type,
                'subject'=>strtoupper($subject),
                'add_info'=>$add_info,
                'user_id'=>auth()->user()->id,
                'assignment'=>0,
                'status_wo'=>0,
                'category'=>$categories,
                'follow_up'=>0,
                'status_approval'=>0,
                'user_id_support'=>'',
                'rating'=>0,
                'created_at'=>date('Y-m-d H:i:s')
            ];
            $post_log =[
                'request_code'=>$ticket_code,
                'request_type'=>$request_type,
                'departement_id'=>auth()->user()->departement,
                'problem_type'=>$problem_type,
                'subject'=>strtoupper($subject),
                'add_info'=>$add_info,
                'user_id'=>auth()->user()->id,
                'assignment'=>0,
                'status_wo'=>0,
                'category'=>$categories,
                'follow_up'=>0,
                'status_approval'=>0,
                'user_id_support'=>'',
                'created_at'=>date('Y-m-d H:i:s'),
                'creator'=>auth()->user()->id,
                'comment'=>''
            ];
            $problemType = ProblemType::find($problem_type);
            $categoriesName = MasterCategory::find($categories);
            $userName = User::find($request->username);
            
            $postEmail = [
                'request_code'=>$ticket_code,
                'request_type'=>$request_type,
                'problem_type'=>$problemType->name,
                'comment'=>$post_log['comment'],
                'categories'=>$categoriesName->name,
                'PIC'=> auth()->user()->name,

            ];
            DB::transaction(function() use($post,$post_log,$postEmail) {
                $insert = WorkOrder::create($post);
                if($insert){
                    WorkOrderLog::create($post_log);
                }
                $title = "Support Ticket";
                $subject = 'NEW - '.$post['subject'];
                $to ="kutukan3@gmail.com";
                $data=[
                    'post'=>$post,
                    'postEmail'=>$postEmail,
                ];
                $message = view('email.newWo',$data);
                $this->sendMail($title,$to,$message,$subject);
            });
            $validasi = WorkOrderLog::where('request_code', $ticket_code)->where('status_wo',0)->count();
            if($validasi==1){
                $status =200;
                $message="Data berhasil disimpan";
            }
           
          
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,

        ]);
    }
    public function sendMail($title,$to,$message,$subject)
    {
        $emails =$to;
    
        $mailData = [
            'title' =>$title,
            'subject'=>$subject,
            'body'=>$message,
            'footer' => 'Email otomatis dari PT.Pralon(ICT Division)'
        ];
        Mail::to($emails)
        ->cc('bagus.slamet@pralon.com')
        ->send(new SendMail($mailData));
    }
    public function get_wo_log(Request $request)
    {
        // $log_data = DB::table('work_order_logs')
        //                 ->leftJoin('users','users.id','=','work_order_logs.user_id_support')
                       
        //                 ->select('work_order_logs.*','users.name as username')
        //                 ->where('work_order_logs.request_code', $request->request_code)->orderBy('work_order_logs.created_at', 'asc')
        //                 ->get();
        $log_data = WorkOrderLog::with(['userPIC','userPICSupport'])->where('request_code', $request->request_code)->orderBy('created_at','asc')->get();
        return response()->json([
            'log_data'=>$log_data,
        ]);
    }
    public function approve_assignment_pic(Request $request)
    {
           $status_wo = $request->status_wo;
           $status = 500;
           $message="Data gagal disimpan";
           $validator = Validator::make($request->all(),[
                'status_wo'=>'required',
                'note_pic'=>'required',
            
            ],[
                'status_wo.required'=>'Progress tidak boleh kosong',
                'note_pic.required'=>'Note tidak boleh kosong',
              
            ]);
            if($validator->fails()){
                return response()->json([
                    'message'=>$validator->errors(), 
                    'status'=>422
                ]);
            }else{
               $validasi_user = WorkOrder::find($request->id);
               if($validasi_user->user_id_support == auth()->user()->id){
                        $post=[
                            'status_wo'=>$status_wo,
                    ];
                    $log_wo = WorkOrder::find($request->id);
                    $post_log = [
                            'request_code'=>$log_wo->request_code,
                            'request_type'=>$log_wo->request_type,
                            'departement_id'=>$log_wo->departement_id,
                            'problem_type'=>$log_wo->problem_type,
                            'add_info'=>$log_wo->add_info,
                            'user_id'=>$log_wo->user_id,
                            'assignment'=>$log_wo->assignment,
                            'status_wo'=>$status_wo,
                            'category'=>$log_wo->category,
                            'follow_up'=>$log_wo->follow_up,
                            'status_approval'=>$log_wo->status_approval,
                            'user_id_support'=>$log_wo->user_id_support,
                            'subject'=>$log_wo->subject,
                            'comment'=>$request->note,
                            'creator'=>auth()->user()->id
                    ];
                
                   $insert = DB::transaction(function() use($post,$request, $post_log) {
                            WorkOrder::find($request->id)->update($post);
                           WorkOrderLog::create($post_log);
                         
                    });
                    $successValidation= WorkOrder::find($request->id); 
                    if($successValidation->status_wo == $status_wo){
                        $status = 200;
                        $message = "Data berhasil disimpan";
                }
                  
              
               }else{
                $message ="Anda bukan PIC pada transaksi ini";
               }
            }
           return response()->json([
                'status'=>$status,
                'message'=>$message,
    
            ]);
    }
    public function manual_approve(Request $request)
    {
        $status = 500;
        $message="Data gagal disimpan";
        $approve = $request->approve;
        $validator = Validator::make($request->all(),[
             'note'=>'required',
         
         ],[
             'note.required'=>'Note tidak boleh kosong',
           
         ]);
         if($validator->fails()){
             return response()->json([
                 'message'=>$validator->errors(), 
                 'status'=>422
             ]);
         }else{
              $post=[
                   'status_wo'=>$approve == 1?1:5,
                   'user_id_support'=>auth()->user()->id,
                   'assignment'=>1
              ];
              $log_wo = WorkOrder::find($request->id);
              $post_log = [
                   'request_code'=>$log_wo->request_code,
                   'request_type'=>$log_wo->request_type,
                   'departement_id'=>$log_wo->departement_id,
                   'problem_type'=>$log_wo->problem_type,
                   'add_info'=>$log_wo->add_info,
                   'user_id'=>$log_wo->user_id,
                   'assignment'=>1,
                   'status_wo'=>$approve == 1?1:5,
                   'category'=>$log_wo->category,
                   'follow_up'=>$log_wo->follow_up,
                   'status_approval'=>$log_wo->status_approval,
                   'user_id_support'=>auth()->user()->id,
                   'subject'=>$log_wo->subject,
                   'comment'=>$request->note,
                   'creator'=>auth()->user()->id
              ];
       
              DB::transaction(function() use($post,$request, $post_log) {
                   WorkOrder::find($request->id)->update($post);
                   WorkOrderLog::create($post_log);
    
              });
              $validasi = WorkOrderLog::where('request_code',$log_wo->request_code)->count();
              if($validasi == 2){
                   $status = 200;
                   $message = "Data berhasil disimpan";
              }
         }
        return response()->json([
             'status'=>$status,
             'message'=>$message,
 
         ]);
    }
    public function rating_pic(Request $request)
    {
        $status = 500;
        $message="Data gagal disimpan";
        $approve = $request->approve;
        $rating = $request->rating;
        $validator = Validator::make($request->all(),[
             'note_pic_rating'=>'required',
         
         ],[
             'note_pic_rating.required'=>'Note tidak boleh kosong',
           
         ]);
         if($validator->fails()){
             return response()->json([
                 'message'=>$validator->errors(), 
                 'status'=>422
             ]);
         }else{
              $post=[
                   'status_wo'=>$approve == 1?4:3,
                    'status_approval'=>$approve,
                    'rating'=>$approve == 1 ? $rating: 0
              ];
            
              $log_wo = WorkOrder::find($request->id);
              $post_log = [
                   'request_code'=>$log_wo->request_code,
                   'request_type'=>$log_wo->request_type,
                   'departement_id'=>$log_wo->departement_id,
                   'problem_type'=>$log_wo->problem_type,
                   'add_info'=>$log_wo->add_info,
                   'user_id'=>$log_wo->user_id,
                   'assignment'=>$log_wo->assignment,
                   'status_wo'=>$approve == 1?4:3,
                   'category'=>$log_wo->category,
                   'follow_up'=>$log_wo->follow_up,
                   'status_approval'=>$approve,
                   'user_id_support'=>$log_wo->user_id_support,
                   'subject'=>$log_wo->subject,
                   'comment'=>$request->note_pic_rating,
                   'creator'=>auth()->user()->id
              ];
            
              DB::transaction(function() use($post,$request, $post_log,$approve) {
                   WorkOrder::find($request->id)->update($post);
                   if($approve != 1 ){
                       WorkOrderLog::create($post_log);
                   }
    
              });
              $validasi = WorkOrderLog::where('request_code',$log_wo->request_code)->where('status_wo',3)->count();
              if($validasi == 1){
                   $status = 200;
                   $message = "Data berhasil disimpan";
              }
         }
        return response()->json([
             'status'=>$status,
             'message'=>$message,
 
         ]);
    }

}
