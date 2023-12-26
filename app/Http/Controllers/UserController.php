<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartement;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterKantor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $message="Data failed to save";
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
    function getUserHris() {        
        set_time_limit(100000);
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://hris.pralon.co.id/application/API/getAttendance?emp_no=ALL&startdate=2023-06-07&enddate=2023-06-07');
        $response = $request->getBody()->getContents();
        $data =json_decode($response, true);
        $status =500;
        $message ='Data has been failed import';
        $Arraypost=[];
        foreach($data as $row){
            $validation = User::where('nik',$row['emp_no'])->count();
            if($validation < 1){
                if($row['emp_no'] !=null){
                    $post=[
                        'name'          =>$row['Full_Name'],
                        'nik'           =>$row['emp_no'],
                        'password'      => Hash::make('pass12345'),
                        'email'         =>'user'.$row['emp_no'].'@pralon.com'
                    ];
                    array_push($Arraypost,$post);
                }
                
            }
        }
        // dd($Arraypost);
        $insert = User::insert($Arraypost);
        if($insert){
            $status =200;
            $message ='Data Successfully imported :)';
        }
        return response()->json([
           'status'=>$status,
           'message'=>$message
        ]);
    }
}
