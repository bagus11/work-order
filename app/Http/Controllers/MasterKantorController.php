<?php

namespace App\Http\Controllers;

use App\Models\MasterKantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MasterKantorController extends Controller
{
    public function index()
    {
        return view('master_kantor.master_kantor-index');
    }
    public function get_kantor()
    {
        $data = MasterKantor::all();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function get_province()
    {
        $get_province = DB::table('tbl_provinsi')->select('*')->get();
        return response()->json([
            'get_province'=>$get_province
        ]);
    }
    public function get_regency(Request $request)
    {
        $get_regency = DB::table('tbl_kabkot')->select('*')->where('provinsi_id', $request->id_province)->get();
        return response()->json([
            'get_regency'=>$get_regency
        ]);
    }
    public function get_district(Request $request)
    {
        $get_district = DB::table('tbl_kecamatan')->select('*')->where('kabkot_id', $request->id_regency)->get();
        return response()->json([
            'get_district'=>$get_district
        ]);
    }
    public function get_village(Request $request)
    {
        $get_village = DB::table('tbl_kelurahan')->select('*')->where('kecamatan_id', $request->id_district)->get();
        return response()->json([
            'get_village'=>$get_village
        ]);
    }
    public function get_postal_code(Request $request)
    {
        $get_postal_code = DB::table('tbl_kelurahan')->select('*')->where('id', $request->id_village)->first();
        return response()->json([
            'get_postal_code'=>$get_postal_code
        ]);
    }
    public function save_kantor(Request $request)
    {

        $office_name = $request->office_name;
        $office_address = $request->office_address;
        $office_type = $request->office_type;
        $id_province = $request->id_province;
        $id_regency = $request->id_regency;
        $id_district = $request->id_district;
        $id_village = $request->id_village;
        $postal_code = $request->postal_code;
      
        $status =500;
        $message ='Data failed to save';
        $validator = Validator::make($request->all(),[
            'office_name'=>'required|unique:master_kantor,name',
            'office_type'=>'required',
            'office_address'=>'required',
            'id_province'=>'required',
            'id_regency'=>'required',
            'id_district'=>'required',
            'id_village'=>'required',
            'postal_code'=>'required',
          
        ],[
            'office_name.required'=>'Nama kantor tidak boleh kosong',
            'office_name.unique'=>'Nama kantor sudah ada',
            'office_address.required'=>'Alamat kantor tidak boleh kosong',
            'office_type.required'=>'Tipe kantor tidak boleh kosong',
            'id_province.required'=>'Provinsi tidak boleh kosong',
            'id_regency.required'=>'Kabupaten tidak boleh kosong',
            'id_district.required'=>'Kecamatan tidak boleh kosong',
            'id_village.required'=>'Kelurahan tidak boleh kosong',
            'postal_code.required'=>'Kode pos tidak boleh kosong',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $city = DB::table('tbl_kabkot')->select('kabupaten_kota')->where('id',$id_regency)->first();
            $post =[
              'city'=>$city->kabupaten_kota,
              'name'=>$office_name,
              'office_type'=>$office_type,
              'address'=>$office_address,
              'id_prov'=>$id_province,
              'id_city'=>$id_regency,
              'id_district'=>$id_district,
              'id_village'=>$id_village,
              'postal_code'=>$postal_code,
              'flg_aktif'=>1
            ];
            $insert = MasterKantor::create($post);
            if($insert){
                $status=200;
                $message='Data successfully inserted';
            }
         
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
    public function update_status_kantor(Request $request)
    {
        $id=$request->id;
        $flg_aktif=$request->flg_aktif;
        $post=[
            'flg_aktif'=>$flg_aktif==1?0:1
        ];
        $message ='Data Gagal diupdate';
        $update = MasterKantor::find($id);
        $update->update($post);
        if($update){
            $message='Data berhasil diupdate';
        }
        return response()->json([
            'message'=>$message,
        ]);
    }
    public function detail_kantor(Request $request)
    {
        $detail = DB::table('master_kantor')->select('master_kantor.*','tbl_provinsi.provinsi as province_name', 'tbl_kabkot.kabupaten_kota as regency_name','tbl_kecamatan.kecamatan as district_name', 'tbl_kelurahan.kelurahan as village_name','tbl_kelurahan.kd_pos as postal_code')
                    ->join('tbl_provinsi','tbl_provinsi.id','=','master_kantor.id_prov')
                    ->join('tbl_kabkot','tbl_kabkot.id','=','id_city')
                    ->join('tbl_kecamatan','tbl_kecamatan.id','=','id_district')
                    ->join('tbl_kelurahan','tbl_kelurahan.id','=','id_village')
                    ->where('master_kantor.id', $request->id)->first();
        $get_province = DB::table('tbl_provinsi')->select('*')->get();      
        return response()->json([
            'get_province'=>$get_province,
            'detail'=>$detail,
        ]);
    }
    public function update_kantor(Request $request)
    {

        $office_name_update = $request->office_name_update;
        $office_address_update = $request->office_address_update;
        $office_type_update = $request->office_type_update;
        $id_province_update = $request->id_province_update;
        $id_regency_update = $request->id_regency_update;
        $id_district_update = $request->id_district_update;
        $id_village_update = $request->id_village_update;
        $postal_code_update = $request->postal_code_update;
      
        $status =500;
        $message ='Data failed to save';
        $validator = Validator::make($request->all(),[
            'office_name_update'=>'required',
            'office_type_update'=>'required',
            'office_address_update'=>'required',
            'id_province_update'=>'required',
            'id_regency_update'=>'required',
            'id_district_update'=>'required',
            'id_village_update'=>'required',
            'postal_code_update'=>'required',
          
        ],[
            'office_name.required'=>'Nama kantor tidak boleh kosong',
            'office_address_update.required'=>'Alamat kantor tidak boleh kosong',
            'office_type_update.required'=>'Tipe kantor tidak boleh kosong',
            'id_province_update.required'=>'Provinsi tidak boleh kosong',
            'id_regency_update.required'=>'Kabupaten tidak boleh kosong',
            'id_district_update.required'=>'Kecamatan tidak boleh kosong',
            'id_village_update.required'=>'Kelurahan tidak boleh kosong',
            'postal_code_update.required'=>'Kode pos tidak boleh kosong',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $city = DB::table('tbl_kabkot')->select('kabupaten_kota')->where('id',$id_regency_update)->first();
            $post =[
              'city'=>$city->kabupaten_kota,
              'name'=>$office_name_update,
              'office_type'=>$office_type_update,
              'address'=>$office_address_update,
              'id_prov'=>$id_province_update,
              'id_city'=>$id_regency_update,
              'id_district'=>$id_district_update,
              'id_village'=>$id_village_update,
              'postal_code'=>$postal_code_update,
            ];
            $insert = MasterKantor::find($request->office_id)->update($post);
            if($insert){
                $status=200;
                $message='Data successfully inserted';
            }
         
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
    public function get_kantor_name(Request $request)
    {
        $data =MasterKantor::where('flg_aktif', 1)->get();
        return response()->json([
            'data'=>$data
        ]);
    }
}
