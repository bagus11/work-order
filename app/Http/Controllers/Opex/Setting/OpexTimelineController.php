<?php

namespace App\Http\Controllers\Opex\Setting;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddOpexHeadRequest;
use App\Http\Requests\UpdateHeadOpexRequest;
use App\Models\MasterDepartement;
use App\Models\MasterKantor;
use App\Models\Opex\OpexHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumConvert;
class OpexTimelineController extends Controller
{
    function index() {
        return view('opex.transaction.opex_timeline.opex-index');
    }
    function getOPex() {
        $data = OpexHeader::with([
            'locationRelation'
        ])->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    function addHeadOpex(Request $request, AddOpexHeadRequest $addOpexHeadRequest) {
         try {
            $increment_code     = OpexHeader::orderBy('id','desc')->first();
            $date_month         = strtotime(date('Y-m-d'));
            $month              = idate('m', $date_month);
            $year               = idate('y', $date_month);
            $month_convert      = NumConvert::roman($month);
            $location    = MasterKantor::find($request->location_id);
            if($increment_code ==null){
                $ticket_code = '1/OPX/'.$location->initial.'/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->request_code,-1);
                if($month_convert != $month_before[3]){
                    $ticket_code = '1/OPX/'.$location->initial.'/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/'.'OPX/'.$location->initial.'/'.$month_convert.'/'.$year;
                }   
            }
            
            $fileName ='';
            if($request->file('attachment')){
                $ticketName = explode("/", $ticket_code);
                $ticketName2 = implode('',$ticketName);
                $custom_file_name = $ticketName2;
                $originalName = $request->file('attachment')->getClientOriginalExtension();
                $fileName =$custom_file_name.'.'.$originalName;
            }
            $post = [
                'request_code'  => $ticket_code,
                'title'  => $request->title,
                'description'  => $request->description,
                'start_date'  => $request->start_date,
                'end_date'  => $request->end_date,
                'status'  => 1,
                'percentage'  => 0,
                'user_id'  => auth()->user()->id,
                'location_id'  => $request->location_id,
                'attachment'=>$fileName != ''? 'storage/OPX/Head/'.$fileName :null
            ];
            DB::transaction(function() use($request,$fileName,$post) {
                OpexHeader::create($post);
                if($request->file('attachment')){
                    $request->file('attachment')->storeAs('/OPX/Head/',$fileName);
                }
            });
            return ResponseFormatter::success(
                $post,
                'Incident successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Incident failed to add',
                500
            );
        }
    }
    function detailHeadOpex(Request $request) {
        $detail = OpexHeader::with([
            'locationRelation',
            'userRelation'
        ])->where('request_code',$request->request_code)->first();
        return response()->json([
            'detail'=>$detail
        ]);
    }
    function updateHeadOpex(Request $request, UpdateHeadOpexRequest $updateHeadOpexRequest) {
        // try {
            $updateHeadOpexRequest->validated();
           $post = [
               'title'  => $request->title_edit,
               'description'  => $request->description_edit,
               'end_date'  => $request->end_date_edit,
           ];
        //    dd($request);
           DB::transaction(function() use($request,$post) {
               OpexHeader::where('request_code',$request->request_code)->update($post);
           });
           return ResponseFormatter::success(
               $post,
               'Incident successfully added'
           );            
    //    } catch (\Throwable $th) {
    //        return ResponseFormatter::error(
    //            $th,
    //            'Incident failed to add',
    //            500
    //        );
    //    }
   }
}
