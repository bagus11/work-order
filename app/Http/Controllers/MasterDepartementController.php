<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\UpdateMasterDepartementRequest;
use App\Models\MasterDepartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterDepartementController extends Controller
{
    public function index()
    {
        return view('master_departement.master_departement-index');
    }
    public function get_departement(Request $request)
    {
        $data = MasterDepartement::all();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function save_departement(Request $request)
    {
        $departement_name = $request->departement_name;
        $initial_name = $request->initial_name;
        $status=500;
        $message="Data Gagal disimpan";
        $validator = Validator::make($request->all(),[
            'departement_name'=>'required|unique:master_departements,name',
            'initial_name'=>'required|unique:master_departements,initial',
        ],[
            'departement_name.required'=>'Departement tidak boleh kosong',
            'initial_name.required'=>'Inisial tidak boleh kosong',
            'departement_name.unique'=>'Departement sudah ada',
            'initial_name.unique'=>'Inisial sudah ada',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$departement_name,
                'initial'=>$initial_name,
                'flg_aktif'=>1
            ];
            $insert = MasterDepartement::create($post);
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
    public function update_status_departement(Request $request)
    {
        $id=$request->id;
        $flg_aktif=$request->flg_aktif;
        $post=[
            'flg_aktif'=>$flg_aktif==1?0:1
        ];
        $message ='Data Gagal diupdate';
        $update = MasterDepartement::find($id);
        $update->update($post);
        if($update){
            $message='Data berhasil diupdate';
        }
        return response()->json([
            'message'=>$message,
        ]);
    }
    public function detail_departement(Request $request)
    {
        $detail = MasterDepartement::find($request->id);
        return response()->json([
            'detail'=>$detail,
        ]);
    }
    public function get_departement_name()
    {
        $data = MasterDepartement::where('flg_aktif',1)->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function update_departement(Request $request, UpdateMasterDepartementRequest $updateMasterDepartementRequest){
        try {
            $updateMasterDepartementRequest->validated();
            $post =[
                'initial'=>$request->initial_name_update,
                'name'=>$request->departement_name_update,
            ];
            MasterDepartement::find($request->id)->update($post);
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
