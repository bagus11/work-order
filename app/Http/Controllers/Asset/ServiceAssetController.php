<?php

namespace App\Http\Controllers\Asset;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreServiveRequest;
use App\Http\Requests\Asset\UpdateServiceRequest;
use App\Models\Asset\ServiceLog;
use App\Models\Asset\ServiceModel;
use App\Models\MasterAsset;
use App\Models\WorkOrder;
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
                ->addColumn('duration', function ($row) {
                    if ($row->status == 1 && $row->start_time) {
                        return null; // biar dihitung real-time di frontend
                    }
    
                    if ($row->start_time && $row->end_time) {
                        $diff = Carbon::parse($row->start_time)->diff(Carbon::parse($row->end_time));
                        return sprintf('%02d:%02d:%02d', $diff->h, $diff->i, $diff->s);
                    }
    
                    return '-';
                })
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
            'start_time'        => now(),
        ];
        ServiceModel::where('service_code', $request->service_code)->update($post);
        ServiceLog::create($post_log);
        return ResponseFormatter::success(   
            $post,                              
            'Service successfully started'
        );            
    }

    function updateService(Request $request, UpdateServiceRequest $update_service_request) {
        try{
            $update_service_request->validated();
            $header = ServiceModel::where('service_code', $request->service_code)->first();
            $status = $header->status;
            $post =[];
            $message = '';
            switch($request->update_service_progress_id){
                case 1:
                    $post = [
                        'status'            => $status,
                    ];
                    $message = 'Service successfully updated';
                    break;
                case 2:
                    $post = [
                        'status'            => $status,
                    ];
                    break;
                case 3:
                    $post = [
                        'status'            => $status + 1 ,
                        'end_date'          => now(),
                    ];
                    break;
            }
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
                'duration'          => 0,
                'department_id'     => $header->department_id,
                'attachment'        => $fileName != '' ? 'storage/Asset/Service/AttachmentLog/'.$fileName : '',
            ];
            $asset = MasterAsset::where('asset_code', $header->asset_code)->first();
            $post_asset_log =[
                'asset_code'    => $asset->asset_code,
                'category'      => $asset->category,
                'brand'         => $asset->brand,
                'type'          => $asset->type,
                'parent_code'   => $asset->parent_code,
                'remark'        => $request->update_service_description,
                'user_id'       => auth()->user()->nik,
                'nik'           => $asset->nik,
                'created_at'    => date('Y-m-d H:i:s'),
                'is_active'     => $request->is_active,
            ];
            
            
        }catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Service failed to update',
                500
            );
        }
    }

}
