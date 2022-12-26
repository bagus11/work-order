<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class SettingController extends Controller
{
   public function index(){
    return view('setting.setting-index');
   }
   public function update_user(Request $request)
    {
        $user_name = $request->user_name;
      
        $status =500;
        $message ='Data gagal disimpan';
        $validator = Validator::make($request->all(),[
            'user_name'=>['required'],
          
        ],[
            'user_name.required'=>'Password sekarang harus diisi',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $user = User::find(auth()->user()->id);
            $user->update(['name'=> $user_name]);
            if($user){
                $status =200;
                $message='Data berhasil disimpan';
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);

    }
    public function change_password(Request $request)
    {
        $current_password = $request->current_password;
        $new_password = $request->new_password;
        $confirm_passowrd = $request->confirm_passowrd;
        $status =500;
        $message ='Data gagal disimpan';
        $validator = Validator::make($request->all(),[
            'current_password'=>['required', new MatchOldPassword],
            'new_password' =>'required|min:8',
            'confirm_password'=>'same:new_password',
        ],[
         
            'current_password.required'=>'Password sekarang harus diisi',
            'new_password.required'=>'Password baru harus diisi',
            'new_password.min'=>'Password baru minimal 8 karakter',
            'confirm_password.same'=>'Password tidak sama dengan password baru',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $user = User::find(auth()->user()->id);
            $user->update(['password'=> Hash::make($new_password)]);
            if($user){
                $status =200;
                $message='Data berhasil disimpan';
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);

    }
}
