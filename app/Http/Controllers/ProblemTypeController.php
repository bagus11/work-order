<?php

namespace App\Http\Controllers;

use App\Models\MasterCategory;
use App\Models\ProblemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Ui\Presets\React;

class ProblemTypeController extends Controller
{
    public function index()
    {
        return view('problem_type.problem_type-index');
    }
    public function get_problem_type()
    {
        $data = DB::table('problem_types')->join('master_categories','master_categories.id','=','problem_types.categories_id')->select('problem_types.*', 'master_categories.name as categories_name')->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function get_problem_type_name(Request $request)
    {
        $data = ProblemType::where('flg_aktif',1 )->where('categories_id', 'like','%'.$request->id.'%')->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function save_problem_type(Request $request)
    {
        $problem_name = $request->problem_name;
        $categories_id = $request->categories_id;
        $status=500;
        $message="Data failed to save";
        $validator = Validator::make($request->all(),[
            'problem_name'=>'required|unique:problem_types,name',
            'categories_id'=>'required',
        ],[
            'problem_name.required'=>'Tipe problem tidak boleh kosong',
            'problem_name.unique'=>'Tipe problem sudah ada',
            'categories_id.required'=>'Tipe problem tidak boleh kosong',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$problem_name,
                'categories_id'=>$categories_id,
                'flg_aktif'=>1
            ];
            $insert = ProblemType::create($post);
            if($insert){
                $status=200;
                $message="Data successfully inserted";
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
    public function update_status_problem(Request $request)
    {
        $id=$request->id;
        $flg_aktif=$request->flg_aktif;
        $post=[
            'flg_aktif'=>$flg_aktif==1?0:1
        ];
        $message ='Data Gagal diupdate';
        $update = ProblemType::find($id);
        $update->update($post);
        if($update){
            $message='Data berhasil diupdate';
        }
        return response()->json([
            'message'=>$message,
        ]);
    }
    public function detail_problems(Request $request)
    {
        $detail =DB::table('problem_types')
                ->join('master_categories','master_categories.id','=','problem_types.categories_id')
                ->select('problem_types.*','master_categories.name as categories_name')
                ->where('problem_types.id',$request->id)->first();
        $data = MasterCategory::where('flg_aktif',1 )->get();
        return response()->json([
            'detail'=>$detail,
            'data'=>$data
        ]);
    }
    public function update_problem(Request $request)
    {
        $problem_name_update = $request->problem_name_update;
        $categories_id_update = $request->categories_id_update;
        $status=500;
        $message="Data failed to save";
        $validator = Validator::make($request->all(),[
            'problem_name_update'=>'required',
            'categories_id_update'=>'required',
        ],[
            'problem_name_update.required'=>'Problem tidak boleh kosong',
            'categories_id_update.required'=>'Kategori tidak boleh kosong' 
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$problem_name_update,
                'categories_id'=>$categories_id_update,
            ];
            $insert = ProblemType::find($request->id)->update($post);
            if($insert){
                $status=200;
                $message="Data successfully inserted";
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
}
