<?php

namespace App\Http\Controllers\Asset;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\ApprovalProgressRequest;
use App\Http\Requests\Asset\StoreDistributionRequest;
use App\Models\Asset\ApprovalDetail;
use App\Models\Asset\ApprovalHeader;
use App\Models\Asset\DistributionDetail;
use App\Models\Asset\DistributionHeader;
use App\Models\Asset\DistributionLog;
use App\Models\MasterAsset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use NumConvert;

class DistributionAssetController extends Controller
{
    function index() {
        return view('asset.transaction.distribution.distribution-index');
    }

    function getDistributionTicket(Request $request) {
        $data = DistributionHeader::with([
           'userRelation',
           'receiverRelation',
           'locationRelation',
           'desLocationRelation',
           'detailRelation'
        ])->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-sm btn-info edit" data-id="' . $row->id . '">
                    <i class="fas fa-eye"></i>
                    </button>';
                    $printBtn = '<button class="btn btn-sm btn-success print" data-id="' . $row->id . '">
                    <i class="fas fa-file"></i>
                    </button>';
                    $return =
                    ' '
                    .$editBtn ;
                    return $return;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getInactiveAsset(Request $request) {
        $data = MasterAsset::with([
            'userRelation',
            'userRelation.Departement',
            'userRelation.locationRelation',
            'historyRelation',
            'historyRelation.creatorRelation',
            'historyRelation.userRelation',
            'historyRelation.userRelation.Departement',
            'historyRelation.userRelation.locationRelation',
            'specRelation'
        ])->where('location_id', $request->location_id)->where('is_active', 0)->get();
        if ($request->ajax()) {
            return DataTables::of($data)
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
            'data'=>$data,
        ]);
    }

