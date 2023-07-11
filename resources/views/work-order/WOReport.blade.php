<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
    <title>Work Order Ticket {{$getTicket->request_code}}</title>
</head>
<body>
    <div class="container" style="text-align:center">
        <h5 style="text-align: center">Work Order Ticket</h5>
        <table style="width:100%;font-size:9px;">
            <tr>
                <td style="width:12.5%">Request Code</td>
                <td style="width:1%">:</td>
                <td style="width:86.5%">{{$getTicket->request_code}}</td>
            </tr>
            <tr>
                <td style="width:12.5%">Request Date</td>
                <td style="width:1%">:</td>
                @php
                    $dateTime   = explode(' ', $getTicket->detailWORelation[0]->created_at);
                    $date       = date('d F Y', strtotime($dateTime[0]));
                    
                @endphp
                <td style="width:86.5%">{{$date}}</td>
            </tr>
        </table>
        <table class="table-stepper" style="width: 100%;font-size:11px;margin-top:10px">
            <tr>
                <td style="width : 15%">Request By</td>
                <td style="width : 1%">:</td>
                <td style="width : 24%">{{$getTicket->picName->name}}</td>
                <td style="width: 20%"></td>
                <td style="width: 15%"></td>
                <td style="width: 1%"></td>
                <td style="width: 24%"></td>
                
            </tr>
            <tr>
                <td style="width: 15%">PIC</td>
                <td style="width: 1%">:</td>
                <td style="width: 24%">{{$getTicket->picSupportName->name}}</td>
                <td style="width: 20%"></td>
                <td style="width: 15%"></td>
                <td style="width: 1%"></td>
                <td style="width: 24%"></td>
            </tr>
            <tr>
                <td style="width: 15%">Category</td>
                <td style="width: 1%">:</td>
                <td style="width: 24%">{{$getTicket->categoryName->name}}</td>
                <td style="width: 20%"></td>
                <td style="width: 15%">Problem Type</td>
                <td style="width: 24%" style="text-align: left">: {{$getTicket->problemTypeName->name}}</td>
                <td style="width: 1% !important"></td>
            </tr>
            <tr>
                <td style="width: 15%">Subject</td>
                <td style="width: 1%">:</td>
                <td style="width: 24%">{{$getTicket->subject}}</td>
                <td style="width: 20%"></td>
                <td style="width: 15%"></td>
                <td style="width: 1%"></td>
                <td style="width: 24%"></td>
            </tr>
            <tr>
                <td  style="width: 15%">Description</td>
                <td  style="width: 1%">:</td>
                <td  style="width: 24%">{{$getTicket->add_info}}</td>
                <td  style="width: 20%"></td>
                <td  style="width: 15%"></td>
                <td  style="width: 1%"></td>
                <td  style="width: 24%"></td>
            </tr>
            <tr>
                <td style="width: 15%">Status</td>
                <td style="width: 1%">:</td>
                <td style="width: 24%"><input type="checkbox" style="border-radius: 5px !important;" class="diterapkan" name="diterapkan" {{$getTicket->status_wo == 1  ?'checked="checked"':''}}> On Progress</td>
                <td style="width: 10%"><input type="checkbox" style="border-radius: 5px !important;" class="diterapkan" name="diterapkan" {{$getTicket->status_wo == 2 ?'checked="checked"':''}}> Pending</td>
                <td style="width: 20%"><input type="checkbox" style="border-radius: 5px !important;" class="diterapkan" name="diterapkan" {{$getTicket->status_wo == 3 ?'checked="checked"':''}}> Revision</td>
                <td style="width: 20%"><input type="checkbox" style="border-radius: 5px !important;" class="diterapkan" name="diterapkan" {{$getTicket->status_wo == 4 ?'checked="checked"':''}}> Done</td>
                <td style="width: 10%"><input type="checkbox" style="border-radius: 5px !important;" class="diterapkan" name="diterapkan" {{$getTicket->status_wo == 5 ?'checked="checked"':''}}> Reject</td>
            </tr>
        </table>
        <p style="text-align: left;font-size:9px">Detail Activity :</p>
        <table class="table-stepper" style="width: 100%;font-size:9px;margin-top:10px">
            <thead>
               <tr>
                    <th>Crated At</th>
                    <th>User</th>
                    <th>Comment</th>
               </tr>
            </thead>
            <tbody>
                @forelse ($getTicket->detailWORelation as $item)
                    @if($item->status_wo > 0){
                        @php
                            $itemDateTime       = explode(' ', $item->created_at);
                            $detailDate         = date('d F Y', strtotime($itemDateTime[0]));
                            $detailTime         = date('H:i:s', strtotime($itemDateTime[1]));
                            
                        @endphp
                        <tr>
                            <td style="width:15%">{{$detailDate}} {{$detailTime}}</td>
                            <td style="width:30%">{{$item->creatorRelation->name}}</td>
                            <td style="width:55%">{{$item->comment}}</td>
                        </tr>  
                    }
                    @endif
                @empty
                    <tr>
                        <td colspan="4">Data is Empty</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
            
            @php
                $splitName = explode(' ',$getTicket->picSupportName->locationRelation->city);
            @endphp
            <div class="container">
                <p style="font-size: 9px;text-align:right">{{$splitName[1]}}, {{date('F d Y')}}</p>
               <table style="width: 100%;font-size:9px;">
                   <tr>
                       <td style="width: 33%">
                           <p>Dibuat</p>
                               <br>
                               <br>
                               <br>
                               <br>
                               <br>
                               <br>
                               <p> {{$getTicket->picName->name}}</p>
                       </td>
                       <td style="width: 33%;text-align:center">
                           <p>Dikerjakan</p>
                               <br>
                               <br>
                               <br>
                               <br>
                               <br>
                               <br>
                               <p> {{$getTicket->picSupportName->name}}</p>
                       </td>
                       <td style="width: 33%;text-align:right">
                           <p>Mengetahui</p>
                               <br>
                               <br>
                               <br>
                               <br>
                               <br>
                               <br>
                               <p></p>
                       </td>
                   </tr>
               </table>
            </div>
    </div>
    <br>
    
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
        border: 1px solid  rgb(182, 181, 181);
        padding-top: 5px;
        font-size: 9px;
        padding-bottom: 5px;
        text-align: center;
        /* background-color: #D61355; */
        color: rgb(123, 121, 121);
        overflow-x:auto !important;
    }
    .table-stepper td, .datatable-stepper th {
        /* border: 1px solid #ddd; */
        padding: 8px;
       
    }
    table tr:last-child {
        font-weight: bold;  
    }



    .datatable-bordered{
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100% !important;
  font-size: 12px;
  overflow-x:auto !important;
  
  }
  .nav-sidebar{
    overflow-y: auto;
  }
  .dataTables_filter input { width: 300px }
  .datatable-bordered td, .datatable-bordered th {
  padding: 8px;
  }
  .datatable-bordered tr:nth-child(even){background-color: #f2f2f2;}

  .datatable-bordered tr:hover {background-color: #ddd;}

  .datatable-bordered th {
  border: 1px solid #ddd;
  padding-top: 10px;
  padding-bottom: 10px;
  text-align: center;
  background-color: white;
  color: black;
  overflow-x:auto !important;
  }

</style>