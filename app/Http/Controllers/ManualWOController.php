<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\StoreManualWORequest;
use App\Mail\SendMail;
use App\Models\MasterCategory;
use App\Models\MasterJabatan;
use App\Models\ProblemType;
use App\Models\User;
use App\Models\WONotification;
use App\Models\WorkOrder;
use App\Models\WorkOrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use NumConvert;
class ManualWOController extends Controller
{
    public function index(){
        return view('manual_wo.manual_wo-index');
    }
    public function manual_wo(Request $request, StoreManualWORequest $storeManualWORequest){
        // try {
            $storeManualWORequest->validated();
            $request_type = $request->request_type;
            $categories = $request->categories;
            $problem_type = $request->problem_type;
            $subject = $request->subject;
            $add_info = $request->add_info;
            $departement_for = $request->request_for;
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
            $departement_id= User::find($request->username);
            $post =[
                'request_code'=>$ticket_code,
                'request_type'=>$request_type,
                'request_for'=>$departement_for,
                'departement_id'=>$departement_id->departement,
                'problem_type'=>$problem_type,
                'subject'=>strtoupper($subject),
                'add_info'=>$add_info,
                'user_id'=>$request->username,
                'assignment'=>1,
                'status_wo'=>1,
                'category'=>$categories,
                'follow_up'=>0,
                'status_approval'=>0,
                'user_id_support'=>auth()->user()->id,
                'rating'=>0,
                'created_at'=>date('Y-m-d H:i:s')
            ];
            $post_log =[
                'request_code'=>$ticket_code,
                'request_type'=>$request_type,
                'departement_id'=>$departement_id->departement,
                'problem_type'=>$problem_type,
                'subject'=>strtoupper($subject),
                'add_info'=>$add_info,
                'user_id'=>$request->username,
                'assignment'=>0,
                'status_wo'=>0,
                'category'=>$categories,
                'follow_up'=>0,
                'status_approval'=>0,
                'user_id_support'=>auth()->user()->id,
                'created_at'=>date('Y-m-d H:i:s'),
                'creator'=>auth()->user()->id,
                'comment'=>'Create Manual Ticket'
            ];
            $post_log2 =[
                'request_code'=>$ticket_code,
                'request_type'=>$request_type,
                'departement_id'=>$departement_id->departement,
                'problem_type'=>$problem_type,
                'subject'=>strtoupper($subject),
                'add_info'=>$add_info,
                'user_id'=>$request->username,
                'assignment'=>1,
                'status_wo'=>1,
                'category'=>$categories,
                'follow_up'=>0,
                'status_approval'=>0,
                'user_id_support'=>auth()->user()->id,
                'created_at'=>date('Y-m-d H:i:s'),
                'creator'=>auth()->user()->id,
                'comment'=>'Create Manual Ticket'
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
                'user_pic'=> auth()->user()->name,
                'PIC'=>$userName->name

            ];
            $userPost =[
                'message'=>auth()->user()->name.' has create your ticket transaction with request code : '.$ticket_code,
                'subject'=>'Manual Ticket',
                'status'=>0,
                'link'=>'work_order_list',
                'userId'=>$request->username,
                'created_at'=>date('Y-m-d H:i:s')
            ];
            $masterJabatan = MasterJabatan::where('departement_id',auth()->user()->departement)->first();
            $headUser = User::where('jabatan',$masterJabatan->id)->first();
            $headPost =[
                'message'=>auth()->user()->name.' has create manual ticket transaction with request code : '.$ticket_code,
                'subject'=>'Manual Ticket',
                'status'=>0,
                'link'=>'work_order_list',
                'userId'=>$headUser->id,
                'created_at'=>date('Y-m-d H:i:s')
            ];
            DB::transaction(function() use($post,$post_log,$post_log2, $postEmail,$userPost,$headPost,$headUser) {
                WorkOrder::create($post);
                WorkOrderLog::create($post_log);
                WorkOrderLog::create($post_log2);
                WONotification::create($userPost);
                WONotification::create($headPost);
                // $title = "Manual Support Ticket";
                // $subject = 'ON PROGRESS - '.$post['subject'];
                // $to =$headUser->email;
                // $this->sendMail($title,$to,$post,$postEmail,$subject);
            });
            return ResponseFormatter::success(
                $post,
                'WO successfully added, please check your email'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'WO failed to add',
        //         500
        //     );
        // }
    }

    public function sendMail($title,$to,$post,$postEmail,$subject)
    {
        $emails =$to;
        $data=[
            'post'=>$post,
            'postEmail'=>$postEmail,
        ];
        $message = view('email.wo_request',$data);
        $mailData = [
            'title' =>$title,
            'subject'=>$subject,
            'body'=>$message,
            'footer' => 'Email otomatis dari PT.Pralon(ICT Department)'
        ];
        Mail::to($emails)
        ->cc('bagus.slamet@pralon.com')
        ->send(new SendMail($mailData));
    }

}