    function getAssetUser(Request $request) {
        $nik = User::find($request->id);
        $data = MasterAsset::with([
            'userRelation',
            'userRelation.Departement',
            'userRelation.locationRelation',
            'historyRelation',
            'historyRelation.creatorRelation',
            'historyRelation.userRelation',
            'historyRelation.userRelation.Departement',
            'historyRelation.userRelation.locationRelation',
            'specRelation'
        ])->where('nik', $nik->nik)->get();
        if ($request->ajax()) {
            return DataTables::of($data)
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
            'data'=>$data,
        ]);
    }

    function getUserLocation(Request $request) {
        $data = User::where('kode_kantor', $request->id)->get();
        return response()->json([
            'data'=>$data,
        ]);
    }

    function addDistribution(Request $request, StoreDistributionRequest $storeDistributionRequest) {
    //   try {
        $storeDistributionRequest->validated();
        $increment_code= DistributionHeader::where('request_type', $request->request_type)->orderBy('id','desc')->first();
        $date_month =strtotime(date('Y-m-d'));
        $month =idate('m', $date_month);
        $year = idate('y', $date_month);
        $month_convert =  NumConvert::roman($month);
        $typeString = '';
        switch($request->request_type) {
            case '1':
                $typeString = 'DIS';
                break;
            case '2':
                $typeString = 'HAN';
                break;
            case '3':
                $typeString = 'RET';
                break;
            default:
                $typeString = '';
        }
        if($increment_code ==null){
            $ticket_code = '1/'.$typeString.'/'.$month_convert.'/'.$year;
        }else{
            $month_before = explode('/',$increment_code->request_code,-1);
            if($month_convert != $month_before[2]){
                $ticket_code = '1/'.$typeString.'/'.$month_convert.'/'.$year;
            }else{
                $ticket_code = $month_before[0] + 1 .'/'.$typeString.'/'.$month_convert.'/'.$year;
            }   
        }

        $approval = ApprovalHeader::where('location_id', $request->location_id)->first();
        $approvalDetail = ApprovalDetail::where('step', 1 )->where('approval_code', $approval->approval_code)->first();
        
        $fileName ='';
        if($request->file('attachment')){
            $ticketName = explode("/", $ticket_code);
            $ticketName2 = implode('',$ticketName);
            $custom_file_name = $typeString.'-'.$ticketName2;
            $originalName = $request->file('attachment')->getClientOriginalExtension();
            $fileName =$custom_file_name.'.'.$originalName;
        } 
        $selectedAssets = json_decode($request->selected_assets, true); // pastiin ini array
        $post_array = [];
      

        foreach ($selectedAssets as $index => $asset) {
            $condition = MasterAsset::where('asset_code', $asset['asset_code'])->first();   
            $detailCode = 'DET-' . str_replace('/', '', $ticket_code) . '-' . ($index + 1); // bikin unik
        
            $post_array[] = [
                'detail_code'       => $detailCode,
                'request_code'        => $ticket_code,
                'asset_code'        => $asset['asset_code'],
                'pic_id'            => $request->current_user_id,
                'receiver_id'       => $request->receiver_id,
                'condition'         => $condition->condition,
                'status'            => 0,
                'attachment'        => '',
                'created_at'        => date('Y-m-d H:i:s')
            ];
        }

        $post = [
            'request_code'      => $ticket_code,
            'location_id'       => $request->location_id,
            'des_location_id'   => $request->destination_location_id,
            'request_type'      => $request->request_type,
            'user_id'           => auth()->user()->id,
            'pic_id'            => $request->current_user_id,
            'receiver_id'       => $request->receiver_id,
            'approval_id'       => $approvalDetail->user_id,
            'status'            => 0,
            'notes'             => $request->notes,
            'attachment'        => $fileName,
        ];

        $post_log =[
            'request_code'      => $ticket_code,
            'location_id'       => $request->location_id,
            'des_location_id'   => $request->destination_location_id,
            'request_type'      => $request->request_type,
            'user_id'           => auth()->user()->id,
            'pic_id'            => $request->current_user_id,
            'receiver_id'       => $request->receiver_id,
            'approval_id'       => $approvalDetail->user_id,
            'status'            => 0,
            'notes'             => $request->notes,
            'attachment'        => $fileName,

        ];
        
       DB::transaction(function() use($post,$request, $post_array,$fileName, $post_log) {

            DistributionHeader::create($post);
            DistributionDetail::insert($post_array);
            DistributionLog::create($post_log);

            if($request->file('attachment')){
                $request->file('attachment')->storeAs('Asset/Distribution/attachment',$fileName);
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

    function detailDistributionTicket(Request $request) {
        $detail = DistributionHeader::with([
            'userRelation',
            'receiverRelation',
            'locationRelation',
            'desLocationRelation',
            'detailRelation',
            'detailRelation.assetRelation',
            'detailRelation.assetRelation.categoryRelation',
            'detailRelation.assetRelation.locationRelation',
            'detailRelation.assetRelation.ownerRelation',
            'detailRelation.assetRelation.brandRelation',
            'historyRelation',
            'historyRelation.locationRelation',
            'historyRelation.desLocationRelation',
            'historyRelation.userRelation',
            'historyRelation.receiverRelation',
            'historyRelation.approvalRelation',
            'historyRelation.picRelation',
        ])->where('id', $request->id)->first();


        return response()->json([
            'detail'=>$detail,
        ]);
    }
    

    function getApprovalAssetNotification(){
        $data = DistributionHeader::with([
            'userRelation',
            'receiverRelation',
            'locationRelation',
            'desLocationRelation',
            'detailRelation',
            'detailRelation.assetRelation',
            'detailRelation.assetRelation.categoryRelation',
            'detailRelation.assetRelation.locationRelation',
            'detailRelation.assetRelation.ownerRelation',
            'detailRelation.assetRelation.brandRelation',
        ])
        ->where('approval_id', auth()->user()->id)
        ->where(function($q) {
            $q->where('status', 0)->orWhere('status', 1);
        })
        ->get();
        
        return response()->json([
            'data'=>$data,
        ]);
    }

    function approvalAssetProgress(Request $request, ApprovalProgressRequest $approval_progress_request) {
    try {
        $approval_progress_request->validated();
        $header = DistributionHeader::where('request_code', $request->request_code)->first();
        $detail = DistributionDetail::where('request_code', $request->request_code)->get();
        $approval = ApprovalHeader::where('location_id', $header->location_id)->first();
        $detailApproval = ApprovalDetail::where('approval_code', $approval->approval_code)->get();
        $currentApproval = ApprovalDetail::where('approval_code', $approval->approval_code)->where('user_id', auth()->user()->id)->first();
        $nextApproval = 0;
        $status = $header->status;
        $post_detail = $detail[0]->status;
        if($currentApproval->step < $approval->step){
            $approval = ApprovalDetail::where('approval_code', $approval->approval_code)->where('step', $currentApproval->step + 1)->first();
            $nextApproval = $approval->user_id;
            $status = $header->status == 0 ? 1 : $header->status + 1;
           
        }else if($currentApproval->step == $approval->step){
           
            $nextApproval = 0;  
            $status = $header ->status + 1;
            $post_detail = $detail[0]->status +1;
        }
        
        $post_log =[
            'request_code'      => $request->request_code,
            'location_id'       => $header->location_id,
            'des_location_id'   => $header->des_location_id,
            'request_type'      => $header->request_type,
            'user_id'           => auth()->user()->id,
            'pic_id'            => $header->pic_id,
            'receiver_id'       => $header->receiver_id,
            'approval_id'       => $nextApproval,
            'status'            => $status,
            'notes'             => $request->approval_notes,
            'attachment'        => '',
        ];
        $post = [
            'status'            => $status,
            'approval_id'       => $nextApproval,
        ];
      
        DB::transaction(function() use($post,$request, $post_log,$post_detail, $currentApproval, $approval ) {
            DistributionLog::create($post_log);
            DistributionHeader::where('request_code', $request->request_code)->update($post);
            if($currentApproval->step == $approval->step){
                DistributionDetail::where('request_code', $request->request_code)->update(['status' => $post_detail]);
            }
            return ResponseFormatter::success(   
                $post,                              
                'Approval successfully updated'
            );            
        });
              } catch (\Throwable $th) {
          return ResponseFormatter::error(
              $th,
              'Approval failed to update',
              500
          );
      }

    }
}
