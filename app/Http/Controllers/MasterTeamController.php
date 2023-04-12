<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\StoreMasterPriorityRequest;
use App\Http\Requests\StroeMasterTeamRequest;
use App\Http\Requests\UpdateMasterTeamRequest;
use App\Models\DetailTeam;
use App\Models\MasterTeam ;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class MasterTeamController extends Controller
{
    public function index()
    {
        return view('masterTeam.masterTeam-index');
    }
    public function getMasterTeam()
    {
        $data = MasterTeam::all();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function addMasterTeam(Request $request, StroeMasterTeamRequest $StroeMasterTeamRequest)
    {
        try {
            $StroeMasterTeamRequest->validated();
            $post =[
                'name'=>$request->teamName,
            ];
            MasterTeam::create($post);
            return ResponseFormatter::success(
                $post,
                'Team Project Name successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Team Project Name failed to add',
                500
            );
        }
    }
    public function getMasterTeamDetail(Request $request)
    {
        $detail             = MasterTeam::find($request->id);
        $table              = DetailTeam::select('users.name as username','detail_teams.*','master_departements.name as departementName','master_jabatan.name as jabatanName')
                                        ->join('users','users.id','detail_teams.userId')
                                        ->join('master_departements','master_departements.id','users.departement')
                                        ->join('master_jabatan','master_jabatan.id','users.jabatan')
                                        ->where('masterId',$request->id)
                                        ->orderBy('detail_teams.position', 'desc')
                                        ->get();
        $leader             = DetailTeam::select('users.name as username','users.id')->join('users','users.id','detail_teams.userId')->where('masterId',$request->id)->where('position',2)->first();
        return response()->json([
            'detail'=>$detail,
            'table'=>$table,
            'leader'=>$leader,
        ]);
    }
    public function updateMasterTeam(Request $request, UpdateMasterTeamRequest $updateMasterTeamRequest)
    { 
       
        // try {
            $updateMasterTeamRequest->validated();
            $post =[
                'name'=>$request->teamNameUpdate
            ];
            $update = DetailTeam ::where('masterId',$request->id)->where('userId',$request->leaderId)->update(['position'=>2]);
          
            if($update){
                MasterTeam::find($request->id)->update($post);
            }
            return ResponseFormatter::success(
               $post,
                'Priority successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Priority failed to update',
        //         500
        //     );
        // }
    }
    public function getDetailTeam(Request $request)
    {
        $active         =  User::select('users.name','users.id','master_departements.name as departementName','master_jabatan.name as jabatanName')
                                ->leftJoin('detail_teams', 'detail_teams.userId','users.id')
                                ->leftJoin('master_departements','master_departements.id','users.departement')
                                ->leftJoin('master_jabatan','master_jabatan.id','users.jabatan')
                                ->where('detail_teams.masterId',$request->id)
                                ->orderBy('users.departement','asc')
                                ->orderBy('users.jabatan','asc')
                                ->get();
        $innactive      =  User::select('users.name','users.id','master_departements.name as departementName','master_jabatan.name as jabatanName')
                                ->join('master_departements','master_departements.id','users.departement')
                                ->join('master_jabatan','master_jabatan.id','users.jabatan')
                                ->whereNotIn('users.id',DB::table('detail_teams')
                                ->select('userId')
                                ->where('masterId',$request->id))
                                ->orderBy('users.departement','asc')
                                ->orderBy('users.jabatan','asc')
                                ->get();
        $leaderOption   =  User::all();
        return response()->json([
            'active'=>$active,
            'innactive'=>$innactive,
            'leaderOption'=>$leaderOption,
        ]);
    }
    public function addDetailTeam(Request $request)
    {
        $status = 500;
        $message = 'Data failed to add';
        $userArray = $request->checkArray;
        $postArray =[];
        foreach($userArray as $row){
            $post=[
                'masterId'=>$request->id,
                'userId'=>$row,
                'position'=>1,
                'created_at'=>date('Y-m-d H:i:s')
            ];
            array_push($postArray, $post);
        } 
       
        $insert = DetailTeam::insert($postArray);
        if($insert){
            $status = 200;
            $message = 'Data successfully insert';
        }
        return response()->json([
            'message'=>$message,
            'status'=>$status,
        ]);
    }
    public function updateDetailTeam(Request $request)
    {
        $status = 500;
        $message = 'Data failed to add';
        $userArray = $request->checkArray;
        foreach($userArray as $row){
            $delete =DetailTeam::where('masterId', $request->id)->where('userId',$row)->delete();
            if($delete){
                $message="Data successfully update";
                $status=200;
            }
        } 
        return response()->json([
            'message'=>$message,
            'status'=>$status,
        ]);
    }
}
