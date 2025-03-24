<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\UpdateHHoldProgressRequest;
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
use App\Models\ChatRFM;
use App\Models\MasterJabatan;
use App\Models\MasterKantor;
use App\Models\ProblemType;
use App\Models\User;
use App\Models\WONotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use \Mpdf\Mpdf as PDF;
use Telegram\Bot\Laravel\Facades\Telegram;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WorkOrderController extends Controller
{
    public function index()
    {
        return view('work-order.work_order-index');
    }
    public function get_work_order_list(Request $request)
    {
        $validationChecking = WorkOrder::where('status_wo',4)
                                        ->where('status_approval',2)
                                        ->where('updated_at', '<=', Carbon::now()->subDays(4)->toDateTimeString())
                                        ->get();
       
        if(count($validationChecking) > 0 ){
            foreach($validationChecking as $item){
                $sumofDuration = WorkOrderLog::select(DB::raw('SUM(duration) as sumOfDuration'))->where('request_code', $item->request_code)->first();
                $postValidateion=[
                    'status_approval'   =>1,
                    'updated_at'        =>date('Y-m-d H:i:s'),
                    'rating'            =>5,
                    'duration'          =>$sumofDuration->sumOfDuration
                ];
            
                DB::transaction(function() use($postValidateion,$item) {
                     WorkOrder::where('request_code', $item->request_code)->update($postValidateion);
                  
                        $postCommentChecking =[
                            'request_code'=>$item->request_code,
                            'request_type'=>$item->request_type,
                            'departement_id'=>$item->departement_id,
                            'problem_type'=>$item->problem_type,
                            'subject'=>$item->subject,
                            'add_info'=>$item->add_info,
                            'user_id'=>$item->user_id,
                            'assignment'=>$item->assignment, 
                            'status_wo'=>$item->status_wo,
                            'category'=>$item->category,
                            'follow_up'=>0,
                            'status_approval'=>1,
                            'duration'=>0,
                            'user_id_support'=>$item->user_id_support,
                            'created_at'=>date('Y-m-d H:i:s'),
                            'creator'=>999,
                            'comment'=>'Done by system'
                        ];
                        WorkOrderLog::create($postCommentChecking);
    
                            $postNotif = [
                                'userId'    =>$item->user_id,
                                'status'    =>0,
                                'message'   =>'your work order with request code : '.$item->request_code.' has been closed by system',
                                'link'      =>'work_order_list',
                                'subject'   =>'WO Progress'
    
                            ];
                            $postNotifUser = [
                                'userId'    =>$item->user_id_support,
                                'status'    =>0,
                                'message'   =>'your work order with request code : '.$item->request_code.' has been closed by system',
                                'link'      =>'work_order_list',
                                'subject'   =>'WO Progress'
    
                            ];
                            WONotification::create($postNotif);
                            WONotification::create($postNotifUser);
                });
                
            }
        }
        $statusFilter   = $request->statusFilter;
        $statusApproval = '';
        $holdProgress  = '';
        $transferPIC    = '';

        if($statusFilter == 6){
            $statusFilter    = 4;
            $statusApproval  = 2;
        }else if($statusFilter == 7){
            $holdProgress    = 1;
        }else if($statusFilter == 8){
            $transferPIC     =1;
        }else if($statusFilter ==4){
            $statusApproval  = 1;
            $transferPIC     = 0;
        }
        // dd($request->userIdSupportFilter);
        if(auth()->user()->hasPermissionTo('get-all-work_order_list'))
        {
            $requestFor     = MasterDepartement::find(auth()->user()->departement);
 

            $data = DB::table('work_orders')
            ->select(
                'work_orders.*',
                'users.name as username',
                'master_categories.name as categories_name',
                'master_departements.name as departement_name',
                'master_kantor.name as kantor_name',
                'master_priorities.name as priorityName',
                 DB::raw("(SELECT COUNT(*) FROM chat_rfm 
                  WHERE chat_rfm.request_code = work_orders.request_code 
                  AND chat_rfm.status = 0 
                  AND chat_rfm.user_id != " . auth()->user()->id . ") as unread_chats")
            )
            ->leftJoin('users','users.id','=','work_orders.user_id')
            ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
            ->leftJoin('master_departements','master_departements.id','=','work_orders.departement_id')
            ->leftJoin('master_kantor','master_kantor.id','=','users.kode_kantor')
            ->leftJoin('master_priorities','master_priorities.id','work_orders.priority')
            ->where('work_orders.request_for',$requestFor->initial)
            ->where('master_kantor.id','like','%'.$request->officeFilter.'%')
            ->where('work_orders.user_id_support','like','%'.$request->userIdSupportFilter.'%')
            ->where('work_orders.status_wo','like','%'.$statusFilter.'%')
            ->where('work_orders.status_approval','like','%'.$statusApproval.'%')
            ->where('work_orders.hold_progress','like','%'.$holdProgress.'%')
            ->where('work_orders.transfer_pic','like','%'.$transferPIC.'%')
            ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->from, $request->to])
            ->orderBy('status_wo', 'asc')
            ->orderBy('work_orders.status_approval','desc')
            ->orderBy('work_orders.priority','desc')
            ->orderBy('id','desc')
            ->get();
        }else if(auth()->user()->hasPermissionTo('get-only_user-work_order_list')){
            $data = DB::table('work_orders')
            ->select(
                'work_orders.*',
                'users.name as username',
                'master_categories.name as categories_name',
                'master_departements.name as departement_name',
                'master_kantor.name as kantor_name',
                'master_priorities.name as priorityName',
                 DB::raw("(SELECT COUNT(*) FROM chat_rfm 
                  WHERE chat_rfm.request_code = work_orders.request_code 
                  AND chat_rfm.status = 0 
                  AND chat_rfm.user_id != " . auth()->user()->id . ") as unread_chats")
            )
            ->join('users','users.id','=','work_orders.user_id')
            ->join('master_categories','master_categories.id','=','work_orders.category')
            ->join('master_departements','master_departements.id','=','work_orders.departement_id')
            ->join('master_kantor','master_kantor.id','=','users.kode_kantor')
            ->leftJoin('master_priorities','master_priorities.id','work_orders.priority')
            ->where('master_kantor.id','like','%'.$request->officeFilter.'%')
            ->where('work_orders.transfer_pic',0)
            ->where('work_orders.status_wo','like','%'.$statusFilter.'%')
            ->where('work_orders.status_approval','like','%'.$statusApproval.'%')
            ->where('work_orders.user_id_support','like','%'.$request->userIdSupportFilter.'%')
            ->where('work_orders.hold_progress','like','%'.$holdProgress.'%')
            ->where('work_orders.transfer_pic','like','%'.$transferPIC.'%')
            ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->from, $request->to])
            ->where('user_id', auth()->user()->id) 
            ->orderBy('status_wo', 'asc')
            ->orderBy('work_orders.status_approval','desc')
            ->orderBy('work_orders.priority','desc')
            ->orderBy('id','desc')
            ->get();
        }
        else{
           
            $data = DB::table('work_orders')
            ->select(
                'work_orders.*',
                'users.name as username',
                'master_categories.name as categories_name',
                'master_departements.name as departement_name',
                'master_kantor.name as kantor_name',
                'master_priorities.name as priorityName',
                 DB::raw("(SELECT COUNT(*) FROM chat_rfm 
                  WHERE chat_rfm.request_code = work_orders.request_code 
                  AND chat_rfm.status = 0 
                  AND chat_rfm.user_id != " . auth()->user()->id . ") as unread_chats")
            )
            ->join('users','users.id','=','work_orders.user_id')
            ->join('master_categories','master_categories.id','=','work_orders.category')
            ->join('master_departements','master_departements.id','=','work_orders.departement_id')
            ->join('master_kantor','master_kantor.id','=','users.kode_kantor')
            ->leftJoin('master_priorities','master_priorities.id','work_orders.priority')
            ->where('master_kantor.id','like','%'.$request->officeFilter.'%')
            ->where('work_orders.user_id_support','like','%'.$request->userIdSupportFilter.'%')
            ->where('work_orders.status_wo','like','%'.$statusFilter.'%')
            ->where('work_orders.status_approval','like','%'.$statusApproval.'%')
            ->where('work_orders.hold_progress','like','%'.$holdProgress.'%')
            ->where('work_orders.transfer_pic','like','%'.$transferPIC.'%')
            ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->from, $request->to])
            ->where(function($query){
                $query->where('user_id_support', auth()->user()->id)->orWhere('status_wo', 0); 
            })
            ->orderBy('status_wo', 'asc')
            ->orderBy('work_orders.status_approval','desc')
            ->orderBy('work_orders.priority','desc')
            ->orderBy('id','desc')
            ->get();
        }
       return response()->json([
        'data'=>$data
        ]);
    }
    public function get_categories_name(Request $request){
      
        $data = MasterCategory::with('departement')->where('departement_id','like','%'.$request->departement_id.'%')->where('flg_aktif',1)->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function getDisscuss(Request $request){
        $data = ChatRFM::with(['userRelation'])->where('request_code', $request->request_code)->orderBy('id', 'desc')->get();
        if($data[0]->user_id == auth()->user()->id){
            ChatRFM::where('request_code', $request->request_code)->update(['status' =>  1,'updated_at' => date("Y-m-d H:i:s")]);
        }
        return response()->json([
            'data'=>$data
        ]);
    }
    public function save_wo(Request $request)
    {
        $status =500;
        $message ="Data failed to save";
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
                $fileName ='';
                if($request->file('attachment')){
                    $ticketName = explode("/", $ticket_code);
                    $ticketName2 = implode('',$ticketName);
                    $custom_file_name = 'UA-'.$ticketName2;
                    $originalName = $request->file('attachment')->getClientOriginalExtension();
                    $fileName =$custom_file_name.'.'.$originalName;
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
                    'duration'=>0,
                    'hold_progress'=>0,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'attachment_user'=>$fileName != ''? 'storage/attachmentUser/'.$fileName :null
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
                    'duration'=>0,
                    'hold_progress'=>0,
                    'user_id_support'=>'',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'creator'=>auth()->user()->id,
                    'comment'=>$add_info
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

                // User Request For 
                $departementId = MasterDepartement::where('initial',$departement_for)->first();
                $headDeptLocation = MasterJabatan::where('departement_id',$departementId->id)->first();
                $userDept = User::where('departement',$departementId->id)->get();
                $userArray = [];
                foreach($userDept as $row){
                    $userPost =[
                        'message'=>auth()->user()->name.' has created new work order transaction',
                        'subject'=>'New Work Order',
                        'status'=>0,
                        'link'=>$row->jabatan == $headDeptLocation->id ?'work_order_assignment':'work_order_list',
                        'userId'=>$row->id,
                        'created_at'=>date('Y-m-d H:i:s')
                    ];
                    array_push($userArray, $userPost);
                }
              

                // dd($post);
                DB::transaction(function() use($post,$post_log,$postEmail,$userArray, $request, $fileName,$ticket_code,$categoriesName,$problemType,$add_info,$subject) {
                    WorkOrder::create($post);
                    WorkOrderLog::create($post_log);
                    WONotification::insert($userArray);
                    if($request->file('attachment')){
                        $request->file('attachment')->storeAs('/attachmentUser',$fileName);
                    }
                    // Send To Telegram Chanel
                      // Set Telegram Message
                        $locationName = MasterKantor::find(auth()->user()->kode_kantor);
                        $text = "<b style='text-align:center'>New Work Order Ticket</b>\n\n\n\n"
                        . "RFM: ".$ticket_code."\n"
                        . "Categories   : ".$categoriesName->name."\n"
                        . "Problem Type : ".$problemType->name."\n"
                        . "Subject      : ".strtoupper($subject)."\n"
                        . "Add Info     : ".$add_info."\n"
                        . "PIC          : ".auth()->user()->name."\n"
                        . "Location     : ".$locationName->name."\n\n\n\n"
                        . " ICT DEV";
    
                    // Set Telegram Message
                        Telegram::sendMessage([
                            'chat_id' => env('TELEGRAM_CHANNEL_ID', '-1001800157734'),
                            'parse_mode' => 'HTML',
                            'text' => $text
                        ]);
                    // Send To Telegram Chanel
                    
                });
                $validasi = WorkOrderLog::where('request_code', $ticket_code)->where('status_wo',0)->count();
                if($validasi==1){
                    $status =200;
                    $message="Data successfully inserted";
                }
            // }

           
          
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
        $log_data = WorkOrderLog::select(DB::raw('DATE_FORMAT(work_order_logs.created_at, "%d %b %Y, %H:%i") as date'), 'work_order_logs.*')->with(['userPIC','userPICSupport','priority','creatorRelation'])->where('request_code', $request->request_code)->orderBy('created_at','asc')->get();
        return response()->json([
            'log_data'=>$log_data,
        ]);
    }
    public function approve_assignment_pic(Request $request)
    {
       
           $status_wo = $request->status_wo;
           $status = 500;
           $message="Data failed to save";
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
               $validasi_user           = WorkOrder::find($request->id);
                $postHead =[];
               if($validasi_user->user_id_support == auth()->user()->id){
                    $log_wo             =   WorkOrder::find($request->id);
                    $fileName           ='';
                    if($request->file('attachmentPIC')){
                        $ticketName     = explode("/", $log_wo->request_code);
                        $ticketName2    = implode('',$ticketName);
                        $custom_file_name = 'PA-'.$ticketName2;
                        $originalName   = $request->file('attachmentPIC')->getClientOriginalExtension();
                        $fileName       =$custom_file_name.'.'.$originalName;
                    }
                    $workOrderStatus    =   WorkOrderLog::where('request_code', $log_wo->request_code)
                                            ->orderBy('created_at','desc')
                                            ->first();
                    // Setup Duration
                        $dateBeforePost     =   $workOrderStatus->created_at->format('Y-m-d');
                        $dateNow            =   date('Y-m-d');

                        $client = new \GuzzleHttp\Client();
                        $api = $client->get('https://hris.pralon.co.id/application/API/getAttendance?emp_no='.auth()->user()->nik.'&startdate='.$dateBeforePost.'&enddate='.$dateNow.'');
                        $response = $api->getBody()->getContents();
                        $data =json_decode($response, true);
                        $totalTime =0;
                        $test =[];
                        // dd($workOrderStatus);
                        foreach($data as $row){
                            if($row['daytype'] =='WD'){

                            // Initialing Date && Time
                                $startDateTimePIC           =   date('Y-m-d H:i:s', strtotime($workOrderStatus->created_at));
                                $startDatePIC               =   date('Y-m-d', strtotime($workOrderStatus->created_at));
                                $startTimePIC               =   date('H:i:s', strtotime($workOrderStatus->created_at));
                                $shiftTimePIC               =   Carbon::createFromFormat('Y-m-d H:i:s', $startDateTimePIC);

                                $shiftstartDatetime         =   date('Y-m-d H:i:s', strtotime($row['shiftstarttime']));
                                $shiftstartDate             =   date('Y-m-d', strtotime($row['shiftstarttime']));
                                $shiftstarttime             =   Carbon::createFromFormat('Y-m-d H:i:s', $shiftstartDatetime);

                                $dateTimeSystem             =   date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
                                $timeSystem                 =   date('H:i:s', strtotime($dateTimeSystem));
                                $endTimeSystem              =   Carbon::createFromFormat('Y-m-d H:i:s', $dateTimeSystem);

                                $shiftendDatetime           =   date('Y-m-d H:i:s', strtotime($row['shiftendtime']));
                                $shiftendDate               =   date('Y-m-d', strtotime($row['shiftendtime']));
                                $shiftendTime               =   date('H:i:s', strtotime($row['shiftendtime']));
                                $shiftendtime               =   Carbon::createFromFormat('Y-m-d H:i:s', $shiftendDatetime);
                              
                            // Initialing Date && Time

                            // Validation Date
                                if($startDatePIC == $shiftstartDate)
                                {
                                    if($startTimePIC >=$shiftendTime){
                                        $totalTime += $shiftTimePIC->diffInMinutes($shiftendtime); 
                                        $test_post =[
                                            'duration' =>   $startDatePIC . ' == '.$shiftstartDate.'  ==> '.$totalTime
                                        ];        
                                    }else{
                                        $totalTime += $shiftTimePIC->diffInMinutes($shiftendtime);
                                        $test_post =[
                                            'duration' =>   $startDatePIC . ' == '.$shiftstartDate.'  ==> '.$totalTime.' tahap 1'
                                        ];  
                                    }
                                    array_push($test,$test_post);
                                
                                }else{
                                    if($shiftendDate == $dateNow){
                                        if(strtotime($timeSystem) >= $shiftendTime && $shiftendDate == $dateNow){
                                            $totalTime += $shiftstarttime->diffInMinutes($shiftendtime);
                                            $test_post =[
                                                'duration' =>   $startDatePIC . ' == '.$shiftstartDate.'  ==> '.$totalTime.' tahap 2'
                                            ];  
                                        }else{
                                            $totalTime += $endTimeSystem->diffInMinutes($shiftstarttime);
                                            $test_post =[
                                                'duration' =>   $startDatePIC . ' == '.$shiftstartDate.'  ==> '.$totalTime.' tahap 3'
                                            ];  
                                        
                                        }
                                    }else{
                                        $totalTime += $shiftstarttime->diffInMinutes($shiftendtime) - 60;
                                        $test_post =[
                                            'duration' =>   $startDatePIC . ' == '.$shiftstartDate.'  ==> '.$totalTime.' tahap 4'
                                        ];  
                                    }
                                    array_push($test,$test_post);
                                }
                            // Validation Date
                            }
                        }
                        // dd($test);
                    // Setup Duration
                    // checking if status wo before is pending, cant change level 
                   if($log_wo->level == 2){

                            $post         =[
                                               'status_wo'=>$status_wo,
                                               'status_approval'=>2,
                                               'attachment_pic'=> $fileName != ''? 'storage/attachmentPIC/'.$fileName  : null,
   
                                           ];
                            $post_log           = [
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
                                            'hold_progress'=>$log_wo->hold_progress,
                                            'comment'=>$request->note_pic,
                                            'creator'=>auth()->user()->id,
                                            'duration'=>0
                                        ];
                   }else{
                            if($status_wo == 2){
                                $post    =[
                                            'status_wo'=>$status_wo,
                                            'status_approval'=>2,
                                            'attachment_pic'=> $fileName != ''? 'storage/attachmentPIC/'.$fileName  : null,
                                            'level'=>$status_wo

                                        ];

                            }else{
                                $post               =[
                                    'status_wo'=>$status_wo,
                                    'status_approval'=>2,
                                    'attachment_pic'=> $fileName != ''? 'storage/attachmentPIC/'.$fileName  : null,

                                ];
                            }
                                // Post 
                                    $post_log           = [
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
                                        'hold_progress'=>$log_wo->hold_progress,
                                        'comment'=>$request->note_pic,
                                        'creator'=>auth()->user()->id,
                                        'duration'=>$totalTime
                                    ];

                                // Post 
                   }
               
                   
                    // dd($totalTime);
    
                      // User Request For 
                    $message            = $status_wo == 4 ?'finish ':'pending';
                    $userPost           =[
                                            'message'=>auth()->user()->name.' has '.$message.' your wo transaction with request code : '.$log_wo->request_code,
                                            'subject'=>'WO Progress',
                                            'status'=>0,
                                            'link'=>'work_order_list',
                                            'userId'=>$log_wo->user_id,
                                            'created_at'=>date('Y-m-d H:i:s')
                                        ];
                    if($status_wo == 2){
                        $headPosition = MasterJabatan::where('departement_id',auth()->user()->departement)->first();
                        $headUser = User::where('jabatan', $headPosition->id)->first();
                        $postHead  =[
                            'message'=>auth()->user()->name.' has pending  wo transaction with request code : '.$post_log['request_code'],
                            'subject'=>'WO Progress',
                            'status'=>0,
                            'link'=>'work_order_list',
                            'userId'=>$headUser->id,
                            'created_at'=>date('Y-m-d H:i:s')
                        ];
                       
                    }
                    // dd($post_log);
                     DB::transaction(function() use($post,$request, $post_log,$userPost,$fileName,$status_wo,$postHead) {
                        if($request->file('attachmentPIC')){
                            $request->file('attachmentPIC')->storeAs('/attachmentPIC',$fileName);
                        }
                                WorkOrder::find($request->id)->update($post);
                                WorkOrderLog::create($post_log);
                                WONotification::create($userPost);
                                // Send Notification on Head Depaetement
                                if($status_wo == 2){
                                    WONotification::create($postHead);
                                }
                    });
                    $successValidation= WorkOrder::find($request->id); 
                    if($successValidation->status_wo == $status_wo){
                        $status = 200;
                        $message = "Data successfully inserted";
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
        $message="Data failed to save";
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
            // Validasi jika data sudaj di assign 
            $log_wo = WorkOrder::find($request->id);
            $username = User::find($log_wo->user_id_support);
            if($log_wo->status_wo == 0 ){
                $post=[
                    'status_wo'=>$approve == 1?1:5,
                    'user_id_support'=>auth()->user()->id,
                    'assignment'=>1
               ];
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
                    'creator'=>auth()->user()->id,
                    'duration'=>0
               ];
                // User Request For 
                    $userMessage = $approve == 1 ?auth()->user()->name.' has assign work order transaction with request code :'.$log_wo->request_code: auth()->user()->name.' has reject work order transaction with request code '.$log_wo->request_code;
                    $userPost =[
                        'message'=>$userMessage,
                        'subject'=>'Manual Assign',
                        'status'=>0,
                        'link'=>'work_order_list',
                        'userId'=>$log_wo->user_id,
                        'created_at'=>date('Y-m-d H:i:s')
                    ];
                    $PICPost =[
                        'message'=>$userMessage,
                        'subject'=>'Manual Assign',
                        'status'=>0,
                        'link'=>'work_order_list',
                        'userId'=>$log_wo->user_id,
                        'created_at'=>date('Y-m-d H:i:s')
                    ];

                // penambahan unutk setiap head departement
                $userIdDepartement = MasterJabatan::where('departement_id',auth()->user()->departement)->orderBy('id','asc')->first();
                $userJabatan  = User::where('jabatan',$userIdDepartement->id)->first();
                $PICHead =[
                    'message'=>$userMessage,
                    'subject'=>'Manual Assign',
                    'status'=>0,
                    'link'=>'work_order_list',
                    'userId'=>$userJabatan->id,
                    'created_at'=>date('Y-m-d H:i:s')
                ];
               DB::transaction(function() use($post,$request, $post_log,$userPost,$PICHead) {
                    WorkOrder::find($request->id)->update($post);
                    WorkOrderLog::create($post_log);
                    WONotification::create($userPost);
                    WONotification::create($PICHead);
     
               });
               $validasi = WorkOrderLog::where('request_code',$log_wo->request_code)->count();
               if($validasi == 2){
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
    public function rating_pic(Request $request)
    {
        $status = 500;
        $message="Data failed to save";
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
            $param = $approve == 1?4:3;
            $log_wo = WorkOrder::with('picName','picSupportName')->find($request->id);
            
            $sumofDuration = WorkOrderLog::select(DB::raw('SUM(duration) as sumOfDuration'))->where('request_code', $log_wo->request_code)->first();

              $post=[
                   'status_wo'=>$approve == 1?4:3,
                    'status_approval'=>$approve,
                    'rating'=>$approve == 1 ? $rating: 0,
                    'duration'=> $approve == 1 ? $sumofDuration->sumOfDuration : 0
              ];
            
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
                   'creator'=>auth()->user()->id,
                   'duration'=> 0
              ];
              $postMessage =$approve == 1 ? 'match, enjoy your life :)':"doesn't match, please fix it again";
              $userPost =[
                'message'=> 'WO transaction with request code : '. $log_wo->request_code.' is '.$postMessage,
                'subject'=>'WO Result',
                'status'=>0,
                'link'=>$approve == 1?'dashboard':'work_order_list',
                'userId'=>$log_wo->user_id_support,
                'created_at'=>date('Y-m-d H:i:s')
            ];
            $categoriesName = MasterCategory::find($log_wo->category);
            $userName = User::find($log_wo->user_id);
            $headDepartement = MasterDepartement::where('initial',$log_wo->request_for)->first();
            $problemType = ProblemType::find($log_wo->problem_type);
            $postEmail = [
                'request_code'=>$log_wo->request_code,
                'request_type'=>$log_wo->request_type,
                'problem_type'=>$problemType->name,
                'comment'=>$request->note_pic,
                'categories'=>$categoriesName->name,
                'pic'=> $log_wo->picSupportName->name,
                'request_by'=>$userName->name,
                'headDepartement'=>$headDepartement->name

            ]; 
            if($approve == 2){
                // Validasi, jika revisi udah 3 kali, WO udah jadi Reject. Jika udah mengirim ke dua, maka akan akan mengirim email ke Head Derpartement
                $validasi = WorkOrderLog::where('request_code',$log_wo->request_code)->where('status_wo',3)->count();
                $userName = User::find($log_wo->user_id);
             
                  if($validasi == 1){
                           $title = "Support Ticket";
                           $subject = 'Revision 2 - '.$post_log['request_code'];
                           $to = $userName->email;
                           $data=[
                               'post'=>$post_log,
                               'postEmail'=>$postEmail,
                           ];
                           $message = view('email.revisiWO',$data);
                         
                           $this->sendMail($title,$to,$message,$subject);
                        
                        DB::transaction(function() use($post,$request, $post_log,$approve,$userPost) {
                            WorkOrder::find($request->id)->update($post);
                            WorkOrderLog::create($post_log);
                            WONotification::create($userPost); 
             
                       });
                  }else if($validasi == 2){
                        $post=[
                                'status_wo'=>5,
                                'status_approval'=>$approve,
                                //  'rating'=>$approve == 1 ? $rating: 0
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
                                'status_wo'=>5,
                                'category'=>$log_wo->category,
                                'follow_up'=>$log_wo->follow_up,
                                'status_approval'=>$approve,
                                'user_id_support'=>$log_wo->user_id_support,
                                'subject'=>$log_wo->subject,
                                'comment'=>$request->note_pic_rating,
                                'creator'=>auth()->user()->id,
                                'duration'=> 0
                        ];
                        $title = "Support Ticket";
                        $subject = 'Revision 3 - '.$post_log['request_code'];
                        $to = $userName->email;
                        $data=[
                            'post'=>$post_log,
                            'postEmail'=>$postEmail,
                        ];
                        $message = view('email.revisiWO',$data);
                     
                        $this->sendMail($title,$to,$message,$subject);
                        DB::transaction(function() use($post,$request, $post_log,$approve,$userPost) {
                            WorkOrder::find($request->id)->update($post);
                            WorkOrderLog::create($post_log);
                            WONotification::create($userPost); 
            
                    });
                  }else{
                    DB::transaction(function() use($post,$request, $post_log,$approve,$userPost) {
                        WorkOrder::find($request->id)->update($post);
                        if($approve != 1 ){
                            WorkOrderLog::create($post_log);
                        }
                        WONotification::create($userPost); 
         
                   });
                  }

            }else{
                DB::transaction(function() use($post,$request, $post_log,$approve,$userPost,$log_wo) {
                    WorkOrder::find($request->id)->update($post);
                    WorkOrderLog::create($post_log);
                    WONotification::create($userPost); 
                    });
             
               }
            }
            
         
              $validasi = WorkOrder::where('request_code',$log_wo->request_code)->first();
              if($validasi->status_wo == $param){
                   $status = 200;
                   $message = "Data successfully inserted";
              }
         
        return response()->json([
             'status'=>$status,
             'message'=>$message,
 
         ]);
    }
    public function getStepper(Request $request)
    {
        $createdBy = WorkOrderLog::with(['userPIC'])->where('request_code',$request->request_code)->where('status_wo',0)->get();
        $responded = WorkOrderLog::with(['userPIC'])->where('request_code',$request->request_code)->where('status_wo',1)->orderBy('id','asc')->limit(1)->get();
        $fixed = WorkOrderLog::with(['userPIC'])->where('request_code',$request->request_code)->where('status_wo',4)
        ->where(function($query){
            $query->where('status_approval',0)->orWhere('status_approval', 2); 
        })->orderBy('created_at','desc')->limit(1)->get();
        $closed = WorkOrderLog::with(['userPIC'])->where('request_code',$request->request_code)->where('status_wo',4)->where('status_approval',1)->orderBy('created_at','desc')->limit(1)->get();
        $statusWo = WorkOrder::where('request_code',$request->request_code)->first();
        return response()->json([   
            'createdBy'=>$createdBy,
            'responded'=>$responded,
            'fixed'=>$fixed,
            'closed'=>$closed,
            'statusWo'=>$statusWo,
        ]);
    }
    public function printWO($from,$to,$officeFilter,$statusFilter,$userId)
    {
        try {
                $requestFor  = MasterDepartement::find(auth()->user()->departement);
                $officeString = '';
                if($officeFilter == '*'){
                    $officeString = null;
                }else{
                    $officeString = $officeFilter; 
                }
                $statusString ='';
                if($statusFilter !='*'){
                    $statusString = $statusFilter;
                }
                $userIdString ='';
                if($userId !='*'){
                    $userIdString = $userId;
                }
                // dd($userId);
                if($userId !='*'){
                    $reportWO               = WorkOrder::with('picSupportName')
                                                ->select('work_orders.*', 'users.name as username','master_kantor.name as location_name','finished','master_categories.name as categories_name','master_departements.name as departement_name','work_orders.level')
                                                ->leftJoin('users','users.id','=','work_orders.user_id')
                                                ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
                                                ->leftJoin('master_departements','master_departements.id','=','work_orders.departement_id')
                                                ->leftJoin('master_kantor','master_kantor.id','=','users.kode_kantor')
                                                ->leftJoin('master_priorities','master_priorities.id','work_orders.priority')
                                                ->leftJoin(DB::raw('(select request_code, created_at as finished from work_order_logs where status_wo = 4) as logs'), 'logs.request_code', '=', 'work_orders.request_code')
                                                ->where('user_id_support',$userIdString)
                                                ->where('work_orders.request_for',$requestFor->initial)
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->where('work_orders.status_wo','like','%'.$statusString.'%')
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                ->orderBy('created_at', 'asc')
                                                ->get();
                    $woCounting             = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalWO'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.id as officeId','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'),  [$from, $to])
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->where('work_orders.user_id_support','like','%'.$userIdString.'%')
                                                ->where('user_id_support',$userIdString)
                                                ->first();
                    $woOnProgress           = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalProgress'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 1)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->where('user_id_support',$userIdString)
                                                ->first();
                    $woPending              = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalPending'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 2)
                                                ->where('user_id_support',$userIdString)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                 ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woRevision             = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalRevision'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 3)
                                                ->where('user_id_support',$userIdString)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woReject               = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalReject'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 5)
                                                ->where('user_id_support',$userIdString)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                 ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woOnChecking           = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalChecking'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 4)
                                                ->where('work_orders.status_approval', 2)
                                                ->where('user_id_support',$userIdString)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                 ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woDone                 = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalDone'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 4)
                                                ->where('work_orders.status_approval', 1)
                                                ->where('user_id_support',$userIdString)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woNew                  = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalNew'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 4)
                                                ->where('work_orders.status_approval', 2)
                                                ->where('user_id_support',$userIdString)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();

                    $avgDuration            =  WorkOrder::select(DB::raw('SUM(work_orders.duration) as totalDuration'),'request_code','master_kantor.name as officeName','work_orders.level')
                                                ->leftJoin('users','users.id','=','work_orders.user_id')
                                                ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
                                                ->leftJoin('master_departements','master_departements.id','=','work_orders.departement_id')
                                                ->leftJoin('master_kantor','master_kantor.id','=','users.kode_kantor')
                                                ->leftJoin('master_priorities','master_priorities.id','work_orders.priority')
                                                ->where('work_orders.request_for',$requestFor->initial)
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->where('work_orders.status_wo','like','%'.$statusString.'%')
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                ->where('user_id_support',$userIdString)
                                                ->groupBy('work_orders.level')
                                                ->groupBy('users.kode_kantor')
                                                ->orderBy('work_orders.created_at', 'asc')
                                                ->get();
                }else{
                    $reportWO       = WorkOrder::with('picSupportName')
                                                ->select('work_orders.*', 'users.name as username','master_kantor.name as location_name','master_categories.name as categories_name','master_departements.name as departement_name','work_orders.level')
                                                ->leftJoin('users','users.id','=','work_orders.user_id')
                                                ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
                                                ->leftJoin('master_departements','master_departements.id','=','work_orders.departement_id')
                                                ->leftJoin('master_kantor','master_kantor.id','=','users.kode_kantor')
                                                ->leftJoin('master_priorities','master_priorities.id','work_orders.priority')
                                                ->leftJoin(DB::raw('(select request_code, created_at as finished from work_order_logs where status_wo = 4) as logs'), 'logs.request_code', '=', 'work_orders.request_code')
                                                ->where('work_orders.request_for',$requestFor->initial)
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->where('work_orders.status_wo','like','%'.$statusString.'%')
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                ->orderBy('created_at', 'asc')
                                                ->get();
                    $woCounting     = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalWO'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.id as officeId','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'),  [$from, $to])
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->where('work_orders.status_wo','like','%'.$statusString.'%')
                                                ->first();
                    $woOnProgress    = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalProgress'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 1)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woPending    = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalPending'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 2)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                 ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woRevision    = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalRevision'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 3)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woReject    = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalReject'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 5)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                 ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woOnChecking    = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalChecking'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 4)
                                                ->where('work_orders.status_approval', 2)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                 ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woDone             = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalDone'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 4)
                                                ->where('work_orders.status_approval', 1)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                 ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
                    $woNew    = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalNew'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                ->join('users','users.id','work_orders.user_id')
                                                ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                ->where('work_orders.status_wo', 4)
                                                ->where('work_orders.status_approval', 2)
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                                 ->where('master_kantor.id','like','%'.$officeString.'%')
                                                ->first();
            
                    $avgDuration  =  WorkOrder::select(DB::raw('SUM(work_orders.duration) as totalDuration'),'request_code','master_kantor.name as officeName','work_orders.level')
                                            ->leftJoin('users','users.id','=','work_orders.user_id')
                                            ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
                                            ->leftJoin('master_departements','master_departements.id','=','work_orders.departement_id')
                                            ->leftJoin('master_kantor','master_kantor.id','=','users.kode_kantor')
                                            ->leftJoin('master_priorities','master_priorities.id','work_orders.priority')
                                            ->where('work_orders.request_for',$requestFor->initial)
                                            ->where('master_kantor.id','like','%'.$officeString.'%')
                                            ->where('work_orders.status_wo','like','%'.$statusString.'%')
                                            ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from, $to])
                                            ->groupBy('work_orders.level')
                                            ->groupBy('users.kode_kantor')
                                            ->orderBy('work_orders.created_at', 'asc')
                                            ->get();                      
                   
                }
                // dd($reportWO);
                

            // $countingWODone = 
                            $data=[
                                'reportWO'=>$reportWO,
                                'woCounting'=>$woCounting,
                                'woOnProgress'=>$woOnProgress,
                                'woDone'=>$woDone,
                                'woPending'=>$woPending,
                                'woRevision'=>$woRevision,
                                'woReject'=>$woReject,
                                'woOnChecking'=>$woOnChecking,
                                'woNew'=>$woNew,
                                'from'=>$from,
                                'to'=>$to,
                                'avgDuration'=>$avgDuration,
                            ];
                            $cetak              = view('work-order.reportWorkOrder',$data);
                            $imageLogo          = '<img src="'.public_path('icon.png').'" width="70px" style="float: right;"/>';
                            $header             = '';
                            $header             .= '<table width="100%">
                                                        <tr>
                                                            <td style="padding-left:10px;">
                                                                <span style="font-size: 16px; font-weight: bold;"> PT PRALON</span>
                                                                <br>
                                                                <span style="font-size:9px;">Synergy Building #08-08 Tangerang 15143 - Indonesia +62 21 304 38808</span>
                                                            </td>
                                                            <td style="width:33%"></td>
                                                                <td style="width: 50px; text-align:right;">'.$imageLogo.'
                                                            </td>
                                                        </tr>
                                                        
                                                    </table>
                                                    <hr>';
                            
                            $footer             = '<hr>
                                                    <table width="100%" style="font-size: 10px;">
                                                        <tr>
                                                            <td width="90%" align="left"><b>Disclaimer</b><br>this document is strictly private, confidential and personal to recipients and should not be copied, distributed or reproduced in whole or in part, not passed to any third party.</td>
                                                            <td width="10%" style="text-align: right;"> {PAGENO}</td>
                                                        </tr>
                                                    </table>';
                
                              
                                $mpdf           = new PDF();
                                $mpdf->SetHTMLHeader($header);
                                $mpdf->SetHTMLFooter($footer);
                                $mpdf->AddPage(
                                    'L', // L - landscape, P - portrait 
                                    '',
                                    '',
                                    '',
                                    '',
                                    5, // margin_left
                                    5, // margin right
                                    25, // margin top
                                    20, // margin bottom
                                    5, // margin header
                                    5
                                ); // margin footer
                                $mpdf->WriteHTML($cetak);
                                // Output a PDF file directly to the browser
                                ob_clean();
                                $mpdf->Output('Report Wo'.'('.date('Y-m-d').').pdf', 'I');

            } catch (\Mpdf\MpdfException $e) {
                // Process the exception, log, print etc.
                echo $e->getMessage();
            }
    }
    public function holdProgressRequest(Request $request, UpdateHHoldProgressRequest $updateHHoldProgressRequest)
    {   
        try {
            $updateHHoldProgressRequest->validated();
            $rfm = WorkOrder::find($request->id);
            $workOrderStatus    =   WorkOrderLog::where('request_code', $rfm->request_code)
                                    ->orderBy('created_at','desc')
                                    ->first();
            $timeBeforePost     =   $workOrderStatus->created_at;
            $timeBefore         =   Carbon::createFromFormat('Y-m-d H:i:s', $timeBeforePost);
            $timeNow            =   Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $totalDuration      =   $timeBefore->diffInMinutes($timeNow);
            $masterJabatan      =   MasterJabatan::where('departement_id',auth()->user()->departement)->orderBy('id','asc')->first();
            $userJabatan        =   User::where('jabatan', $masterJabatan->id)->first();
          
            $post=[
                'hold_progress'=>1,
            ];
            $postLog=[
                'request_code'=>$workOrderStatus->request_code,
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
                'comment'=>$request->holdProgressNote,
                'creator'=>auth()->user()->id,
                'duration'=>$totalDuration,
                'hold_progress'=>1,
                'transfer_pic'=>$workOrderStatus->transfer_pic,
                'request_id'=>$workOrderStatus->request_id,
            ];
            $postHead  =[
                'message'=>auth()->user()->name.' has submitted a request to hold wo transaction with request code : '.$workOrderStatus->request_code,
                'subject'=>'Hold Request',
                'status'=>0,
                'link'=>'hold_request',
                'userId'=>$userJabatan->id,
                'created_at'=>date('Y-m-d H:i:s')
            ];
            DB::transaction(function() use($post,$request, $postHead, $postLog, $rfm) {
                $rfm->update($post);
                WorkOrderLog::create($postLog);
                WONotification::create($postHead);

            });
            return ResponseFormatter::success(
                $post,
                'Hold Request successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Hold Request failed to add',
                500
            );
        }
    }
    function reportDetailWO($request_code){
       $requestCode = str_replace("&*.","/",$request_code);
       try 
       {
            $getTicket          = WorkOrder::with(['picSupportName','picName','departementName','categoryName','problemTypeName','detailWORelation','picSupportName.locationRelation.regencyRelation','detailWORelation.creatorRelation'])->where('request_code',$requestCode)->first();
            $mengetahui         = '';
            $data               =[
                'getTicket'=>$getTicket
            ];
            
            $cetak              = view('work-order.WOReport',$data);
            $imageLogo          = '<img src="'.public_path('icon.png').'" width="70px" style="float: right;"/>';
            $header             = '';
            $header             .= '<table width="100%">
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <span style="font-size: 16px; font-weight: bold;"> PT PRALON</span>
                                                <br>
                                                <span style="font-size:8px;">'.$getTicket->picSupportName->locationRelation->address.'</span>
                                            </td>
                                            <td style="width:30%"></td>
                                                <td style="width: 50px; text-align:right;">'.$imageLogo.'
                                            </td>
                                        </tr>
                                        
                                    </table>
                                    <hr>';
            
            $footer             = '<hr>
                                    <table width="100%" style="font-size: 10px;">
                                        <tr>
                                            <td width="90%" align="left"><b>Disclaimer</b><br>this document is strictly private, confidential and personal to recipients and should not be copied, distributed or reproduced in whole or in part, not passed to any third party.</td>
                                            <td width="10%" style="text-align: right;"> {PAGENO}</td>
                                        </tr>
                                    </table>';
            
                        
            $mpdf           = new PDF();
            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);
            $mpdf->AddPage(
                'P', // L - landscape, P - portrait 
                '',
                '',
                '',
                '',
                5, // margin_left
                5, // margin right
                25, // margin top
                20, // margin bottom
                5, // margin header
                5
            ); // margin footer
            $mpdf->WriteHTML($cetak);
            // Output a PDF file directly to the browser
            ob_clean();
            $mpdf->Output('Report Wo'.'('.date('Y-m-d').').pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            // Process the exception, log, print etc.
            echo $e->getMessage();
        }
    }
    function sendDisscuss(Request $request){
        $message ="Failed send message, please contact ICT Dev. Thanks";
        $status =500;
        $post = [
            'request_code'  =>  $request->request_code,
            'comment'       =>  $request->remark_chat,
            'user_id'       => auth()->user()->id
        ];
        $insert = ChatRFM::create($post);
        if($insert){
            $message ="Successfully sending message :)";
            $status =200;
        }
        return response()->json([   
            'message'=>$message,
            'status'=>$status,
        ]);
    }
    function revisiDuration() {
        // $dataAll = WorkOrderLog::all();
        $dataAll = WorkOrderLog::with('userPICSupport')->where('request_code', '5/RFM/ICT/VII/23')->where('status_approval', 0)->where('assignment', 1)->get();
      
        $totalTime = 0; // Initialize total time accumulator
        $updateCount = []; // Initialize a counter for the number of times totalTime is updated
    
        foreach ($dataAll as $row) {
            $lastRow = WorkOrderLog::with('userPICSupport')
                ->where('request_code', $row->request_code)
                ->where('status_wo', '4')
                ->where('status_approval', 0)
                ->first();
            
            // Skip rows with status_wo 0 or already approved ones
            if (($row->status_wo == 0 && $row->assignment == 0) || ($row->status_wo == "4" && $row->status_approval == 1)) {
                continue;
            }
    
            try {
                    $before = WorkOrderLog::with('userPICSupport')->where('request_code', $row->request_code)->where('status_approval', 0)->where('assignment', 1)->where('status_wo', 1)->first();
                    $dateBefore =  Carbon::parse($before->created_at);
                    $datePost = $row->created_at->format('Y-m-d');
                    
                    $startDateTicket = Carbon::parse($row->created_at);
                    $endTicket = Carbon::parse($lastRow->created_at); // Get the end ticket from last row
                    
                    // Check day type from external API
                    $client = new Client();
                    $response = $client->get('https://hris.pralon.co.id/application/API/getAttendance', [
                        'query' => [
                            'emp_no' => optional($row->userPICSupport)->nik,
                            'startdate' => $datePost,
                            'enddate' => $datePost
                        ]
                    ]);
            
                    $data = json_decode($response->getBody()->getContents(), true);
            
                    if ($data[0]['daytype'] == 'WD') {
                        $startTimePIC = Carbon::parse($data[0]['shiftstarttime']);
                        $endTimePIC = Carbon::parse($data[0]['shiftendtime']);
                        if($row->status_wo == 1 ){
                            $totalTime +=0;
                            array_push($updateCount, $totalTime);  
                        }else{
                            if ($endTicket->format('Y-m-d') == $datePost) {
                                if ($endTicket->format('H:i:s') > $endTimePIC->format('H:i:s')) {
                                    $totalTime += $endTicket->diffInMinutes($endTicket); 
                                    $mssage = "$totalTime = $endTicket -- $endTicket  Logic 1";
                                    array_push($updateCount, $mssage);  
                                } else if(($endTicket->format('H:i:s') > $startTimePIC->format('H:i:s') && $endTicket->format('H:i:s') < $endTimePIC->format('H:i:s')) && $endTicket->format('Y-m-d') == $datePost ) {
                                    $totalTime += $dateBefore->diffInMinutes($endTicket); 
                                    $mssage = "$totalTime = $dateBefore -- $endTicket Logic 2";
                                    array_push($updateCount, $mssage);  
                                   
                                }
                            }else{
                                dd('test Logic 2');
                            }
                           
                        }
                    }
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
      
        // Log the total time and the count of updates
        Log::info("Total time: {$totalTime} minutes");
        // Log::info("Total updates to totalTime: {$updateCount} times");
        dd($updateCount);
    
        return $totalTime;
    }
    
    
    

    // function revisiDuration() {
    //     $dataAll = WorkOrderLog::where('request_code', '31/RFM/ICT/VIII/23')->get();
    //     $array = [];
    //     $test = [];
    //     $totalTime = 0;
    //     $test_post = [];
    //     $array_duration =[];
    //     foreach ($dataAll as $row) {
    //         $totalTime = 0;
    //         if ($row->duration > 0) {
    //             $log_before = WorkOrderLog::with(['userPICSupport'])
    //                 ->where('request_code', $row['request_code'])
    //                 ->where('status_approval', 0)
    //                 ->orderBy('id', 'desc')
    //                 ->skip(1)
    //                 ->first();
    //             // dd($log_before);
    //             if ($log_before === null) {
    //                 continue;
    //             }
              
    //             $dateBeforePost = $log_before->created_at->format('Y-m-d');
    //             $startDateTimePIC = date('Y-m-d H:i:s', strtotime($row['created_at']));
    //             $end_date = explode(' ', $startDateTimePIC);

    //             $client = new \GuzzleHttp\Client();
    //             $api = $client->get('https://hris.pralon.co.id/application/API/getAttendance', [
    //                 'query' => [
    //                     'emp_no' => $row->userPICSupport->nik,
    //                     'startdate' => $dateBeforePost,
    //                     'enddate' => $end_date[0]
    //                 ]
    //             ]);

    //             $response = $api->getBody()->getContents();
    //             $data = json_decode($response, true);

    //             $allDuration = []; // Clear the array for each row
               
    //             foreach ($data as $col) {
    //                 if ($col['daytype'] == 'WD') {
    //                     $a1 = Carbon::parse($log_before->created_at);
    //                     $b1 = Carbon::parse($col['shiftstarttime']);
    //                     $c1 = Carbon::parse($row['created_at']);
    //                     $b3 = Carbon::parse($col['shiftendtime']);

    //                     $a = $a1->format('Y-m-d');
    //                     $b = $b1->format('Y-m-d');
    //                     $c = $c1->format('Y-m-d');

    //                     $a2 = $a1->format('H:i:s');
    //                     $b2 = $b1->format('H:i:s');
    //                     $c2 = $c1->format('H:i:s');

    //                     $totalTime = 0;

    //                     if ($a === $c) {
    //                         if ($c2 >= $b2) {
    //                             $totalTime += $a1->diffInMinutes($b3);
    //                             $test_post = [
    //                                 'duration' => "{$a} == {$c}  ==> {$totalTime} tahap 1 ==> {$a1} => {$c2} => {$b1} => {$b3} => {$b2}",
    //                                 'rfm' => $row->request_code,
    //                                 'duration_all' => $totalTime,
    //                                 'user_id' => $row['user_id_support']
    //                             ];
    //                            //array_push($all_duration,$totalTime); //
    //                         } else {
    //                             $totalTime += $a1->diffInMinutes($c1);
    //                             $test_post = [
    //                                 'duration' => "{$a} == {$c}  ==> {$totalTime} tahap 2 ==> {$a2} => {$c2} => {$b1} => {$b3}",
    //                                 'rfm' => $row->request_code,
    //                                 'duration_all' => $totalTime,
    //                                 'user_id' => $row['user_id_support']
    //                             ];
    //                            //array_push($all_duration,$totalTime); // Push duration to allDuration
    //                         }
    //                         // array_push($test,$test_post);
    //                     } elseif ($a != $c) {
    //                         if ($b !== $c) {
    //                             if ($a2 >= $b2) {
    //                                 $totalTime += $a1->diffInMinutes($b3);
    //                             } elseif ($a === $b) {
    //                                 $totalTime += $a1->diffInMinutes($b3);
    //                             }
    //                            //array_push($all_duration,$totalTime); // Push duration to allDuration
    //                             $test_post = [
    //                                 'duration' => "{$a} == {$c}  ==> {$totalTime} tahap 3 ==> {$a2} => {$c2} => {$b1}",
    //                                 'rfm' => $row->request_code,
    //                                 'duration_all' => $totalTime,
    //                                 'user_id' => $row['user_id_support']
    //                             ];
                                
    //                         } elseif ($b === $c) {
    //                             $totalTime += $b1->diffInMinutes($c1);
    //                            //array_push($all_duration,$totalTime); // Push duration to allDuration
    //                             $test_post = [
    //                                 'duration' => "{$a} == {$c}  ==> {$totalTime} tahap 4 ==> {$a2} => {$c2} => {$b1}",
    //                                 'rfm' => $row->request_code,
    //                                 'duration_all' => $totalTime,
    //                                 'user_id' => $row['user_id_support']
    //                             ];
    //                         }
    //                     }
                      

    //                     $test[] = $test_post;
    //                 }
    //             }
    //             $postUpdate =[
    //                 'duration'  => $totalTime,
    //                 'rfm'       => $row->request_code
    //             ];
    //             array_push($array_duration,$postUpdate);
    //         }
    //         array_push($test,$test_post);
    //     }
    //     dd($test);
    // }
}
