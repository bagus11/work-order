<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\EditMasterPriorityRequest;
use App\Http\Requests\StoreMasterPriorityRequest;
use App\Models\MasterPriority;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class MasterPriorityController extends Controller
{
    public function index()
    {
        return view('masterPriority.masterPriority-index');
    }
    public function getPriority()
    {
        $data = MasterPriority::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function addPriority(MasterPriority $masterPriority, StoreMasterPriorityRequest $storeMasterPriorityRequest)
    {
        try {
            $masterPriority->create($storeMasterPriorityRequest->validated());
           
            return ResponseFormatter::success(
                $storeMasterPriorityRequest,
                'Priority successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Priority failed to add',
                500
            );
        }
    }
    public function getPriorityDetail(Request $request)
    {
        $data = MasterPriority::find($request->id);
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function updatePriority(Request $request, EditMasterPriorityRequest $editMasterPriorityRequest)
    {
        try {
            $editMasterPriorityRequest->validated();
            $post =[
                'name'=>$request->nameUpdate,
                'duration'=>$request->durationUpdate,
                'duration_lv2'=>$request->duration_lv2Update,
            ];
           MasterPriority::find($request->id)->update($post);
        
            return ResponseFormatter::success(
               $post,
                'Priority successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Priority failed to update',
                500
            );
        }
    }
}
