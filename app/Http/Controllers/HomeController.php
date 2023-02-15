<?php

namespace App\Http\Controllers;

use App\Models\MasterJabatan;
use App\Models\WONotification;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.home');
    }
    public function get_wo_summary(Request $request)
    {
        $from_date = $request->from_date;
        $end_date = $request->end_date;
        if(auth()->user()->hasPermissionTo('get-all-dashboard'))
        {
            $status_new = WorkOrder::select(DB::raw('COUNT(id) as status_new'))->where('status_wo', 0)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
            $status_on_progress = WorkOrder::select(DB::raw('COUNT(id) as status_on_progress'))->whereIn('status_wo', [1,4])->where('status_approval',0)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
            $status_pending = WorkOrder::select(DB::raw('COUNT(id) as status_pending'))->where('status_wo', 2)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
            $status_revision = WorkOrder::select(DB::raw('COUNT(id) as status_revision'))->where('status_wo', 3)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
            $status_done = WorkOrder::select(DB::raw('COUNT(id) as status_done'))->where('status_wo', 4)->where('status_approval', 1)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
            $status_reject = WorkOrder::select(DB::raw('COUNT(id) as status_reject'))->where('status_wo', 5)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
            $ratingUser = WorkOrder::select(DB::raw('AVG(rating) as rating'), DB::raw('COUNT(rating) as total'))->where('status_wo', 4)
            ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
            ->where(function($query){
                $query->where('user_id_support', auth()->user()->id)
                ->where('status_approval', 1); 
            })->first();
            $classementPIC = DB::table('work_orders')->select(DB::raw('AVG(work_orders.rating) as classement'),'users.name')
            ->join('users','users.id','=','work_orders.user_id_support')
            ->groupBy('work_orders.user_id_support')
            ->where('status_approval',1)
            ->orderBy('classement','desc')
            ->get();
            $jabatanUser= MasterJabatan::find(auth()->user()->jabatan);
        }else{
            $status_new = WorkOrder::select(DB::raw('COUNT(id) as status_new'))->where('status_wo', 0)
            ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
            ->where(function($query){
                $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
            })->first();
            $status_on_progress = WorkOrder::select(DB::raw('COUNT(id) as status_on_progress'))->whereIn('status_wo', [1,4])->where('status_approval',0)
            ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
            ->where(function($query){
                $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
            })->first();
            $status_pending = WorkOrder::select(DB::raw('COUNT(id) as status_pending'))->where('status_wo', 2)
            ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
            ->where(function($query){
                $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
            })->first();
            $status_revision = WorkOrder::select(DB::raw('COUNT(id) as status_revision'))->where('status_wo', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
            ->where(function($query){
                $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
            })->first();
            $status_done = WorkOrder::select(DB::raw('COUNT(id) as status_done'))->where('status_wo', 4)
            ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
            ->where('status_approval', 1)
            ->where(function($query){
                $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
            })->first();
            $status_reject = WorkOrder::select(DB::raw('COUNT(id) as status_reject'))->where('status_wo', 5)
            ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
            ->where(function($query){
                $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
            })->first();
            $classementPIC="";

            // Trackijng History
        
            // Rating User
            $ratingUser = WorkOrder::select(DB::raw('AVG(rating) as rating'), DB::raw('COUNT(rating) as total'))
            ->where('status_wo', 4)
            ->where('status_approval',1)
            ->where('user_id_support', auth()->user()->id)
            // ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
            ->first();
            $jabatanUser= MasterJabatan::find(auth()->user()->jabatan);

        }
   
        return response()->json([
            'status_new'=>$status_new,
            'status_on_progress'=>$status_on_progress,
            'status_pending'=>$status_pending,
            'status_revision'=>$status_revision,
            'status_done'=>$status_done,
            'status_reject'=>$status_reject,
            'ratingUser'=>$ratingUser,
            'classementPIC'=>$classementPIC,
            'jabatan'=>$jabatanUser->name,
        ]);
    }
    public function logRating(Request $request)
    {
        $data = WorkOrder::select( DB::raw('DATE(created_at) as date'),'request_code','rating')
                            ->where('status_wo',4)
                            ->where('user_id_support', auth()->user()->id)
                            ->where('status_approval',1)
                            ->orderBy('created_at','desc')
                            ->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function getNotification(){
        $data  = WONotification::select((DB::raw('DATE_FORMAT(created_at, "%H:%i") as time')),(DB::raw('DATE_FORMAT(created_at, "%d %M") as date')),'link','subject','message','status')
                                ->where('userId',auth()->user()->id)
                                ->limit(10)
                                ->orderBy('id', 'desc')
                                ->get();
        $countStatus  = WONotification::select(DB::raw('COUNT(id) as new'))->where('userId',auth()->user()->id)->where('status',0)->first();
      
        return response()->json([
            'data'=>$data,
            'countStatus'=>$countStatus,
        ]);
    }
    public function updateNotif()
    {
        $post=[
            'status'=>1
        ];
        $data = WONotification::where('userId',auth()->user()->id)->update($post);

        return response()->json([
            'data'=>$data,
        ]);
    }
}
