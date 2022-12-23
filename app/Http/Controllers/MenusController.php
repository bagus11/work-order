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
   public function getDetailMenus(Request $request)
   {
        $detail = Menus::find($request->id);
        return response()->json([
            'detail'=>$detail
        ]);
   }
   public function update_menus(Request $request)
   {
    $menus_name_update = $request->menus_name_update;
    $menus_icon_update = $request->menus_icon_update;
    $menus_description_update = $request->menus_description_update;
    $status =500;
    $message='';
    $validator = Validator::make($request->all(),[
        'menus_name_update'=>'required',
        'menus_icon_update'=>'required',
        'menus_description_update'=>'required',
    ],[
        'menus_name_update.required'=>'Nama Menu tidak boleh kosong',
        'menus_icon_update.required'=>'Icon Menu tidak boleh kosong',
        'menus_description_update.required'=>'Deskripsi Menu tidak boleh kosong',
    ]);
    if($validator->fails()){
        return response()->json([
            'message'=>$validator->errors(), 
            'status'=>422,
          
        ]);
    }else{
        $status_menus = $request->status;
        $post=[
            'name'=>$menus_name_update,
            'description'=>$menus_description_update,
            'status'=>$status_menus,
            'icon'=>$menus_icon_update,
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        
        $update = Menus::where('id', $request->id_menus_update)->update($post);
        if($update){
            $status =200;
            $message='Data telah tersimpan';
        }else{
            $message='Gagal disimpan';
        }
    }
    return response()->json([
        'status'=>$status,
        'message'=>$message
    ]);
   }
   public function deleteMenus(Request $request)
   {
        $status =500;
        $message ='Data gagal dihapus';
        $delete = Menus::find($request->id);
        $delete->delete();
        if($delete){
            $status=200;
            $message='Data berhasil dihapus';
        }
        return response()->json([
            'message'=>$message,
            'status'=>$status
        ]);
   }
   
}
