<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\masterModule;
use Illuminate\Http\Request;

class MasterModuleController extends Controller
{
    function index(){
        return view('master_module.master_module-index');
    }
     function getModule(){
        $data = masterModule::with([
            'aspekRelation',
        ])->get();
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $data
        ]);
    }
    
     function moduleFilter(Request $request){
        $data = masterModule::where('aspek', $request->aspect)->get();
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $data
        ]);
    }

    function addModule(Request $request){
        try {
            $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'aspek_id' => 'nullable|integer',
            ]);
            masterModule::create([
                'name' => $request->name,
                'aspek' => $request->aspek_id,
                'description' => $request->description,
                'status' =>1
            ]);
                return ResponseFormatter::success(   
                    '',                              
                    'Module successfully created'
                );            
        }catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'System failed to create',
                500
            );
        }
       
    }
    function updateModule(Request $request){
        try {
            $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_description' => 'nullable|string',
            'edit_aspek_id' => 'nullable|integer',
            ]);
            masterModule::find($request->id)->update([
                'name' => $request->edit_name,
                'aspek' => $request->edit_aspek_id,
                'description' => $request->edit_description,
            ]);
                return ResponseFormatter::success(   
                    '',                              
                    'System successfully updated'
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
