<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\AddStockOpnameRequest;
use App\Http\Requests\StockOpname\ApprovalSORequest;
use App\Models\Asset\ApprovalDetail;
use App\Models\Asset\ApprovalHeader;
use App\Models\MasterAsset;
use App\Models\MasterAssetLog;
use App\Models\MasterDepartement;
use App\Models\MasterKantor;
use App\Models\Setting\MasterRoom;
use App\Models\StockOpname\StockOpnameList;
use App\Models\StockOpnameHeader;
use App\Models\StockOpnameLog;
use App\Models\User;
use App\Models\WONotification;
use App\Services\FcmService;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

    public function getStockOpnameTicket()
    {
        $data = StockOpnameHeader::with('listRelation')->whereIn('status', [2,3])->get();
        $data->each(function ($header) {
            $header->count_by_condition = $header->countByCondition();
        });

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
                    'status' => 0,
                    'location_id' => auth()->user()->kode_kantor,
                    'description' =>$request->description,
                    'user_id' => auth()->user()->id,
                ];
            $user = User::where('id', $approval->user_id)->first();
            // dd($user->fcm_token);
          (new FcmService)->send(
                $user->fcm_token,
                'Stock Opname Approval',
                auth()->user()->name . ' has created a stock opname ticket, please approve it.',
                [
                    'ticket_code' => $ticket_code,
                    'api_url' => url('/api/stock-opname/detail?ticket_code=' . $ticket_code),
                ]
            );


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
        $user = User::where('id', $stockOpname->user_id)->first();
            (new FcmService)->send(
            $user->fcm_token,
            'Stock Opname Approval',
            auth()->user()->name . ' has assign your stock opname ticket. please check it',
           
        );
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

    // Ambil header + relasi penting (tanpa countByCondition di eager load)
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
    $approval = ApprovalDetail::where('approval_code', $detail->approval_code)->first();
    if (!$detail) {
        return response()->json([
            'success' => false,
            'message' => 'Data not found',
        ], 404);
    }

    // Tambahkan count_by_condition secara manual
    $detail->count_by_condition = $detail->countByCondition();

    return response()->json([
        'success' => true,
        'data' => $detail,
        'approval' => $approval,
    ]);
}
    public function stockOpnameAssign(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string'
        ]);

        // Ambil header + relasi penting (tanpa countByCondition di eager load)
        $detail = StockOpnameHeader::with([
            'userRelation',
        ])->where('ticket_code', $request->ticket_code)->first();
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

    public function stockOPnameUpdateItem(Request $request)
    {
        DB::beginTransaction(); // mulai transaksi

        // try {
            $request->validate([
                'ticket_code' => 'required|string|exists:stock_opname_lists,ticket_code',
                'asset_code'  => 'required|string|exists:master_asset,asset_code',
                'remark'      => 'nullable|string',
                'condition'   => 'required',
                'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            $header = StockOpnameList::where('ticket_code', $request->ticket_code)
                ->where('status', 0)
                ->first();

            if (!$header) {
                return ResponseFormatter::error(null, 'Ticket not found or already processed', 404);
            }

            $asset = MasterAsset::where('asset_code', $request->asset_code)->first();

            if (!$asset) {
                return ResponseFormatter::error(null, 'Asset not found', 404);
            }

            $attachmentPath = null;
            $postSO = [
                'notes'            => $request->remark,
                'updated_by'       => auth()->id(),
                'condition_before' => $asset->condition,
                'condition_after'  => $request->condition,
                'updated_at'       => now(),
                'status'           => 1,
            ];
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
                $tempPath = $file->storeAs('stock_opname/', $filename);
            }

            // Tambahkan path attachment kalau ada
            if (isset($tempPath)) {
                $finalPath = 'public/stock_opname/' . $filename; // simpan di storage/app/public/stock_opname
                Storage::move($tempPath, $finalPath);
                $attachmentPath = str_replace('public/', 'storage/', $finalPath);
                $postSO['attachment'] = $attachmentPath;
            }

        
            StockOpnameList::where([
                'ticket_code' => $request->ticket_code,
                'asset_code'  => $request->asset_code,
            ])->update($postSO);
            
            $totalItems = StockOpnameList::where('ticket_code', $request->ticket_code)->count();
            $completedItems = StockOpnameList::where('ticket_code', $request->ticket_code)
                ->where('status', 1)
                ->count();

            $progress = $totalItems > 0 ? round(($completedItems / $totalItems) * 100, 2) : 0;
            $head = StockOpnameHeader::where('ticket_code', $request->ticket_code)->first();
            DB::table('stock_opname_headers')
                ->where('ticket_code', $request->ticket_code)
                ->update([
                    'progress' => $progress,
                    'updated_at' => now(),
                    'status'    => $progress == 100 ? 3 : $head->status
                ]);
            if($progress == 100) {
                $approval = ApprovalDetail::where('approval_code', $head->approval_code)->where('step', 1)->value('user_id');
                   $userPost =[
                        'message'=>auth()->user()->name.' has finish checking items, please finish the ticket',
                        'subject'=>'Stock Opname Checking',
                        'status'=>0,
                        'type'=> 1,
                        'request_code'=>$head->ticket_code,
                        'link'=>'stock_opname',
                        'userId'=>$approval,
                        'created_at'=>date('Y-m-d H:i:s')
                    ];
                    WONotification::create($userPost);
                       $post_log = [
                            'ticket_code'   => $header->ticket_code,
                            'start_date'    => $header->start_date,
                            'end_date'      => $request->result == 'match' ? date('Y-m-d'): $header->end_date,
                            'status'        => 3,
                            'user_id'       => auth()->user()->id,
                            'location_id'   => $header->location_id,
                            'description'   => auth()->user()->name. ' has finish checking items'
                        ];
                    StockOpnameLog::create($post_log);
            }

            DB::commit(); // sukses → commit semua perubahan
            $parameter = StockOpnameHeader::with([
                    'userRelation',
                    'listRelation',
                    'listRelation.assetRelation',
                    'listRelation.assetRelation.userRelation',
                    'listRelation.assetRelation.roomRelation',
                    'listRelation.assetRelation.userRelation.departmentRelation',
                    'listRelation.userRelation',
                    'locationRelation'
                ])->where('ticket_code', $header->ticket_code)->first();
            return ResponseFormatter::success($parameter, 'Stock Opname List successfully updated');
        // } catch (\Throwable $th) {
        //     DB::rollBack(); // kalau error → batalkan semua perubahan

        //     // Hapus file sementara kalau ada
        //     if (isset($tempPath) && Storage::exists($tempPath)) {
        //         Storage::delete($tempPath);
        //     }

        //     return ResponseFormatter::error($th->getMessage(), 'Failed to update Stock Opname', 500);
        // }
    }    

    public function stockOpnameChecking(Request $request){
          DB::beginTransaction(); // mulai transaksi

        try {
            $request->validate([
                'ticket_code' => 'required|string|exists:stock_opname_lists,ticket_code',
                'result'      => 'nullable|string',
                'remark'   => 'required'
            ]);

            $header = StockOpnameHeader::where('ticket_code', $request->ticket_code)->first();
            $status = $request->result == 'match' ? $header->status + 1 : $header->status + 2;

            $post = [
                'status'        => $status,
                'end_date'      => $request->result == 'match' ? date('Y-m-d'): $header->end_date
            ];
            $post_log = [
                'ticket_code'   => $header->ticket_code,
                'start_date'    => $header->start_date,
                'end_date'      => $request->result == 'match' ? date('Y-m-d'): $header->end_date,
                'status'        => $status,
                'user_id'       => auth()->user()->id,
                'location_id'   => $header->location_id,
                'description'   => $request->remark
            ];
            if($request->result == 'match'){
                $assets = StockOpnameList::where('ticket_code', $header->ticket_code)->get();
                foreach($assets as $row){
                    MasterAsset::where('asset_code', $row->asset_code)->update([
                        'condition' => $row->condition_after,
                        'image'     => $row->attachment
                    ]);
                    $asset = MasterAsset::where('asset_code', $row->asset_code)->first();
                    MasterAssetLog::create([
                           'asset_code'         => $row->asset_code,
                           'category'           => $asset->category,
                           'brand'              => $asset->brand,
                           'type'               => $asset->type,
                           'parent_code'        => $asset->parent_code,
                           'remark'             => auth()->user()->id. ' has update condition by stock opname.',
                           'user_id'            => auth()->user()->id,
                           'is_active'          =>$asset->is_active,
                           'condition'          =>$row->condition_after,
                           'nik'                =>$asset->nik,
                           'join_date'          =>$asset->join_date,
                           'location_id'        =>$asset->location_id,
                    ]);
                } 
            }
            StockOpnameHeader::where('ticket_code', $request->ticket_code)->update($post);
            StockOpnameLog::create($post_log);
            DB::commit();

            return ResponseFormatter::success($request, 'Stock Opname List successfully updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseFormatter::error($th->getMessage(), 'Failed to update Stock Opname', 500);
        }
    }
}
