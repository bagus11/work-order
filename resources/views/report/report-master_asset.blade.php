<!DOCTYPE html>
<html>
<head>
    <title>Detail Asset Report </title>
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
                /* font-size: 10px !important; */
            }
        .section-title {
            background-color: #f2f2f2;
            padding: 5px;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table td {
            padding: 5px;
            font-size: 10pt;
        }
        .child-table, .child-table th, .child-table td {
            border: 1px solid #ddd;
            border-collapse: collapse;
            font-size: 9pt;
            padding: 5px;
        }
        .child-table {
            width: 100%;
            margin-top: 10px;
        }
        .child-table th {
            background: #f2f2f2;
            text-align: left;
        }
        footer{
            border: none !important;
        }
    </style>
</head>
<body>

    {{-- General Information --}}
    <div class="section-title">General Information</div>
    <table class="info-table">
        <tr>
            <td width="20%">Asset Code</td>
            <td width="30%">: {{ $data->asset_code }}</td>
            <td width="20%">Category</td>
            <td width="30%">: {{ $data->category ?? '-' }}</td>
        </tr>
        <tr>
            <td>Brand</td>
            <td>: {{ $data->brand }}</td>
            <td>Type</td>
            <td>: {{ $data->type == 1 ? "Parent" : "Child"}}</td>
        </tr>
        <tr>
            <td>Parent</td>
            <td>: {{ $data->parent ?? '-' }}</td>
            <td>Current PIC</td>
            <td>: {{ $data->userRelation->name ?? '-' }}</td>
        </tr>
        <tr>
            @php
                $condition = '';
                switch ( $data->condition) {
                    case 1:
                        $condition = 'Good';
                        break;
                    case 2:
                        $condition = 'Partially Good';
                        break;
                    case 3:
                        $condition = 'Damaged';
                        break;
                    default:
                        $condition = '-';
                        break;
                }
            @endphp
            <td>Location</td>
            <td>: {{ $data->userRelation->locationRelation->name ?? '-' }}</td>
            <td>Condition</td>
            <td>: {{$condition }}</td>
        </tr>
    </table>
<br>
 @if(isset($data->specRelation))
     <div class="section-title">Detail Asset</div>
    <table width="100%" cellspacing="0" cellpadding="5" border="0" style="font-family: Poppins, sans-serif; font-size: 12px;">
        <tr>
            <td width="25%">Type</td>
            <td width="25%">: {{ $data->specRelation->type ?? '-' }}</td>
            <td width="25%">CD / DVD</td>
            <td width="25%">: {{ $data->specRelation->cd == 0 ? '-' : $data->specRelation->cd }}</td>
        </tr>
        <tr>
            <td>IP Address</td>
            <td>: {{ $data->specRelation->ip_address ?? '-' }}</td>
            <td>Mac Address</td>
            <td>: {{ $data->specRelation->mac_address ?? '-' }}</td>
        </tr>
        <tr>
            <td>Processor</td>
            <td>: {{ $data->specRelation->processor ?? '-' }}</td>
            <td>Protection</td>
            <td>: {{ $data->specRelation->protection ?? '-' }}</td>
        </tr>
        <tr>
            <td>RAM</td>
            <td>: {{ $data->specRelation->ram ?? '-' }} GB</td>
            <td>Storage</td>
            <td>: {{ $data->specRelation->storage ?? '-' }} GB</td>
        </tr>
    </table>
@endif
    <br>
    {{-- Asset Child --}}
    @if(isset($data->childRelation) && count($data->childRelation) > 0)
        <div class="section-title">Asset Child</div>
        <table class="child-table">
            <thead>
                <tr>
                    <th>Asset Code</th>
                    <th>Category</th>
                    <th>Brand</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->childRelation as $child)
                    <tr>
                        <td>{{ $child->asset_code }}</td>
                        <td>{{ $child->category }}</td>
                        <td>{{ $child->brand }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
        <br>
    {{-- Installed Software --}}
    @if(isset($data->softwareRelation) && count($data->softwareRelation) > 0)
        <div class="section-title">Installed Software</div>
        <table class="child-table">
            <thead>
                <tr>
                    <th>Software Name</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->softwareRelation as $sw)
                    <tr>
                        <td>{{ $sw->name }}</td>
                        <td>{{ $sw->details ?? '-' }}</td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
        <br>
      {{-- History --}}
    @if(isset($data->historyRelation) && count($data->historyRelation) > 0)
        <div class="section-title">History</div>
        <table class="child-table">
            <thead>
                <tr>
                    <th>Created At</th>
                    <th>Created by</th>
                    <th>PIC</th>
                    <th>Status</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->historyRelation as $h)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($h->created_at)->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $h->creatorRelation->name ?? '-' }}</td>
                        <td>{{ $h->userRelation->name ?? '-' }}</td>
                        <td>{{ $h->is_active == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $h->remark ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
