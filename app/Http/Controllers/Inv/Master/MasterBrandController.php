<?php

namespace App\Http\Controllers\inv\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddMasterBrandRequest;
use App\Http\Requests\UpdateMasterBrandRequest;
use App\Models\Inventory\Master\MasterBrand;
use Illuminate\Http\Request;

class MasterBrandController extends Controller
{
    function index() {
        return view('inv.master.brand.master_brand-index');
    }
    function getBrand(){
        $data = MasterBrand::all();
        return response()->json([
            'data'=>$data
        ]);
    }
    function addBrand(Request $request, AddMasterBrandRequest $addMasterBrandRequest){
        try {
            $addMasterBrandRequest->validated();
            $post =[
                'name'=>$request->name,
            ];
            MasterBrand::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Brand successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Brand failed to add',
                500
            );
        }
    }
    function detailBrand(Request $request){
        $detail = MasterBrand::find($request->id);
        return response()->json([
            'detail'=>$detail
        ]);
    }
    function updateBrand(Request $request, UpdateMasterBrandRequest $updateMasterBrandRequest){
        try {
            $updateMasterBrandRequest->validated();
            $post =[
                'name'=>$request->name_edit,
            ];
            MasterBrand::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Brand successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Brand failed to update',
                500
            );
        }
    }
    function deleteBrand(Request $request) {
        $status = 500;
        $message = 'Brand failed to delete';
        $delete = MasterBrand::find($request->id)->delete();
        if($delete){
            $status = 200;
            $message = 'Brand successfully deleted';
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
   }
}
