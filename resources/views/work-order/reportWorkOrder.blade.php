<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
    <title>Work Order Transaction Report ({{$from}} - {{$to}})</title>
</head>
<body>
    <div class="container" style="text-align:center">
        <p style="font-size:10px;margin-top:-10px">
            <b style="font-size:14px">Work Order Transaction Report</b> <br>
            periode : {{date("d-m-Y", strtotime($from))}} - {{date("d-m-Y", strtotime($to))}}
        </p>
        <br>
        <div class="container" style="padding-left:80px;padding-right:80px">
            <table class="table-stepper">
                <thead>
                    <tr>
                        <th>New</th>
                        <th>On Progress</th>
                        <th>Revision</th>
                        <th>Pending</th>
                        <th>Done</th>
                        <th>Checking</th>
                        <th>Reject</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center;width:12%">{{$woNew->totalNew}}</td>
                        <td style="text-align:center;width:12%">{{$woOnProgress->totalProgress}}</td>
                        <td style="text-align:center;width:12%">{{$woRevision->totalRevision}}</td>
                        <td style="text-align:center;width:12%">{{$woPending->totalPending}}</td>
                        <td style="text-align:center;width:12%">{{$woDone->totalDone}}</td>
                        <td style="text-align:center;width:12%">{{$woOnChecking->totalChecking}}</td>
                        <td style="text-align:center;width:12%">{{$woReject->totalReject}}</td>
                        <td style="text-align:center;width:12%">{{$woCounting->totalWO}}</td>
                    </tr>
                </tbody>
            </table>

            <br>
            <table class="table-stepper" style="padding-left:80px;padding-right:80px">
                <thead>
                    <tr>
                        <th>Total Duration</th>
                        <th>Average</th>
                        <th>Office Name</th>
                        <th>Level</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($avgDuration as $item)
                    @php
                       $time =  date('H i', mktime(0, $item->totalDuration));
                       $timeExplode = explode(' ', $time);
                       $jam =$timeExplode[0];
                       $menit =$timeExplode[1]; 


                       $avgTime     = date('H i', mktime(0, $item->totalDuration / $woDone->totalDone));
                       $avgExplode  = explode(' ', $avgTime);
                       $avgHour     = $avgExplode[0];
                       $avgMinute   = $avgExplode[1];
                       
                    @endphp
                        <tr>
                            <td>{{$jam }} hour {{$menit}} minutes</td>
                            <td>{{$avgHour }} hour {{$avgMinute}} minutes</td>
                            <td>{{$item->officeName}}</td>
                            <td style="text-align: center">{{$item->level}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">
                                Data is Null
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
  
    <br>
    <p style="font-size:10px">
        <b>Detail RFM :</b>
    </p>
  
    <table class="table-stepper">
        <thead>
            <tr>
                <th>No</th>
                <th>Created At</th>
                <th>Request Code</th>
                <th>User</th>
                <th>Departement</th>
                <th>Categories</th>
                <th>Subject</th>
                <th>Add Info</th>
                <th>PIC</th>
                <th>Status</th>
                <th>Finished at</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
            @endphp
           
            @forelse ($reportWO as $item)
                @php
                    $statusLabel = '';
                    if($item->status_wo == 1){
                        $statusLabel ='On Progress';
                    }
                    else if($item->status_wo == 0){
                        $statusLabel ='New';
                    }
                    else if($item->status_wo == 2){
                        $statusLabel ='Pending';
                    }
                    else if($item->status_wo == 3){
                        $statusLabel ='Revision';
                    }
                    else if($item->status_wo == 4){
                        if($item->status_approval == 1){
                            $statusLabel ='Done';
                        }else{
                            $statusLabel ='Checking';
                        }
                    }else{
                        $statusLabel ='Reject';
                    }

                    $subject = explode('_',$item->subject)
                @endphp
                    <tr>
                        <td style="text-align:center">{{$i+1}}</td>
                        <td style="text-align:center">{{$item->created_at}}</td>
                        <td style="text-align:center">{{$item->request_code}}</td>
                        <td style="text-align:left">{{$item->username}}</td>
                        <td style="text-align:left">{{$item->departement_name}}</td>
                        <td style="text-align:left">{{$item->categories_name}}</td>
                        <td style="text-align:left">{{$subject[0]}}</td>
                        <td style="text-align:left">{{$item->add_info}}</td>
                        <td style="text-align:{{$item->picSupportName == null ? 'center': 'left'}}">{{$item->picSupportName == null ? '-' : $item->picSupportName->name}}</td>
                        <td style="text-align:left">{{$statusLabel}}</td>
                        <td style="text-align:center">{{$item->finished}}</td>
                    </tr>
                @php
                    $i++;
                @endphp
            @empty
                    <tr>
                        <td colspan="7">
                            Data is empty
                        </td>
                    </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
<style>
      .table-stepper{
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 9px;
        width: 100% !important;
        border: 1px solid #ddd;
        
  }
    .table-stepper tr:nth-child(even){background-color: #f2f2f2;}

    .table-stepper tr:hover {background-color: #ddd;}

    .table-stepper th {
        border: 1px solid #ddd;
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: center;
        background-color: #D61355;
        color: white;
        overflow-x:auto !important;
    }
    .table-stepper td, .datatable-stepper th {
        border: 1px solid #ddd;
        padding: 8px;
       
    }
    table tr:last-child {
        font-weight: bold;  
    }
</style>