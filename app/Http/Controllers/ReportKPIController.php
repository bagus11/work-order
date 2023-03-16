<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WOCounting;
use App\Models\WorkOrder;
use App\Models\WorkOrderLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportKPIController extends Controller
{
    public function index()
    {
        return view('reportKPI.reportKPI-index');
    }
    public function getKPIUser()
    {
        $data = User::with('Departement','Jabatan')
                    ->where('id','!=',auth()->user()->id)
                    ->where('departement', auth()->user()->departement)
                    ->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function getKPIUserDetail(Request $request)
    {
        $date = Carbon::createFromFormat('Y-m-d', $request->dateFilter.'-01')
        ->endOfMonth();
        $user           = User::with('Departement','Jabatan')->find($request->id);
        $data           = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalWO'),'master_kantor.name as officeName')
                                    ->join('users','work_orders.user_id','users.id')
                                    ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                    ->where('work_orders.user_id_support',$request->id)
                                    ->where('work_orders.status_wo','!=',5)
                                    ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->dateFilter.'-01', $date])
                                    ->groupBy('master_kantor.id')
                                    ->get();
        $percentage     = WorkOrder::select(DB::raw('COUNT(work_orders.category) as count'),'work_orders.problem_type','master_categories.name as problemName')
                                    ->join('master_categories','master_categories.id','=','work_orders.category')
                                    ->where('user_id_support', $request->id) 
                                    ->where('work_orders.status_wo','!=',5)
                                    ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->dateFilter.'-01', $date])
                                    ->groupBy('work_orders.category')
                                    ->get();
        $result           = WOCounting::where('user_id',$request->id)
                                    ->whereBetween(DB::raw('DATE(created_at)'), [$request->dateFilter.'-01', $date])
                                    ->first();
        $level2           = WorkOrder::select(DB::raw('COUNT(work_orders.id) as count'),DB::raw('SUM(work_orders.duration) as totalDuration'))
                                    ->join('work_order_logs','work_orders.request_code','work_order_logs.request_code')
                                    ->where('work_order_logs.status_wo', 2)
                                    ->groupBy('work_orders.request_code')
                                    ->first();

        return response()->json([
            'data'=>$data,
            'result'=>$result,
            'user'=>$user,
            'level2'=>$level2,
            'percentage'=>$percentage
        ]);
    }
}
