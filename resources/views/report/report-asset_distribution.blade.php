<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BAST Asset Distribution</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
       body {
            font-size: 13px;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .subtitle {
            font-size: 13px;
            margin-bottom: 20px;
        }
        .table th {
            background-color: #f1f3f4;
            text-align: center;
            vertical-align: middle;
            font-weight: 600;
        }
        .table td {
            vertical-align: middle;
            padding: 6px 8px;
        }
        .signature {
            margin-top: 60px;
        }
        .signature td {
            padding: 40px;
            vertical-align: bottom;
            text-align: center;
            font-size: 13px;
        }
        .software-table {
            font-size: 12px;
            margin-top: 5px;
        }
        .software-table th {
            background-color: #e9ecef;
            font-weight: 500;
            text-align: left;
            padding: 4px 6px;
        }
        .software-table td {
            text-align: left;
            padding: 4px 6px;
        }
        .asset-code {
            font-weight: 600;
            margin-bottom: 3px;
        }
        .remark-col {
            text-align: left;
            max-width: 300px;
            white-space: normal;
            word-break: break-word;
        }
        .footer {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: gray;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-size: 12px;
              border: 1px solid #000;
        }

        .ttd-table th,
        .ttd-table td {
            border: 1px solid #000; /* bikin kotak */
            padding: 10px 10px;     /* kasih jarak biar lega */
            vertical-align: bottom;
        }
        .ttd-table th {
            font-weight: bold;
            text-transform: uppercase;
        }
        table.approval-table td {
                padding: 2px 6px; /* atas-bawah 2px, kiri-kanan 6px */
                line-height: 1.2; /* biar jarak antar teks rapat */
            }

            table.approval-table b {
                display: block; /* biar konsisten */
            }

    </style>
</head>
<body>
    {{-- Title --}}
    <div class="text-center">
        <div class="title">Item Transfer Record</div>
        <div class="subtitle">ASSET / INVENTORY</div>
    </div>

    {{-- Info --}}
    <table class="table table-borderless mb-3">
         <tr>
            <td style="width:25%;">Document Number</td>
            <td style="width:25%;">: {{ $data->request_code ?? '-' }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="width:25%;">Created at</td>
            <td style="width:25%;">: {{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Handed Over By</td>
            <td>: {{ $data->currentRelation->name ?? '-' }}</td>
            <td>Received By</td>
            <td>: {{ $data->receiverRelation->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Origin Location</td>
            <td>: {{ $data->locationRelation->name ?? '-' }}</td>
            <td>Destination Location</td>
            <td>: {{ $data->desLocationRelation->name ?? '-' }}</td>
        </tr>
    </table>

    <p>The following assets/inventory are hereby handed over:</p>

    {{-- Assets Table --}}
    <table class="table table-bordered table-striped table-hover table-sm align-middle" style="font-size: 12px !important;">
        <thead class="table-light text-center">
            <tr>
                <th style="width: 15%;">Received At</th>
                <th style="width: 30%;">Asset</th>
                <th style="width: 10%;">Category</th>
                <th style="width: 10%;">Condition</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data->detailRelation as $detail)
                @php
                    switch ($detail->condition) {
                        case 1:  $condition = 'Good'; break;
                        case 2:  $condition = 'Partially Good'; break;
                        case 3:  $condition = 'Damaged'; break;
                        default: $condition = '-';
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ \Carbon\Carbon::parse($detail->updated_at)->format('d F Y H:i:s') }}</td>
                    <td>
                        <div class="asset-code" style="text-align: center">{{ $detail->assetRelation->asset_code ?? '-' }}</div>

                        {{-- Software List --}}
                        @if(!empty($detail->assetRelation->softwareRelation) && $detail->assetRelation->softwareRelation->count() > 0)                          
                            <table class="table table-sm table-bordered software-table mt-1 mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:45%;">Name</th>
                                        <th style="width:55%;">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detail->assetRelation->softwareRelation as $software)
                                        <tr>
                                            <td>{{ $software->name ?? '-' }}</td>
                                            <td>{{ $software->details ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </td>
                    <td class="text-center">{{ $detail->assetRelation->categoryRelation->name ?? '-' }}</td>
                    <td class="text-center">{{ $condition }}</td>
                    <td class="remark-col">{{ $detail->remark ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <p>This Handover Report is prepared for proper use as required.</p>

    {{-- Signature --}}
    <br>
    <br>
    <br>
  <div class="ttd-box">
    <table class="ttd-table">
      <tr>
        @foreach($data->historyRelation->where('status', 1)->sortByDesc('id') as $approval)
            <td style="text-align:center; font-size:11px; line-height:1.3;">
                <div><b>Approved by</b></div>
                <div style="font-size:10px;">Approved at: {{ \Carbon\Carbon::parse($approval->created_at)->format('d F Y') }}</div>
                <div style="margin:6px 0;">
                    @if(!empty($approval->signature))
                        <img src="data:image/png;base64,{{ $approval->signature }}" height="50">
                    @endif
                </div>
               
            </td>
        @endforeach

        <td style="text-align:center; font-size:11px; line-height:1.3;">
            <div><b>Given by</b></div>
            <div style="font-size:11px;">
                Given at: {{ optional($data->historyRelation->where('status',2)->first())->created_at ? 
                    \Carbon\Carbon::parse($data->historyRelation->where('status',2)->first()->created_at)->format('d F Y') : '-' }}
            </div>
            <div style="margin:6px 0;">
                @if(!empty($data->historyRelation->where('status',2)->first()->signature))
                    <img src="data:image/png;base64,{{ $data->historyRelation->where('status',2)->first()->signature }}" height="50">
                @endif
            </div>
          
        </td>

        <td style="text-align:center; font-size:11px; line-height:1.3;">
            <div><b>Received by</b></div>
            <div style="font-size:11px;">
                Received at: {{ optional($data->historyRelation->where('status',3)->first())->created_at ? 
                    \Carbon\Carbon::parse($data->historyRelation->where('status',3)->first()->created_at)->format('d F Y') : '-' }}
            </div>
            <div style="margin:6px 0;">
                @if(!empty($data->historyRelation->where('status',3)->first()->signature))
                    <img src="data:image/png;base64,{{ $data->historyRelation->where('status',3)->first()->signature }}" height="50">
                @endif
            </div>
           
        </td>
    </tr>


        <tr>
            @foreach($data->historyRelation->where('status', 1)->sortByDesc('id') as $approval)
                <td>
                    <br>
                    <br>
                    <br>
                </td>
            @endforeach
            <td>
                    <br>
                    <br>
                    <br>
            </td>
            <td>
                    <br>
                    <br>
                    <br>
            </td>
        </tr>
        <tr>
        @foreach($data->historyRelation->where('status', 1)->sortByDesc('id') as $approval)
            <td style="text-align:center; font-size:11px; line-height:1.2;">
                <b>{{ $approval->userRelation->name ?? '-' }}</b><br>
                {{ $approval->userRelation->positionRelation->name ?? '-' }}
            </td>
        @endforeach

        <td style="text-align:center; font-size:11px; line-height:1.2;">
            <b>{{ $data->historyRelation->where('status',2)->first()->userRelation->name ?? '-' }}</b><br>
            {{ $data->historyRelation->where('status',2)->first()->userRelation->positionRelation->name ?? '-' }}
        </td>

        <td style="text-align:center; font-size:11px; line-height:1.2;">
            <b>{{ $data->historyRelation->where('status',3)->first()->userRelation->name ?? '-' }}</b><br>
            {{ $data->historyRelation->where('status',3)->first()->userRelation->positionRelation->name ?? '-' }}
        </td>
    </tr>

    </table>
</div>

</body>
</html>
