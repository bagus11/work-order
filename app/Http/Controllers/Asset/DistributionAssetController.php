<?php

namespace App\Http\Controllers\Asset;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\ApprovalProgressRequest;
use App\Http\Requests\Asset\StoreDistributionRequest;
use App\Models\Asset\ApprovalDetail;
use App\Models\Asset\ApprovalHeader;
use App\Models\Asset\DistributionDetail;
use App\Models\Asset\DistributionHeader;
use App\Models\Asset\DistributionLog;
use App\Models\MasterAsset;
use App\Models\MasterAssetLog;
use App\Models\SoftwareModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use NumConvert;
use \Mpdf\Mpdf as PDF;

class DistributionAssetController extends Controller
{
    function index() {
        return view('asset.transaction.distribution.distribution-index');
    }

    function getDistributionTicket(Request $request) {
        $data = DistributionHeader::with([
           'userRelation',
           'receiverRelation',
           'locationRelation',
           'desLocationRelation',
           'detailRelation'
        ])->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-sm btn-info edit" data-id="' . $row->id . '">
                    <i class="fas fa-eye"></i>
                    </button>';
                    $printBtn = $row->status == 4 ? '<button class="btn btn-sm btn-success print" title="print BAST" data-id="' . $row->id . '">
                    <i class="fas fa-file"></i>
                    </button>' : '';
                    $return =
                    $printBtn. ' '
                    .$editBtn ;
                    return $return;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getInactiveAsset(Request $request) {
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
        ])->where('location_id', $request->location_id)->where('is_active', 0)->get();
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

