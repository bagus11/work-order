<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ERP Report - {{ $data->ticket_code }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 6px; }
        .section-title { font-weight: bold; margin-top: 15px; margin-bottom: 5px; }
        h4 { margin: 10px 0 5px 45px; }
        ul { margin: 0 0 10px 75px; padding-left: 55px; }
        li { margin-bottom: 10px; line-height: 1.4; }
        li strong { display: inline-block; width: 80px; } 
        img { margin-top: 5px; margin-bottom: 5px; }

        .footer {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: gray;
        }

        .ttd-box {
            position: fixed;
            bottom: 80px; /* space before footer */
            left: 0;
            right: 0;
            width: 100%;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .ttd-table th, .ttd-table td {
            border: 1px solid #000;
            padding: 10px;
            height: 80px;
            vertical-align: bottom;
        }
    </style>
</head>
<body>
@php
    function formatDuration($minutes) {
        if (!$minutes) return '-';
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return ($hours > 0 ? $hours . ' hours ' : '') . ($mins > 0 ? $mins . ' minutes' : '');
    }
    function renderStatus($status) {
        switch ($status) {
            case 0: return 'Waiting for Approval';
            case 1: return 'In Progress';
            case 2: return 'Checked by PIC';
            case 3: return 'Revise';
            case 4: return 'Done';
            case 5: return 'Rejected';
            default: return 'Unknown';
        }
    }
@endphp

{{-- Ticket Data --}}
<table style="width:90%; border-collapse: collapse; margin: 0 auto 20px;">
    <tr>
        <td style="width:25%; font-weight:bold; border:none;">Ticket Code</td>
        <td colspan="3" style="border:none;">: {{ $data->ticket_code }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; border:none;">Created At</td>
        <td style="border:none;">: {{ date_format($data->created_at, 'd F Y H:i:s') }}</td>
        <td style="font-weight:bold; border:none;">Finished At</td>
        <td style="border:none;">: {{ date_format($data->updated_at, 'd F Y H:i:s') }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; border:none;">Created By</td>
        <td style="border:none;">: {{ $data->userRelation->name ?? '-' }}</td>
        <td style="font-weight:bold; border:none;">Employee ID</td>
        <td style="border:none;">: {{ $data->userRelation->nik ?? '-' }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; border:none;">Department</td>
        <td colspan="3" style="border:none;">: {{ $data->userRelation->departmentRelation->name ?? '-' }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; border:none;">Subject</td>
        <td colspan="3" style="border:none;">: {{ $data->subject ?? '-' }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold; border:none;">Remark</td>
        <td colspan="3" style="border:none;">: {{ $data->remark ?? '-' }}</td>
    </tr>
</table>


{{-- Request Information --}}
<div class="section-title">Request Information</div>
@if($data->detailRelation->count() > 0)
    @php $firstDetail = $data->detailRelation->first(); @endphp
    <table style="width:100%; border-collapse: collapse; margin-bottom: 15px; margin-left:20px;">
        <tr><td style="width:20%; font-weight:bold; border:none;">System</td><td style="border:none;">{{ $firstDetail->aspectRelation->name ?? '-' }}</td></tr>
        <tr><td style="font-weight:bold; border:none;">Module</td><td style="border:none;">{{ $firstDetail->moduleRelation->name ?? '-' }}</td></tr>
        <tr><td style="font-weight:bold; border:none;">Data Type</td><td style="border:none;">{{ $firstDetail->dataTypeRelation->name ?? '-' }}</td></tr>
        <tr><td style="font-weight:bold; border:none;">Details</td><td style="border:none;">:</td></tr>
    </table>
@endif

{{-- Data Addition --}}
@if($data->detailRelation->where('type', 1)->count() > 0)
    <h4>Data Addition</h4>
    <ul>
        @foreach($data->detailRelation->where('type', 1) as $detail)
            <li>
                <strong>Detail Code:</strong> {{ $detail->detail_code ?? '-' }} <br>
                <strong>Problem:</strong> {{ $detail->subject ?? '-' }} <br>
                <strong>PIC:</strong> {{ $detail->userRelation->name }} <br>
                <strong>Duration:</strong> {{ formatDuration($detail->duration) }}
            </li>
        @endforeach
    </ul>
@endif

{{-- Data Update --}}
@if($data->detailRelation->where('type', 2)->count() > 0)
    <h4>Data Update</h4>
    <ul>
        @foreach($data->detailRelation->where('type', 2) as $detail)
            <li>
                <strong>Detail Code:</strong> {{ $detail->detail_code ?? '-' }} <br>
                <strong>Problem:</strong> {{ $detail->subject ?? '-' }} <br>
                <strong>PIC:</strong> {{ $detail->userRelation->name }} <br>
                <strong>Duration:</strong> {{ formatDuration($detail->duration) }}
            </li>
        @endforeach
    </ul>
@endif

{{-- Duration --}}
<table style="width:100%; border-collapse: collapse; margin-bottom: 20px; margin-left:20px;">
    <tr>
        <td style="text-align:right; font-weight:bold; border:none; width:85%;">Total Duration</td>
        <td style="border:none; width:15%;">{{ formatDuration($data->duration) }}</td>
    </tr>
</table>

{{-- Signature Section --}}
@php
    $approvals = $data->historyRelation->where('status', 0)->sortBy('step');
@endphp

<div class="ttd-box">
    <table class="ttd-table">
        <tr>
            <th>EXECUTOR</th>
            @foreach($approvals->reverse()->values() as $i => $approval)
                <th>APPROVAL <br> Layer {{ $i+1 }}</th>
            @endforeach
            <th>REQUESTER</th>
        </tr>
        <tr>
            <td>
                <br><br><br><br><br>
                {{ $data->detailRelation->first()->userRelation->name ?? '-' }} <br>
                <small>{{ $data->detailRelation->first()->userRelation->departmentRelation->name ?? '-' }}</small>
            </td>
            @foreach($approvals->reverse()->values() as $approval)
                <td>
                    <br><br><br><br><br>
                    {{ $approval->userRelation->name ?? '-' }} <br>
                    <small>{{ $approval->userRelation->departmentRelation->name ?? '-' }}</small>
                </td>
            @endforeach
            <td>
                <br><br><br><br><br>
                {{ $data->userRelation->name ?? '-' }} <br>
                <small>{{ $data->userRelation->departmentRelation->name ?? '-' }}</small>
            </td>
        </tr>
    </table>
</div>


{{-- Footer --}}
<div class="footer">
   
</div>

</body>
</html>
