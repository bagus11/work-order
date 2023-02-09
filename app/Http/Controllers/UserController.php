<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartement;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterKantor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view('user.user-index');
    }
    public function update_status_user(Request $request)
    {
        $id=$request->id;
        $flg_aktif=$request->flg_aktif;
        
        $post=[
            'flg_aktif'=>$flg_aktif==1?0:1
        ];
        $message ='Data Gagal diupdate';
        $update = User::find($id);
        $update->update($post);
        if($update){
            $message='Data berhasil diupdate';
        }else{
            $message="test";
        }
        return response()->json([
            'message'=>$message,
        ]);
    }
    public function detail_user(Request $request)
    {
        $detail = DB::table('view_user')->where('id', $request->id)->first();
        $departement = MasterDepartement::where('flg_aktif',1)->get();
        $kantor =MasterKantor::where('flg_aktif',1)->get();
        return response()->json([
            'detail'=>$detail,
            'kantor'=>$kantor,
          
            'departement'=>$departement,
        ]);
    }
    public function update_user_setting(Request $request)
    {
        $user_name = $request->user_name;
        $departement_id = $request->departement_id;
        $jabatan_id = $request->jabatan_id;
        $kode_kantor = $request->kode_kantor;
        $status=500;
        $message="Data Gagal disimpan";
        $validator = Validator::make($request->all(),[
            'user_name'=>'required',
            'departement_id'=>'required',
            'jabatan_id'=>'required',
            'kode_kantor'=>'required',
        ],[
            'user_name.required'=>'Nama user tidak boleh kosong',
            'departement_id.required'=>'Departement user tidak boleh kosong',
            'jabatan_id.required'=>'Jabatan user tidak boleh kosong',
            'kode_kantor.required'=>'Kantor user tidak boleh kosong',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$user_name,
                'departement'=>$departement_id,
                'jabatan'=>$jabatan_id,
                'kode_kantor'=>$kode_kantor,
            ];
           
            $update = User::find($request->id)->update($post);
            if($update){
                $status=200;
                $message="Data berhasil diupdate";
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
}
