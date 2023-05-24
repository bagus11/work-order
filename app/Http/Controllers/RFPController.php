<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\StoreRFPTransactionRequest;
use App\Http\Requests\UpdateProgressRFPSubDetail;
use App\Http\Requests\UpdateProgressRFPSubDetailRequest;
use App\Http\Requests\UpdateRFPDetailRequest;
use App\Http\Requests\UpdateRFPMasterRequest;
use App\Http\Requests\UpdateRFPSubDetailRequest;
use App\Models\DailyActivity;
use App\Models\DetailTeam;
use App\Models\MasterDepartement;
use App\Models\MasterJabatan;
use App\Models\RFPDetail;
use App\Models\RFPSubDetail;
use App\Models\RFPTransaction;
use App\Models\User;
use App\Models\WONotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumConvert;
class RFPController extends Controller
{
    public function index()
    {
        return view('rfpTransaction.rfpTransaction-index');
    }
    public function getrfpTransaction()
    {
        $data ='';
        if(auth()->user()->hasPermissionTo('get-all-rfp_transaction')){
            $data = RFPTransaction::with(['location','departementRelation'])->get();
        }else{
            $data = RFPTransaction::with(['location','departementRelation'])->get();
        }
        return response()->json([
            'data'=>$data
        ]);
    }
    public function saveRFPTransaction(Request $request, StoreRFPTransactionRequest $storeRFPTransactionRequest)
    {
        try {
                $storeRFPTransactionRequest->validated();
                $requestType = 'RFP';
                $departementId = MasterDepartement::where('initial',$request->departement)->first();
                $increment_code= RFPTransaction::orderBy('id','desc')->first();
                $date_month =strtotime(date('Y-m-d'));
                $month =idate('m', $date_month);
                $year = idate('y', $date_month);
                $month_convert =  NumConvert::roman($month);
                if($increment_code ==null){
                    $ticket_code = '1/'.$requestType.'/'.$request->departement.'/'.$month_convert.'/'.$year;
                }else{
                    $month_before = explode('/',$increment_code->request_code,-1);
                   
                    if($month_convert != $month_before[3]){
                        $ticket_code = '1/'.$requestType.'/'.$request->departement.'/'.$month_convert.'/'.$year;
                    }else{
                        $ticket_code = $month_before[0] + 1 .'/'.$requestType.'/'.$request->departement.'/'.$month_convert.'/'.$year;
                    }   
                }
                $fileName ='';
                if($request->file('attachmentRFP')){
                    $ticketName = explode("/", $ticket_code);
                    $ticketName2 = implode('',$ticketName);
                    $custom_file_name = 'RFPMaster-'.$ticketName2;
                    $originalName = $request->file('attachmentRFP')->getClientOriginalExtension();
                    $fileName =$custom_file_name.'.'.$originalName;
                }
                $post =[
                    'request_code'=>$ticket_code,
                    'departement'=>$departementId->id,
                    'description'=>$request->description,
                    'title'=>$request->title,
                    'teamId'=>$request->team,
                    'office'=>auth()->user()->kode_kantor,
                    'user_id'=>auth()->user()->id,
                    'status'=>0,
                    'priority'=>0,
                    'attachment'=>$fileName != ''? 'storage/attachmentRFPMaster/'.$fileName :null,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'start_date'=>$request->startDate,
                    'dateline'=>$request->dateline,
                    'category'=>$request->categories,

            ];
            $teamProject = DetailTeam::where('masterId', $request->team)->get();
            $arrayNotification = [];
            foreach($teamProject as $row){
                $postNotification =[
                        'message'=>auth()->user()->name.' has created new request for project',
                        'subject'=>'New Request For Project',
                        'status'=>0,
                        'link'=>'rfp_transaction',
                        'userId'=>$row->userId,
                        'created_at'=>date('Y-m-d H:i:s')
                ];
                array_push($arrayNotification, $postNotification);
            }
            DB::transaction(function() use($post,$arrayNotification,$request,$fileName) {
                RFPTransaction::create($post);
                WONotification::insert($arrayNotification);
                if($request->file('attachmentRFP')){
                    $request->file('attachmentRFP')->storeAs('public/attachmentRFPMaster',$fileName);
                }
            });
            return ResponseFormatter::success(
                $post,
                'Request For Project successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Request For Project failed to add',
                500
            );
        }
    }
    public function getrfpTransactionDetail(Request $request)
    {
        $detail = RFPTransaction ::with(['location','departementRelation','userRelation','categoryRelation'])->find($request->id);
        $module = RFPDetail::with('userRelation')->where('request_code', $request->request_code)->get();
        return response()->json([
            'detail'=>$detail,
            'module'=>$module,
        ]);
    }
    public function getRFPDetail(Request $request)
    {
        $data = RFPDetail ::with(['userRelation','rfpRelation','rfpRelation.userRelation'])->where('request_code',$request->request_code)->get();
        return response()->json([
            'data'=>$data
        ]); 
    }
    public function saveRFPDetail(Request $request)
    {
        $message ='Data fail to add';
        $status =500;
        $array =[];
     
        foreach($request->array as $row){
           
                
                $increment_code= RFPDetail::orderBy('id','desc')->first();
                $date_month =strtotime(date('Y-m-d'));
                $month =idate('m', $date_month);
                $year = idate('y', $date_month);
                $month_convert =  NumConvert::roman($month);
               
                $requestCodeExplode = explode('/',$row[0]);
               
                if($increment_code ==null){
                    $ticket_code = '1/'.$requestCodeExplode[0].$requestCodeExplode[3].$requestCodeExplode[4].'/'.$month_convert.'/'.$year;
                }else{
                    $month_before = explode('/',$increment_code->detail_code,-1);
                   
                    if($month_convert != $month_before[2]){
                       
                        $ticket_code = '1/'.$requestCodeExplode[0].$requestCodeExplode[3].$requestCodeExplode[4].'/'.$month_convert.'/'.$year;
                    }else{
                        $ticket_code = $month_before[0] + 1 .'/'.$requestCodeExplode[0].$requestCodeExplode[3].$requestCodeExplode[4].'/'.$month_convert.'/'.$year;
                    }   
                }
                $post =[
                    'request_code'  =>$row[0],
                    'user_id'       =>auth()->user()->id,
                    'title'         =>$row[1],
                    'start_date'    =>$row[4],
                    'dateline'      =>$row[3],
                    'description'   =>$row[2],
                    'detail_code'   =>$ticket_code,
                    'status'        =>0
                ];
            
                RFPDetail::create($post); 
                $message    =   "Data successfully inserted";
                $status     =   200;
        }
     
     
        return response()->json([
            'message'=>$message,
            'status'=>$status,
        ]);
    }
    public function saveRFPSubDetail(Request $request)
    {
        $message ='Data fail to add';
        $status =500;
        foreach($request->array as $row){
                $requestType = 'RFPSD';
                $increment_code= RFPSubDetail::orderBy('id','desc')->first();
                $date_month =strtotime(date('Y-m-d'));
                $month =idate('m', $date_month);
                $year = idate('y', $date_month);
                $month_convert =  NumConvert::roman($month);
              
                $requestCodeExplode = explode('/',$row[0]);
             
                if($increment_code ==null){
                    $ticket_code = '1'.'/'.$requestCodeExplode[0].$requestCodeExplode[2].$requestCodeExplode[3].'/'.$month_convert.'/'.$year;
                }else{
                    $month_before = explode('/',$increment_code->subdetail_code,-1);
                    if($month_convert != $month_before[2]){
                        $ticket_code = '1'.'/'.$requestCodeExplode[0].$requestCodeExplode[2].$requestCodeExplode[3].'/'.$month_convert.'/'.$year;
                    }else{
                        $ticket_code = $month_before[0] + 1 .'/'.$requestCodeExplode[0].$requestCodeExplode[2].$requestCodeExplode[3].'/'.$month_convert.'/'.$year;
                    }   
                }
              
                $post =[
                    'detail_code'   =>$row[0],
                    'request_code'  =>$row[6],
                    'user_id'       =>$row[4],
                    'title'         =>$row[1],
                    'dateline'      =>$row[3],
                    'start_date'    =>$row[5],
                    'description'   =>$row[2],
                    'subdetail_code'=>$ticket_code,
                    'status'        =>0
                ];
                DB::transaction(function() use($post,$request,$row) {
                $insert = RFPSubDetail::create($post);
                if($insert){
                    $statusDone     = RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('detail_code',$row[0])->where('status',1)->first();
                    $statusAll      = RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('detail_code',$row[0])->first();
                    $percentage     = ($statusDone->percentage / $statusAll->percentage) * 100;
                    RFPDetail::where('detail_code', $row[0])->update(['percentage'=>$percentage]);

                    $statusRFPDone  = RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('request_code',$row[6])->where('status',1)->first();
                    $statusRFPAll   = RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('request_code',$row[6])->first();
                    $percentageTransaction     = ($statusRFPDone->percentage / $statusRFPAll->percentage) * 100;
                    RFPTransaction::where('request_code', $row[6])->update(['progress'=>$percentageTransaction]);
                }
            });
                $message ="Data successfully inserted";
                $status =200;
        }
        return response()->json([
            'message'=>$message,
            'status'=>$status,
        ]);
    }
    public function editRFPDetail(Request $request)
    {
        $data       = RFPDetail ::with(['userRelation','rfpRelation'])->find($request->id);
        $user       = RFPTransaction::select('users.name','users.id')
                                ->join('master_teams','master_teams.id','=','rfp_transaction.teamId')
                                ->join('detail_teams','detail_teams.masterId','=','master_teams.id')
                                ->join('users','users.id','=','detail_teams.userId')
                                ->where('rfp_transaction.request_code',$request->request_code)
                                ->get();
                               
        $module     = RFPSubDetail ::with(['userRelation'])->where('detail_code', $request->detail)->get(); 
                               
        return response()->json([
            'user'=>$user,
            'data'=>$data,
            'module'=>$module,
        ]); 
    }
    public function getRFPSubDetail(Request $request)
    {
        $data = RFPSubDetail::with(['userRelation', 'rfpDetailRelation'])->where('detail_code',$request->detail_code)->orderBy('start_date','asc')->get();                             
        return response()->json([
            'data'=>$data,
        ]); 
    }
    public function getLogSubDetailRFP(Request $request)
    {
        $data = DailyActivity::with('userRelation')->where('activityCode',$request->subdetail_code)->get();                             
        return response()->json([
            'data'=>$data,
        ]);  
    }
    public function updateRFPDetail(Request $request, UpdateRFPDetailRequest $updateRFPDetailRequest)
    {
        try {
            $updateRFPDetailRequest->validated();
            $post=[
                'title'=>$request->titleEdit,
                'description'=>$request->descriptionEdit,
                // 'start_date'=>$request->startDateEdit,
                'dateline'=>$request->datelineEdit,
            ];
            RFPDetail::find($request->id)->update($post);
            return ResponseFormatter::success(
                $post,
                'Request For Project successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Request For Project failed to add',
                500
            );
        }
    }
    public function updateMasterRFP(Request $request, UpdateRFPMasterRequest $updateRFPMasterRequest)
    {
        try {
            $updateRFPMasterRequest->validated();
            $post=[
                'title'=>$request->titleMasterEdit,
                'description'=>$request->descriptionMasterEdit,
                // 'start_date'=>$request->startDateMasterEdit,
                'dateline'=>$request->datelineMasterEdit,
            ];
            RFPTransaction::find($request->id)->update($post);
            return ResponseFormatter::success(
                $post,
                'Request For Project successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Request For Project failed to add',
                500
            );
        }
    }
    public function getSubDetailRFP(Request $request)
    {
        $data = RFPSubDetail::with('userRelation')->find($request->id);                             
        return response()->json([
            'data'=>$data,
        ]); 
    }
    public function updateRFPSubDetail(Request $request, UpdateRFPSubDetailRequest $updateRFPDetailRequest)
    {
        try {
            $updateRFPDetailRequest->validated();
            $post=[
                'title'=>$request->titleSubDetailEdit,
                'description'=>$request->descriptionSubDetailEdit,
                // 'start_date'=>$request->startDateSubDetailEdit,
                'dateline'=>$request->datelineSubDetailEdit,
            ];
          
            RFPSubDetail::find($request->id)->update($post);
            return ResponseFormatter::success(
                $post,
                'Request For Project successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Request For Project failed to add',
                500
            );
        }
    }
    public function updateRFPSubDetailProgress(Request $request, UpdateProgressRFPSubDetailRequest $UpdateProgressRFPSubDetailRequest)
    {
        try {
            $UpdateProgressRFPSubDetailRequest->validated();
            $post =[
                'description'=>$request->addInfoUpdate,
                'status'=>$request->progressUpdate,
                'userId'=>auth()->user()->id,
                'activityCode'=>$request->id
            ];
            if($request->progressUpdate == 1 ){
                $postUpdate = [
                    'finish_date'=>date('Y-m-d') > $request->startDateSubDetailUpdate ? date('Y-m-d') : $request->startDateSubDetailUpdate,
                    'status'=>$request->progressUpdate
                ];
            }else{
                $postUpdate = [
                    'status'=>$request->progressUpdate
                ];   
            }
              
            $update =RFPSubDetail::where('subdetail_code',$request->id)->update($postUpdate);
            
            if($update){
                DailyActivity::create($post);
                $statusDone     =   RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('detail_code',$request->detail_code)->where('status',1)->first();
                $statusAll      =   RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('detail_code',$request->detail_code)->first();
                $percentage     =   ($statusDone->percentage / $statusAll->percentage) * 100;
                $statusRFPDone  =   RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('request_code',$request->request_code)->where('status',1)->first();
                $statusRFPAll   =   RFPSubDetail::select(DB::raw('count(id) as percentage'))->where('request_code',$request->request_code)->first();
                $percentageRFP  =   ($statusRFPDone->percentage / $statusRFPAll->percentage) * 100 ; 
                if($percentage == 100 ){
                    if($percentageRFP == 100){
                       RFPTransaction::where('request_code',$request->request_code)->update([
                        'progress'=>$percentageRFP,
                        'status'=>1
                       ]);
                    }
                    RFPDetail::where('detail_code', $request->detail_code)->update([
                        'percentage'=>$percentage,
                        'status'=> 1
                    ]);
                }else{
                    RFPDetail::where('detail_code', $request->detail_code)->update(['percentage'=>$percentage]);
                    RFPTransaction::where('request_code',$request->request_code)->update([
                        'progress'=>$percentageRFP
                    ]);
                }
            }
            return ResponseFormatter::success(
                $post,
                'Request For Project successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Request For Project failed to add',
                500
            );
        }
    }
}

