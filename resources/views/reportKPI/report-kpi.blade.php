<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report KPI User - {{$user->id.date('Ymd')}}</title>
</head>
    <body>
        <div class="container">
            <h5 style="text-align:center">Report KPI User</h5>
        </div>
        <div class="container">
            <table style="font-size:11px;">
                <tr>
                    <td style="width:15%">
                        <span>Name</span>
                    </td>
                    <td style="width:2%">
                        <span>:</span>
                    </td>
                    <td style="width:83%">
                        <span>{{$user->name}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width:15%">
                        <span>Departement</span>
                    </td>
                    <td style="width:2%">
                        <span>:</span>
                    </td>
                    <td style="width:83%">
                        <span>{{$user->Departement->name}}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width:15%">
                        <span>Position</span>
                    </td>
                    <td style="width:2%">
                        <span>:</span>
                    </td>
                    <td style="width:83%">
                        <span>{{$user->Jabatan->name}}</span>
                    </td>
                </tr>
            </table>
           
        </div>
        <div class="caontainer"  style="justify-content:center;margin-top:20px">
          
            <table class="table-stepper">
                <thead>
                    <tr>
                        <th style="width:16%%">Kategori</th>
                        <th style="width:7%">Jan</th>
                        <th style="width:7%">Feb</th>
                        <th style="width:7%">Mar</th>
                        <th style="width:7%">Apr</th>
                        <th style="width:7%">Mei</th>
                        <th style="width:7%">Jun</th>
                        <th style="width:7%">Jul</th>
                        <th style="width:7%">Agu</th>
                        <th style="width:7%">Sep</th>
                        <th style="width:7%">Okt</th>
                        <th style="width:7%">Nov</th>
                        <th style="width:7%">Des</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center;font-weight:bold">WO Submited</td>
                        <td colspan="12" style="text-align:center"></td>
                    </tr>
                        @php
                            $countJan =[];
                            $countFeb =[];
                            $countMar =[];
                            $countApr =[];
                            $countMei =[];
                            $countJun =[];
                            $countJul =[];
                            $countAgu =[];
                            $countSep =[];
                            $countOkt =[];
                            $countNov =[];
                            $countDes =[];
         
                        @endphp
                    @if (count($kpiUserbyOffice1) > 0){
                        @foreach ($kpiUserbyOffice1 as $item)
                        @php
                            array_push($countJan,$item->januari);
                            array_push($countFeb,$item->februari);
                            array_push($countMar,$item->maret);
                            array_push($countApr,$item->april);
                            array_push($countMei,$item->mei);
                            array_push($countJun,$item->juni);
                            array_push($countJul,$item->juli);
                            array_push($countAgu,$item->agustus);
                            array_push($countSep,$item->september);
                            array_push($countOkt,$item->oktober);
                            array_push($countNov,$item->november);
                            array_push($countDes,$item->desember);
                        @endphp
                        <tr>
                            <td>{{$item->categoriesName}}</td>
                            <td style="text-align:center">{{$item->januari}}</td>
                            <td style="text-align:center">{{$item->februari}}</td>
                            <td style="text-align:center">{{$item->maret}}</td>
                            <td style="text-align:center">{{$item->april}}</td>
                            <td style="text-align:center">{{$item->mei}}</td>
                            <td style="text-align:center">{{$item->juni}}</td>
                            <td style="text-align:center">{{$item->juli}}</td>
                            <td style="text-align:center">{{$item->agustus}}</td>
                            <td style="text-align:center">{{$item->september}}</td>
                            <td style="text-align:center">{{$item->oktober}}</td>
                            <td style="text-align:center">{{$item->november}}</td>
                            <td style="text-align:center">{{$item->desember}}</td>
                    </tr>
                        @endforeach
                    }     
                        @else
                        <tr>
                            <td colspan="13" style="text-align:center">Data is empty</td>
                        </tr>                     
                    @endif
                    <tr>
                        <td style="text-align:center;font-weight:bold">WO Done</td>
                        <td colspan="12" style="text-align:center"></td>
                    </tr> 
                        @php
                            $doneJan =[];
                            $doneFeb =[];
                            $doneMar =[];
                            $doneApr =[];
                            $doneMei =[];
                            $doneJun =[];
                            $doneJul =[];
                            $doneAgu =[];
                            $doneSep =[];
                            $doneOkt =[];
                            $doneNov =[];
                            $doneDes =[];
                        @endphp
                    @if (count($kpiUserbyOfficeDone1) > 1){
                        @foreach ($kpiUserbyOfficeDone1 as $row)
                            @php
                                array_push($doneJan,$row->januari);
                                array_push($doneFeb,$row->februari);
                                array_push($doneMar,$row->maret);
                                array_push($doneApr,$row->april);
                                array_push($doneMei,$row->mei);
                                array_push($doneJun,$row->juni);
                                array_push($doneJul,$row->juli);
                                array_push($doneAgu,$row->agustus);
                                array_push($doneSep,$row->september);
                                array_push($doneOkt,$row->oktober);
                                array_push($doneNov,$row->november);
                                array_push($doneDes,$row->desember);                              
                            @endphp
                        <tr>
                            <td>{{$row->categoriesName}}</td>
                            <td style="text-align:center">{{$row->januari}}</td>
                            <td style="text-align:center">{{$row->februari}}</td>
                            <td style="text-align:center">{{$row->maret}}</td>
                            <td style="text-align:center">{{$row->april}}</td>
                            <td style="text-align:center">{{$row->mei}}</td>
                            <td style="text-align:center">{{$row->juni}}</td>
                            <td style="text-align:center">{{$row->juli}}</td>
                            <td style="text-align:center">{{$row->agustus}}</td>
                            <td style="text-align:center">{{$row->september}}</td>
                            <td style="text-align:center">{{$row->oktober}}</td>
                            <td style="text-align:center">{{$row->november}}</td>
                            <td style="text-align:center">{{$row->desember}}</td>
                    </tr>
                        @endforeach
                    }     
                        @else
                        <tr>
                            <td colspan="13" style="text-align:center">Data is empty</td>
                        </tr>                     
                    @endif
                    @php
                        $duration1=array_sum($doneJan) !=0 ?array_pop($donejan) : 0 ;  
                        $duration2=array_sum($doneFeb) !=0 ?array_pop($doneFeb) : 0 ;  
                        $duration3=array_sum($doneMar) !=0 ?array_pop($doneMar) : 0 ;  
                        $duration4=array_sum($doneApr) !=0 ?array_pop($doneApr) : 0 ;  
                        $duration5=array_sum($doneMei) !=0 ?array_pop($doneMei) : 0 ;  
                        $duration6=array_sum($doneJun) !=0 ?array_pop($doneJun) : 0 ;  
                        $duration7=array_sum($doneJul) !=0 ?array_pop($doneJul) : 0 ;  
                        $duration8=array_sum($doneAgu) !=0 ?array_pop($doneAgu) : 0 ;  
                        $duration9=array_sum($doneSep) !=0 ?array_pop($doneSep) : 0 ;  
                        $duration10=array_sum($doneOkt) !=0 ?array_pop($doneOkt) : 0 ;  
                        $duration11=array_sum($doneNov) !=0 ?array_pop($doneNov) : 0 ;  
                        $duration12=array_sum($doneDes) !=0 ?array_pop($doneDes) : 0 ;

                        $done1 = array_sum($doneJan);  
                        $done2 = array_sum($doneFeb);  
                        $done3 = array_sum($doneMar);  
                        $done4 = array_sum($doneApr);  
                        $done5 = array_sum($doneMei);  
                        $done6 = array_sum($doneJun);  
                        $done7 = array_sum($doneJul);  
                        $done8 = array_sum($doneAgu);  
                        $done9 = array_sum($doneSep);  
                        $done10 = array_sum($doneOkt);  
                        $done11 = array_sum($doneNov);  
                        $done12 = array_sum($doneDes); 

                        $count1 = array_sum($countJan);  
                        $count2 = array_sum($countFeb);  
                        $count3 = array_sum($countMar);  
                        $count4 = array_sum($countApr);  
                        $count5 = array_sum($countMei);  
                        $count6 = array_sum($countJun);  
                        $count7 = array_sum($countJul);  
                        $count8 = array_sum($countAgu);  
                        $count9 = array_sum($countSep);  
                        $count10 = array_sum($countOkt);  
                        $count11 = array_sum($countNov);  
                        $count12 = array_sum($countDes);  
                    @endphp
                    <tr>
                        <td style="font-weight:bold">Percentage</td>
                        <td style="text-align:center;font-weight:bold">{{$count1 == 0 ? '-' : round(($done1/$count1)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count2 == 0 ? '-' : round(($done2/$count2)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count3 == 0 ? '-' : round(($done3/$count3)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count4 == 0 ? '-' : round(($done4/$count4)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count5 == 0 ? '-' : round(($done5/$count5)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count6 == 0 ? '-' : round(($done6/$count6)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count7 == 0 ? '-' : round(($done7/$count7)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count8 == 0 ? '-' : round(($done8/$count8)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count9 == 0 ? '-' : round(($done9/$count9)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count10 == 0 ? '-' : round(($done10/$count10)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count11 == 0 ? '-' : round(($done11/$count11)*100,2).'%'}} </td>
                        <td style="text-align:center;font-weight:bold">{{$count12 == 0 ? '-' : round(($done12/$count12)*100,2).'%'}} </td>
                    </tr>
                    <tr>
                         <td style="font-weight:bold"> Actual Mean Time (Hour) </td>
                         <td style="text-align:center;font-weight:bold">{{$done1 == 0 ? '-' : round(($duration1/$done1))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done2 == 0 ? '-' : round(($duration2/$done2))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done3 == 0 ? '-' : round(($duration3/$done3))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done4 == 0 ? '-' : round(($duration4/$done4))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done5 == 0 ? '-' : round(($duration5/$done5))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done6 == 0 ? '-' : round(($duration6/$done6))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done7 == 0 ? '-' : round(($duration7/$done7))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done8 == 0 ? '-' : round(($duration8/$done8))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done9 == 0 ? '-' : round(($duration9/$done9))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done10 == 0 ? '-' : round(($duration10/$done10))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done11== 0 ? '-' : round(($duration11/$done11))}} </td>
                         <td style="text-align:center;font-weight:bold">{{$done12 == 0 ? '-' : round(($duration12/$done12))}} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    
        <div class="container" style="justify-content:center;margin-top:20px">
            <h6>Detail Ticket</h6>
            <table class="table-stepper">
                <thead>
                    <tr>
                        <th>Office</th>
                        <th>Request Code</th>
                        <th>Categories</th>
                        <th>Departement</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detailTicket as $item)
                        <tr>
                            <td>{{$item->kantor_name}}</td>
                            <td style="text-align:center">{{$item->request_code}}</td>
                            <td style="text-align:center">{{$item->categories_name}}</td>
                            <td style="text-align:center">{{$item->departement_name}}</td>
                            <td style="text-align:center">{{$item->status_wo}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center">Data is empty</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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