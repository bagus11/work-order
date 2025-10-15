<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\AddStockOpnameRequest;
use App\Http\Requests\StockOpname\ApprovalSORequest;
use App\Models\Asset\ApprovalDetail;
use App\Models\Asset\ApprovalHeader;
use App\Models\MasterAsset;
use App\Models\MasterDepartement;
use App\Models\MasterKantor;
use App\Models\Setting\MasterRoom;
use App\Models\StockOpname\StockOpnameList;
use App\Models\StockOpnameHeader;
use App\Models\StockOpnameLog;
use App\Models\User;
use App\Models\WONotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use NumConvert;
class StockOpnameController extends Controller
{
    function index() {
        return view('stock_opname.stock_opname-index');
    }

    function getStockOpname(Request $request) {
         $query = StockOpnameHeader::with([
            'userRelation',
            'historyRelation',
            'departmentRelation',
            'listRelation',
            'listRelation.assetRelation',
            'listRelation.assetRelation.categoryRelation',
            'listRelation.assetRelation.brandRelation',
            'listRelation.userRelation',
            'locationRelation'
        ]);
        if($request->period){
            $query->where('DATE(created_at)', '>=', $request->period )
                  ->where('DATE(created_at)', '<=', $request->period);
        }
        $query->get();
        if ($request->ajax()) {
            return DataTables::of($query)
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
            'data'=>$query,
        ]);

    }

    function getStockOpnameTicket() {
        $data = StockOpnameHeader::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    function addStockOpname(Request $request, AddStockOpnameRequest $addStockOpnameRequest) {
        // try{
            $addStockOpnameRequest->validated();
                $increment_code= StockOpnameHeader::orderBy('id','desc')->first();
                $date_month =strtotime(date('Y-m-d'));
                $month =idate('m', $date_month);
                $year = idate('y', $date_month);
                $month_convert =  NumConvert::roman($month);
                $initial = MasterKantor::where('id', auth()->user()->kode_kantor)->first();
                
                if($increment_code ==null){
                    $ticket_code = '1/'.$initial->initial.'/'.$month_convert.'/'.$year;
                }else{
                    $month_before = explode('/',$increment_code->ticket_code,-1);
                    if($month_convert != $month_before[2]){
                        $ticket_code = '1/'.$initial->initial.'/'.$month_convert.'/'.$year;
                    }else{
                        $ticket_code = $month_before[0] + 1 .'/'.$initial->initial.'/'.$month_convert.'/'.$year;
                    }   
                }
            $approvalHeader = ApprovalHeader::where('link', $request->currentPath)->where('location_id', auth()->user()->kode_kantor)->where('department', auth()->user()->departement)->first(); 
            $approval = ApprovalDetail::where('approval_code', $approvalHeader->approval_code)->where('step', 1)->first();
            $post = [
                'ticket_code'   => $ticket_code,
                'location_id'   => auth()->user()->kode_kantor,
                'department_id' => auth()->user()->departement,
                // 'start_date'   =>  date('Y-m-d'),
                // 'end_date'   =>  date('Y-m-d'),
                'status'   =>  0,
                'user_id'   =>  auth()->user()->id,
                'subject'   =>  $request->subject,
                'approval_code'   =>  $approvalHeader->approval_code,
                'step'   =>  1,
                'approval_id'   =>  $approval->user_id,
                'description'   =>  $request->description,
            ];
            $post_notification = [
                'userId' => $approval->user_id,
                'subject' => 'New Stock Opname Request',
                'message' => 'You have a new stock opname request from '.auth()->user()->name,
                'link' => '#stockOpnameApproval',
                'request_code' => $ticket_code,
                'type' => 2, // Assuming 1 is for stock opname
            ];
               $postLog = [
                    'ticket_code' => $ticket_code,
                    // 'start_date' =>  date('Y-m-d'),
                    'status' => 0,
                    'location_id' => auth()->user()->kode_kantor,
                    'description' =>$request->description,
                    'user_id' => auth()->user()->id,
                ];
            WONotification::create($post_notification);
            StockOpnameHeader::create($post);
            StockOpnameLog::create($postLog);
             return ResponseFormatter::success(   
               $post,                              
               'Stock Opname successfully added'
           );            
        // }catch (\Throwable $th) {
        //       return ResponseFormatter::error(
        //           $th,
        //           'Approval failed to update',
        //           500
        //       );
        // }
   
      
    }

    function getApprovalStockOpname(Request $request) {
        $detail = StockOpnameHeader::with([
            'userRelation',
            'historyRelation',
            'departmentRelation',
            'locationRelation'
        ])->where('ticket_code', $request->ticket_code)->first();

        return response()->json([
            'detail' => $detail,
        ]);
    }
function approveSO(Request $request, ApprovalSORequest $approvalSORequest) {
    // try {
        $approvalSORequest->validated();

        $stockOpname = StockOpnameHeader::where('ticket_code', $request->approval_so_ticket_code)->first();
        if (!$stockOpname) {
            return ResponseFormatter::error(null, 'Stock Opname not found', 404);
        }

        $currentApproval = ApprovalDetail::where('approval_code', $stockOpname->approval_code)
            ->where('user_id', auth()->user()->id)
            ->where('step', $stockOpname->step)
            ->first();

        $approvalHeader = ApprovalHeader::where('approval_code', $stockOpname->approval_code)->first();

        if (!$currentApproval) {
            return ResponseFormatter::error(null, 'You are not authorized to approve this stock opname', 403);
        }

        $status = 0;
        $post = [];
        $post_notification = [];

        if ($approvalHeader->step > $currentApproval->step) {
            $nextApproval = ApprovalDetail::where('approval_code', $stockOpname->approval_code)
                ->where('step', $currentApproval->step + 1)
                ->first();          
                $status = $request->approval_so_status == 1 ?1 : 5;
                $post = [
                    'approval_id' => $nextApproval ? $nextApproval->user_id : 0,
                    'step' => $nextApproval ? $nextApproval->step : 0,
                    'status' => $status,
                ];

                  $post_notification =[
                       'subject' => 'New Stock Opname Request',
                        'message' => 'You have a new stock opname request from '.auth()->user()->name,
                        'status'=>0,
                        'type'=> 2,
                        'request_code'=>$stockOpname->ticket_code,
                        'link'=>'#stockOpnameApproval',
                        'userId'=>$nextApproval->user_id,
                        'created_at'=>date('Y-m-d H:i:s')
                    ];
             
        }else{
               $status = $request->approval_so_status == 1 ? 2 : 5;
               $subject = $request->approval_so_status == 1 ? 'Stock Opname Approved' : 'Stock Opname Rejected';
               $message = $request->approval_so_status == 1 ? 'Your stock opname ticket has been approved' : 'Your stock opname ticket has been rejected';
                $post = [
                    'approval_id' => 0,
                    'step' => 0,
                    'start_date' => $request->approval_so_start_date,
                    'end_date'      => $request->approval_so_end_date,
                    'status' => $status,
                ];
                 $post_notification =[
                       'subject' => $subject,
                        'message' => $message,
                        'status'=>0,
                        'type'=> 1,
                        'request_code'=>$stockOpname->ticket_code,
                        'link'=>'#stockOpnameApproval',
                        'userId'=>$stockOpname->user_id,
                        'created_at'=>date('Y-m-d H:i:s')
                    ];
            $array_assset = [];
            $asset = MasterAsset::where('location_id', $stockOpname->location_id)
                ->get();
            foreach($asset as $row){
                $post_asset = [
                    'ticket_code'           => $stockOpname->ticket_code,
                    'location_id'           => $stockOpname->location_id,
                    'asset_code'            => $row->asset_code,
                    'condition_before'      => $row->condition,
                    'condition_after'       => 0,
                    'notes'                 => '',
                    'status'                => 0,
                    'attachment'            => '',
                    'updated_by'            => 99,
                ];
                array_push($array_assset, $post_asset);
            }
            // dd($array_assset);
            StockOpnameList::insert($array_assset);
        }
    //    dd($post);
        $postLog = [
            'ticket_code' => $request->approval_so_ticket_code,
            'start_date' => $request->approval_so_start_date,
            'status' => $status,
            'location_id' => $stockOpname->location_id,
            'description' => $request->approval_so_description,
            'user_id' => auth()->user()->id,
        ];
        
        StockOpnameLog::create($postLog);
        $stockOpname->update($post);
        WONotification::where('request_code', $request->approval_so_ticket_code)
            ->where('userId', auth()->user()->id)
            ->update(['status' => 1]);
        WONotification::create($post_notification);
        return ResponseFormatter::success($stockOpname, 'Stock Opname successfully updated');
    // } catch (\Throwable $th) {
    //     return ResponseFormatter::error($th, 'Approval failed to update', 500);
    // }
}
public function stockOPnameDetail(Request $request)
{
    $request->validate([
        'ticket_code' => 'required|string'
    ]);

    $detail = StockOpnameHeader::with([
        'userRelation',
        'listRelation',
        'listRelation.assetRelation',
        'listRelation.assetRelation.userRelation',
        'listRelation.assetRelation.roomRelation',
        'listRelation.assetRelation.userRelation.departmentRelation',
        'listRelation.userRelation',
        'locationRelation'
    ])->where('ticket_code', $request->ticket_code)->first();

    if (!$detail) {
        return response()->json([
            'success' => false,
            'message' => 'Data not found',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $detail,
    ]);
}

function stockOpnameFilter() {
    $nik = User::where('flg_aktif', 1)->get();
    $department = MasterDepartement::with([
        'divisionRelation'
    ])->get();
    $room = MasterRoom::with([
        'locationRelation'
    ])->get();
    $data =[
        'nik' => $nik,
        'department' => $department,
        'room' => $room,
    ];
     return response()->json([
        'success' => true,
        'data' => $data,
      
    ]);  
}

function stockOPnameUpdateItem(Request $request) {
     // try{
            $header = StockOpnameList::where('ticket_code', $request->input('ticket_code'))->first();
            $asset = MasterAsset::where('asset_code', $request->input('asset_code'))->first();
            $postSO = [
                'notes'                     => $request->input('remark'),
                'condition_after'           => $request->input('condition'),
            ];
             return ResponseFormatter::success(   
               $header,                              
               'Stock Opname successfully added'
           );            
        // }catch (\Throwable $th) {
        //       return ResponseFormatter::error(
        //           $th,
        //           'Approval failed to update',
        //           500
        //       );
        // }
   
}
    
}
