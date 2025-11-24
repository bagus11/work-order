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
        $intervalDate                           =\Carbon\Carbon::today()->subMonth()->format('Y-m-d');
        $intervalLastDay                        =\Carbon\Carbon::createFromFormat('Y-m-d', $intervalDate)
                                                    ->endOfMonth()
                                                    ->format('Y-m-d');
        $requestFor                             = WorkOrder::whereBetween(DB::raw('DATE(created_at)'), [date('Y-m').'-01', date('Y-m-d')])->groupBy('request_for')->get();
        for($k = 0; $k < count($requestFor); $k ++){
            $departementId                      = MasterDepartement :: where('initial', $requestFor[$k]->request_for)->first();
            $mappingUser                        = User :: where('departement', $departementId->id)->get();
                for($i = 0; $i < count($mappingUser); $i++){
                    $woCounting                 = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalWO'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.id as officeId','work_orders.category')
                                                    ->join('users','users.id','work_orders.user_id_support')
                                                    ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                    ->where('work_orders.user_id_support',$mappingUser[$i]->id)
                                                    ->where('work_orders.status_wo','!=', 5)
                                                    ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [date('Y-m').'-01', date('Y-m-d')])
                                                    ->groupBy('work_orders.user_id_support')
                                                    ->groupBy('master_kantor.id')
                                                    ->groupBy('work_orders.category')
                                                    ->groupBy('work_orders.level')
                                                    ->get();
                    $woDone                     = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalDone'),'level',DB::raw('SUM(work_orders.duration) as totalDuration'),'work_orders.request_for','user_id_support','work_orders.request_for','master_kantor.name','work_orders.category')
                                                    ->join('users','users.id','work_orders.user_id_support')
                                                    ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                                    ->where('work_orders.user_id_support',$mappingUser[$i]->id)
                                                    ->where('work_orders.status_wo', 4)
                                                    ->where('work_orders.status_approval', 1)
                                                    ->whereBetween(DB::raw('DATE(work_orders.updated_at)'), [date('Y-m').'-01', date('Y-m-d')])
                                                    ->groupBy('work_orders.user_id_support')
                                                    ->groupBy('master_kantor.id')
                                                    ->groupBy('work_orders.category')
                                                    ->groupBy('work_orders.level')
                                                    ->get();

                    $intervalMonthBefore        = WOCounting::where(DB::raw('DATE(created_at)'),$intervalLastDay)
                                                    ->where('user_id', $mappingUser[$i]->id)
                                                    ->groupBy('user_id')
                                                    ->groupBy('officeId')
                                                    ->groupBy('categories')
                                                    ->groupBy('level')
                                                    ->get();
                  
                            for($j=0; $j < count($woCounting); $j ++){
                      
                                $woTotal                =   $woCounting[$j] == null ? 0 : $woCounting[$j]->totalWO;
                                $CountingwoDone         =   $woDone[$j]->totalDone ?? 0;

                                $woLv1                  =   $woCounting[$j]->totalDuration ?? 0;
                                $unfinished             =  isset( $intervalMonthBefore[$j]) ? $intervalMonthBefore[$j]['unfinished'] : 0 ;
                                $post                   = [
                                                            'user_id'       => $mappingUser[$i]->id,
                                                            'level'         => $woCounting[$j]->level,
                                                            'done'          => $CountingwoDone,
                                                            'unfinished'    => $woTotal - $CountingwoDone < 0 ?  ($woTotal - $CountingwoDone)*-1 : $woTotal - $CountingwoDone,
                                                            'wo_total'      =>  $unfinished +  $woCounting[$j]->totalWO,
                                                            'request_for'   => $requestFor[$k]->request_for,
                                                            'duration_lv2'  => 0,
                                                            'duration'      => $woLv1 ,
                                                            'created_at'    =>  date('Y-m-d H:i:s'),
                                                            'officeId'      => $woCounting[$j]->officeId,
                                                            'categories'    => $woCounting[$j]->category,
                                                        ];
                                                        
                                                        array_push($arrayPost, $post);
                            }
                         
                       
                }
        }
        WOCounting::insert($arrayPost);
        Log::info('Cron is running successfully');
    }
}
