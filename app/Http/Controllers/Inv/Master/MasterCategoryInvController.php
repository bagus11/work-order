<?php

namespace App\Http\Controllers\inv\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryInvRequest;
use App\Http\Requests\UpdateCategoryInvRequest;
use App\Http\Requests\uploadCategoryRequest;
use App\Imports\UploadCategory;
use App\Models\Inventory\Master\MasterInvCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MasterCategoryInvController extends Controller
{
    function index() {
        return view('inv.master.category.master_category-index');
    }
    function getCategoryInv() {
        $data = MasterInvCategory::with(['typeRelation'])->get();
        return response()->json([
            'data'=>$data
        ]);
        
    }
    function saveCategoryInv(Request $request, StoreCategoryInvRequest $storeCategoryInvRequest) {
        try {
           $storeCategoryInvRequest->validated();
           $post =[
               'name'=>$request->name,
               'type_id'=>$request->type_id,
               'description'=>$request->description,
           ];
           MasterInvCategory::create($post);
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
   function detailCategoryInv(Request $request) {
        $detail = MasterInvCategory::find($request->id);
        return response()->json([
            'detail'=>$detail
        ]);
   }
   function updateCategoryInv(Request $request, UpdateCategoryInvRequest $updateCategoryInvRequest) {
    try {
        $updateCategoryInvRequest->validated();
        $post =[
            'name'=>$request->name_edit,
            'type_id'=>$request->type_id_edit,
            'description'=>$request->description_edit,
        ];
        MasterInvCategory::find($request->id)->update($post);
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
   function deleteCategoryInv(Request $request) {
        $status = 500;
        $message = 'Category failed to delete';
        $delete = MasterInvCategory::find($request->id)->delete();
        if($delete){
            $status = 200;
            $message = 'Category successfully to deleted';
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
   }
   function uploadCategory(Request $request, uploadCategoryRequest $updateCategoryInvRequest){
     
    try {
        $updateCategoryInvRequest->validated();
        $category= new UploadCategory;
        Excel::import($category, $request->upload_file);
        return ResponseFormatter::success(   
            'ok',                              
            'Category successfully uploaded'
        );            
    } catch (\Throwable $th) {
        return ResponseFormatter::error(
            $th,
            'Category failed to upload',
            500
        );
    }
   }
}
