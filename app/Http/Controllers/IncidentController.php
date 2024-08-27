<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\StoreIncidentRequest;
use App\Http\Requests\UpdateIncidentRequest;
use App\Models\IncidentHeader;
use App\Models\IncidentLog;
use App\Models\MasterCategory;
use App\Models\MasterDepartement;
use App\Models\ProblemType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumConvert;

class IncidentController extends Controller
{
    function index() {
        return view('incident_log.incident_log-index');
    }
    function getIncident() {

        $data = IncidentHeader::with([
            'problemRelation',
            'categoriesRelation',
            'locationRelation',
        ])->orderBy('created_at', 'desc')->orderBy('status','asc')->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getCategoryIncident() {
        $data = MasterCategory::where(
            [
                'type'=>2,
                'flg_aktif'=>1,
            ] )->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getIncidentProblem(Request $request) {
        $data = ProblemType::where([
            'flg_aktif' => 1,
            'type' => 2
        ])->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function addIncident(Request $request, StoreIncidentRequest $storeIncidentRequest) {
        // try {
            $storeIncidentRequest->validated();
            $increment_code     = IncidentHeader::orderBy('id','desc')->first();
            $date_month         = strtotime(date('Y-m-d'));
            $month              = idate('m', $date_month);
            $year               = idate('y', $date_month);
            $month_convert      = NumConvert::roman($month);
            $departement_for    = MasterDepartement::find(auth()->user()->departement);
            if($increment_code ==null){
                $ticket_code = '1/INC/'.$departement_for->initial.'/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->incident_code,-1);
                if($month_convert != $month_before[3]){
                    $ticket_code = '1/INC/'.$departement_for->initial.'/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/'.'INC/'.$departement_for->initial.'/'.$month_convert.'/'.$year;
                }   
            }
            $fileName ='';
            if($request->file('attachment_start')){
                $ticketName = explode("/", $ticket_code);
                $ticketName2 = implode('',$ticketName);
                $custom_file_name = 'START-'.$ticketName2;
                $originalName = $request->file('attachment_start')->getClientOriginalExtension();
                $fileName =$custom_file_name.'.'.$originalName;
            }
            $post=[
                'incident_code'=>$ticket_code,
                'incident_category'=>$request->categories_id,
                'incident_problem'=>$request->problem_id,
                'user_id'=>auth()->user()->id,
                'status'=>1,
                'subject'=>$request->title_incident,
                'description'=>$request->description_incident,
                'start_date'=>$request->start_date_incident,
                'end_date'=>'',
                'kode_kantor'=>$request->location_id,
                'duration'=>0,
            ];
            $postLog=[
                'incident_code'=>$ticket_code,
                'comment'=>$request->description_incident,
                'user_id'=>auth()->user()->id,
                'attachment'=>$fileName != ''? 'storage/attachmentIncident/'.$fileName :'',
                'status'=>1
            ];
            DB::transaction(function() use($post,$postLog,$request,$fileName) {
                IncidentHeader::create($post);
                IncidentLog::create($postLog);
                if($request->file('attachment_start')){
                    $request->file('attachment_start')->storeAs('/attachmentIncident',$fileName);
                }
            });
            return ResponseFormatter::success(
                $post,
                'Incident successfully added'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Incident failed to add',
        //         500
        //     );
        // }
    }
    function getIncidentDetail(Request $request) {
        $detail = IncidentHeader::with([
            'problemRelation',
            'categoriesRelation',
            'locationRelation',
            'UserRelation',
        ])->where('incident_code',$request->incident_code)->first();
        $data =IncidentLog::with(['headerRelation','userRelation'])->where('incident_code',$request->incident_code)->get();
        return response()->json([
            'data'=>$data,
            'detail'=>$detail,
        ]);
    }
    function updateIncident(Request $request, UpdateIncidentRequest $updateIncidentRequest){
        // try {
            $updateIncidentRequest->validated();
            $dataOld = IncidentHeader::where('incident_code',$request->id)->first();
            $fileName ='';
            if($request->file('attachment_end')){
                $ticketName = explode("/", $dataOld->incident_code);
                $ticketName2 = implode('',$ticketName);
                $custom_file_name = 'END-'.$ticketName2;
                $originalName = $request->file('attachment_end')->getClientOriginalExtension();
                $fileName =$custom_file_name.'.'.$originalName;
            }
              // Setup Duration
                    $dateBeforePost     =   Carbon::parse($dataOld->start_time)->format('Y-m-d');
                    $dateNow            =   date('Y-m-d');

                    $client = new \GuzzleHttp\Client();
                    $api = $client->get('https://hris.pralon.co.id/application/API/getAttendance?emp_no='.auth()->user()->nik.'&startdate='.$dateBeforePost.'&enddate='.$dateNow.'');
                    $response = $api->getBody()->getContents();
                    $data =json_decode($response, true);
                    $totalTime =0;

                    // foreach($data as $row){
                    //     if($row['daytype'] =='WD'){

                    //     // Initialing Date && Time
                    //         $startDateTimePIC           =   date('Y-m-d H:i:s', strtotime($dataOld->start_time));
                    //         $startDatePIC               =   date('Y-m-d', strtotime($dataOld->start_time));
                    //         $startTimePIC               =   date('H:i:s', strtotime($dataOld->start_time));
                    //         $shiftTimePIC               =   Carbon::createFromFormat('Y-m-d H:i:s', $startDateTimePIC);

                    //         $shiftstartDatetime         =   date('Y-m-d H:i:s', strtotime($row['shiftstarttime']));
                    //         $shiftstartDate             =   date('Y-m-d', strtotime($row['shiftstarttime']));
                    //         $shiftstarttime             =   Carbon::createFromFormat('Y-m-d H:i:s', $shiftstartDatetime);

                    //         $dateTimeSystem             =   date('Y-m-d H:i:s', strtotime($request->end_date_incident_edit));
                    //         $timeSystem                 =   date('H:i:s', strtotime($dateTimeSystem));
                    //         $endTimeSystem              =   Carbon::createFromFormat('Y-m-d H:i:s', $dateTimeSystem);

                    //         $shiftendDatetime           =   date('Y-m-d H:i:s', strtotime($row['shiftendtime']));
                    //         $shiftendDate               =   date('Y-m-d', strtotime($row['shiftendtime']));
                    //         $shiftendTime               =   date('H:i:s', strtotime($row['shiftendtime']));
                    //         $shiftendtime               =   Carbon::createFromFormat('Y-m-d H:i:s', $shiftendDatetime);
                    //     // Initialing Date && Time

                    //     // Validation Date
                    //         if($startDatePIC == $shiftstartDate)
                    //         {
                    //             if($startTimePIC >=$shiftendTime){
                    //                 $totalTime += $shiftTimePIC->diffInMinutes($shiftendtime);         
                    //             }else{
                    //                 $totalTime += $shiftTimePIC->diffInMinutes($endTimeSystem);
                    //                 // dd($startTimePIC . ' == '.$shiftendTime.'  ==> '.$totalTime);
                    //             }
                            
                    //         }else{
                    //             if($shiftendDate == $dateNow){
                                   
                    //                 if(strtotime($timeSystem) >= $shiftendTime && $shiftendDate == $dateNow){
                    //                     dd('test 1');
                    //                     $totalTime += $shiftstarttime->diffInMinutes($shiftendtime);
                    //                 }else{
                    //                     $totalTime += $endTimeSystem->diffInMinutes($shiftstarttime);
                    //                     dd($endTimeSystem.'-'.$shiftstarttime.'='.$totalTime);
                                    
                    //                 }
                    //             }else{
                                  
                    //                 $totalTime += $shiftstarttime->diffInMinutes($shiftendtime);
                    //             }
                    //         }
                    //     // Validation Date
                    //     }
                    // }
                    // dd($totalTime);
             // Setup Duration
            $post=[
                'end_date'=>$request->end_date_incident_edit,
                'status'=>2,
                'duration'=>0,
            ];
            $postLog=[
                'incident_code'=>$request->id,
                'comment'=>$request->comment_incident_edit,
                'user_id'=>auth()->user()->id,
                'attachment'=>$fileName != ''? 'storage/attachmentIncident/'.$fileName :'',
                'status'=>1
            ];
            DB::transaction(function() use($post,$postLog,$request,$fileName) {
                IncidentHeader::where('incident_code',$request->id)->update($post);
                IncidentLog::create($postLog);
                if($request->file('attachment_end')){
                    $request->file('attachment_end')->storeAs('/attachmentIncident',$fileName);
                }
            });
            return ResponseFormatter::success(
                $post,
                'Incident successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Incident failed to update',
        //         500
        //     );
        // }
    }
}
