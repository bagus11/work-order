<?php

namespace App\Http\Controllers\Asset;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreServiveRequest;
use App\Http\Requests\Asset\UpdateServiceRequest;
use App\Models\Asset\ServiceLog;
use App\Models\Asset\ServiceModel;
use App\Models\MasterAsset;
use App\Models\MasterAssetLog;
use App\Models\WorkOrder;
use App\Models\WorkOrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumConvert;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ServiceAssetController extends Controller
{
    function index() {
        return view('asset.transaction.service.service-index');
    }
    public function getService(Request $request)
    {
        $query = ServiceModel::with([
            'locationRelation',
            'departmentRelation',
            'userRelation',
            'assetRelation',
            'assetRelation.userRelation',
            'historyRelation',
            'historyRelation.userRelation',
            'ticketRelation',
            'ticketRelation.picName',
            'ticketRelation.categoryName',
            'ticketRelation.problemTypeName',
        ]);
    
        if (!auth()->user()->hasPermissionTo('get-all-service_asset')) {
            $query->where('user_id', auth()->id());
        }
    
        if ($request->ajax()) {
            return DataTables::of($query->get())
                // ->addColumn('duration', function ($row) {
                //     if ($row->status == 1 && $row->start_time) {
                //         return null; // biar dihitung real-time di frontend
                //     }
    
                //     if ($row->start_time && $row->end_time) {
                //         $diff = Carbon::parse($row->start_time)->diff(Carbon::parse($row->end_time));
                //         return sprintf('%02d:%02d:%02d', $diff->h, $diff->i, $diff->s);
                //     }
    
                //     return '-';
                // })
                ->addColumn('start_time', function ($row) {
                    return $row->start_time ? Carbon::parse($row->start_time)->toIso8601String() : null;
                })
                ->rawColumns(['action']) // Kalau pakai kolom action tombol, tambahkan di sini
                ->make(true);
        }
    
        return response()->json(['data' => $query->get()]);
    }
    
    function getRequestCode() {
        $query = WorkOrder::where('status_wo',1);
        if (!auth()->user()->hasPermissionTo('get-all-service_asset')) {
            $query->where('user_id_support', auth()->user()->id);
        }
        return response()->json([
            'data' => $query->get(),
        ]);
    }
    function detailRequestCode(Request $request) {
        $query = WorkOrder::with([
            'picName',
            'picName.locationRelation',
            'categoryName',
            'problemTypeName',
            'picSupportName',
        ])->where('request_code', $request->request_code)->first();
        $data = MasterAsset::where('nik', $query->picName->nik)->get(); 
        return response()->json([
            'detail' => $query,
            'data'   => $data,
        ]);
        
    }
    function addService(Request $request, StoreServiveRequest $serviceRequest)
    {
       //   try {
        $serviceRequest->validated();
        $increment_code= ServiceModel::orderBy('id','desc')->first();
        $date_month =strtotime(date('Y-m-d'));
        $month =idate('m', $date_month);
        $year = idate('y', $date_month);
        $month_convert =  NumConvert::roman($month);
        if($increment_code ==null){
            $ticket_code = '1/'.'SVC'.'/'.$month_convert.'/'.$year;
        }else{
            $month_before = explode('/',$increment_code->service_code,-1);
            if($month_convert != $month_before[2]){
                $ticket_code = '1/'.'SVC'.'/'.$month_convert.'/'.$year;
            }else{
                $ticket_code = $month_before[0] + 1 .'/'.'SVC'.'/'.$month_convert.'/'.$year;
            }   
        }
        $fileName ='';
        if($request->file('attachment')){
            $ticketName = explode("/", $ticket_code);
            $ticketName2 = implode('',$ticketName);
            $custom_file_name = 'SVC'.'-'.$ticketName2;
            $originalName = $request->file('attachment')->getClientOriginalExtension();
            $fileName =$custom_file_name.'.'.$originalName;
        } 
        $post = [
            'service_code'      => $ticket_code,
            'location_id'       => $request->location_id,
            'request_code'      => $request->request_code_id,
            'subject'           => $request->subject,
            'description'       => $request->description,
            'asset_code'        => $request->asset_code,
            'department_id'     => $request->department_id,
            'status'            => 0,
            'user_id'           => auth()->user()->id,
            'duration'          => 0,
            'attachment'        =>'storage/Asset/Service/attachment/'. $fileName,
        ];

        $post_log =[
            'service_code'      => $ticket_code,
            'location_id'       => $request->location_id,
            'request_code'      => $request->request_code_id,
            'subject'           => $request->subject,
            'description'       => $request->description,
            'asset_code'        => $request->asset_code,
            'status'            => 0,
            'user_id'           => auth()->user()->id,
            'duration'          => 0,
            'department_id'     => $request->department_id,
            'attachment'        => 'storage/Asset/Service/AttachmentLog/'.$fileName,
        ];
    
       DB::transaction(function() use($post,$request,$fileName, $post_log) {
            ServiceModel::create($post);
            ServiceLog::create($post_log);
            if($request->file('attachment')){
                $request->file('attachment')->storeAs('Asset/Service/attachment',$fileName);
                $request->file('attachment')->storeAs('Asset/Service/AttachmentLog',$fileName);
            }            
        });
       
        return ResponseFormatter::success(   
            $post,                              
            'Asset successfully updated'
        );            
    //   } catch (\Throwable $th) {
    //       return ResponseFormatter::error(
    //           $th,
    //           'Asset failed to add',
    //           500
    //       );
    //   }
    }

    function startService(Request $request)
    {
        $service = ServiceModel::where('service_code', $request->service_code)->first();
        $post = [
            'status'            => 1,
            'start_date'        => now(),
        ];
        $post_log = [
            'service_code'      => $service->service_code,
            'location_id'       => $service->location_id,
            'request_code'      => $service->request_code,
            'subject'           => $service->subject,
            'description'       => auth()->user()->name .' has started the service',
            'asset_code'        => $service->asset_code,
            'status'            => 1,
            'user_id'           => auth()->user()->id,
            'duration'          => 0,
            'department_id'     => $service->department_id,
            'attachment'        => '',
        ];
          DB::transaction(function() use($post,$request, $post_log) {
              ServiceModel::where('service_code', $request->service_code)->update($post);
              ServiceLog::create($post_log);
          });
        return ResponseFormatter::success(   
            $post,                              
            'Service successfully started'
        );            
    }

    function updateService(Request $request, UpdateServiceRequest $update_service_request) {
        // try{
            $update_service_request->validated();
            $header = ServiceModel::where('service_code', $request->service_code)->first();
            $workOrder = WorkOrderLog::where('request_code', $header->request_code)->orderBy('created_at','desc')->first();
            $status = $header->status;
            $post =[];
            $post_request = [];
            $dateBeforePost     =   $workOrder->created_at->format('Y-m-d');
            $dateNow            =   date('Y-m-d');
            // Counting Duration
                if ($request->update_service_progress_id !== 1) {
                    $client = new \GuzzleHttp\Client();
                    $api = $client->get('https://hris.pralon.co.id/application/API/getAttendance?emp_no=' . auth()->user()->nik . '&startdate=' . $dateBeforePost . '&enddate=' . $dateNow);
                    $response = $api->getBody()->getContents();
                    $data = json_decode($response, true);
    
                    $durations = [];
                    $finalDuration = 0; 
                    foreach ($data as $row) {
                        if ($row['daytype'] == 'WD') {
                            $start = \Carbon\Carbon::parse($row['shiftstarttime']);
                            $end = \Carbon\Carbon::parse($row['shiftendtime']);
                             $startToday = \Carbon\Carbon::parse($workOrder->created_at);
                            $validation = '';
                            if($end->isToday()){
                                if( $workOrder->created_at->format('Y-m-d') == date('Y-m-d')){
                                        $minutes = $startToday->diffInMinutes(\Carbon\Carbon::now()); 
                                        $validation = '1';
                                    }else{
                                        $minutes = $start->diffInMinutes(\Carbon\Carbon::now()); 
                                        $validation = '1 1';

                                    }
                                }else{
                                    if($start < $startToday){
                                        $minutes = $startToday->diffInMinutes($end); 
                                        $validation = '2 1';
                                    }else{
                                        $validation = '2';
                                        $minutes = $start->diffInMinutes($end);
                                    }
                                }
                            $finalDuration += $minutes;
                                $durations[] = [
                                    'date' => $row['date'] ?? $start->toDateString(),
                                    'start' => $start->format('H:i'),
                                    'end' => $end->format('H:i'),
                                    'minutes' => $minutes,
                                    'total' => $finalDuration,
                                    'validation'=> $validation
                                ];
                                
                        }
                    }
                    $service = ServiceLog::where('service_code', $request->service_code)->orderBy('id', 'desc')->first();
                        $api_1 = $client->get('https://hris.pralon.co.id/application/API/getAttendance?emp_no=' . auth()->user()->nik . '&startdate=' . $service->created_at->format('Y-m-d') . '&enddate=' . $dateNow);
                        $response_1 = $api_1->getBody()->getContents();
                        $data_1 = json_decode($response_1, true);
        
                        $durations_1 = [];
                        $finalDuration_1 = 0; 
                        foreach ($data_1 as $row) {
                        
                            if ($row['daytype'] == 'WD') {
                                $start = \Carbon\Carbon::parse($row['shiftstarttime']);
                                $end = \Carbon\Carbon::parse($row['shiftendtime']);
                                $startToday = \Carbon\Carbon::parse($service->created_at);
                                $validation = '';
                                if($end->isToday()){
                                    if( $service->created_at->format('Y-m-d') == date('Y-m-d')){
                                        $minutes = $startToday->diffInMinutes(\Carbon\Carbon::now()); 
                                        $validation = '1';
                                    }else{
                                        $minutes = $start->diffInMinutes(\Carbon\Carbon::now()); 
                                        // dd($start->format('H:i'), now()->format('H:i'), $minutes);
                                        $validation = '1 1';

                                    }
                                }else{
                                    if($start < $startToday){
                                        $minutes = $startToday->diffInMinutes($end); 
                                        $validation = '2 1';
                                    }else{
                                        $validation = '2';
                                        $minutes = $start->diffInMinutes($end);
                                    }
                                }
                                $finalDuration_1 += $minutes;
                                    $durations_1[] = [
                                        'date' => $row['date'] ?? $start->toDateString(),
                                        'start' => $start->format('H:i'),
                                        'end' => $end->format('H:i'),
                                        'minutes' => $minutes,
                                        'total' => $finalDuration_1,
                                        'start_time'=>  $service->created_at->format('H:i:s'),
                                        'start_time 2'=>  $startToday->format('H:i:s'),
                                        'validation' => $validation,
                                    ];
                                    
                            }
                        }
                    
                }
            // Counting Duration

          
            
              $fileName ='';
            if($request->file('update_service_attachment')){
                $ticketName = explode("/", $request->service_code);
                $ticketName2 = implode('',$ticketName);
                $custom_file_name = 'SVC'.'-'.$ticketName2.date('YmdHis');
                $originalName = $request->file('update_service_attachment')->getClientOriginalExtension();
                $fileName =$custom_file_name.'.'.$originalName;
            } 
            $post_asset =[
                'condition'       => $request->update_service_condition_id
            ];
            $post_log = [
                'service_code'      => $header->service_code,
                'location_id'       => $header->location_id,
                'request_code'      => $header->request_code,
                'subject'           => $header->subject,
                'description'       => $request->update_service_description,
                'asset_code'        => $header->asset_code,
                'status'            => $request->update_service_progress_id,
                'user_id'           => auth()->user()->id,
                'duration'          => $workOrder->level == 2 ? 0 : $finalDuration_1,
                'department_id'     => $header->department_id,
                'attachment'        => $fileName != '' ? 'storage/Asset/Service/AttachmentLog/'.$fileName : '',
            ];
            $asset = MasterAsset::where('asset_code', $header->asset_code)->first();
            $post_asset_log =[
                'asset_code'        => $asset->asset_code,
                'category'          => $asset->category,
                'brand'             => $asset->brand,
                'type'              => $asset->type,
                'parent_code'       => $asset->parent_code,
                'remark'            => $request->update_service_description,
                'user_id'           => auth()->user()->nik,
                'nik'               => $asset->nik,
                'join_date'         => $asset->join_date,
                'created_at'        => date('Y-m-d H:i:s'),
                'is_active'         => $asset->is_active,
            ];      
           
             $post_log_request = [
                'request_code'      =>$workOrder->request_code,
                'request_type'      =>$workOrder->request_type,
                'departement_id'    =>$workOrder->departement_id,  
                'problem_type'      =>$workOrder->problem_type,
                'add_info'          =>$workOrder->add_info,
                'user_id'           =>$workOrder->user_id,
                'assignment'        =>$workOrder->assignment,
                'status_wo'         =>$request->update_service_progress_id == 3 ?  4 : $request->update_service_progress_id,
                'category'          =>$workOrder->category,
                'follow_up'         =>$workOrder->follow_up,
                'status_approval'   =>$workOrder->status_approval,
                'user_id_support'   =>$workOrder->user_id_support,
                'subject'           =>$workOrder->subject,
                'hold_progress'     =>$workOrder->hold_progress,
                'comment'           =>$request->update_service_description,
                'creator'           =>auth()->user()->id,
                'duration'          =>$workOrder->level == 2 ? 0 : $finalDuration  ,
            ];
            // dd($durations_1);
                DB::transaction(function() use($post,$request, $post_log, $post_asset_log, $post_asset, $fileName, $header,$post_log_request, $workOrder) {
                    ServiceLog::create($post_log);
                      switch($request->update_service_progress_id){
                        case 1:
                            $post = [
                                'status'            => $request->update_service_progress_id,
                            ];
                            break;
                        case 2:
                            $post = [
                                'status'            => $request->update_service_progress_id,
                            ];
                            break;
                        case 3:
                        $totalDuration = ServiceLog::where('service_code', $request->service_code)->sum('duration');
                            $post = [
                                'status'            => $request->update_service_progress_id,
                                'end_date'          => now(),
                                'duration'          => $totalDuration,
                            ];
                            break;
                    }
                    ServiceModel::where('service_code', $header->service_code)->update($post);
                    
                    MasterAsset::where('asset_code', $request->asset_code)->update($post_asset);
                    MasterAssetLog::create($post_asset_log);
                    $post_request= [];
                    if($request->update_service_progress_id == 2){
                        $post_request    =[
                                    'status_wo'=>$request->update_service_progress_id,
                                    'status_approval'=>2,
                                    'attachment_pic'=> $fileName != ''? 'Asset/Service/AttachmentLog'.$fileName  : null,
                                    'level'=>$request->update_service_progress_id
                            ];

                    }else if($request->update_service_progress_id == 3){
                        $post_request =[
                            'status_wo'=> 4,
                            'status_approval'=>2,
                            'attachment_pic'=> $fileName != ''? 'storage/attachmentPIC/'.$fileName  : null,
                        ];
                    }
                    if($request->update_servicde_progress_id !== 1 && $workOrder->status_wo !== 4){
                        WorkOrderLog::create($post_log_request);
                        WorkOrder::where('request_code', $header->request_code)->update($post_request);
                    }
                    if($request->file('update_service_attachment')){
                        $request->file('update_service_attachment')->storeAs('Asset/Service/AttachmentLog',$fileName);
                    }
                });
                return ResponseFormatter::success(   
                    $finalDuration,                              
                    'Service asset successfully updated'
                );
            
        // }catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Service failed to update',
        //         500
        //     );
        // }
    }

}
