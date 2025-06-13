<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use App\Models\MasterCategory;
use App\Models\MasterDepartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class MasterCategoryController extends Controller
{
    public function index()
    {
        return view('master_category.master_category-index');
    }
    public function get_categories()
    {
        $data = MasterCategory::with('departement')->get();
        return response()->json([
            'data'=>$data
        ]);
    }
   public function get_categories_id(Request $request)
   {
        $id = MasterDepartement::where('initial', $request->initial)->first();
        // dd($id);
        $data = MasterCategory::with('departement')->where('departement_id', $id->id)->where('type',1)->get();
        return response()->json([
            'data'=>$data
        ]);
   }
    public function save_categories(Request $request, StoreCategoriesRequest $storeCategoriesRequest)
    {
        try {
            $storeCategoriesRequest->validated();
            $post =[
                'flg_aktif'=>1,
                'departement_id'=>$request->departement_id,
                'name'=>$request->categories_name,
            ];
            MasterCategory::create($post);
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
    public function update_status_categories(Request $request)
    {
        $id=$request->id;
        $flg_aktif=$request->flg_aktif;
        $post=[
            'flg_aktif'=>$flg_aktif==1?0:1
        ];
        $message ='Data Gagal diupdate';
        $update = MasterCategory::find($id);
        $update->update($post);
        if($update){
            $message='Data berhasil diupdate';
        }
        return response()->json([
            'message'=>$message,
        ]);
    }
    public function detail_categories(Request $request)
    {
        $detail = MasterCategory::with('departement')->find($request->id);
        $data = MasterDepartement::where('flg_aktif',1)->get();
        return response()->json([
            'detail'=>$detail,
            'data'=>$data
        ]);
    }
    public function update_categories(Request $request, UpdateCategoriesRequest $updateCategoriesRequest)
    {
        try {
            $updateCategoriesRequest->validated();
            $post =[
                'departement_id'=>$request->departement_id_update,
                'name'=>$request->categories_name_update,
            ];
            MasterCategory::find($request->id)->update($post);
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
}
