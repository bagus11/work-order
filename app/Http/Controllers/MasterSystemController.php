<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\MasterSystem;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class MasterSystemController extends Controller
{
    function index(){
        return view('master_system.master_system-index');
    }
    function getSystem(){
        $data = MasterSystem::with([
            'moduleRelation',
            'moduleRelation.aspekRelation',
        ])->get();
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $data
        ]);
    }
    function systemFilter(Request $request){
        $data = MasterSystem::where('module_id', $request->module)->get();
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $data
        ]);
    }
    function addSystem(Request $request){
        try {
            $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'module' => 'nullable|integer',
            ]);
            MasterSystem::create([
                'name' => $request->name,
                'module_id' => $request->module,
                'description' => $request->description,
                'status' =>1
            ]);
                return ResponseFormatter::success(   
                    '',                              
                    'System successfully created'
                );            
        }catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'System failed to create',
                500
            );
        }
       
    }
    function updateSystem(Request $request){
        try {
            $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_description' => 'nullable|string',
            'edit_module' => 'nullable|integer',
            ]);
           
           $update =  MasterSystem::find($request->id)->update([
                'name' => $request->edit_name,
                'description' => $request->edit_description,
                'module_id' => $request->edit_module,
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
