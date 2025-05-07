<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartement;
use App\Models\MasterJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class MasterJabatanController extends Controller
{
    public function index()
    {
        return view('master_jabatan.master_jabatan-index');
    }
    public function get_jabatan()
    {
        $data = DB::table('master_jabatan')->join('master_departements','master_departements.id','=','master_jabatan.departement_id')->select('master_jabatan.*', 'master_departements.name as departement_name')->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function save_jabatan(Request $request)
    {
        $jabatan_name = $request->jabatan_name;
        $departement_id = $request->departement_id;
        $status=500;
        $message="Data failed to save";
        $validator = Validator::make($request->all(),[
            'jabatan_name'=>'required',
            'departement_id'=>'required',
        ],[
            'jabatan_name.required'=>'Jabatan tidak boleh kosong',
            'departement_id.required'=>'Departement tidak boleh kosong',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $validasi_1 = MasterJabatan::where('departement_id', $departement_id)->where('name',$jabatan_name)->count();
            if($validasi_1 > 0){
                $message='Data sudah ada';
            }else{
                $post=[
                    'name'=>$jabatan_name,
                    'departement_id'=>$departement_id,
                    'flg_aktif'=>1
                ];
                $insert = MasterJabatan::create($post);
                if($insert){
                    $status=200;
                    $message="Data successfully inserted";
                }
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
    public function update_status_jabatan(Request $request)
    {
        $id=$request->id;
        $flg_aktif=$request->flg_aktif;
        $post=[
            'flg_aktif'=>$flg_aktif==1?0:1
        ];
        $message ='Data Gagal diupdate';
        $update = MasterJabatan::find($id);
        $update->update($post);
        if($update){
            $message='Data berhasil diupdate';
        }
        return response()->json([
            'message'=>$message,
        ]);
    }
    public function detail_jabatan(Request $request)
    {
        $detail = DB::table('master_jabatan')->join('master_departements','master_departements.id','=','master_jabatan.departement_id')->select('master_jabatan.*', 'master_departements.name as departement_name')->where('master_jabatan.id', $request->id)->first();
        $data = MasterDepartement::where('flg_aktif',1)->get();
        return response()->json([
            'detail'=>$detail,
            'data'=>$data,
        ]);
    }
    public function update_jabatan(Request $request)
    {
        $jabatan_name_update = $request->jabatan_name_update;
        $status=500;
        $message="Data failed to save";
        $validator = Validator::make($request->all(),[
            'jabatan_name_update'=>'required',
        ],[
            'jabatan_name_update.required'=>'Jabatan tidak boleh kosong',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
          
                $post=[
                    'name'=>$jabatan_name_update,
                ];
                $update = MasterJabatan::find($request->id)->update($post);
                if($update){
                    $status=200;
                    $message="Data successfully inserted";
                }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
    public function get_jabatan_name(Request $request)
    {
        $data = MasterJabatan::where('flg_aktif',1)->where('departement_id','like','%'.$request->id.'%')->get();
        return response()->json([
            'data'=>$data
        ]);
    }
}
