<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterRoomRequest;
use App\Http\Requests\UpdateMAasterRoomRequest;
use App\Models\Setting\MasterRoom;
use Illuminate\Http\Request;

class MasterRoomController extends Controller
{
    function index(){
        return  view('master_room.master_room-index');
    }

    function getRoom() {
        $data = MasterRoom::with('locationRelation')->get();
        return response()->json([
            'data' => $data
        ]);
    }

    function addRoom(Request $request, StoreMasterRoomRequest $storeMasterRoomRequest ) {
           try {
         
            $storeMasterRoomRequest->validated();
            $post = [
                'name' => $request->name,
                'location_id' => $request->location_id,
            ];
            MasterRoom::create($post);
                return ResponseFormatter::success(   
                    $post,                              
                    'Room successfully created'
                );            
        }catch (\Throwable $th) {
              return ResponseFormatter::error(
                  $th,
                  'Approval failed to create',
                  500
              );
        }
        
    }
    function updateRoom(Request $request, UpdateMAasterRoomRequest $storeMasterRoomRequest ) {
        //    try {
         
            $storeMasterRoomRequest->validated();
            $post = [
                'name' => $request->name,
                'location_id' => $request->location_id,
            ];
            MasterRoom::find($request->id)->update($post);
                return ResponseFormatter::success(   
                    $post,                              
                    'Room successfully updated'
                );            
        // }catch (\Throwable $th) {
        //       return ResponseFormatter::error(
        //           $th,
        //           'Room failed to update',
        //           500
        //       );
        // }
        
    }
}
