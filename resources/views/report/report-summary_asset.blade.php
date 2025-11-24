<!DOCTYPE html>
<html>
<head>
    <title>Summary Asset Report</title>
    <style>
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path("fonts/Poppins-Regular.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: bold;
            src: url('{{ public_path("fonts/Poppins-Bold.ttf") }}') format('truetype');
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
        }

        h3 {
            text-align: center;
            margin: 10px 0;
        }

        h4 {
            margin: 8px 0;
            font-size: 12px;
        }

        h5 {
            margin: 6px 0;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #666;
            padding: 5px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
            font-size: 11px;
        }

        td {
            font-size: 10px;
        }
    </style>
</head>
<body>
    @php
        $location = '';
        if($request->location_id){
            $header = DB::table('master_kantor')->where('id', $request->location_id)->value('name');
            $location = ' Location :  '.$header;
        }
    @endphp
   <h3>Summary Asset {{$location}}</h3> 
   <h3>{{date('d F Y')}}</h3>

 {{-- Chart Section --}}
<table width="100%" cellspacing="0" cellpadding="5" style="border:none;">
    @foreach(array_chunk($charts, 2, true) as $row)
        <tr>
            @foreach($row as $chart)
                <td width="50%" style="text-align:center; vertical-align:top;">
                    {!! $chart !!}
                </td>
            @endforeach
            @if(count($row) < 2)
                <td width="50%"></td>
            @endif
        </tr>
    @endforeach
</table>
   <br><br>
   <h4>Summary Table</h4>
{{-- Summary Section --}}
@foreach($summaries->chunk(2) as $row)
    <table width="100%" cellspacing="0" cellpadding="5" style="border:none; margin-bottom:15px;">
        <tr>
            @foreach($row as $summary)
                @php
                    $total = array_sum($summary['data']->toArray());
                @endphp
                <td width="50%" style="vertical-align:top; padding:0 10px;">
                    <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse:collapse; font-size:11px;">
                        <thead style="background-color:#f2f2f2;">
                            <tr>
                                <th style="text-align:left;">{{ $summary['title'] }}</th>
                                <th style="text-align:right;">Total</th>
                                <th style="text-align:right;">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($summary['data'] as $key => $count)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td style="text-align:right;">{{ $count }}</td>
                                    <td style="text-align:right;">
                                        {{ $total > 0 ? number_format(($count / $total) * 100, 2) : 0 }}%
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="font-weight:bold; background-color:#f9f9f9;">
                                <td>Total</td>
                                <td style="text-align:right;">{{ $total }}</td>
                                <td style="text-align:right;">100%</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            @endforeach
            @if(count($row) < 2)
                <td width="50%"></td>
            @endif
        </tr>
    </table>
@endforeach

   <br><br>

   {{-- Detail Asset Section --}}
   <h4>Detail Asset</h4>
   <table>
        <thead>
            <tr>
                <th style="width:3%;">#</th>
                <th style="width:12%;">Asset Code</th>
                <th style="width:10%;">Category</th>
                <th style="width:10%;">Brand</th>
                <th style="width:10%;">Location</th>
                <th style="width:10%;">Division</th>
                <th style="width:10%;">Department</th>
                <th style="width:8%;">Condition</th>
                <th style="width:12%;">User</th>
            </tr>
        </thead>
        <tbody>
        @foreach($assets as $i => $asset)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $asset->asset_code }}</td>
                <td>{{ optional($asset->categoryRelation)->name ?? '-' }}</td>
                <td>{{ $asset->brand ?? '-' }}</td>
                <td>{{ optional(optional($asset->userRelation)->locationRelation)->name ?? '-' }}</td>
                <td>{{ optional(optional(optional($asset->userRelation)->Departement)->divisionRelation)->name ?? '-' }}</td>
                <td>{{ optional(optional($asset->userRelation)->Departement)->name ?? '-' }}</td>
                <td>
                    @if($asset->condition == 1) Good
                    @elseif($asset->condition == 2) Partially Good
                    @elseif($asset->condition == 3) Damaged
                    @else -
                    @endif
                </td>
                <td>{{ optional($asset->userRelation)->name ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
   </table>
</body>
</html>
