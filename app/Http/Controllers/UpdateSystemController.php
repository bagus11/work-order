<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\FinalizeTicketRequest;
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
use \Mpdf\Mpdf as PDF;

class UpdateSystemController extends Controller
{
    function index() {
        return view('update_system.update_system-index');
    }

    function getTicketSystem()
    {
        $user = auth()->user();

        $query = UpdateSystem::with([
            'approverRelation',
            'userRelation',
            'userRelation.departmentRelation',
            'userRelation.locationRelation',
            'detailRelation',
            'detailRelation.historyRelation',
            'detailRelation.historyRelation.userRelation',
            'detailRelation.aspectRelation',
            'detailRelation.moduleRelation',
            'detailRelation.dataTypeRelation',
            'detailRelation.userRelation',
            'historyRelation',
            'historyRelation.userRelation',
        ]);

        // Kalau bukan developer, filter tiket
       if (!$user->hasRole('Developer') && !$user->hasRole('Head') ) {
            $query->where('status', 0)
                ->orWhereHas('detailRelation', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
        }

        $data = $query->get();

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
            'detailRelation.historyRelation',
            'detailRelation.historyRelation.userRelation',
            'detailRelation.aspectRelation',
            'detailRelation.moduleRelation',
            'detailRelation.dataTypeRelation',
            'detailRelation.userRelation',
            'historyRelation',
            'historyRelation.userRelation',
        ])->where('ticket_code', $request->ticket_code)->first();
        return response()->json([
            'data' => $data
        ]);
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/summernote'); 
            $url = asset(str_replace('public/', 'storage/', $path)); // mapping public -> storage

            return response()->json(['url' => $url], 200); // 🔑 key jadi 'url'
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
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
                // dd($post);
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
                $headerText .= "📝 <b>Ticket:</b> {$ticket_code}\n";
                $headerText .= "<b>Subject:</b> {$request->subject}\n";
                $headerText .= "<b>Additional Info:</b> {$request->add_info}\n\n";

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

