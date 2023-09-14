<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WOCounting;
use App\Models\WorkOrder;
use App\Models\WorkOrderLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use \Mpdf\Mpdf as PDF;
use CpChart\Data as DataChart;
use CpChart\Image as ImageChart;
use CpChart\Chart\Pie as PieChart;
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
    public function printKPIUser($dateFilter, $id)
    {

        try {
            $date = Carbon::createFromFormat('Y-m-d', $dateFilter.'-01')
            ->endOfMonth();
            $exp                =explode('-',$dateFilter);
            $year               =$exp[0]; 
            $user               = User::with('Departement','Jabatan')->find($id);
            $dataWO             = WorkOrder::select(DB::raw('COUNT(work_orders.id) as totalWO'),'master_kantor.name as officeName')
                                        ->join('users','work_orders.user_id','users.id')
                                        ->join('master_kantor','master_kantor.id','users.kode_kantor')
                                        ->where('work_orders.user_id_support',$id)
                                        ->where('work_orders.status_wo','!=',5)
                                        ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$dateFilter.'-01', $date])
                                        ->groupBy('master_kantor.id')
                                        ->get();
            $percentage         = WorkOrder::select(DB::raw('COUNT(work_orders.category) as count'),'work_orders.problem_type','master_categories.name as problemName')
                                        ->join('master_categories','master_categories.id','=','work_orders.category')
                                        ->where('user_id_support', $id) 
                                        ->where('work_orders.status_wo','!=',5)
                                        ->whereBetween(DB::raw('DATE(work_orders.created_at)'), [$dateFilter.'-01', $date])
                                        ->groupBy('work_orders.category')
                                        ->get();
            $result             = WOCounting::where('user_id',$id)
                                        ->whereBetween(DB::raw('DATE(created_at)'), [$dateFilter.'-01', $date])
                                        ->first();
            $level2             = WorkOrder::select(DB::raw('COUNT(work_orders.id) as count'),DB::raw('SUM(work_orders.duration) as totalDuration'))
                                        ->join('work_order_logs','work_orders.request_code','work_order_logs.request_code')
                                        ->where('work_order_logs.status_wo', 2)
                                        ->groupBy('work_orders.request_code')
                                        ->first();
            $detailTicket       = DB::table('work_orders')
                                        ->select('work_orders.*', 'users.name as username','master_categories.name as categories_name','master_departements.name as departement_name','master_kantor.name as kantor_name')
                                        ->join('users','users.id','=','work_orders.user_id')
                                        ->join('master_categories','master_categories.id','=','work_orders.category')
                                        ->join('master_departements','master_departements.id','=','work_orders.departement_id')
                                        ->join('master_kantor','master_kantor.id','=','users.kode_kantor')
                                        ->leftJoin('master_priorities','master_priorities.id','work_orders.priority')
                                        ->where('work_orders.user_id_support',$id)
                                        ->orderBy('status_wo', 'asc')
                                        ->orderBy('work_orders.status_approval','desc')
                                        ->orderBy('work_orders.priority','desc')
                                        ->orderBy('id','desc')
                                        ->get();
            $kpiUserbyOffice1    = DB::select("call getKPIUser($id,$year,'1')");
            $kpiUserbyOfficeDone1    = DB::select("call getKPIUserDone($id,$year,'1')");
            $data               =[
                                    'user'=>$user,
                                    'dataWO'=>$dataWO,
                                    'percentage'=>$percentage,
                                    'result'=>$result,
                                    'level2'=>$level2,
                                    'kpiUserbyOffice1'=>$kpiUserbyOffice1,
                                    'kpiUserbyOfficeDone1'=>$kpiUserbyOfficeDone1,
                                    'detailTicket'=>$detailTicket,
                                
                                ];
            
            $cetak              = view('reportKPI.report-kpi',$data);
            $imageLogo          = '<img src="'.public_path('icon.png').'" width="70px" style="float: right;"/>';
            $header             = '';
            $header             .= '<table width="100%">
                <tr>
                <td style="padding-left:10px;"><span style="font-size: 16px; font-weight: bold;">PT PRALON</span><br><span style="font-size:9px;">Synergy Building #08-08
                Tangerang 15143 - Indonesia
                +62 21 304 38808</span></td>
                <td style="width:33%"></td>
                    <td style="width: 50px; text-align:right;">'.$imageLogo.'</td>
                </tr>
                
            </table><hr>';
            
            $footer             = '<table width="100%" style="font-size: 10px;">
            <tr>
            
                <td width="64%" align="center"></td>
                <td width="33%" style="text-align: right;">Halaman : {PAGENO}</td>
            </tr>
            </table>';

                // $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);
                $mpdf           = new PDF();
                $mpdf->SetHTMLHeader($header);
                $mpdf->SetHTMLFooter($footer);
                $mpdf->AddPage(
                    'P', // L - landscape, P - portrait 
                    '',
                    '',
                    '',
                    '',
                    5, // margin_left
                    5, // margin right
                    25, // margin top
                    0, // margin bottom
                    5, // margin header
                    5
                ); // margin footer
                $mpdf->WriteHTML($cetak);
                // Output a PDF file directly to the browser
                ob_clean();
                $mpdf->Output($user->name.'('.date('Y-m-d').').pdf', 'I');
               
        } catch (\Mpdf\MpdfException $e) {
            // Process the exception, log, print etc.
            echo $e->getMessage();
        }
    }

    function getUserSupport() {
        $data = DB::table('users')->select('users.name','users.id')->join('model_has_roles','model_has_roles.model_id','=','users.id')
        ->where('model_has_roles.role_id',3)
        ->where('users.departement',auth()->user()->departement)
        ->get();
        return response()->json([
            'data'=>$data
        ]);
    }
}
