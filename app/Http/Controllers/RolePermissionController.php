<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class RolePermissionController extends Controller
{
    public function index()
    {
        return view('role_permission.role_permission-index');
    }
    public function get_role()
    {
        $data = Role::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function get_permission()
    {
        $data = Permission::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    public function save_role(Request $request)
    {
        $roles_name = $request->roles_name;
        $status=500;
        $message="Data Gagal disimpan";
        $validator = Validator::make($request->all(),[
            'roles_name'=>'required|unique:roles,name',
        ],[
            'roles_name.required'=>'Nama Role tidak boleh kosong',
            'roles_name.unique'=>'Nama Role sudah ada',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$roles_name,
                'guard_name'=>'web',
            ];
            $insert = Role::create($post);
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
    public function getDetailRoles(Request $request)
    {
        $detail = Role::find($request->id);
        return response()->json([
            'detail'=>$detail,
        ]);
    }
    public function update_role(Request $request)
    {
        $id = $request->roles_id;
        $roles_name_update = $request->roles_name_update;
        $status =500;
        $message ='';
        $validator = Validator::make($request->all(),[
            'roles_name_update'=>'required|unique:roles,name',
        ],[
            'roles_name_update.required'=>'Nama Role tidak boleh kosong',
            'roles_name_update.unique'=>'Nama Role sudah ada',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$roles_name_update,
                'guard_name'=>'web',
            ];
            $update =Role::where('id', $id)->update($post);
            if($update){
                $status=200;
                $message="Data berhasil disimpan";
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
    public function delete_role(Request $request)
    {
        $status = 500;
        $message = 'Data gagal dihapus, harap hubungi ICT Dev';
        $delete = Role::find($request->id)->delete();
        if($delete){
            $status =200;
            $message ='Data berhasil dihapus';
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
    public function permission_menus_name(){
        $data = DB::table('view_menus')
                    ->select('*')
                    ->get();
        return response()->json([
            'menus_name'=>$data,
        ]);
    
    }
    public function save_permission(Request $request)
    {
        $permission_name = $request->permission_name;
        $status=500;
        $message="Data Gagal disimpan";
        $validator = Validator::make($request->all(),[
            'permission_name'=>'required|unique:permissions,name',
        ],[
            'permission_name.required'=>'Permission tidak boleh kosong',
            'permission_name.unique'=>'Permission sudah ada',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$permission_name,
                'guard_name'=>'web',
            ];
         
            $insert = Permission::create($post);
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
    public function delete_permission(Request $request)
    {
        $status =200;
        $message ='Data gagal dihapus';
        $delete = Permission::find($request->id);
        $delete->delete();
        if($delete){
            $message ="Data berhasil dihapus";
            $status =200;
        }
          return response()->json([
            'message'=>$message,
            'status'=>$status,
        ]);
    }
}
