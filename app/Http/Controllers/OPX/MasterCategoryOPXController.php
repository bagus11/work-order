<?php

namespace App\Http\Controllers\OPX;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryOPXReqeuest;
use App\Http\Requests\UpdateCategoryOPXRequest;
use App\Models\OPX\MasterCategoryOPX;
use Illuminate\Http\Request;

class MasterCategoryOPXController extends Controller
{
    function index() {
        return view('opex.master_category_opex.master_category_opex-index');
    }
    function getmasterCategoryOPX() {
        $data = MasterCategoryOPX::all();
        return response()->json([
            'data'=>$data
        ]);
    }
    function getActiveCategoryOPX() {
        $data = MasterCategoryOPX::where([
            'status'=> 1,
        ])->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    function getDevCategoryOPX() {
        $data = MasterCategoryOPX::where([
            'status'=> 1,
            'type'  =>2
            
        ])->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    function addCategoryOPX(Request $request, StoreCategoryOPXReqeuest $storeCategoryRequest) {
        try {
            $storeCategoryRequest->validated();
            $post =[
                'name'      => $request->name,
                'status'    => 0,
                'type'    => $request->type,
            ];
            MasterCategoryOPX::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Category successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Category failed to add',
                500
            );
        }
    }
    function updateCategoryOPX(Request $request, UpdateCategoryOPXRequest $storeCategoryRequest) {
        try {
            $storeCategoryRequest->validated();
            $post =[
                'name'      => $request->name_edit,
                'type'    => $request->type_edit,
            ];
            MasterCategoryOPX::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Category successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Category failed to update',
                500
            );
        }
    }

    function updateStatusCategoryOPX(Request $request) {
        $status = 500;
        $message = 'failed update status';
        $head = MasterCategoryOPX::find($request->id);
        $post =[
            'status'=>$head->status ==1 ? 0 : 1
        ];
        $update = $head->update($post);
        if($update){
            $status = 200;
            $message = 'successfully update status';
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }

}
