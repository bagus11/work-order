<?php

namespace App\Console\Commands;

use App\Models\MasterDepartement;
use App\Models\User;
use App\Models\WOCounting;
use App\Models\WorkOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CountingWOMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arrayPost =[];
        $requestFor = WorkOrder::whereBetween(DB::raw('DATE(created_at)'), [date('Y-m').'-01', date('Y-m-d')])->groupBy('request_for')->get();
        for($i = 0; $i < count($requestFor); $i ++){
            $departementId = MasterDepartement :: where('initial', $requestFor[$i]->request_for)->first();
            $user = User:: where('departement', $departementId->id)->get();
            for($j = 0; $j < count($user);  $j++){
                $WorkOrderCounting  = WorkOrder::select(DB::raw('COUNT(id) as totalWO'),DB::raw('SUM(duration) as totalDuration'),'request_for','user_id_support','request_for')
                                                ->whereBetween(DB::raw('DATE(created_at)'), [date('Y-m').'-01', date('Y-m-d')])
                                                ->where('status_wo','!=', 5)
                                                ->where('user_id_support', $user[$j]->id)
                                                ->groupBy('user_id_support')
                                                ->first();
                $WorkOrderDone      = WorkOrder::select(DB::raw('COUNT(id) as totalDone'),'request_for')
                                                ->whereBetween(DB::raw('DATE(created_at)'), [date('Y-m').'-01', date('Y-m-d')])
                                                ->where('status_wo',4)
                                                ->where('status_approval',1)
                                                ->where('user_id_support', $user[$j]->id)
                                                ->groupBy('user_id_support')
                                                ->first();
                $WorkOrderLevel2    = WorkOrder::select(DB::raw('SUM(work_orders.duration) as level2'),'work_orders.user_id_support')
                                                ->join('work_order_logs','work_orders.request_code','work_order_logs.request_code')
                                                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [date('Y-m').'-01', date('Y-m-d')])
                                                ->where('work_orders.status_wo','!=', 5)
                                                ->where('work_order_logs.status_wo',2)
                                                ->where('work_orders.user_id_support', $user[$j]->id)
                                                ->groupBy('work_orders.user_id_support')
                                                ->first();
                $intervalDate       = \Carbon\Carbon::today()->subMonth()->format('Y-m-d');
                $intervalLastDay    = \Carbon\Carbon::createFromFormat('Y-m-d', $intervalDate)
                                                    ->endOfMonth()
                                                    ->format('Y-m-d');
                $interval           = WOCounting::where(DB::raw('DATE(created_at)'),$intervalLastDay)->where('user_id', $user[$j]->id)->first();
                $woTotal = $WorkOrderCounting == null ? 0 : $WorkOrderCounting->totalWO;
                $unfinishedBefore = $interval == null ? 0 : $interval->unfinished; 
                $woDone = $WorkOrderDone == null ? 0 : $WorkOrderDone->totalDone;
                $woLv2 = $WorkOrderLevel2 == null ? 0 : $WorkOrderLevel2->level2;
                $woLv1 = $WorkOrderCounting == null ? 0 : $WorkOrderCounting->totalDuration;
                $post = [
                    'user_id'=>$user[$j]->id,
                    'done'=>$woDone,
                    'unfinished'=>$woTotal - $woDone,
                    'request_for'=>$requestFor[$i]->request_for,
                    'wo_total'=> $unfinishedBefore +  $woTotal,
                    'duration_lv2'=>$woLv2,
                    'duration'=>$woLv1 - $woLv2,
                    'created_at'=> date('Y-m-d H:i:s')
                ];
                array_push($arrayPost,$post);
            }
        }
        WOCounting::insert($arrayPost);
        Log::info('Cron is running successfully');
    }
}