                // if($firstImage){
                //     // kirim sekali dengan gambar
                //     Telegram::sendPhoto([
                //         'chat_id'    => env('TELEGRAM_CHANNEL_ID', '-1001800157734'),
                //         'photo'      => InputFile::create($firstImage), // <- disini
                //         'caption'    => $finalText,
                //         'parse_mode' => 'HTML'
                //     ]);
                // } else {
                //     // kirim sekali tanpa gambar
                //     Telegram::sendMessage([
                //         'chat_id'    => env('TELEGRAM_CHANNEL_ID', '-1001800157734'),
                //         'text'       => $finalText,
                //         'parse_mode' => 'HTML'
                //     ]);
                // }

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
        $statusHeader = 0;
        $statusMessage = '';
        if($request->erp_approval == 2){
            $status = 5;
            $statusMessage = 'rejected';
            $statusHeader = 5; 
        }else{
            $status = 0 ;
            $statusHeader = count($nextApproval) > 0 ? 0 : 1;
        }
        foreach($nextApproval as $row){
            $postNotification = [
                'message'      => auth()->user()->name.' has '.$statusMessage.' your Update Data Request',
                'subject'      => 'Update Data Request Approved',
                'status'       => $status,
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
            'status'        => $statusHeader,
            'pic'           => $currentApproval->step == 1 ? $request->erp_pic : $header->pic, 
            'updated_at'    => now(),
        ];
     
        $post_log =[
            'ticket_code'   => $request->erp_ticket_code,
            'user_id'       => auth()->user()->id,
            'approval_code' => $header->approval_code,
            'step'          => $currentApproval->step,
            'status'       => $status,
            'remark'        => $request->erp_remark ?? '',
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
        // dd($post);
        DB::transaction(function() use($request, $post, $postDetail, $statusMessage,$header, $array_approval, $status, $post_log, $currentApproval, $approval) {
            WONotification::where('request_code', $request->erp_ticket_code)
                ->update(['status' => 1]);
            UpdateSystem::where('ticket_code', $request->erp_ticket_code)
                ->update($post);
            if($currentApproval->step == 1){
                // if approval result == reject
                    if($status == 5 ){
                        DetailSystem::where('ticket_code', $request->erp_ticket_code)
                                    ->update([
                                        'status'  => $status
                                    ]);
                    }else{
                        DetailSystem::where('ticket_code', $request->erp_ticket_code)
                                    ->update($postDetail);
                    }
                // if approval result == reject
            }
            if(count($array_approval) > 0){
                WONotification::insert($array_approval);
            }
            UpdateSystemLog::create($post_log);

            // If last approval, notify creator to start task
                if($currentApproval->step == $approval->step){
                    $map = DetailSystem::where('ticket_code', $request->erp_ticket_code)->get();
                    foreach($map as $item) {
                        $postLogDetail = [
                            'ticket_code'   => $item->ticket_code,
                            'detail_code'   => $item->detail_code,
                            'user_id'       => auth()->user()->id,
                            'remark'        => 'Request has been '.$statusMessage.'. Please start the task',
                            'status'        => $status,
                            'duration'        => 0,
                            'created_at'    => now(),
                            'updated_at'    => now(),
                        ];
                        DetailSystemLog::create($postLogDetail);
                    }
                    $post_notif =[
                            'message'      => auth()->user()->name.' has '.$statusMessage.' your request. Please contact PIC to inform the completion of the request',
                            'subject'      => 'Update Data Request',
                            'status'       => $status,
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
                    return ResponseFormatter::success(
                            $postDetail,
                            'System successfully updated'
                        );
            // If last approval, notify creator to start task
        });
            return ResponseFormatter::success(
                            $postDetail,
                            'System successfully updated'
                        );
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

            // Perhitungan Duration Detail System
                  // Duration 
                    $detailLogTicket = DetailSystemLog::where('ticket_code', $header->ticket_code)->orderBy('id','desc')->first();
                        $client = new \GuzzleHttp\Client();
                        $api = $client->get(
                            'https://hris.pralon.co.id/application/API/getAttendance?emp_no='
                            . auth()->user()->nik
                            . '&startdate=' . $detailLogTicket->created_at->format('Y-m-d')
                            . '&enddate=' . date('Y-m-d H:i:s')
                        );
                        $responseDetail = $api->getBody()->getContents();
                        $dataDetail = json_decode($responseDetail, true);
                        $durationDetails = [];
                        $finalDurationDetails = 0;
                        
                        foreach ($dataDetail as $att) {
                        if ($att['daytype'] == 'WD') {
                            $startDetail = Carbon::parse($att['shiftstarttime']);  // jam shift mulai
                            $endDetails   = Carbon::parse($att['shiftendtime']);    // jam shift selesai
                            $startTicketDetails = Carbon::parse($detailLogTicket->created_at); // jam WO mulai
                            $endTicketDetails   = Carbon::now();   // jam WO selesai

                            $minuteDetails = 0;
                            $validationDetails = '';

                            // ✅ kalau start_wo & end_wo di tanggal yang sama
                            if ($startTicketDetails->isSameDay($endTicketDetails)) {
                                $minuteDetails = $startTicketDetails->diffInMinutes($endTicketDetails);
                                $validationDetails = 'same-day';
                            } else {
                                // ambil interval aktif WO dalam hari ini
                                $activeStartDetails = $startTicketDetails->greaterThan($startDetail) ? $startTicketDetails : $startDetail;
                                $activeEndDetails   = $endTicketDetails->lessThan($endDetails) ? $endTicketDetails : $endDetails;

                                // hitung hanya kalau masih ada sisa waktu valid
                                if ($activeEndDetails > $activeStartDetails) {
                                    $minuteDetails = $activeStartDetails->diffInMinutes($activeEndDetails);
                                    $validationDetails = 'valid';
                                } else {
                                    $minuteDetails = 0; // kalau WO di luar jam shift
                                    $validationDetails = 'skip';
                                }
                            }

                            $finalDurationDetails += $minuteDetails;

                            $durationDetails[] = [
                                'date'       => $att['date'] ?? $startDetail->toDateString(),
                                'start'      => $startDetail->format('H:i'),
                                'end'        => $endDetails->format('H:i'),
                                'minutes'    => $minuteDetails,
                                'total'      => $finalDurationDetails,
                                'validation' => $validationDetails,
                                'request_code'=>$detailLogTicket->request_code
                            ];
                        }
                    }
                // Duration 
            // Perhitungan Duration Detail System

            $post = [
                'status'        => 2,
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
                'duration'      => $finalDurationDetails,
                'attachment'    => $path,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
            if ($request->hasFile('finish_attachment')) {
                $file->storeAs('public/updateSystem/task', $filename);
            }
            DetailSystemLog::create($post_log);
            $header->update($post);
            $checkPending = DetailSystem::where('ticket_code', $ticket->ticket_code)
            ->whereIn('status', [0, 3])
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
                        'status'        => 1,
                        'remark'        => auth()->user()->name . ' has completed all tasks, please verify and close the ticket',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                    // dd($postLogSystem);
                 UpdateSystemLog::create($postLogSystem);
                  $post_notif =[
                        'message'      => auth()->user()->name.' has completed all tasks, please verify and close the ticket',
                        'subject'      => 'Update Data Request',
                        'status'       => 0,
                        'type'         => 2,
                        'request_code' => $header->ticket_code,
                        'link'         => 'update_system_check',
                        'userId'       => $header->user_id,
                        'created_at'   => now()
                ];
                WONotification::create($post_notif);
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
  function finalizeERP(Request $request, FinalizeTicketRequest $finalizeTicketRequest)
    {
        $finalizeTicketRequest->validated();

        DB::beginTransaction();

        try {
            $status  = $request->erp_result == '1' ? 4 : 3;
            $header = UpdateSystem::where('ticket_code', $request->erp_ticket_code)->first();
            $detail  = DetailSystem::where('ticket_code', $request->erp_ticket_code)->first();
            $duration  = $status == 4 
                ? UpdateSystemLog::where('ticket_code', $request->erp_ticket_code)->sum('duration') 
                : 0;
            $message = $status == 4 
                ? ' has finalized the ticket as DONE' 
                : ' has finalized the ticket as REVISE ';

            // data buat update UpdateSystem
            $post = [
                'status'     => $status,
                'updated_at' => now(),
                'remark'     => $request->erp_remark_result,
                'duration'   => $duration,
            ];
            // update UpdateSystem
            $header->update($post);
            // log ke UpdateSystemLog
            $postLogSystem = [
                'ticket_code'   => $header->ticket_code,
                'user_id'       => auth()->user()->id,
                'approval_code' => $header->approval_code,
                'duration'      => $duration,
                'step'          => 0,
                'status'        => $status,
                'remark'        => auth()->user()->name . $message,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
            UpdateSystemLog::create($postLogSystem);
            foreach (DetailSystem::where('ticket_code', $header->ticket_code)->get() as $item) {
                $durationDetails  = $status == 4 
                    ? DetailSystemLog::where('ticket_code', $item->ticket_code)
                        ->where('detail_code', $item->detail_code)
                        ->sum('duration') 
                    : 0;
                // log ke DetailSystemLog
                $postLogDetail = [
                    'ticket_code'   => $item->ticket_code,
                    'detail_code'   => $item->detail_code,
                    'user_id'       => auth()->user()->id,
                    'remark'        => $request->erp_remark_result,
                    'status'        => $status,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
                DetailSystemLog::create($postLogDetail);
                if ($status == 3) {
                    // kalau direvisi, balikin status detail ke 0 (open)
                    $item->update([
                        'status'    => 3,
                        'end_date'  => '0000-00-00',
                    ]);
                }
                if($status == 4){

                    // kalau done, pastiin semua detail udah done
                    $item->update([
                        'status'    => 4,
                        'duration'  => $durationDetails,
                    ]);
                }
            }

            // notifikasi
            $post_notif = [
                'message'      => auth()->user()->name . $message,
                'subject'      => 'Update Data Request',
                'status'       => 0,
                'type'         => 1,
                'request_code' => $header->ticket_code,
                'link'         => 'update_system',
                'userId'       => $header->user_id,
                'created_at'   => now()
            ];
            WONotification::create($post_notif);

            // commit kalau semua sukses
            DB::commit();

            return ResponseFormatter::success($post, 'Ticket finalized successfully');

        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseFormatter::error([
                'error' => $th->getMessage()
            ], 'Failed to finalize ticket', 500);
        }
    }

    public function printERP($id)
    {
        $ticket_code = str_replace("_", "/", $id);
        $data = UpdateSystem::with([
            'approverRelation',
            'userRelation',
            'userRelation.departmentRelation',
            'userRelation.locationRelation',
            'detailRelation',
            'detailRelation.historyRelation',
            'detailRelation.historyRelation.userRelation',
            'detailRelation.aspectRelation',
            'detailRelation.moduleRelation',
            'detailRelation.dataTypeRelation',
            'detailRelation.userRelation',
            'historyRelation',
            'historyRelation.userRelation',
        ])->where('ticket_code', $ticket_code)->first();

        // Render blade jadi HTML
        $html = view('report.report-erp', compact('data'))->render();
        $imageLogo          = '<img src="'.public_path('icon.png').'" width="70px" style="float: right;"/>';
        $header             = '';
        $header             .= '<table width="100%">
                                    <tr>
                                        <td style="padding-left:10px;">
                                            <span style="font-size: 16px; font-weight: bold;"> PT PRALON</span>
                                            <br>
                                            <span style="font-size:9px;">Synergy Building #08-08 Tangerang 15143 - Indonesia +62 21 304 38808</span>
                                        </td>
                                        <td style="width:33%"></td>
                                            <td style="width: 50px; text-align:right;">'.$imageLogo.'
                                        </td>
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
            $mpdf->Output('Report Wo'.'('.date('Y-m-d').').pdf', 'I');
    
        // // Output langsung ke browser
        // return response($mpdf->Output("ERP-Report-{$ticket_code}.pdf", 'I'))
        //     ->header('Content-Type', 'application/pdf');
    }
}
