<!DOCTYPE html>
<html>
<head>
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
            font-size: 10pt;
            color: #333;
            margin: 20px;
        }

        h1,  {
            font-size: 12pt;
            font-weight: bold;
            color: #222;
            border-left: 5px solid #BF092F;
            padding-left: 8px;
            margin-bottom: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 15px;
        }

        td, th {
            padding: 6px 8px;
            vertical-align: top;
        }
        .info-table {
            width: 52% !important;
        }
        
        .info-table td:first-child {
            font-weight: bold;
            width: 10% !important;
            color: #000;
        }

        .info-table td:nth-child(2) {
            width: 3%;
            /* font-weight: bold; */
            text-align: center;
        }

        .info-table td:last-child {
            color: #444;
        }

        /* Asset Detail Table */
        .info-table-detail {
            width: 85% !important;
            /* border: 1px solid #ddd; */
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .info-table-detail tr:nth-child(even) {
            /* background-color: #f9f9f9; */
        }

        .info-table-detail td {
            padding: 6px 8px;
            vertical-align: middle;
        }

        .info-table-detail td:first-child,
        .info-table-detail td:nth-child(3) {
            color: #000;
        }

        .info-table-detail td:nth-child(2),
        .info-table-detail td:nth-child(4) {
         
        }

        /* Section: Log Table */
        .log-table {
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .log-table th {
            /* background-color: #BF092F; */
            /* color: #fff; */
            color: black
            text-align: center;
            font-size: 9pt;
            padding: 8px;
            /* border: 1px solid #BF092F; */
        }

        .log-table td {
            border: 1px solid #ddd;
            font-size: 9pt;
            padding: 6px;
        }

        .log-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .log-table tr:hover {
            background-color: #eef5ff;
        }

        .footer {
            margin-top: 30px;
            font-size: 8pt;
            text-align: center;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .title{
            margin-bottom: 20px;
            font-size: 13pt;
            text-align: center;
            font-weight: bold;

        }
    </style>
</head>
<body>
    <div class="title">
        Asset Service History Report
    </div>

    <h1>General Information</h1>
    <table class="info-table">
        <tr>
            <td>Asset Code</td>
            <td>:</td>
            <td>{{ $asset->asset_code ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Asset Type</td>
            <td>:</td>
            <td>{{ $asset->type == 1 ? 'Parent' : 'Child' }}</td>
        </tr>
        <tr>
            <td>Asset Category</td>
            <td>:</td>
            <td>{{ $asset->category ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>User</td>
            <td>:</td>
            <td>{{ $asset->userRelation->name ?? 'N/A' }} ({{$asset->userRelation->nik ?? 'N/A'}})</td>
        </tr>
        <tr>
            <td>Department</td>
            <td>:</td>
            <td>{{ $asset->userRelation->departmentRelation->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Location</td>
            <td>:</td>
            <td>{{ $asset->locationRelation->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Current Condition</td>
            <td>:</td>
            <td>
                {{
                    [
                        '1' => 'Good',
                        '2' => 'Partially Good',
                        '3' => 'Damaged'
                    ][$query[0]->assetRelation->condition] ?? 'N/A'
                }}
            </td>
        </tr>
    </table>
    @if ($asset->specRelation !== null)
        <h1>Asset Detail</h1>
        <table class="info-table-detail">
            <tr>
                <td width="25%">Type</td>
                <td width="25%">: {{ $asset->specRelation->type ?? '-' }}</td>
                <td width="25%">CD / DVD</td>
                <td width="25%">: {{ $asset->specRelation->cd == 0 ? '-' : $asset->specRelation->cd }}</td>
            </tr>
            <tr>
                <td>IP Address</td>
                <td>: {{ $asset->specRelation->ip_address ?? '-' }}</td>
                <td>Mac Address</td>
                <td>: {{ $asset->specRelation->mac_address ?? '-' }}</td>
            </tr>
            <tr>
                <td>Processor</td>
                <td>: {{ $asset->specRelation->processor ?? '-' }}</td>
                <td>Protection</td>
                <td>: {{ $asset->specRelation->protection ?? '-' }}</td>
            </tr>
            <tr>
                <td>RAM</td>
                <td>: {{ $asset->specRelation->ram ?? '-' }} GB</td>
                <td>Storage</td>
                <td>: {{ $asset->specRelation->storage ?? '-' }} GB</td>
            </tr>
        </table>
    @endif


    <h1>Log History</h1>
    <table class="log-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Date</th>
                <th width="20%">Request Code</th>
                <th width="15%">User</th>
                <th width="25%">Subject</th>
                <th width="20%">Remark</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($query as $log)
            <tr>
                <td align="center">{{ $no++ }}</td>
                <td>{{ date('d-m-Y H:i:s', strtotime($log->created_at)) }}</td>
                <td>{{ $log->service_code }}</td>
                <td>{{ $log->ticketRelation->picName->name ?? 'N/A' }}</td>
                <td>{{ $log->ticketRelation->subject }}</td>
                <td>{{ $log->ticketRelation->add_info }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
