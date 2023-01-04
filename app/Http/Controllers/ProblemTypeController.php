<?php

namespace App\Http\Controllers;

use App\Models\ProblemType;
use Illuminate\Http\Request;
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
        $data = ProblemType::all();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function get_problem_type_name()
    {
        $data = ProblemType::where('flg_aktif',1 )->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function save_problem_type(Request $request)
    {
        $problem_name = $request->problem_name;
        $status=500;
        $message="Data Gagal disimpan";
        $validator = Validator::make($request->all(),[
            'problem_name'=>'required|unique:problem_types,name',
        ],[
            'problem_name.required'=>'Nama Role tidak boleh kosong',
            'problem_name.unique'=>'Nama Role sudah ada',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$problem_name,
                'flg_aktif'=>1
            ];
            $insert = ProblemType::create($post);
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
        $detail = ProblemType::find($request->id);
        return response()->json([
            'detail'=>$detail
        ]);
    }
    public function update_problem(Request $request)
    {
        $problem_name_update = $request->problem_name_update;
        $status=500;
        $message="Data Gagal disimpan";
        $validator = Validator::make($request->all(),[
            'problem_name_update'=>'required',
        ],[
            'problem_name_update.required'=>'Problem tidak boleh kosong' 
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$problem_name_update,
            ];
            $insert = ProblemType::find($request->id)->update($post);
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
