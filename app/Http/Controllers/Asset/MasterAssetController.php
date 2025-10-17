<?php

namespace App\Http\Controllers\Asset;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreMasterAssetRequest;
use App\Models\Asset\BrandAsset;
use App\Models\Asset\CategoryAsset;
use App\Models\MasterAsset;
use App\Models\MasterAssetLog;
use App\Models\MasterDepartement;
use App\Models\MasterDivision;
use App\Models\MasterKantor;
use App\Models\SoftwareModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Str;


class MasterAssetController extends Controller
{
  function index() {
    return view('asset.master.master_asset.master_asset-index');
  }
  function getMasterAsset(Request $request) {
    $data = MasterAsset::with([
        'userRelation',
        'userRelation.Departement',
        'userRelation.locationRelation',
        'historyRelation',
        'historyRelation.creatorRelation',
        'historyRelation.userRelation',
        'historyRelation.userRelation.Departement',
        'historyRelation.userRelation.locationRelation',
        'specRelation',
        'softwareRelation',
    ])->get();
    if ($request->ajax()) {
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $editBtn = '<button class="btn btn-sm btn-warning edit" data-id="' . $row->id . '">
                <i class="fas fa-edit"></i>
                </button>';
                $printBtn = '<button class="btn btn-sm btn-success print" data-id="' . $row->id . '">
                <i class="fas fa-file"></i>
                </button>';
                $return =
                ' '
                .$printBtn ;
                return $return;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    return response()->json([
        'data'=>$data,
    ]);
  }
  function getMasterAssetUser(Request $request) {
    $data = MasterAsset::with([
        'userRelation',
        'userRelation.Departement',
        'userRelation.locationRelation',
    ])->groupBy('nik')->get();
    if ($request->ajax()) {
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $editBtn = '<button class="btn btn-sm btn-warning edit" data-id="' . $row->id . '">
                <i class="fas fa-edit"></i>
                </button>';
                $printBtn = '<button class="btn btn-sm btn-success print" data-id="' . $row->id . '">
                <i class="fas fa-file"></i>
                </button>';
                $return =
                ' '
                .$printBtn ;
                return $return;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    return response()->json([
        'data'=>$data,
    ]);
  }

  function mappingAssetUser(Request $request) {
    $data = MasterAsset::with([
        'userRelation',
        'userRelation.Departement',
        'userRelation.locationRelation',
    ])->where('nik', $request->nik)->get();
    return response()->json([
        'data'=>$data,
    ]);
  }

  function updateStatusMasterAsset(Request $request) {
      //  try {
     
        $post =[
          'is_active'   => $request->is_active == 1 ? 0 : 1
        ];
        $head = MasterAsset::where('asset_code',$request->asset_code)->first();
        $postLog =[
          'asset_code'  => $head->asset_code,
          'category'  => $head->category,
          'brand'  => $head->brand,
          'type'  => $head->type,
          'parent_code'  => $head->parent_code,
          'remark'  => 'Update status is_active',
          'user_id'  => auth()->user()->nik,
          'nik'  => $head->nik,
          'created_at'  => date('Y-m-d H:i:s'),
          'is_active'   => $request->is_active
        ];
        MasterAsset::where('asset_code',$request->asset_code)->update($post);
        MasterAssetLog::create($postLog);
          return ResponseFormatter::success(   
              $post,                              
              'Asset successfully updated'
          );            
    // } catch (\Throwable $th) {
    //     return ResponseFormatter::error(
    //         $th,
    //         'Asset failed to add',
    //         500
    //     );
    // }
  }

    function mappingAssetChild(Request $request) {
      $data = MasterAsset::where('parent_code', $request->asset_code)->get();
      return response()->json([
          'data'=>$data,
      ]);
    }


    function getAssetCategory() {
      $data = CategoryAsset::all();
      return response()->json([
          'data'=>$data,
      ]);
    }
    function getAssetBrand() {
      $data = BrandAsset::all();
      return response()->json([
          'data'=>$data,
      ]);
    }
    function getActiveParent() {
      $data = MasterAsset::where('type', 1)->get();
      return response()->json([
          'data'=>$data,
      ]);
    }
    function getUser() {
      $data = User::all();
      return response()->json([
          'data'=>$data,
      ]);
    }

    function addMasterAsset(Request $request, StoreMasterAssetRequest $storeMasterAssetRequest) {
      // try {
        $nik = User::find($request->pic_id);
        $increment_code = MasterAsset::where('type', $request->type_id)->where('location_id', $request->location_id)
            ->orderBy('id', 'desc')
            ->first();
        $location = MasterKantor::find($request->location_id);
        if ($increment_code == null) {
            $counter = 1;
        } else {
            $last_code_parts = explode('-', $increment_code->asset_code);
            $last_number = (int) end($last_code_parts); // ambil bagian terakhir, yaitu nomor
            $counter = $last_number + 1;
        }
        $formatted_number = str_pad($counter, 3, '0', STR_PAD_LEFT);
        $ticket_code = $location->initial . '-' . $request->type_id . '-' . $formatted_number;
        $category = CategoryAsset::find($request->category_id);
        $brand = BrandAsset::find($request->brand_id);
        $post =[
          'asset_code'    => $ticket_code,
          'category'      => $category->name,
          'brand'         => $brand->name,
          'type'          => $request->type_id,
          'nik'           => $nik->nik,
          'is_active'     => 1,
          'location_id'   => $request->location_id,
          'join_date'     => $request->join_date, 
        ];
        $post_log =[
          'asset_code'    => $ticket_code,
          'category'      => $category->name,
          'brand'         => $brand->name,
          'type'          => $request->type_id,
          'nik'           => $nik->nik,
          'is_active'     => 1,
          'location_id'   => $request->location_id,
          'join_date'     => $request->join_date, 
          'remark'        => auth()->user()->name . 'has add Asset',
        ];

        DB::transaction(function() use($post,$post_log) {
          MasterAsset::create($post);
          MasterAssetLog::create($post_log);

            return ResponseFormatter::success(   
              $post,                              
              'Asset successfully added'
            );            
        });
      
     
    // } catch (\Throwable $th) {
    //     return ResponseFormatter::error(
    //         $th,
    //         'Asset failed to add',
    //         500
    //     );
    // }
      
    }

    public function summaryAsset(){
        $category= [];
        $condition =[];
        $available = [];
        if (auth()->user()->hasPermissionTo('get-all-work_order_list') ) {
            $category = MasterAsset::select(
                            'category',
                            DB::raw('COUNT(*) as total'),
                        )->groupBy('category')
                        ->get();
            $condition = MasterAsset::select(
                            'condition',
                            DB::raw('COUNT(*) as total'),
                        )->groupBy('condition',)
                        ->get();
           $available = MasterAsset::selectRaw("
                            COUNT(CASE WHEN nik = 0 THEN 1 END) as count_user_id_zero,
                            COUNT(CASE WHEN nik IS NOT NULL AND nik != 0 THEN 1 END) as count_user_assigned
                        ")->first();
           
        }else if(auth()->user()->hasPermissionTo('get-only_user-work_order_list')) {
           
        }else{
            $category = MasterAsset::select(
                            'category',
                            DB::raw('COUNT(*) as total'),
                        )
                        ->where('location_id', auth()->user()->kode_kantor)
                        ->groupBy('category')
                        ->get();
            $condition = MasterAsset::select(
                            'condition',
                            DB::raw('COUNT(*) as total'),
                        )
                        ->where('location_id', auth()->user()->kode_kantor)
                        ->groupBy('condition')
                        ->get();
           $available = MasterAsset::selectRaw("
                            COUNT(CASE WHEN nik = 0 THEN 1 END) as count_user_id_zero,
                            COUNT(CASE WHEN nik IS NOT NULL AND nik != 0 THEN 1 END) as count_user_assigned
                        ")
                        ->where('location_id', auth()->user()->kode_kantor)
                        ->first();
        }
         $totalSelf = MasterAsset::selectRaw("
                            COUNT(*) AS total
                        ")->where('nik', auth()->user()->nik)->first();
        
        return response()->json([
            'category'      => $category,
            'condition'     => $condition,
            'available'     => $available,
            'totalSelf'     => $totalSelf
        ]);
    }

  public function getInactiveAssetChild(Request $request)
  {
      $query = MasterAsset::query();

      $query->where('type', 2);
            // ->whereNull('parent_code');

      if ($request->has('q') && !empty($request->q)) {
          $search = $request->q;
          $query->where(function($q) use ($search) {
              $q->where('asset_code', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('brand', 'like', "%{$search}%");
          });
      }

      $assets = $query->get();

      return response()->json([
          'data' => $assets
      ]);
  }
  public function updateAssetChild(Request $request)
  {
      // try {
        // dd($request);
          $asset = MasterAsset::where('asset_code', $request->asset_code)->first();
          $parent_code = str_replace(': ', '', $request->parent_code)  ;
          $parent = MasterAsset::where('asset_code', $parent_code)->first();
          if (!$asset) {
              return ResponseFormatter::error(null, 'Asset not found', 404);
          }
          $post = [
              'parent_code' => $parent_code,
              'nik' => $parent->nik,
          ];
          MasterAsset::where('asset_code', $request->asset_code)->update($post);

          // Log the change
          MasterAssetLog::create([
              'asset_code' => $asset->asset_code,
              'category' => $asset->category,
              'brand' => $asset->brand,
              'type' => $asset->type,
              'parent_code' => $asset->parent_code,
              'remark' => 'Updated parent asset to ' . $request->parent_code,
              'user_id' => auth()->user()->nik,
              'nik' => $asset->nik,
              'created_at' => date('Y-m-d H:i:s'),
              'is_active' => $asset->is_active,
          ]);
          $data = MasterAsset::with([
              'historyRelation',
              'historyRelation.creatorRelation',
              'historyRelation.userRelation',
              'historyRelation.userRelation.Departement',
              'historyRelation.userRelation.locationRelation',
          ])->where('parent_code', $parent_code)->get(); 
          return ResponseFormatter::success($data, 'Asset child updated successfully');
      // } catch (\Throwable $th) {
      //     return ResponseFormatter::error($th, 'Failed to update asset child', 500);
      // }
  }
  function addSoftwareTemp(Request $request) {
    try {
      $post =[
        'asset_code'    => $request->asset_code,
        'name'    => $request->name,
        'details'    => $request->details,
        'created_at'    => date('Y-m-d H:i:s'),
      ];
     
      DB::transaction(function() use($post) {
        SoftwareModel::create($post);
             
      });
       $data = SoftwareModel::where('asset_code', $request->asset_code)
              ->get();
       return ResponseFormatter::success(   
            $data,                              
            'Software successfully added'
          );        
    } catch (\Throwable $th) {
        return ResponseFormatter::error(
            $th,
            'Software failed to add',
            500
        );
    }
  }
  function exportAssetPDF(Request $request) {
    $asset_code = $request->asset_code;
    $data = MasterAsset::with([
        'userRelation',
        'userRelation.Departement',
        'userRelation.locationRelation',
        'historyRelation',
        'historyRelation.creatorRelation',
        'historyRelation.userRelation',
        'historyRelation.userRelation.Departement',
        'historyRelation.userRelation.locationRelation',
        'specRelation',
        'softwareRelation',
    ])->where('asset_code', $asset_code)->first();
      
    $html = view('report.report-master_asset', compact('data'))->render();
            $imageLogo          = '<img src="'.public_path('icon.png').'" width="70px" style="float: right;"/>';
            $header             = '';
            $header .= '
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none; border-collapse:collapse;">
                                        <tr>
                                            <td style="padding-left:10px; border:none;">
                                                <span style="font-size: 16px; font-weight: bold;">PT PRALON</span>
                                                <br>
                                                <span style="font-size:9px;">Synergy Building #08-08 Tangerang 15143 - Indonesia +62 21 304 38808</span>
                                            </td>
                                            <td style="width:33%; border:none;"></td>
                                            <td style="width: 50px; text-align:right; border:none;">'.$imageLogo.'</td>
                                        </tr>
                                    </table>

                                    <hr>';
            
            $footer             = '<hr>
                                    <table width="100%" style="font-size: 10px;">
                                        <tr>
                                            <td width="90%" align="left"><b>Disclaimer</b><br>this document is strictly private, confidential and personal to recipients and should not be copied, distributed or reproduced in whole or in part, not passed to any third party.</td>
                                            <td width="10%" style="text-align: right;"> {PAGENO}</td>
                                        </tr>
                                    </table>';

                
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
                    20, // margin bottom
                    5, // margin header
                    5
                ); // margin footer
                $mpdf->WriteHTML($html);
                // Output a PDF file directly to the browser
                ob_clean();
                $mpdf->Output('Master Asset Report'.$data->service_code.'('.date('Y-m-d').').pdf', 'I');
  }

  function getLocationFilter() {
    $data = MasterKantor::all();
    return response()->json([
        'data'=>$data,
    ]);
  }
public function exportMasterAsset(Request $request)
{
    // 1. Query utama untuk data asset
    $query = MasterAsset::with([
        'userRelation',
        'userRelation.Departement',
        'userRelation.Departement.divisionRelation',
        'userRelation.locationRelation',
        'historyRelation',
        'historyRelation.creatorRelation',
        'historyRelation.userRelation',
        'historyRelation.userRelation.Departement',
        'historyRelation.userRelation.locationRelation',
        'specRelation',
        'softwareRelation',
        'categoryRelation'
    ])
    ->orderBy(
        MasterDivision::select('master_division.name')
            ->join('master_departements', 'master_departements.division_id', '=', 'master_division.id')
            ->join('users', 'users.departement', '=', 'master_departements.id')
            ->whereColumn('users.nik', 'master_asset.nik')
            ->limit(1)
    )
    ->orderBy(
        MasterDepartement::select('master_departements.name')
            ->join('users', 'users.departement', '=', 'master_departements.id')
            ->whereColumn('users.nik', 'master_asset.nik')
            ->limit(1)
    )
    ->orderBy('nik', 'asc');

    // Apply filters kalau ada
    if ($request->location_id !== '' && $request->location_id !== null) {
        $query->whereHas('userRelation.locationRelation', function ($q) use ($request) {
            $q->where('id', $request->location_id);
        });
    }
    if ($request->division_id !== '' && $request->division_id !== null) {
        $query->whereHas('userRelation.Departement.divisionRelation', function ($q) use ($request) {
            $q->where('id', $request->division_id);
        });
    }
    if ($request->department_id !== '' && $request->department_id !== null) {
        $query->whereHas('userRelation.Departement', function ($q) use ($request) {
            $q->where('id', $request->department_id);
        });
    }
    if ($request->condition !== '' && $request->condition !== null) {
        $query->where('condition', $request->condition);
    }
    if ($request->available !== '' && $request->available !== null) {
        $query->where('is_active', $request->available);
    }

    $assets = $query->get();

    // 2. Summary groupings (pakai collection dari $assets)
    $summaryDivisionDept =$assets->groupBy(function ($asset) {
        $user = $asset->userRelation;
        $dept = optional($user->Departement);
        $div  = optional($dept->divisionRelation);

        return $div->name ?? 'No Division';
    })->map->count();
    $summaryDept = $assets->groupBy(function ($asset) { 
        $user = $asset->userRelation; 
        $dept = optional($user->Departement); 
        $div = optional($dept->divisionRelation); 
        $divName = $div->name ?? 'No Division'; $deptName = $dept->name ?? 'No Department'; 
        return $divName . ' - ' . $deptName; })
        ->map->count();

    $summaryCategory = $assets->groupBy(function ($asset) {
        return optional($asset->categoryRelation)->name ?? 'No Category';
    })->map->count();
    $summaryCondition = $assets->groupBy(function ($asset) {
        switch ($asset->condition) {
            case 1: return 'Good';
            case 2: return 'Partially Good';
            case 3: return 'Damaged';
            default: return 'Unknown';
        }
    })->map->count();
    $summaryLocation = $assets->groupBy(function ($asset) {
        return optional(optional($asset->userRelation)->locationRelation)->name ?? 'No Location';
    })->map->count();

    // 3. Chart dynamic
    $charts = [];

    if (empty($request->location_id)) {
        $charts['chartImageLocation'] = $this->generateBarChart(
            $summaryLocation->keys(),
            $summaryLocation->values(),
            'By Location',
            [
                '#E62727','#1E93AB', '#FCC61D'
            ]
        );
    }
    if (empty($request->division_id)) {
        $charts['chartImageDivision'] = $this->generateBarChart(
            $summaryDivisionDept->keys(),
            $summaryDivisionDept->values(),
            'By Division',
            '#1E93AB'
        );
    }
    if (empty($request->department_id)) {
        $charts['chartImageDepartment'] = $this->generateBarChart(
            $summaryDept->keys(),
            $summaryDept->values(),
            'By Department',
            '#FCC61D'
        );
    }
if (empty($request->condition)) {
    $charts['chartImageCondition'] = $this->generatePieChart(
        $summaryCondition->keys(),
        $summaryCondition->values(),
        'By Condition',
        [
            '#7ADAA5', // Good
            '#FCC61D', // Partially Good
            '#E62727', // Damaged
            '#CCCCCC', // Unknown
        ]
    );
}


    if (empty($request->available)) {
        // kalau mau tambahin chart available/unavailable, tinggal aktifin ini
        // $charts['chartImageAvailable'] = $this->generatePieChart(...);
    }

    if (empty($request->category_id)) {
        $charts['chartImageCategory'] = $this->generateBarChart(
            $summaryCategory->keys(),
            $summaryCategory->values(),
            'By Category',
            '#27548A'
        );
    }
  $html = view('report.report-summary_asset', [
    'assets'    => $assets,
    'charts'    => $charts,
    'request'    => $request,
    'summaries' => collect([
        [
            'title' => 'Summary Location',
            'data'  => $summaryLocation
        ],
        [
            'title' => 'Summary Division',
            'data'  => $summaryDivisionDept
        ],
        [
            'title' => 'Summary Department',
            'data'  => $summaryDept
        ],
        [
            'title' => 'Summary Category',
            'data'  => $summaryCategory
        ],
        [
            'title' => 'Summary Condition',
            'data'  => $summaryCondition
        ],
      
    ]),
])->render();
    $address = MasterKantor::where('id', auth()->user()->kode_kantor)->value('address');


            $imageLogo          = '<img src="'.public_path('icon_1.png').'" width="70px" style="float: right;"/>';
            $header             = '';
            $header .= '
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none; border-collapse:collapse;">
                                        <tr>
                                            <td style="padding-left:10px; border:none;">
                                                <span style="font-size: 16px; font-weight: bold;">'.$imageLogo.'</span>
                                                <br>
                                                <span style="font-size:9px;">'.$address.'</span>
                                            </td>
                                            <td style="width:33%; border:none;"></td>
                                            <td style="width: 50px; text-align:right; border:none;">'.' '.'</td>
                                        </tr>
                                    </table>

                                    <hr>';
            
            $footer             = '<hr>
                                    <table width="100%" style="font-size: 10px; border:none !important;">
                                        <tr>
                                            <td width="90%" align="left"><b>Disclaimer</b><br>this document is strictly private, confidential and personal to recipients and should not be copied, distributed or reproduced in whole or in part, not passed to any third party.</td>
                                            <td width="10%" style="text-align: right;"> {PAGENO}</td>
                                        </tr>
                                    </table>';

                
                $mpdf = new \Mpdf\Mpdf([
                    'tempDir' => storage_path('app/mpdf/temp'), // biar gak error permission
                    'allow_output_buffering' => true
                ]);

                // Biar bisa debug kalau ada masalah gambar
                $mpdf->showImageErrors = true;
                $mpdf->curlAllowUnsafeSslRequests = true; 

                $mpdf->SetHTMLHeader($header);
                $mpdf->SetHTMLFooter($footer);

                $mpdf->AddPage(
                    'P', // L - landscape, P - portrait 
                    '',
                    '',
                    '',
                    '',
                    5,  // margin_left
                    5,  // margin right
                    25, // margin top
                    20, // margin bottom
                    5,  // margin header
                    5   // margin footer
                );

                $mpdf->WriteHTML($html);

                // Buang buffer biar PDF gak rusak
                if (ob_get_length()) {
                    ob_clean();
                }

                $mpdf->Output('Summary Asset Report - ('.date('Y-m-d').').pdf', 'I');

    
 
}
private function generateChart($config, $width = 400, $height = 300)
{
    $ch = curl_init('https://quickchart.io/chart');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['chart' => $config]));
    $imageData = curl_exec($ch);
    curl_close($ch);

    if ($imageData) {
        $base64 = base64_encode($imageData);
        return "<img src='data:image/png;base64,{$base64}' width='{$width}' height='{$height}' />";
    }

    return "<p>Chart gagal dimuat</p>";
}


private function generateBarChart($labels, $data, $title, $colors = null)
{
    if (!$colors) {
        $labelsArray = is_array($labels) ? $labels : (array) $labels;
        $colors = array_map(fn() => '#' . substr(md5(rand()), 0, 6), $labelsArray);
    }

    $config = [
        'type' => 'bar',
        'data' => [
            'labels' => $labels,
            'datasets' => [[
                'label' => $title,
                'data' => $data,
                'backgroundColor' => $colors,
            ]],
        ],
        'options' => [
            'plugins' => [
                'legend' => ['display' => false],
                'title'  => ['display' => true, 'text' => $title],
            ],
        ],
    ];

    // HATI2 jangan double urlencode
    $url = "https://quickchart.io/chart?c=" . rawurlencode(json_encode($config));
// dd($url);

    return "<img src='{$url}' width='400' height='300'>";
}

private function generatePieChart($labels, $data, $title, $colors = null)
{
    if (!$colors) {
        $labelsArray = is_array($labels) ? $labels : (array) $labels;
        $colors = array_map(fn() => '#' . substr(md5(rand()), 0, 6), $labelsArray);
    }

    $config = [
        'type' => 'pie',
        'data' => [
            'labels' => $labels,
            'datasets' => [[
                'label' => $title,
                'data' => $data,
                'backgroundColor' => $colors,
            ]],
        ],
        'options' => [
            'plugins' => [
                'legend' => ['position' => 'bottom'],
                'title'  => ['display' => true, 'text' => $title],
            ],
        ],
    ];

    $url = "https://quickchart.io/chart?c=" . rawurlencode(json_encode($config));

    return "<img src='{$url}' style='max-width: 450px; max-height: 450px;' />";
}


}
