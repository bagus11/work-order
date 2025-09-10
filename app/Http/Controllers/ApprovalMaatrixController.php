<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\ApprovalMatrix;
use App\Models\ApprovalMatrixDetail;
use Illuminate\Http\Request;

class ApprovalMaatrixController extends Controller
{
    function index() {
        return view('approval_matrix.approval_matrix-index');
    }
    function getApprovalMatrix() {
        $data = ApprovalMatrix::with([
            'aspectRelation',
            'moduleRelation',
            'dataTypeRelation',
            'details',
        ])->get();
        return response()->json([
            'data'=>$data,
        ]);
    
    }
    function getApproverDetail(Request $request) {
        $data = ApprovalMatrixDetail::with(
            [
                'userRelation',
                'userRelation.departmentRelation',

            ]
        )->where('approval_code', $request->approval_code)->get();
        return response()->json([
            'data'=>$data,
        ]);
    
    }

    function addApprovalMatrix(Request $request) {
        // try {
            $month = now()->month;
            $year = now()->format('y'); // 2 digit tahun
            $romanMonths = [1=>'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
            $romanMonth = $romanMonths[$month];

            // generate ticket_code
            $lastTicket = ApprovalMatrix::orderBy('id','desc')
                ->first();

            $increment = $lastTicket ? ((int) explode('/', $lastTicket->approval_code)[0] + 1) : 1;

            $approval_code = $increment . '/' . $request->data_type . '/' . $romanMonth . '/' . $year;
            $post =[
                'approval_code'     =>$approval_code,
                'aspect'            =>$request->aspect,
                'module'            =>$request->module,
                'data_type'         =>$request->data_type,
                'step'              =>$request->step,
            ];
            ApprovalMatrix::create($post);
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
    function updateApprovalMatrix(Request $request) {
        // try {
            $post =[
                'step'              =>$request->edit_step,
            ];
            ApprovalMatrix::where('approval_code', $request->approval_code)->update($post);
            return ResponseFormatter::success(
                $post,
                'Incident successfully update'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Incident failed to add',
        //         500
        //     );
        // }
    }

    function updateApproverMatrixDetail(Request $request) {
      // try {
            foreach($request->step as $row){
              $post =[
                'approval_code' => $request->approval_code,
                'user_id' => $row['user_id'],
                'step' => $row['step'],
              ];
              ApprovalMatrixDetail :: create($post);
            }
            return ResponseFormatter::success(
                'hmmm',
                'Approver successfully Update'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Incident failed to add',
        //         500
        //     );
        // }
    }
}
