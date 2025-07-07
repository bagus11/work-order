<?php

namespace App\Http\Controllers\Asset;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreMasterAssetRequest;
use App\Models\Asset\BrandAsset;
use App\Models\Asset\CategoryAsset;
use App\Models\MasterAsset;
use App\Models\MasterAssetLog;
use App\Models\MasterKantor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
        'specRelation'
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
        return response()->json([
            'category' => $category,
            'condition' => $condition,
            'available' => $available,
        ]);
    }
  
}
