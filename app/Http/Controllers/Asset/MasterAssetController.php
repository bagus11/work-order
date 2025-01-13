<?php

namespace App\Http\Controllers\Asset;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\MasterAsset;
use App\Models\MasterAssetLog;
use Illuminate\Http\Request;
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
  
}
