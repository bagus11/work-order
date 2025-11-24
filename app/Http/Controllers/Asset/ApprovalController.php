<?php

namespace App\Http\Controllers\Asset;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreApprovalRequest;
use App\Http\Requests\Asset\UpdateApprovalRequest;
use App\Models\Asset\ApprovalDetail;
use App\Models\Asset\ApprovalHeader;
use App\Models\MasterKantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use NumConvert;

class ApprovalController extends Controller
{
    function index() {
        return view('asset.approval.approval-index');
    }
    function getApproval() {
        $data = ApprovalHeader::with([
            'locationRelation',
            'departmentRelation',
            'detailRelation',
            'detailRelation.userRelation',
         ])->get();
         return response()->json([
             'data'=>$data,
         ]);
    }

    function addApprovalHeader(Request $request, StoreApprovalRequest $storeMasterApproverRequest) {
        // try {
            $storeMasterApproverRequest->validated();
    
            $location = MasterKantor::find($request->location_id);
    
            $month = (int)date('m');
            $year = (int)date('y');
            $month_romawi = NumConvert::roman($month);
            
            // Ambil approval terakhir sesuai lokasi & bulan & tahun
            $lastApproval = ApprovalHeader::
                orderBy('id', 'desc')
                ->first();
            $increment = 1;
            if ($lastApproval) {
                $lastCode = explode('/', $lastApproval->approval_code);
                $increment = (int)$lastCode[0] + 1;
            }
            // dd($increment);
    
            $ticket = $increment . '/' . $location->initial . '/' . $month_romawi . '/' . $year;
            $post = [
                'step'              => $request->step,
                'link'              => $request->link,
                'location_id'       => $request->location_id,
                'department'        => $request->department_id,
                'approval_code'     => $ticket
            ]; 
            ApprovalHeader::create($post);
    
            return ResponseFormatter::success($post, 'Master Approver successfully added');
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error($th, 'Master Approver failed to add', 500);
        // }
    }

    function getStepApproval(Request $request) {
        $data = ApprovalDetail::with('userRelation')->where('approval_code',$request->approval_code)->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    
    function updateApprover(Request $request, UpdateApprovalRequest $updateApproverRequest) {
        // try {
            $updateApproverRequest->validated();
            $validating = ApprovalDetail::where('approval_code',$request->approval_code)->count();
            $array_post=[];
            foreach($request->user_array as $row){
                $location = ApprovalHeader::where('approval_code',$request->approval_code)->first(); 
                $post = [
                    'user_id'           => $row['user_id'],
                    'step'              => $row['step'],
                    'approval_code'     => $location->approval_code,
                ];
                array_push($array_post, $post);
            }
            DB::transaction(function() use($validating,$array_post,$request) {
                if($validating > 0){
                    ApprovalDetail::where('approval_code',$request->approval_code)->delete();
                    ApprovalDetail::insert($array_post);
                }else{
                    ApprovalDetail::insert($array_post);
                }
            });
            return ResponseFormatter::success(   
                $post,                              
                'Master Approver successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Master Approver failed to update',
        //         500
        //     );
        // }
    }

    function detailMasterApproval(Request $request) {
        $detail = ApprovalHeader::with([
            'locationRelation',
        ])
        ->where('id',$request->id)
        ->first();
        return response()->json([
            'detail'=>$detail,  
        ]);  
    }

    function editMasterApproval(Request $request, ) {
        try {
            $post =[
                'step'              => $request->edit_step,
            ];
            ApprovalHeader::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Master Approver successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Master Approver failed to update',
                500
            );
        }
    }
}
