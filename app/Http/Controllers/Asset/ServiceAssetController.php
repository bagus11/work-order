<?php

namespace App\Http\Controllers\Asset;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreServiveRequest;
use App\Models\Asset\ServiceLog;
use App\Models\Asset\ServiceModel;
use App\Models\MasterAsset;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumConvert;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class ServiceAssetController extends Controller
{
    function index() {
        return view('asset.transaction.service.service-index');
    }
    function getService(Request $request)
    {
        $query = ServiceModel::with([
            'locationRelation',
            'departmentRelation',
            'userRelation',
            'assetRelation',
            'assetRelation.userRelation',
            'historyRelation',
            'historyRelation.userRelation',
        ]);
    
        if (!auth()->user()->hasPermissionTo('get-all-service_asset')) {
            $query->where('user_id', auth()->id());
        }
        if ($request->ajax()) {
            return DataTables::of($query->get())
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-sm btn-warning edit" data-id="' . $row->id . '">
                    <i class="fas fa-edit"></i>
                    </button>';
                    $printBtn = '<button class="btn btn-sm btn-success print" data-id="' . $row->id . '">
                    <i class="fas fa-file"></i>
                    </button>';
                    $return =
                    ' '
                    .$printBtn ;
                    return $return;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->json([
            'data' => $query->get(),
        ]);
    }
    
    function getRequestCode() {
        $query = WorkOrder::where('status_wo',2);
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
            $month_before = explode('/',$increment_code->request_code,-1);
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
            'department_id'        => $request->department_id,
            'status'            => 0,
            'user_id'           => auth()->user()->id,
            'duration'          => 0,
            'attachment'        =>'storage/Asset/Service/attachment'. $fileName,
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
            'attachment'        => 'storage/Asset/Service/AttachmentLog'.$fileName,
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
}
