<?php

namespace App\Http\Controllers\Inv\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvTypeRequest;
use App\Http\Requests\UpdateTypeInvRequest;
use App\Models\Inventory\Master\MasterTypeModel;
use Illuminate\Http\Request;

class MasterTypeInvController extends Controller
{
    function index(){
        return view('inv.master.type.master_type-index');
    }
    function getTypeInv() {
        $data = MasterTypeModel::all();
        return response()->json([
            'data'=>$data
        ]);
    }
    function saveTypeInv(Request $request, StoreInvTypeRequest $storeInvTypeRequest) {
         try {
            $storeInvTypeRequest->validated();
            $post =[
                'name'=>$request->name,
                'description'=>$request->description,
            ];
            MasterTypeModel::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Type successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Type failed to add',
                500
            );
        }
    }
    function detailTypeInv(Request $request) {
        $detail = MasterTypeModel::find($request->id);
        return response()->json([
            'detail'=>$detail
        ]);
    }
    function updateTypeInv(Request $request, UpdateTypeInvRequest $updateTypeInvRequest) {
        try {
           $updateTypeInvRequest->validated();
           $post =[
               'name'=>$request->name_edit,
               'description'=>$request->description_edit,
           ];
           MasterTypeModel::find($request->id)->update($post);
           return ResponseFormatter::success(   
               $post,                              
               'Type successfully updated'
           );            
       } catch (\Throwable $th) {
           return ResponseFormatter::error(
               $th,
               'Type failed to update',
               500
           );
       }
   }
    
}
