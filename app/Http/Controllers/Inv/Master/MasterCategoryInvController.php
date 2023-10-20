<?php

namespace App\Http\Controllers\inv\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryInvRequest;
use App\Models\Inventory\Master\MasterInvCategory;
use Illuminate\Http\Request;

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
}
