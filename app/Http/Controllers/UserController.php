<?php

namespace App\Http\Controllers;

use App\Models\MasterDepartement;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterKantor;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.user-index');
    }
    public function update_status_user(Request $request)
    {
        $id=$request->id;
        $flg_aktif=$request->flg_aktif;
        
        $post=[
            'flg_aktif'=>$flg_aktif==1?0:1
        ];
        $message ='Data Gagal diupdate';
        $update = User::find($id);
        $update->update($post);
        if($update){
            $message='Data berhasil diupdate';
        }else{
            $message="test";
        }
        return response()->json([
            'message'=>$message,
        ]);
    }
    public function detail_user(Request $request)
    {
        $detail = DB::table('view_user')->where('id', $request->id)->first();
        $departement = MasterDepartement::where('flg_aktif',1)->get();
        $kantor =MasterKantor::where('flg_aktif',1)->get();
        return response()->json([
            'detail'=>$detail,
            'kantor'=>$kantor,
          
            'departement'=>$departement,
        ]);
    }
    public function update_user_setting(Request $request)
    {
        $user_name = $request->user_name;
        $departement_id = $request->departement_id;
        $jabatan_id = $request->jabatan_id;
        $kode_kantor = $request->kode_kantor;
        $status=500;
        $message="Data failed to save";
        $validator = Validator::make($request->all(),[
            'user_name'=>'required',
            'departement_id'=>'required',
            'jabatan_id'=>'required',
            'kode_kantor'=>'required',
        ],[
            'user_name.required'=>'Nama user tidak boleh kosong',
            'departement_id.required'=>'Departement user tidak boleh kosong',
            'jabatan_id.required'=>'Jabatan user tidak boleh kosong',
            'kode_kantor.required'=>'Kantor user tidak boleh kosong',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $post=[
                'name'=>$user_name,
                'departement'=>$departement_id,
                'jabatan'=>$jabatan_id,
                'kode_kantor'=>$kode_kantor,
            ];
           
            $update = User::find($request->id)->update($post);
            if($update){
                $status=200;
                $message="Data berhasil diupdate";
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);
    }
    function getUserHris() {        
        set_time_limit(100000);
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://hris.pralon.co.id/application/API/getAttendance?emp_no=ALL&startdate='.date('Y-m-d').'&enddate='.date('Y-m-d'));
        $response = $request->getBody()->getContents();
        $data =json_decode($response, true);
        $status =500;
        $message ='Data has been failed import';
        $Arraypost=[];
        foreach($data as $row){
            $validation = User::where('nik',$row['emp_no'])->count();
            if($row['emp_no'] !=null){
                if($validation < 1){
                        
                        $post=[
                            'name'          =>$row['Full_Name'],
                            'nik'           =>$row['emp_no'],
                            'password'      => Hash::make('pass12345'),
                            'email'         =>'user'.$row['emp_no'].'@pralon.com'
                        ];
                        array_push($Arraypost,$post);
                        
                }
            }
        }
        $insert = User::insert($Arraypost);
        if($insert){
            $status =200;
            $message ='Data Successfully imported :)';
        }
        return response()->json([
           'status'=>$status,
           'message'=>$message
        ]);
    }

    function updateJoinDateUser() {
        set_time_limit(100000); // Extend execution time
        $users = User::where('start_date','0000-00-00')->get();
        $status = 500;
        $message = 'Failed to update data';
    
        foreach ($users as $user) {     
            $client = new \GuzzleHttp\Client();
            $response = $client->get('https://hris.pralon.co.id/application/API/getAttendance', [
                'query' => [
                    'emp_no' => $user->nik,
                    'startdate' => date('Y-m-d'),
                    'enddate' => date('Y-m-d'),
                ]
            ]);
    
            $responseBody = $response->getBody()->getContents();
            $data = json_decode($responseBody, true);
            $employee = [];
            // Check if $data is an array and contains a valid element at index 0
            if (is_array($data) && isset($data[0]) && isset($data[0]['start_date'])) {
                $start_date = explode(' ', $data[0]['start_date'])[0];
                
                if ($user->nik == $data[0]['emp_no']) {
                    if($user->start_date != $start_date){
                        $update = User::where('nik', $user->nik)->update(['start_date' => $start_date]);
                        if ($update) {
                            $status = 200;
                            $message = 'Successfully updated start date';
                        }
                    }else{
                        $post_employee = [
                            'nik'           => $user->nik,
                            'start_date'    =>$user->start_date,
                            'message'       =>'tidak sama'
                        ];
                        array_push($post_employee, $employee);
                    }
    
                }else{
                    $post_employee = [
                        'nik'   => $user->nik,
                        'start_date'    =>$user->start_date,
                        'message'       =>'tidak sama'
                    ];
                    array_push($post_employee, $employee);
                }
            } else {
                // Log or handle cases where the API response is not valid
                $message = "No valid data found for emp_no: {$user->nik}";
            }
        }
    
        return response()->json([
            'result'    => $employee,
            'status' => $status,
            'message' => $message,
        ]);
    }

    function durationRevision() {
    $header = WorkOrder::whereBetween('created_at', [
            Carbon::create(2024, 1, 1),
            // Carbon::create(2024, 8, 31)
             Carbon::now()
        ])
        ->where('status_wo', 4)
        ->where('status_approval', 1)
        ->where('level',1)
        ->get();

    foreach ($header as $row) {
        $pic = User::find($row->user_id_support);

        $start_wo = WorkOrderLog::where('request_code', $row->request_code)
            ->where('status_wo', 1)
            ->first();

        $end_wo = WorkOrderLog::where('request_code', $row->request_code)
            ->where('status_wo', 4)
            ->first();

        if (! $start_wo || ! $end_wo || ! $pic) {
            continue; // skip kalau data ga lengkap
        }

        $client = new \GuzzleHttp\Client();
        $api = $client->get(
            'https://hris.pralon.co.id/application/API/getAttendance?emp_no='
            . $pic->nik
            . '&startdate=' . $start_wo->created_at->format('Y-m-d')
            . '&enddate=' . $end_wo->created_at->format('Y-m-d')
        );
        $response = $api->getBody()->getContents();
        $data = json_decode($response, true);

        $durations = [];
        $finalDuration = 0;

        foreach ($data as $att) {
          if ($att['daytype'] == 'WD') {
            $start = Carbon::parse($att['shiftstarttime']);  // jam shift mulai
            $end   = Carbon::parse($att['shiftendtime']);    // jam shift selesai
            $startWO = Carbon::parse($start_wo->created_at); // jam WO mulai
            $endWO   = Carbon::parse($end_wo->created_at);   // jam WO selesai

            $minutes = 0;
            $validation = '';

            // ✅ kalau start_wo & end_wo di tanggal yang sama
            if ($startWO->isSameDay($endWO)) {
                $minutes = $startWO->diffInMinutes($endWO);
                $validation = 'same-day';
            } else {
                // ambil interval aktif WO dalam hari ini
                $activeStart = $startWO->greaterThan($start) ? $startWO : $start;
                $activeEnd   = $endWO->lessThan($end) ? $endWO : $end;

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
                'request_code'=>$row->request_code
            ];
        }
        // dd($durations);

            // WorkOrderLog::where('request_code', $row->request_code)
            //     ->where('status_wo', 4)
            //     ->where('status_approval', 1)
            //     ->limit(1)
            //     ->update(['duration' => $finalDuration]);

            WorkOrder::where('request_code', $row->request_code)->update([
                'duration' =>$finalDuration
            ]);
        }
        
    }
}

    
}
