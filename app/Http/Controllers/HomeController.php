<?php

namespace App\Http\Controllers;

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
            $status_on_progress = WorkOrder::select(DB::raw('COUNT(id) as status_on_progress'))->where('status_wo', 1)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
            $status_pending = WorkOrder::select(DB::raw('COUNT(id) as status_pending'))->where('status_wo', 2)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
            $status_revision = WorkOrder::select(DB::raw('COUNT(id) as status_revision'))->where('status_wo', 3)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
            $status_done = WorkOrder::select(DB::raw('COUNT(id) as status_done'))->where('status_wo', 4)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
            $status_reject = WorkOrder::select(DB::raw('COUNT(id) as status_reject'))->where('status_wo', 5)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])->first();
        }else{
            $status_new = WorkOrder::select(DB::raw('COUNT(id) as status_new'))->where('status_wo', 0)
            ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
            ->where(function($query){
                $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
            })->first();
            $status_on_progress = WorkOrder::select(DB::raw('COUNT(id) as status_on_progress'))->where('status_wo', 1)
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
            ->where(function($query){
                $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
            })->first();
            $status_reject = WorkOrder::select(DB::raw('COUNT(id) as status_reject'))->where('status_wo', 5)
            ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
            ->where(function($query){
                $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
            })->first();

            // Trackijng History
        
        }
   
        return response()->json([
            'status_new'=>$status_new,
            'status_on_progress'=>$status_on_progress,
            'status_pending'=>$status_pending,
            'status_revision'=>$status_revision,
            'status_done'=>$status_done,
            'status_reject'=>$status_reject,
        ]);
    }
}
