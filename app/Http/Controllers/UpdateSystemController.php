<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\UpdateSystemRequest;
use App\Models\ApprovalMatrix;
use App\Models\ApprovalMatrixDetail;
use App\Models\DetailSystem;
use App\Models\DetailSystemLog;
use App\Models\MasterAspek;
use App\Models\Mastermodule;
use App\Models\MasterDepartement;
use App\Models\MasterSystem;
use App\Models\UpdateSystem;
use App\Models\UpdateSystemLog;
use App\Models\WONotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;

class UpdateSystemController extends Controller
{
    function index() {
        return view('update_system.update_system-index');
    }

    function getTicketSystem() {
        $data = UpdateSystem:: with([
            'approverRelation',
            'userRelation',
            'userRelation.departmentRelation',
            'userRelation.locationRelation',
        ])->get();
        return response()->json([
            'data' => $data
        ]);
    }
    function getDetailERP(Request $request) {
        $data = UpdateSystem:: with([
            'approverRelation',
            'userRelation',
            'userRelation.departmentRelation',
            'userRelation.locationRelation',
            'detailRelation',
            'detailRelation.aspectRelation',
            'detailRelation.moduleRelation',
            'detailRelation.dataTypeRelation',
            'detailRelation.userRelation',
        ])->where('ticket_code', $request->ticket_code)->first();
        return response()->json([
            'data' => $data
        ]);
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/summernote'); // nyimpen di storage/app/public/summernote
            $url = asset('storage/' . $path); // langsung tambahin storage/ di depan
            return $url;
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function deleteImage(Request $request)
    {
        $src = $request->input('src');

        // Ambil path relatif setelah "storage/"
        $path = str_replace(asset('storage') . '/', '', $src);

        // Pastikan path sesuai lokasi di public/
        $fullPath = public_path('storage/' . $path);
        // dd($fullPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'File not found'], 404);
    }

   function addSystemTicket(Request $request) {
        // try {
            ini_set('max_execution_time', 120);
            $department_id = auth()->user()->departement; // ambil dept user
            $department = MasterDepartement::where('id', $department_id)->value('initial');
            $month = now()->month;
            $year = now()->format('y'); // 2 digit tahun
            $romanMonths = [1=>'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
            $romanMonth = $romanMonths[$month];

            // generate ticket_code
            $lastTicket = UpdateSystem::orderBy('id','desc')
                ->first();

            $increment = $lastTicket ? ((int) explode('/', $lastTicket->ticket_code)[0] + 1) : 1;

            $ticket_code = $increment . '/' . $department . '/' . $romanMonth . '/' . $year;
            DB::transaction(function() use($request, $ticket_code) {
                $dataType = MasterSystem::where('name', $request->items[0]['data_type'])->value('id');
                $approval_code  = ApprovalMatrix::where('data_type', $dataType)->first();
                $approval_id    = ApprovalMatrixDetail::where('approval_code', $approval_code->approval_code)->where('step',1)->get();
               $post =[
                    'ticket_code'       => $ticket_code,
                    'user_id'           => auth()->user()->id,
                    'approval_code'     => $approval_code->approval_code,
                    'step'              => 1,
                    'status'            => 0,
                    'approval_id'       => 0,
                    'pic'               => 0,
                    'subject'           => $request->subject,
                    'remark'            => $request->add_info,
                    'attachment'        =>''
                ];
                UpdateSystem::create($post);

                // loop items untuk bikin detail
                $detailIncrement = 1;
                foreach($request->items as $row){
                    // format detail_code => increment/ticket_code
                    $detail_code = $detailIncrement . '/' . $ticket_code;
                    $aspect = MasterAspek::where('name', $row['aspect'])->value('id');
                    $module = Mastermodule::where('name', $row['module'])->where('aspek',$aspect)->value('id');
                    $data_type = MasterSystem::where('name', $row['data_type'])->where('module_id',$module)->value('id');
                    $type = $row['data_type'] == 'Adding Data' ? 1 :2 ;
                    DetailSystem::create([
                        'ticket_code'       => $ticket_code,
                        'detail_code'       => $detail_code,
                        'aspect'            => $aspect,
                        'module'            => $module,
                        'data_type'         => $data_type,
                        'type'              => $type,
                        'subject'           => $row['subject'],
                        'remark'            => '',
                        'attachment'        => $row['image'] ?? str_replace(url('storage').'/', 'storage/', $row['image']),
                        'user_id'           => 0,
                        'attachment_pic'    => '',
                        'start_date'        => '0000-00-00',
                        'end_date'          => '0000-00-00',
                        'status'            => 0,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);
                    $detailIncrement++;
                }
            if(count($approval_id) > 0){
                $creator = auth()->user()->name;
                $headerText = "<b>📌 New Update Data Request</b>\n";
                $headerText .= "👤 <b>From:</b> {$creator}\n";
                $headerText .= "📝 <b>Ticket:</b> {$ticket_code}\n\n";

                $details = "";
                $firstImage = null;

                // gabung semua item ke dalam 1 text
                foreach($request->items as $row){
                    $details .= "<b>Details:</b>\n";
                    $details .= "━━━━━━━━━━━━━━━\n";
                    $details .= "🔹 <b>Aspect:</b> {$row['aspect']}\n";
                    $details .= "🔹 <b>Module:</b> {$row['module']}\n";
                    $details .= "🔹 <b>Data Type:</b> {$row['data_type']}\n";
                    $details .= "🔹 <b>Subject:</b> {$row['subject']}\n\n";

                    // ambil gambar pertama yang ada
                    if (!$firstImage && !empty($row['image'])) {
                        // ambil path asli dari storage
                        $imagePath = storage_path('app/public/' . str_replace('storage/', '', $row['image']));

                        if (file_exists($imagePath)) {
                            $firstImage = new \Telegram\Bot\FileUpload\InputFile($imagePath);
                        }
                    }

                   
                }

                $finalText = $headerText . $details;

                if($firstImage){
                    // kirim sekali dengan gambar
                    Telegram::sendPhoto([
                        'chat_id'    => env('TELEGRAM_CHANNEL_ID', '-1001800157734'),
                        'photo'      => InputFile::create($firstImage), // <- disini
                        'caption'    => $finalText,
                        'parse_mode' => 'HTML'
                    ]);
                } else {
                    // kirim sekali tanpa gambar
                    Telegram::sendMessage([
                        'chat_id'    => env('TELEGRAM_CHANNEL_ID', '-1001800157734'),
                        'text'       => $finalText,
                        'parse_mode' => 'HTML'
                    ]);
                }

                // simpan notifikasi ke DB untuk tiap approval
                foreach($approval_id as $row){
                    $post = [
                        'message'      => $creator.' has created new Update Data Request',
                        'subject'      => 'New Update Data Request',
                        'status'       => 0,
                        'type'         => 2,
                        'request_code' => $ticket_code,
                        'link'         => 'update_system',
                        'userId'       => $row->user_id,
                        'created_at'   => now()
                    ];
                    WONotification::create($post);
                
                }
            }



            });

            return ResponseFormatter::success(
                ['ticket_code' => $ticket_code],
                'Request For Project successfully added'
            );

        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th->getMessage(),
        //         'Request For Project failed to add',
        //         500
        //     );
        // }
    }
    function approvalERP(Request $request) {
        $array_approval = [];
        $status  = 0;
        $header = UpdateSystem::where('ticket_code', $request->erp_ticket_code)->first();
        $approval = ApprovalMatrix::where('approval_code', $header->approval_code)->first();
        $currentApproval = ApprovalMatrixDetail::where('approval_code', $header->approval_code)
                            ->where('user_id', auth()->user()->id)
                            ->first();
        $nextApproval = ApprovalMatrixDetail::where('approval_code', $header->approval_code)
                            ->where('step', $currentApproval->step + 1)
                            ->get();
        foreach($nextApproval as $row){
            $postNotification = [
                'message'      => auth()->user()->name.' has approved your Update Data Request',
                'subject'      => 'Update Data Request Approved',
                'status'       => 0,
                'type'         => 2,
                'request_code' => $request->erp_ticket_code,
                'link'         => 'update_system',
                'userId'       => $row->user_id,
                'created_at'   => now()
            ];
            array_push($array_approval, $postNotification);
        }
        $postDetail=[];
        if($currentApproval->step == 1){
            $postDetail = [
                'user_id'   => $request->erp_pic,
            ];
        }
        $result = 0;
        if ($header->step == 0) {
            $result = 2;
        } elseif ($currentApproval->step < $approval->step) {
            $result = $currentApproval->step + 1;
        } else {
            $result = 0;
        }
        $post =[
            'step'          =>  $result, 
            'status'        => count($nextApproval) > 0 ? 0 : 1,
            'updated_at'    => now(),
        ];
        $post_log =[
            'ticket_code'   => $request->erp_ticket_code,
            'user_id'       => auth()->user()->id,
            'approval_code' => $header->approval_code,
            'step'          => $currentApproval->step,
             'status'       => count($nextApproval) > 0 ? 0 : 1,
            'remark'        => $request->erp_remark ?? '',
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
        // dd($post);
        DB::transaction(function() use($request, $post, $postDetail, $header, $array_approval, $status, $post_log, $currentApproval, $approval) {
            WONotification::where('request_code', $request->erp_ticket_code)
                ->update(['status' => 1]);
            UpdateSystem::where('ticket_code', $request->erp_ticket_code)
                ->update($post);
            if($currentApproval->step == 1){
                DetailSystem::where('ticket_code', $request->erp_ticket_code)
                    ->update($postDetail);
            }
            if(count($array_approval) > 0){
                WONotification::insert($array_approval);
            }
            UpdateSystemLog::create($post_log);
            if($currentApproval->step == $approval->step){
                $post_notif =[
                        'message'      => auth()->user()->name.' has approve your request. Please contact PIC to inform the completion of the request',
                        'subject'      => 'Update Data Request',
                        'status'       => 0,
                        'type'         => 1,
                        'request_code' => $request->erp_ticket_code,
                        'link'         => 'update_system',
                        'userId'       => $header->user_id,
                        'created_at'   => now()
                ];
                WONotification::create($post_notif);
                DetailSystem::where('ticket_code', $request->erp_ticket_code)
                    ->update(['start_date' => date('Y-m-d H:i:s')]);
                    return ResponseFormatter::success(
                        $postDetail,
                        'System successfully updated'
                    );
            }
        });
    }
    public function finishTask(Request $request, UpdateSystemRequest $updateSystemRequest) {
        $updateSystemRequest->validated();

        DB::beginTransaction();
        try {
            $detail_code = explode(' : ', $request->detail_code);
            $header = DetailSystem::where('detail_code', $detail_code[1])->first();
            $ticket = UpdateSystem::where('ticket_code', $header->ticket_code)->first();

            $path = '';
            $filename = null;
            if ($request->hasFile('finish_attachment')) {
                $file = $request->file('finish_attachment');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'public/updateSystem/task/' . $filename;
            }

            $post = [
                'status'        => 1,
                'remark'        => $request->finish_remark,
                'end_date'      => now(),
                'attachment_pic'=> $path,
            ];

            $post_log = [
                'ticket_code'   => $header->ticket_code,
                'detail_code'   => $header->detail_code,
                'user_id'       => auth()->user()->id,
                'remark'        => $request->finish_remark,
                'status'        => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
          
            if ($request->hasFile('finish_attachment')) {
                $file->storeAs('public/updateSystem/task', $filename);
            }
            DetailSystemLog::create($post_log);
            $header->update($post);
            $checkPending = DetailSystem::where('ticket_code', $ticket->ticket_code)
                ->where('status', 0)
                ->count();
           
            if ($checkPending == 0) {
                // Duration 
                    $logTicket = UpdateSystemLog::where('ticket_code', $header->ticket_code)->orderBy('id','desc')->first();
                        $client = new \GuzzleHttp\Client();
                        $api = $client->get(
                            'https://hris.pralon.co.id/application/API/getAttendance?emp_no='
                            . auth()->user()->nik
                            . '&startdate=' . $logTicket->created_at->format('Y-m-d')
                            . '&enddate=' . date('Y-m-d H:i:s')
                        );
                        $response = $api->getBody()->getContents();
                        $data = json_decode($response, true);
                        $durations = [];
                        $finalDuration = 0;
                        
                        foreach ($data as $att) {
                        if ($att['daytype'] == 'WD') {
                            $start = Carbon::parse($att['shiftstarttime']);  // jam shift mulai
                            $end   = Carbon::parse($att['shiftendtime']);    // jam shift selesai
                            $startTicket = Carbon::parse($logTicket->created_at); // jam WO mulai
                            $endTiccket   = Carbon::now();   // jam WO selesai

                            $minutes = 0;
                            $validation = '';

                            // ✅ kalau start_wo & end_wo di tanggal yang sama
                            if ($startTicket->isSameDay($endTiccket)) {
                                $minutes = $startTicket->diffInMinutes($endTiccket);
                                $validation = 'same-day';
                            } else {
                                // ambil interval aktif WO dalam hari ini
                                $activeStart = $startTicket->greaterThan($start) ? $startTicket : $start;
                                $activeEnd   = $endTiccket->lessThan($end) ? $endTiccket : $end;

                                // hitung hanya kalau masih ada sisa waktu valid
                                if ($activeEnd > $activeStart) {
                                    $minutes = $activeStart->diffInMinutes($activeEnd);
                                    $validation = 'valid';
                                } else {
                                    $minutes = 0; // kalau WO di luar jam shift
                                    $validation = 'skip';
                                }
                            }

                            $finalDuration += $minutes;

                            $durations[] = [
                                'date'       => $att['date'] ?? $start->toDateString(),
                                'start'      => $start->format('H:i'),
                                'end'        => $end->format('H:i'),
                                'minutes'    => $minutes,
                                'total'      => $finalDuration,
                                'validation' => $validation,
                                'request_code'=>$logTicket->request_code
                            ];
                        }
                    }
                // Duration 
                    $ticket->update([
                        'status' => 2,
                    ]);
                    $postLogSystem = [
                        'ticket_code'   => $header->ticket_code,
                        'user_id'       => auth()->user()->id,
                        'approval_code' => $ticket->approval_code,
                        'duration'      => $finalDuration,
                        'step'          => 0,
                        'status'        => 2,
                        'remark'        => auth()->user()->name . ' has completed all tasks, please verify and close the ticket',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                    // dd($postLogSystem);
                 $testTerakhir =   UpdateSystemLog::create($postLogSystem);
            }  
            
            DB::commit();

            return ResponseFormatter::success(
                $header,
                'System successfully updated'
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            if (!empty($filename) && Storage::exists('public/updateSystem/task/' . $filename)) {
                Storage::delete('public/updateSystem/task/' . $filename);
            }

            return ResponseFormatter::error(
                $th->getMessage(),
                'System failed to update',
                500
            );
        }
    }
}