    function getAssetUser(Request $request) {
        $nik = User::find($request->id);
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
        ])->where('nik', $nik->nik)->get();
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

    function getUserLocation(Request $request) {
        $data = User::where('kode_kantor', $request->id)->get();
        return response()->json([
            'data'=>$data,
        ]);
    }

    function addDistribution(Request $request, StoreDistributionRequest $storeDistributionRequest) {
    //   try {
        $storeDistributionRequest->validated();
        $increment_code= DistributionHeader::where('request_type', $request->request_type)->orderBy('id','desc')->first();
        $date_month =strtotime(date('Y-m-d'));
        $month =idate('m', $date_month);
        $year = idate('y', $date_month);
        $month_convert =  NumConvert::roman($month);
        $typeString = '';
        switch($request->request_type) {
            case '1':
                $typeString = 'DIS';
                break;
            case '2':
                $typeString = 'HAN';
                break;
            case '3':
                $typeString = 'RET';
                break;
            default:
                $typeString = '';
        }
        if($increment_code ==null){
            $ticket_code = '1/'.$typeString.'/'.$month_convert.'/'.$year;
        }else{
            $month_before = explode('/',$increment_code->request_code,-1);
            if($month_convert != $month_before[2]){
                $ticket_code = '1/'.$typeString.'/'.$month_convert.'/'.$year;
            }else{
                $ticket_code = $month_before[0] + 1 .'/'.$typeString.'/'.$month_convert.'/'.$year;
            }   
        }
        $approval = ApprovalHeader::where('location_id', $request->location_id)->where('department', $request->asset_type)->where('link', $request->currentPath)->first();
        $approvalDetail = ApprovalDetail::where('step', 1 )->where('approval_code', $approval->approval_code)->first();
       
        $fileName ='';
        if($request->file('attachment')){
            $ticketName = explode("/", $ticket_code);
            $ticketName2 = implode('',$ticketName);
            $custom_file_name = $typeString.'-'.$ticketName2;
            $originalName = $request->file('attachment')->getClientOriginalExtension();
            $fileName =$custom_file_name.'.'.$originalName;
        } 
        $selectedAssets = [];
        if($request->request_type == 3){
            $selectedAssets = MasterAsset::where('nik', auth()->user()->nik)->get();
        }else{
            $selectedAssets = json_decode($request->selected_assets, true); // pastiin ini array
        }
        $post_array = [];
        $owner =0;

        foreach ($selectedAssets as $index => $asset) {
            $condition = MasterAsset::where('asset_code', $asset['asset_code'])->first();   
            $detailCode = 'DET-' . str_replace('/', '', $ticket_code) . '-' . ($index + 1); // bikin unik
        
            $post_array[] = [
                'detail_code'       => $detailCode,
                'request_code'      => $ticket_code,
                'asset_code'        => $asset['asset_code'],
                'pic_id'            => $request->current_user_id,
                'receiver_id'       => $request->receiver_id,
                'condition'         => $condition->condition,
                'status'            => 0,
                'attachment'        => '',
                'remark'            => '',
                'created_at'        => date('Y-m-d H:i:s'),
                'finish_date'       => null,
            ];
            $owner =$condition->owner_id;
           
        }
        $owner_location = User::find($owner);
       
        $post = [
            'request_code'      => $ticket_code,
            'location_id'       => $request->location_id,
            'des_location_id'   => $request->request_type == 3 ? auth()->user()->kode_kantor : $request->destination_location_id,
            'request_type'      => $request->request_type,
            'user_id'           => auth()->user()->id,
            'pic_id'            => $request->current_user_id ? $request->current_user_id : 0,
            'receiver_id'       =>  $request->request_type == 3 ? 0 : $request->receiver_id,
            'approval_id'       => $approvalDetail->user_id,
            'status'            => 0,
            'notes'             => $request->notes,
            'attachment'        => $fileName,
        ];

        $post_log =[
            'request_code'      => $ticket_code,
            'location_id'       => $request->location_id,
            'des_location_id'   => $request->request_type == 3 ? auth()->user()->kode_kantor : $request->destination_location_id,
            'request_type'      => $request->request_type,
            'user_id'           => auth()->user()->id,
            'pic_id'            => $request->current_user_id ? $request->current_user_id : 0,
            'receiver_id'       =>  $request->request_type == 3 ? 0 : $request->receiver_id,
            'approval_id'       => $approvalDetail->user_id,
            'status'            => 0,
            'notes'             => $request->notes,
            'attachment'        => $fileName,

        ];
       DB::transaction(function() use($post,$request, $post_array,$fileName, $post_log) {

            DistributionHeader::create($post);
            DistributionDetail::insert($post_array);
            DistributionLog::create($post_log);

            if($request->file('attachment')){
                $request->file('attachment')->storeAs('Asset/Distribution/attachment',$fileName);
                $request->file('attachment')->storeAs('Asset/Distribution/AttachmentLog',$fileName);
            }            
        });
       
        return ResponseFormatter::success(   
            $post,                              
            'Asset successfully updated'
        );            
    //   } catch (\Throwable $th) {
    //       return ResponseFormatter::error(
    //           $th,
    //           'Asset failed to add',
    //           500
    //       );
    //   }


    }

    function detailDistributionTicket(Request $request) {
        $detail = DistributionHeader::with([
            'userRelation',
            'receiverRelation',
            'locationRelation',
            'currentRelation',
            'desLocationRelation',
            'detailRelation',
            'detailRelation.assetRelation',
            'detailRelation.assetRelation.softwareRelation',
            'detailRelation.assetRelation.categoryRelation',
            'detailRelation.assetRelation.locationRelation',
            'detailRelation.assetRelation.ownerRelation',
            'detailRelation.assetRelation.brandRelation',
            'historyRelation',
            'historyRelation.locationRelation',
            'historyRelation.desLocationRelation',
            'historyRelation.userRelation',
            'historyRelation.receiverRelation',
            'historyRelation.approvalRelation',
            'historyRelation.picRelation',
        ])->where('id', $request->id)->first();


        return response()->json([
            'detail'=>$detail,
        ]);
    }
    

    function getApprovalAssetNotification(){
        $data = DistributionHeader::with([
            'userRelation',
            'receiverRelation',
            'locationRelation',
            'desLocationRelation',
            'detailRelation',
            'detailRelation.assetRelation',
            'detailRelation.assetRelation.categoryRelation',
            'detailRelation.assetRelation.locationRelation',
            'detailRelation.assetRelation.ownerRelation',
            'detailRelation.assetRelation.brandRelation',
        ])
        ->where('approval_id', auth()->user()->id)
        ->where(function($q) {
            $q->where('status', 0)->orWhere('status', 1);
        })
        ->get();
        
        return response()->json([
            'data'=>$data,
        ]);
    }

    function approvalAssetProgress(Request $request, ApprovalProgressRequest $approval_progress_request) {
    try {
        $approval_progress_request->validated();
        $header = DistributionHeader::where('request_code', $request->request_code)->first();
        $detail = DistributionDetail::where('request_code', $request->request_code)->get();
        $approval = ApprovalHeader::where('location_id', $header->location_id)->first();
        $detailApproval = ApprovalDetail::where('approval_code', $approval->approval_code)->get();
        $currentApproval = ApprovalDetail::where('approval_code', $approval->approval_code)->where('user_id', auth()->user()->id)->first();
        $nextApproval = 0;
        $status = $header->status;
        $post_detail = $detail[0]->status;
        if($request->status == 2){
            $nextApproval = 0;
            $status = 5;
            $post_detail = 5;
        }else{
            if($currentApproval->step < $approval->step){
                $approval = ApprovalDetail::where('approval_code', $approval->approval_code)->where('step', $currentApproval->step + 1)->first();
                $nextApproval = $approval->user_id;
                $status = $header->status == 0 ? 1 : $header->status + 1;
               
            }else if($currentApproval->step == $approval->step){
               
                $nextApproval = 0;  
                $status = $header ->status + 1;
                $post_detail = $detail[0]->status +1;
            }
        }
        
        $post_log =[
            'request_code'      => $request->request_code,
            'location_id'       => $header->location_id,
            'des_location_id'   => $header->des_location_id,
            'request_type'      => $header->request_type,
            'user_id'           => auth()->user()->id,
            'pic_id'            => $header->pic_id,
            'receiver_id'       => $header->receiver_id,
            'approval_id'       => $nextApproval,
            'status'            => 1,
            'notes'             => $request->approval_notes,
            'attachment'        => '',
        ];
        $post = [
            'status'            => $status,
            'approval_id'       => $nextApproval,
        ];
      
        DB::transaction(function() use($post,$request, $post_log,$post_detail, $currentApproval, $approval ) {
            DistributionLog::create($post_log);
            DistributionHeader::where('request_code', $request->request_code)->update($post);
            if($currentApproval->step == $approval->step){
                DistributionDetail::where('request_code', $request->request_code)->update(['status' => $post_detail]);
            }
        });
        return ResponseFormatter::success(   
            $post,                              
            'Approval successfully updated'
        );            
              } catch (\Throwable $th) {
          return ResponseFormatter::error(
              $th,
              'Approval failed to update',
              500
          );
      }

    }
    function sendingDistribution(Request $request) {
        // try {
            $header = DistributionHeader::where('request_code', $request->ict_request_code)->first();
            $detail = DistributionDetail::where('request_code', $request->ict_request_code)->get();
            $fileName ='';
            if($request->file('ict_progress_attachment')){
                $ticketName = explode("/", $header->request_code);
                $ticketName2 = implode('',$ticketName);
                $custom_file_name = date('YmdHis').'-'.$ticketName2;
                $originalName = $request->file('ict_progress_attachment')->getClientOriginalExtension();
                $fileName =$custom_file_name.'.'.$originalName;
            } 
            $post_log =[
                'request_code'      => $request->ict_request_code,
                'location_id'       => $header->location_id,
                'des_location_id'   => $header->des_location_id,
                'request_type'      => $header->request_type,
                'user_id'           => auth()->user()->id,
                'pic_id'            => $header->pic_id,
                'receiver_id'       => $header->receiver_id,
                'approval_id'       => $header->approval_id,
                'status'            => $header->status,
                'notes'             => $request->ict_notes_progress,
                'attachment'        => $fileName,
            ];
            $post = [
                'status'            => $header->status + 1,
            ];
        
            
            DB::transaction(function() use($post,$request, $post_log,$fileName, $detail) {

                DistributionLog::create($post_log);
                DistributionHeader::where('request_code', $request->ict_request_code)->update($post);
                DistributionDetail::where('request_code', $request->ict_request_code)->update(['status' => $detail[0]->status + 1]);
                $assets = json_decode($request->assets); // kalau dari JSON string

                foreach($assets as $asset){
                    SoftwareModel::where('asset_code', $asset->asset_code)->delete(); 
                    foreach($asset->softwares as $software){
                        $post = [
                            'name'      => $software->name,
                            'details'    => $software->detail,
                            'asset_code' => $asset->asset_code,
                        ];
                        if($software->name == null || $software->detail == ''){
                            continue;
                        }
                        SoftwareModel::create($post);
                    }
                    MasterAsset::where('asset_code', $asset->asset_code)->update([
                        'condition' => $asset->condition,
                    ]);
                }

                foreach($detail as $value){
                    $asset = MasterAsset::where('asset_code', $value->asset_code)->first();
                    $postLog = [
                        'asset_code' => $value->asset_code,
                        'category' => $asset->category,
                        'brand' => $asset->brand,
                        'type' => $asset->type,
                        'parent_code' => $asset->parent_code,
                        'remark' => 'Sending asset to destination location',
                        'user_id'=>auth()->user()->id,
                        'is_active' => $asset->is_active,
                        'nik' => $asset->nik,
                        'join_date'=> $asset->join_date,
                        'location_id' => 0,
                        // 'condition' => $asset->condition,
                        // 'status' => $asset->status,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    MasterAsset::where('asset_code', $asset->asset_code)->update([
                        'location_id' => 0 
                    ]);
                    MasterAssetLog::create($postLog);
                }
                if($request->file('ict_progress_attachment')){
                    $request->file('ict_progress_attachment')->storeAs('Asset/Distribution/attachmentLog',$fileName);
                }            
            });
                return ResponseFormatter::success(   
                    $post,                              
                    'Access successfully locked'
                );            
        // }catch (\Throwable $th) {
        //       return ResponseFormatter::error(
        //           $th,
        //           'Approval failed to update',
        //           500
        //       );
        // }
    }

    function incomingProgress(Request $request){
        DB::beginTransaction();
        // try {
            $assets = $request->assets; // Misal data yang dikirimkan dalam bentuk array 'assets'
            $header = DistributionHeader::where('request_code', $request->ict_request_code)->first();
            $path = '';
            $fileName = '';
            foreach ($assets as $assetCode => $data) {
                if (isset($data['attachment'])) {
                    $file = $data['attachment'];
                    $originalName = $file->getClientOriginalExtension();
                    $custom_file_name = 'inc-' . $assetCode . $request->request_code . date('YmdHis');
                    $fileName =$custom_file_name.'.'.$originalName;
                    $path = 'Asset/Distribution/attachmentDetail/' . $fileName;
                  
                    }
                $asset = DistributionDetail::where('asset_code', $assetCode)->where('request_code', $request->ict_request_code)->first();
                $postAttachment = [
                    'condition' => $data['condition'],
                    'remark' => $data['remark'],
                    'attachment' => $path,
                    'status' => $asset->status + 1,
                    'finish_date' => date('Y-m-d H:i:s'),
                ];
                $nik = User::where('id', $header->receiver_id)->first();
                if($header->request_type == 1){
                    $postMaster = [
                        'location_id' => $header->des_location_id,
                        'nik' =>$nik->nik,
                         'condition' => $data['condition'],
                    ];
                }else if($header->request_type == 2){   
                    $postMaster = [
                        'location_id' => $header->des_location_id,
                        'nik' =>$nik->nik,
                         'condition' => $data['condition'],
                        'is_active' => 1,
                    ];
                }else{
                    $postMaster = [
                        'location_id' => 1,
                        'nik' => 0,
                        'is_active' => 0,
                         'condition' => $data['condition'],
                    ];   
                }
                // dd($postMaster);
                if (isset($data['attachment'])) {
                    $path = $file->storeAs('Asset/Distribution/attachmentDetail/', $fileName, 'public');
                }
                DistributionDetail::where('asset_code', $assetCode)->where('request_code', $request->ict_request_code)->update($postAttachment);
                MasterAsset::where('asset_code', $assetCode)->update($postMaster);
            }

            $count_done = DistributionDetail::where('request_code', $request->ict_request_code)->where('status', 3)->count();
            $count_all = DistributionDetail::where('request_code', $request->ict_request_code)->count();
            $postLog = [
                'request_code' => $request->ict_request_code,
                'location_id' => $header->location_id,
                'des_location_id' => $header->des_location_id,
                'request_type' => $header->request_type,
                'user_id' => auth()->user()->id,
                'pic_id' => $header->pic_id,
                'receiver_id' => $header->receiver_id,
                'approval_id' => 0,
                'status' => $count_all == $count_done ? $header->status + 1 : $header->status,
                'notes' => $request->ict_incoming_notes,
                'attachment' => '',
            ];
            DistributionLog::create($postLog);
            if($count_done == $count_all){
                $post = [
                    'status' => $header->status + 1,
                ];
                DistributionHeader::where('request_code', $request->ict_request_code)->update($post);
            }
            DB::commit();

            return ResponseFormatter::success(
                null, // Tidak ada data yang perlu dikirim
                'Assets processed successfully.',
                200
            );
    
        // } catch (\Exception $e) {
        //     // Jika ada error, rollback transaksi
        //     DB::rollBack();

        //     // Menggunakan ResponseFormatter untuk error
        //     return ResponseFormatter::error(
        //         $e,
        //         'An error occurred while processing the assets.',
        //         500
        //     );
        // }
    }
    function printDistribution($id){
        $data = DistributionHeader::with([
            'userRelation',
            'currentRelation',
            'receiverRelation',
            'historyRelation',
            'historyRelation.userRelation',
            'locationRelation',
            'desLocationRelation',
            'detailRelation',
            'detailRelation.assetRelation',
            'detailRelation.assetRelation.categoryRelation',
            'detailRelation.assetRelation.locationRelation',
            'detailRelation.assetRelation.ownerRelation',
            'detailRelation.assetRelation.brandRelation',
        ])->where('id', $id)->first();
        $html = view('report.report-asset_distribution', compact('data'))->render();
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
            $mpdf->Output('Distribution Report'.$data->request_code.'('.date('Y-m-d').').pdf', 'I');
    }
}
