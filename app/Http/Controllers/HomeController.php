<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartement;
use App\Models\MasterJabatan;
use App\Models\User;
use App\Models\WOCounting;
use App\Models\WONotification;
use App\Models\WorkOrder;
use Carbon\Carbon;
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
        $userDepartement = MasterDepartement::find(auth()->user()->departement);
        if(auth()->user()->hasPermissionTo('get-all-dashboard'))
        {
            $status_new             = WorkOrder::select(DB::raw('COUNT(id) as status_new'))
                                        ->where('status_wo', 0)
                                        ->where('request_for',$userDepartement->initial)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->first();
            $status_on_progress     = WorkOrder::select(DB::raw('COUNT(id) as status_on_progress'))
                                        ->whereIn('status_wo', [1,4])->where('status_approval',0)
                                        ->where('request_for',$userDepartement->initial)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->first();
            $status_pending         = WorkOrder::select(DB::raw('COUNT(id) as status_pending'))
                                        ->where('status_wo', 2)
                                        ->where('request_for',$userDepartement->initial)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->first();
            $status_revision        = WorkOrder::select(DB::raw('COUNT(id) as status_revision'))
                                        ->where('status_wo', 3)
                                        ->where('request_for',$userDepartement->initial)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->first();
            $status_done            = WorkOrder::select(DB::raw('COUNT(id) as status_done'))
                                        ->where('status_wo', 4)
                                        ->where('status_approval', 1)
                                        ->where('transfer_pic', 0)
                                        ->where('request_for',$userDepartement->initial)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->first();
            $status_checking        = WorkOrder::select(DB::raw('COUNT(id) as status_checking'))
                                        ->where('status_wo', 4)
                                        ->where('status_approval', 2)
                                        ->where('request_for',$userDepartement->initial)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->first();
            $ratingUser             = WorkOrder::select(DB::raw('AVG(rating) as rating'), DB::raw('COUNT(rating) as total'))
                                        ->where('status_wo', 4)
                                        ->where('request_for',$userDepartement->initial)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->where(function($query){
                                            $query->where('user_id_support', auth()->user()->id)
                                            ->where('status_approval', 1); 
                                        })->first();

            $classementPIC          = DB::table('work_orders')->select(DB::raw('AVG(work_orders.rating) as classement'),'users.name',DB::raw('COUNT(work_orders.rating) as count'),DB::raw('AVG(work_orders.duration) as duration'))
                                        ->join('users','users.id','=','work_orders.user_id_support')
                                        ->groupBy('work_orders.user_id_support')
                                        ->where('status_approval',1)
                                        ->where('request_for',$userDepartement->initial)
                                        ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$from_date, $end_date])
                                        ->orderBy('classement','desc')
                                        ->orderBy('count','desc')
                                        ->get();

            $jabatanUser            = MasterJabatan::find(auth()->user()->jabatan);

            $ticketLevel2           = WorkOrder::with(['categoryName','departementName','problemTypeName','picSupportName'])
                                                ->where([
                                                    'status_wo' =>4,
                                                    'level'     =>2
                                                    ])->get();
        }else{
            $requestFor             = MasterDepartement::find(auth()->user()->departement);
            $status_new             = WorkOrder::select(DB::raw('COUNT(id) as status_new'))->where('status_wo', 0)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->where(function($query) use($requestFor){
                                            $query->where('user_id', auth()->user()->id)
                                            ->orWhere('request_for', $requestFor->initial); 
                                        })->first();
            $status_on_progress     = WorkOrder::select(DB::raw('COUNT(id) as status_on_progress'))
                                        ->whereIn('status_wo', [1,4])->where('status_approval',0)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->where(function($query){
                                            $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
                                        })->first();
            $status_pending         = WorkOrder::select(DB::raw('COUNT(id) as status_pending'))
                                        ->where('status_wo', 2)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->where(function($query){
                                            $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
                                        })->first();
            $status_revision        = WorkOrder::select(DB::raw('COUNT(id) as status_revision'))
                                        ->where('status_wo', 3)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->where(function($query){
                                            $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
                                        })->first();
            $status_done            = WorkOrder::select(DB::raw('COUNT(id) as status_done'))
                                        ->where('status_wo', 4)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->where('status_approval', 1)
                                        ->where(function($query){
                                            $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
                                        })->first();
            $status_checking        = WorkOrder::select(DB::raw('COUNT(id) as status_checking'))
                                        ->where('status_wo', 4)
                                        ->where('status_approval', 2)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->where(function($query){
                                            $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
                                        })->first();
            $classementPIC="";

            // Trackijng History
        
            // Rating User
            $ratingUser             = WorkOrder::select(DB::raw('AVG(rating) as rating'), DB::raw('COUNT(rating) as total'))
                                        ->where('status_wo', 4)
                                        ->where('status_approval',1)
                                        ->where('user_id_support', auth()->user()->id)
                                        // ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $end_date])
                                        ->first();
            $jabatanUser            = MasterJabatan::find(auth()->user()->jabatan);

            $ticketLevel2           = '';

        }  
        return response()->json([
            'status_new'=>$status_new,
            'status_on_progress'=>$status_on_progress,
            'status_pending'=>$status_pending,
            'status_revision'=>$status_revision,
            'status_done'=>$status_done,
            'status_checking'=>$status_checking,
            'ratingUser'=>$ratingUser,
            'classementPIC'=>$classementPIC,
            'jabatan'=>$jabatanUser->name,
            'ticketLevel2'=>$ticketLevel2,
        ]);
    }
    public function logRating(Request $request)
    {
     
        if($request->selectFilter == 2){
            $date = Carbon::createFromFormat('Y-m-d', $request->filter.'-01')
            ->endOfMonth()
            ->format('Y-m-d');
            $data = WorkOrder::select( DB::raw('DATE(created_at) as date'),'request_code','rating','duration')
            ->where('status_wo',4)
            ->where('user_id_support', auth()->user()->id)
            ->where('status_approval',1)
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->filter.'-01', $date])
            ->orderBy('created_at','desc')
            ->get();

            $ratingUser = WorkOrder::select(DB::raw('AVG(rating) as rating'), DB::raw('COUNT(rating) as total'))
            ->where('status_wo', 4)
            ->where('status_approval',1)
            ->where('user_id_support', auth()->user()->id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->filter.'-01', $date])
            ->first();
        }else if($request->selectFilter == 3){
            $data = WorkOrder::select( DB::raw('DATE(created_at) as date'),'request_code','rating','duration')
            ->where('status_wo',4)
            ->where('user_id_support', auth()->user()->id)
            ->where('status_approval',1)
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->filter.'-01-01', $request->filter.'-12-31'])
            ->orderBy('created_at','desc')
            ->get();
            $ratingUser = WorkOrder::select(DB::raw('AVG(rating) as rating'), DB::raw('COUNT(rating) as total'))
            ->where('status_wo', 4)
            ->where('status_approval',1)
            ->where('user_id_support', auth()->user()->id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->filter.'-01-01', $request->filter.'-12-31'])
            ->first();
        }
        else{
            $data = WorkOrder::select( DB::raw('DATE(created_at) as date'),'request_code','rating','duration')
            ->where('status_wo',4)
            ->where('user_id_support', auth()->user()->id)
            ->where('status_approval',1)
            ->orderBy('created_at','desc')
            ->get();
            $ratingUser = WorkOrder::select(DB::raw('AVG(rating) as rating'), DB::raw('COUNT(rating) as total'))
            ->where('status_wo', 4)
            ->where('status_approval',1)
            ->where('user_id_support', auth()->user()->id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->filter.'-01-01', $request->filter.'-12-31'])
            ->first();
        }
        return response()->json([
            'data'=>$data,
            'ratingUser'=>$ratingUser,
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
    public function getRankingFilter(Request $request)
    {
        $userDepartement = MasterDepartement::find(auth()->user()->departement);
        if($request->selectFilter == 2){
            $date = Carbon::createFromFormat('Y-m-d', $request->filter.'-01')
                            ->endOfMonth()
                            ->format('Y-m-d');
            $classementPIC = DB::table('work_orders')->select(DB::raw('AVG(work_orders.rating) as classement'),'users.name',DB::raw('COUNT(work_orders.rating) as count'),DB::raw('AVG(work_orders.duration) as duration'))
                                    ->join('users','users.id','=','work_orders.user_id_support')
                                    ->groupBy('work_orders.user_id_support')
                                    ->where('status_approval',1)
                                    ->where('request_for',$userDepartement->initial)
                                    ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->filter.'-01', $date])
                                    ->orderBy('classement','desc')
                                    ->orderBy('count','desc')
                                    ->get();
        }
        else if($request->selectFilter == 3){
            $classementPIC = DB::table('work_orders')->select(DB::raw('AVG(work_orders.rating) as classement'),'users.name',DB::raw('COUNT(work_orders.rating) as count'),DB::raw('AVG(work_orders.duration) as duration'))
                                    ->join('users','users.id','=','work_orders.user_id_support')
                                    ->groupBy('work_orders.user_id_support')
                                    ->where('status_approval',1)
                                    ->where('request_for',$userDepartement->initial)
                                    ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->filter.'-01-01', $request->filter.'-12-31'])
                                    ->orderBy('classement','desc')
                                    ->orderBy('count','desc')
                                    ->get();
        }else{
            $classementPIC = DB::table('work_orders')->select(DB::raw('AVG(work_orders.rating) as classement'),'users.name',DB::raw('COUNT(work_orders.rating) as count'),DB::raw('AVG(work_orders.duration) as duration'))
                                    ->join('users','users.id','=','work_orders.user_id_support')
                                    ->groupBy('work_orders.user_id_support')
                                    ->where('status_approval',1)
                                    ->where('request_for',$userDepartement->initial)
                                    ->orderBy('classement','desc')
                                    ->orderBy('count','desc')
                                    ->get();
        }
        return response()->json([
            'classementPIC'=>$classementPIC,
        ]);
    }
    function getLevel2Filter(Request $request){
       
        if($request->filter_level == 2){
            $date = Carbon::createFromFormat('Y-m-d', $request->filter.'-01')
            ->endOfMonth()
            ->format('Y-m-d');
            $data =  WorkOrder::with(['categoryName','departementName','problemTypeName','picSupportName'])
                                                     ->where([
                                                         'status_wo' =>4,
                                                         'level'     =>2
                                                         ])
                                                      ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->filter.'-01', $date])
                                                      ->get();

        }else if($request->filter_level == 3){
            $data =  WorkOrder::with(['categoryName','departementName','problemTypeName','picSupportName'])
                                                     ->where([
                                                         'status_wo' =>4,
                                                         'level'     =>2
                                                         ])
                                                      ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->filter.'-01-01', $request->filter.'-12-31'])
                                                      ->get();
        }
        else{
            $data =  WorkOrder::with(['categoryName','departementName','problemTypeName','picSupportName'])
            ->where([
                'status_wo' =>4,
                'level'     =>2
                ])
             ->get();
        }
        return response()->json([
            'data'=>$data,
        ]);
    }
    
    public function percentageType(Request $request){
        $data='';
        if(auth()->user()->hasPermissionTo('get-problem_type-dashboard')){

            if($request->selectFilter == 2){
                $date = Carbon::createFromFormat('Y-m-d', $request->filter.'-01')
                                ->endOfMonth()
                                ->format('Y-m-d');
                $data = DB::table('work_orders')->select(DB::raw('COUNT(work_orders.category) as count'),'work_orders.problem_type','master_categories.name as problemName')
                                        
                                        ->join('master_categories','master_categories.id','=','work_orders.category')
                                        ->where(function($query){
                                            $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
                                        })
                                        ->where('work_orders.status_wo','!=',5)
                                        ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->filter.'-01', $date])
                                        ->groupBy('work_orders.category')
                                        ->get();
            }
            else if($request->selectFilter == 3){
                $data = DB::table('work_orders')->select(DB::raw('COUNT(work_orders.category) as count'),'work_orders.problem_type','master_categories.name as problemName')
                                        
                                        ->join('master_categories','master_categories.id','=','work_orders.category')
                                        ->where(function($query){
                                            $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
                                        })
                                        ->where('work_orders.status_wo','!=',5)
                                        ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->filter.'-01-01', $request->filter.'-12-31'])
                                        ->groupBy('work_orders.category')
                                        
                                        ->get();
            }else{
                $data = DB::table('work_orders')->select(DB::raw('COUNT(work_orders.category) as count'),'work_orders.problem_type','master_categories.name as problemName')
                                        
                                        ->join('master_categories','master_categories.id','=','work_orders.category')
                                        ->where(function($query){
                                            $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
                                        })
                                        ->where('work_orders.status_wo','!=',5)
                                        ->groupBy('work_orders.category')
                                        
                                        ->get();
            }
        }

        return response()->json([
            'data'=>$data,
        ]);
    }
    public function getWorkOrderByStatus(Request $request)
    {
        $userDepartement = MasterDepartement::find(auth()->user()->departement);
        if(auth()->user()->hasPermissionTo('get-all-work_order_list'))
        {
            if($request->status == 4){
                $data = DB::table('work_orders')
                ->select('work_orders.*','master_categories.name as categories_name', DB::raw('DATE(work_orders.created_at) as date'))
                ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
                ->where('work_orders.status_wo',$request->status)
                ->where('work_orders.status_approval',1)
                ->where(function($query) use($userDepartement){
                    $query->where('request_for',$userDepartement->initial)->orWhere('work_orders.departement_id',auth()->user()->departement);
    
                })
                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->from_date, $request->end_date])
                ->orderBy('id','desc')
                ->get();
            }else if($request->status == 5){
                $data = DB::table('work_orders')
                ->select('work_orders.*','master_categories.name as categories_name', DB::raw('DATE(work_orders.created_at) as date'))
                ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
                ->where('work_orders.status_wo',4)
                ->where('work_orders.status_approval',2)
                ->where(function($query) use($userDepartement){
                    $query->where('request_for',$userDepartement->initial)->orWhere('work_orders.departement_id',auth()->user()->departement);
    
                })
                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->from_date, $request->end_date])
                ->orderBy('id','desc')
                ->get();
            }else{
                $data = DB::table('work_orders')
                ->select('work_orders.*','master_categories.name as categories_name', DB::raw('DATE(work_orders.created_at) as date'))
                ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
                ->where('work_orders.status_wo',$request->status)
                ->where(function($query) use($userDepartement){
                    $query->where('request_for',$userDepartement->initial)->orWhere('work_orders.departement_id',auth()->user()->departement);
    
                })
                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->from_date, $request->end_date])
                ->orderBy('id','desc')
                ->get();
            }
        }else{
            if($request->status == 0){
                $data = DB::table('work_orders')
                ->select('work_orders.*','master_categories.name as categories_name', DB::raw('DATE(work_orders.created_at) as date'))
                ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
                ->where('work_orders.status_wo',$request->status)
                ->where(function($query) use($userDepartement){
                    $query->where('request_for',$userDepartement->initial)->orWhere('work_orders.departement_id',auth()->user()->departement);

                })
                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->from_date, $request->end_date])
                ->orderBy('id','desc')
                ->get();
            }else if($request->status == 4){
                $data = DB::table('work_orders')
                ->select('work_orders.*','master_categories.name as categories_name', DB::raw('DATE(work_orders.created_at) as date'))
                ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
                ->where('work_orders.status_wo',$request->status)
                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->from_date, $request->end_date])
                ->where(function($query) use($userDepartement){
                    $query->where('work_orders.request_for',$userDepartement->initial)->orWhere('work_orders.departement_id',auth()->user()->departement);

                })
                ->where(function($query){
                    $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
                })
                ->where('status_approval',1)
                ->orderBy('id','desc')
                ->get();
            }
            else{
                $data = DB::table('work_orders')
                ->select('work_orders.*','master_categories.name as categories_name', DB::raw('DATE(work_orders.created_at) as date'))
                ->leftJoin('master_categories','master_categories.id','=','work_orders.category')
                ->where('work_orders.status_wo',$request->status)
                ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$request->from_date, $request->end_date])
                ->where(function($query) use($userDepartement){
                    $query->where('work_orders.request_for',$userDepartement->initial)->orWhere('work_orders.departement_id',auth()->user()->departement);

                })
                ->where(function($query){
                    $query->where('user_id', auth()->user()->id)->orWhere('user_id_support', auth()->user()->id); 
                })
                ->orderBy('id','desc')
                ->get();

            }
        }
       return response()->json([
        'data'=>$data
        ]);
    }

}
