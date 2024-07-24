<?php

namespace App\Http\Controllers\OPX;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductOPXRequest;
use App\Http\Requests\UpdateProductOPXRequest;
use App\Models\OPX\MasterProductOPX;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class MasterProductOPXController extends Controller
{
    function index() {
        return view('opex.master_product_opx.master_product_opx-index');
    }
    function getProductOPX() {
        $data = MasterProductOPX::with('categoryRelation')->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    function getProductFilter(Request $request) {
        $data = MasterProductOPX::where('category',$request->category)->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    function addProductOPX(Request $request, StoreProductOPXRequest $storeProductOPXRequest) {
        try {
            $storeProductOPXRequest->validated();
            $post =[
                'name'      => $request->name,
                'status'    => 0,
                'category'    => $request->category,
                'description'    => $request->description,
            ];
            MasterProductOPX::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Product successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Product failed to add',
                500
            );
        }
    }
    function updateProductOPX(Request $request, UpdateProductOPXRequest $updateProductOPXRequest) {
        try {
            $updateProductOPXRequest->validated();
            $post =[
                'name'      => $request->name_edit,
                'category'    => $request->category_edit,
                'description'    => $request->description_edit,
            ];
            MasterProductOPX::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Product successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Product failed to add',
                500
            );
        }
    }
    function updateStatusProductOPX(Request $request) {
        $status = 500;
        $message = 'failed update status';
        $head = MasterProductOPX::find($request->id);
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
