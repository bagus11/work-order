<?php

namespace App\Http\Controllers\OPX;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPOOPXRequest;
use App\Http\Requests\StoreOPXRequest;
use App\Models\OPX\MonitoringOPX;
use App\Models\OPX\OPXIS;
use App\Models\OPX\OPXPO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringOPXController extends Controller
{
    function index() {
        return view('opex.monitoring_opx.monitoring_opx-index');
    }
    function getOPX() {
        $data = MonitoringOPX::select(
            DB::raw('SUM(price) as sumPrice'),
            'category',
            'id',
            'location'
        )
        ->with([
            'categoryRelation',
            'locationRelation',
        ])
        ->groupBy('category', 'location')
        ->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    function getDetervative(Request $request) {
        $head = MonitoringOPX::find($request->id);
        $data = MonitoringOPX::with([
            'productRelation'
        ])->where([
            'category' => $head->category,
            'location' => $head->location,

        ])->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    function getPOOPX(Request $request) {
        $detail = MonitoringOPX::with([
            'categoryRelation',
            'locationRelation',
        ])->find($request->id)->first();
        $data = OPXPO::with([
            'userRelation'
        ])->where([
            'opx_id' => $request->id,

        ])->get();
        return response()->json([
            'data'=>$data,
            'detail'=>$detail,
        ]);
    }
    function getISOPX(Request $request) {
        $data = OPXIS::with([
            'userRelation'
        ])->where([
            'po_id' => $request->id,

        ])->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function addOPX(Request $request, StoreOPXRequest $storeProductOPXRequest) {
        try {
            $storeProductOPXRequest->validated();
            $post =[
                'location'      => $request->location,
                'user_id'       => auth()->user()->id,
                'category'      => $request->category,
                'product'       => $request->product =='' ? '-' : $request->product ,
                'note'          => $request->description,
                'start_date'    => $request->date,
                'price'         => $request->price,
                'pph'           => $request->pph,
                'ppn'           => $request->ppn,
                'dph'           => 0,
                'po'           => '',
                'is'           => '',
               
            ];
            // dd($post);
            MonitoringOPX::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'OPX successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'OPX failed to add',
                500
            );
        }
    }
    function addPOOPX(Request $request, AddPOOPXRequest $storeProductOPXRequest) {
        try {
            $storeProductOPXRequest->validated();
            $post =[
               'po'  =>$request->po,
               'pr'  =>$request->pr,
               'opx_id'  =>$request->id,
               'user_id'  =>auth()->user()->id,
               
            ];
            // dd($post);
            OPXPO::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'PO and PR successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'PO and PR failed to add',
                500
            );
        }
    }
    function updateISOPX(Request $request) {
        $status = 500;
        $message ="Failed update IS";
        $update =OPXIS::find($request->id)->update([
            'is'=>$request->is,
            'user_id'=>auth()->user()->id,
        ]);
        if($update){
            $status = 200;
            $message ="Successfully update IS";

        }

        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
    }
    function updatePOOPX(Request $request) {
        $status = 500;
        $message ="Failed update PO";
        $update =OPXPO::find($request->id)->update([
            'po'=>$request->po,
            'user_id'=>auth()->user()->id,
        ]);
        if($update){
            $status = 200;
            $message ="Successfully update PO";

        }

        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
    }
    function updatePROPX(Request $request) {
        $status = 500;
        $message ="Failed update PR";
        $update =OPXPO::find($request->id)->update([
            'pr'=>$request->pr,
            'user_id'=>auth()->user()->id,
        ]);
        if($update){
            $status = 200;
            $message ="Successfully update PR";

        }

        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
    }
    function addISOPX(Request $request) {
        $status = 500;
        $message ="Failed update IS";
        // dd($request);
        $insert =OPXIS::create([
            'is'=>$request->is,
            'opx_id'=>$request->opx_id,
            'po_id'=>$request->po_id,
            'user_id'=>auth()->user()->id
        
        ]);
        if($insert){
            $status = 200;
            $message ="Successfully update IS";
        }

        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
    }
}
