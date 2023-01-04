<?php

namespace App\Http\Controllers;

use App\Models\MasterCategory;
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
        $data = MasterCategory::all();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function save_categories(Request $request)
    {
        $categories_name = $request->categories_name;
        $status=500;
        $message="Data Gagal disimpan";
        $validator = Validator::make($request->all(),[
            'categories_name'=>'required|unique:master_categories,name',
        ],[
            'categories_name.required'=>'Nama Role tidak boleh kosong',
            'categories_name.unique'=>'Nama Role sudah ada',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$categories_name,
                'flg_aktif'=>1
            ];
            $insert = MasterCategory::create($post);
            if($insert){
                $status=200;
                $message="Data berhasil disimpan";
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
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
        $detail = MasterCategory::find($request->id);
        return response()->json([
            'detail'=>$detail,
        ]);
    }
    public function update_categories(Request $request)
    {
        $categories_name_update = $request->categories_name_update;
        $status=500;
        $message="Data Gagal disimpan";
        $validator = Validator::make($request->all(),[
            'categories_name_update'=>'required',
        ],[
            'categories_name_update.required'=>'Nama Role tidak boleh kosong',
            'categories_name_update.unique'=>'Nama Role sudah ada',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$categories_name_update,
            ];
            $insert = MasterCategory::find($request->id)->update($post);
            if($insert){
                $status=200;
                $message="Data berhasil disimpan";
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
}
