<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\Submenu;
use CreateSubmenusTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
class MenusController extends Controller
{
   public function index()
   {
    return view('menus.menus-index');
   }
   public function get_menus(Request $request)
   {
        $data = Menus::all();
        return response()->json([
            'data'=>$data
        ]);
   }
   public function save_menus(Request $request)
   {
        $menus_name = $request->menus_name;
        $menus_icon = $request->menus_icon;
        $menus_link = $request->menus_link;
        $menus_type = $request->menus_type;
        $menus_description = $request->menus_description;
        $status =500;
        $message ='Data gagal disimpan';
        $validator = Validator::make($request->all(),[
            'menus_name'=>'required|unique:menus,name',
            'menus_link'=>'required|unique:menus,link',
            'menus_type'=>'required',
            'menus_icon'=>'required',
            'menus_description'=>'required',
        ],[
            'menus_name.required'=>'Nama Menu tidak boleh kosong',
            'menus_name.unique'=>'Nama Menu sudah ada',
            'menus_type.required'=>'Tipe Menu tidak boleh kosong',
            'menus_icon.required'=>'Icon Menu tidak boleh kosong',
            'menus_link.required'=>'Link Menu tidak boleh kosong',
            'menus_link.unique'=>'Link Menu sudah ada',
            'menus_description.required'=>'Deskripsi Menu tidak boleh kosong',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post =[
                'name'=>$menus_name,
                'link'=>$menus_type == 1?$menus_link:'',
                'icon'=>$menus_icon,
                'description'=>$menus_description,
                'type'=>$menus_type,
                'status'=>0,
                'permission_name'=>'view-'.$menus_link,
            ];
            $insert = Menus::create($post);
            if($insert){
                $status =200;
                $message ='Data berhasil disimpan';
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
   }
   public function get_menus_name()
   {
        $data = Menus::where('status', 1)->where('type',2)->get();
        return response()->json([
            'data'=>$data
        ]);
   }
   public function save_submenus(Request $request)
   {
        $submenus_name = $request->submenus_name;
        $submenus_link = $request->submenus_link;
        $menus_id = $request->menus_id;
        $submenus_description = $request->submenus_description;
        $status =500;
        $message ='Data gagal disimpan';
        $validator = Validator::make($request->all(),[
            'submenus_name'=>'required|unique:menus,name',
            'submenus_link'=>'required|unique:menus,link',
            'menus_id'=>'required',
            'submenus_description'=>'required',
        ],[
            'submenus_name.required'=>'Nama Menu tidak boleh kosong',
            'submenus_name.unique'=>'Nama Menu sudah ada',
            'menus_id.required'=>'Tipe Menu tidak boleh kosong',
            'submenus_link.required'=>'Link Menu tidak boleh kosong',
            'submenus_link.unique'=>'Link Menu sudah ada',
            'submenus_description.required'=>'Deskripsi Menu tidak boleh kosong',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post =[
                'name'=>$submenus_name,
                'link'=>$submenus_link,
                'description'=>$submenus_description,
                'id_menus'=>$menus_id,
                'status'=>0,
                'permission_name'=>'view-'.$submenus_link,
            ];
            $insert = Submenu::create($post);
            if($insert){
                $status =200;
                $message ='Data berhasil disimpan';
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
   }
   public function get_submenus()
   {
    $data = Submenu::all();
    return response()->json([
        'data'=>$data
    ]);
   }
   
}
