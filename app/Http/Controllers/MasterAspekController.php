<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\MasterAspek;
use Illuminate\Http\Request;

class MasterAspekController extends Controller
{
     function index(){
        return view('master_aspek.master_aspek-index');
    }
     function getAspek(){
        $data = MasterAspek::all();
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $data
        ]);
    }
    
    function addAspek(Request $request){
        try {
            $request->validate([
            'name' => 'required|string|max:255',
            ]);
            MasterAspek::create([
                'name' => $request->name,
            ]);
                return ResponseFormatter::success(   
                    '',                              
                    'Aspek successfully created'
                );            
        }catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'System failed to create',
                500
            );
        }
       
    }
    function updateAspek(Request $request){
        try {
            $request->validate([
            'edit_name' => 'required|string|max:255',
            ]);
            MasterAspek::find($request->id)->update([
                'name' => $request->edit_name,
            ]);
                return ResponseFormatter::success(   
                    '',                              
                    'Aspek successfully updated'
                );            
        }catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'System failed to create',
                500
            );
        }
       
    }
}
