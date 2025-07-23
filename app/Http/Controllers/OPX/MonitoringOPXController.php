<?php

namespace App\Http\Controllers\OPX;

use App\Exports\OPXExport;
use App\Exports\OPXPivotExport;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPOOPXRequest;
use App\Http\Requests\StoreOPXRequest;
use App\Models\MasterKantor;
use App\Models\OPX\MonitoringOPX;
use App\Models\OPX\OPXIS;
use App\Models\OPX\OPXPO;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MonitoringOPXController extends Controller
{
    function index() {
        return view('opex.monitoring_opx.monitoring_opx-index');
    }
    function getOPX(Request $request) {
        $query = MonitoringOPX::select(
                DB::raw('SUM(price) as sumPrice'),
                'category',
                'id',
                'location'
            )
            ->with([
                'categoryRelation',
                'locationRelation',
            ]);

        // Filter tanggal created_at
        if (!empty($request->month) && !empty($request->year)) {
                $query->whereMonth('start_date', $request->month)
                ->whereYear('start_date', $request->year);
        }
        if (!empty($request->location)) {
            $query->where('location', $request->location);
        }


        // Group By
        $data = $query->groupBy('category', 'location')->get();

        return response()->json([
            'data' => $data
        ]);
    }

    function detailOPX(Request $request) {
           $detail = MonitoringOPX::with([
                'categoryRelation',
                'locationRelation',
                'productRelation',
                'userRelation'
            ])->find($request->id);

            if (!$detail) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            $createdAt = Carbon::parse($detail->start_date);
            $startOfMonth = $createdAt->copy()->startOfMonth()->startOfDay();
            $endOfMonth   = $createdAt->copy()->endOfMonth()->endOfDay();
            $sumPrice = MonitoringOPX::where([
                'location' => $detail->location,
                'category' => $detail->category,
            ])
            ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
            ->select(DB::raw('SUM(price) as sumPrice'))
            ->value('sumPrice');

            $detail->sumPrice = $sumPrice ?? 0;
            $log = MonitoringOPX::with([
                'categoryRelation',
                'locationRelation',
                'productRelation'
            ])
            ->where([
                'location' => $detail->location,
                'category' => $detail->category,
            ])
            ->whereBetween('start_date', [$startOfMonth, $endOfMonth]);
            // if($detail->product !== 0){
            //     $log->where('product', $detail->product);
            // }
            // dd(vsprintf(str_replace('?', '%s', $log->toSql()), collect($log->getBindings())->map(fn($b) => is_numeric($b) ? $b : "'$b'")->toArray()));

            $log = $log->get();
            
            return response()->json([
                'detail' => $detail,
                'log'    => $log
            ]);
    }
function childOPXDetail(Request $request) {
          $detail = MonitoringOPX::with([
                'categoryRelation',
                'locationRelation',
                'productRelation',
                'userRelation'
            ])->find($request->id);

            if (!$detail) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            $createdAt = Carbon::parse($detail->start_date);
            $startOfMonth = $createdAt->copy()->startOfMonth()->startOfDay();
            $endOfMonth   = $createdAt->copy()->endOfMonth()->endOfDay();
            $sumPrice = MonitoringOPX::where([
                'location' => $detail->location,
                'category' => $detail->category,
            ])
            ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
            ->select(DB::raw('SUM(price) as sumPrice'))
            ->value('sumPrice');

            $detail->sumPrice = $sumPrice ?? 0;
            $log = MonitoringOPX::with([
                'categoryRelation',
                'locationRelation',
                'productRelation'
            ])
            ->where([
                'location' => $detail->location,
                'category' => $detail->category,
            ])
            ->whereBetween('start_date', [$startOfMonth, $endOfMonth]);
            $log->where('product', $detail->product);
            $log = $log->get();
            
            return response()->json([
                'detail' => $detail,
                'log'    => $log
            ]);
    }
    function getDetervative(Request $request) {
        $head = MonitoringOPX::find($request->id);
        $createdAt = Carbon::parse($head->start_date);
        $startOfMonth = $createdAt->copy()->startOfMonth()->startOfDay();
        $endOfMonth   = $createdAt->copy()->endOfMonth()->endOfDay();
        $query = MonitoringOPX::select(
                'monitoring_opx.id',
                DB::raw('SUM(monitoring_opx.price) as sumPrice'),
                'monitoring_opx.category',
                'master_product_opx.name as product_name',
                'monitoring_opx.location',
                'monitoring_opx.start_date',
                'monitoring_opx.price'
            )
            ->join('master_product_opx', 'master_product_opx.id', '=', 'monitoring_opx.product')
            ->where('monitoring_opx.category', $head->category)
            ->where('monitoring_opx.location', $head->location)
            ->whereBetween('monitoring_opx.start_date', [$startOfMonth, $endOfMonth])
            ->groupBy('monitoring_opx.category', 'master_product_opx.name', 'monitoring_opx.location')->get();

        // Lihat raw SQL dengan bindings
        
        return response()->json([
            'data'=>$query
        ]);
    }
    function getPOOPX(Request $request) {
        $detail = MonitoringOPX::with([
            'categoryRelation',
            'locationRelation',
        ])->find($request->id)->first();
        $data = OPXPO::with([
            'userRelation'
        ])->where([
            'opx_id' => $request->id,

        ])->get();
        return response()->json([
            'data'=>$data,
            'detail'=>$detail,
        ]);
    }
    function getISOPX(Request $request) {
        $data = OPXIS::with([
            'userRelation'
        ])->where([
            'po_id' => $request->id,

        ])->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function addOPX(Request $request, StoreOPXRequest $storeProductOPXRequest) {
        try {
            $storeProductOPXRequest->validated();
            $post =[
                'location'      => $request->location,
                'user_id'       => auth()->user()->id,
                'category'      => $request->category,
                'product'       => $request->product =='' ? '-' : $request->product ,
                'note'          => $request->description,
                'start_date'    => $request->date,
                'price'         => $request->price,
                'pph'           => $request->pph,
                'ppn'           => $request->ppn,
                'dph'           => 0,
                'po'           => '',
                'is'           => '',
               
            ];
            // dd($post);
            MonitoringOPX::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'OPX successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'OPX failed to add',
                500
            );
        }
    }
    function addPOOPX(Request $request, AddPOOPXRequest $storeProductOPXRequest) {
        try {
            $storeProductOPXRequest->validated();
            $post =[
               'po'  =>$request->po,
               'pr'  =>$request->pr,
               'opx_id'  =>$request->id,
               'user_id'  =>auth()->user()->id,
               
            ];
            // dd($post);
            OPXPO::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'PO and PR successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'PO and PR failed to add',
                500
            );
        }
    }
    function updateISOPX(Request $request) {
        $status = 500;
        $message ="Failed update IS";
        $update =OPXIS::find($request->id)->update([
            'is'=>$request->is,
            'user_id'=>auth()->user()->id,
        ]);
        if($update){
            $status = 200;
            $message ="Successfully update IS";

        }

        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
    }
    function updatePOOPX(Request $request) {
        $status = 500;
        $message ="Failed update PO";
        $update =OPXPO::find($request->id)->update([
            'po'=>$request->po,
            'user_id'=>auth()->user()->id,
        ]);
        if($update){
            $status = 200;
            $message ="Successfully update PO";

        }

        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
    }
    function updatePROPX(Request $request) {
        $status = 500;
        $message ="Failed update PR";
        $update =OPXPO::find($request->id)->update([
            'pr'=>$request->pr,
            'user_id'=>auth()->user()->id,
        ]);
        if($update){
            $status = 200;
            $message ="Successfully update PR";

        }

        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
    }
    function addISOPX(Request $request) {
        $status = 500;
        $message ="Failed update IS";
        // dd($request);
        $insert =OPXIS::create([
            'is'=>$request->is,
            'opx_id'=>$request->opx_id,
            'po_id'=>$request->po_id,
            'user_id'=>auth()->user()->id
        
        ]);
        if($insert){
            $status = 200;
            $message ="Successfully update IS";
        }

        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);
    }
 public function exportPivot(Request $request)
{
    $location = $request->location;
    $year     = $request->year ?? date('Y');
    $endMonth = $request->month ?? date('n');

    $locations = ['HO', 'CMG', 'KRW'];
    $months = [];
    for ($m = 1; $m <= $endMonth; $m++) {
        $months[] = [
            'name'   => date('M', mktime(0, 0, 0, $m, 1)),
            'number' => $m,
        ];
    }

    // Data pivot
    $pivotData = $this->getPivotData($location, $year, $endMonth, $locations, $months);

    // Data amount source
    $amountSourceData = $this->getAmountSourceData($location, $year, $endMonth);
    
    return Excel::download(
        new OPXExport($pivotData, $amountSourceData, $months, $locations),
        'opx_report.xlsx'
    );
}


    private function getPivotData($location, $year, $endMonth, $locations, $months)
    {
        $query = MonitoringOPX::select(
                'monitoring_opx.category',
                'monitoring_opx.product',
                'monitoring_opx.location',
                DB::raw('MONTH(monitoring_opx.start_date) as month'),
                DB::raw('SUM(monitoring_opx.price) as total_price')
            )
            ->with(['categoryRelation:id,name', 'productRelation:id,name', 'locationRelation:id,initial'])
            ->whereYear('monitoring_opx.start_date', $year)
            ->whereMonth('monitoring_opx.start_date', '<=', $endMonth);

        if (!empty($location)) {
            $query->where('monitoring_opx.location', $location);
        }

        $opx = $query
            ->groupBy('monitoring_opx.category', 'monitoring_opx.product', 'monitoring_opx.location', DB::raw('MONTH(monitoring_opx.start_date)'))
            ->orderBy('monitoring_opx.category')
            ->orderBy('monitoring_opx.product')
            ->get();

        // Bentuk pivotData (sama seperti sebelumnya)
        $pivotData = [];
        foreach ($opx as $row) {
            $category = $row->categoryRelation->name ?? '';
            $product  = $row->productRelation->name ?? '';
            $loc      = $row->locationRelation->initial ?? '';
            $month    = date('M', mktime(0, 0, 0, $row->month, 1));

            $key = "{$category}_{$product}";
            if (!isset($pivotData[$key])) {
                $pivotData[$key] = [
                    'category' => $category,
                    'product'  => $product
                ];
                foreach ($months as $m) {
                    foreach ($locations as $locKey) {
                        $pivotData[$key]["{$m['name']}_{$locKey}"] = 0;
                    }
                    $pivotData[$key]["{$m['name']}_Total"] = 0;
                }
            }

            if (in_array($loc, $locations)) {
                $pivotData[$key]["{$month}_{$loc}"] += $row->total_price;
            }
        }

        foreach ($pivotData as &$row) {
            foreach ($months as $m) {
                $month = $m['name'];
                $row["{$month}_Total"] = array_sum(array_intersect_key(
                    $row,
                    array_flip(array_map(fn($loc) => "{$month}_{$loc}", $locations))
                ));
            }
        }
        unset($row);

        return $pivotData;
    }

    private function getAmountSourceData($location, $year, $endMonth)
    {
        $queries = [];

        // === PR ===
        $queries[] = DB::table('monitoring_opx as mo')
            ->leftJoin('opxpo as po', 'mo.id', '=', 'po.opx_id')
            ->leftJoin('master_product_opx as mpo', 'mo.product', '=', 'mpo.id')
            ->leftJoin('master_category_opx as mco', 'mo.category', '=', 'mco.id')
            ->leftJoin('master_kantor as mk', 'mo.location', '=', 'mk.id')
            ->select(
                'mpo.name as product',
                'mco.name as category',
                DB::raw('MONTH(mo.start_date) as month'),
                'mk.initial as location',
                DB::raw('"PR" as type'),
                'po.pr as amount'
            )
            ->whereYear('mo.start_date', $year)
            ->whereMonth('mo.start_date', '<=', $endMonth)
            ->when($location, fn($q) => $q->where('mo.location', $location));

        // === PO ===
        $queries[] = DB::table('monitoring_opx as mo')
            ->leftJoin('opxpo as po', 'mo.id', '=', 'po.opx_id')
            ->leftJoin('master_product_opx as mpo', 'mo.product', '=', 'mpo.id')
            ->leftJoin('master_category_opx as mco', 'mo.category', '=', 'mco.id')
            ->leftJoin('master_kantor as mk', 'mo.location', '=', 'mk.id')
            ->select(
                'mpo.name as product',
                'mco.name as category',
                DB::raw('MONTH(mo.start_date) as month'),
                'mk.initial as location',
                DB::raw('"PO" as type'),
                'po.po as amount'
            )
            ->whereYear('mo.start_date', $year)
            ->whereMonth('mo.start_date', '<=', $endMonth)
            ->when($location, fn($q) => $q->where('mo.location', $location));

        // === IS ===
        $queries[] = DB::table('monitoring_opx as mo')
            ->leftJoin('opxpo as po', 'mo.id', '=', 'po.opx_id')
            ->leftJoin('opxis as is', 'po.id', '=', 'is.po_id')
            ->leftJoin('master_product_opx as mpo', 'mo.product', '=', 'mpo.id')
            ->leftJoin('master_category_opx as mco', 'mo.category', '=', 'mco.id')
            ->leftJoin('master_kantor as mk', 'mo.location', '=', 'mk.id')
            ->select(
                'mpo.name as product',
                'mco.name as category',
                DB::raw('MONTH(mo.start_date) as month'),
                'mk.initial as location',
                DB::raw('"IS" as type'),
                'is.is as amount'
            )
            ->whereYear('mo.start_date', $year)
            ->whereMonth('mo.start_date', '<=', $endMonth)
            ->when($location, fn($q) => $q->where('mo.location', $location));

        // Ambil data mentah
        $rawData = $queries[0]
            ->unionAll($queries[1])
            ->unionAll($queries[2])
            ->get()
            ->map(fn($item) => [
                'category' => $item->category,
                'product'  => $item->product,
                'month'    => date('M', mktime(0, 0, 0, $item->month, 1)),
                'location' => $item->location,
                'type'     => $item->type,
                'amount'   => $item->amount ?? '',
            ])
            ->toArray();

        // === GROUPING (Gabung \n) ===
        $groupedData = [];
        foreach ($rawData as $item) {
            $key    = "{$item['category']}_{$item['product']}";
            $colKey = "{$item['month']}_{$item['location']}_{$item['type']}";

            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'category' => $item['category'],
                    'product'  => $item['product'],
                ];
            }

            if (!empty($groupedData[$key][$colKey])) {
                $groupedData[$key][$colKey] .= "\n" . $item['amount'];
            } else {
                $groupedData[$key][$colKey] = $item['amount'];
            }
        }

        return array_values($groupedData);
    }








}
