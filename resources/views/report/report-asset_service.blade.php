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

        body { font-family: 'Poppins', sans-serif; font-size: 10pt; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 10px; }
        td, th { padding: 5px; vertical-align: top; }
        .title { font-size: 12pt; font-weight: bold; margin: 15px 0 8px 0; font-family: 'Poppins'; }
        .log-table th, .log-table td {
            border: 1px solid #000;
            font-size: 9pt;
        }
    </style>
</head>
<body>

    {{-- GENERAL INFORMATION --}}
    <div class="title">General Information</div>
    <table>
        <tr>
            <td width="25%">Service Code</td><td>: {{ $query->service_code }}</td>
            <td width="25%">Created By</td><td>: {{ $query->userRelation->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Request Code</td><td>: {{ $query->ticketRelation->request_code ?? '-' }}</td>
            <td>Asset Code</td><td>: {{ $query->assetRelation->asset_code ?? '-' }}</td>
        </tr>
        <tr>
            <td>Location</td><td>: {{ $query->locationRelation->name ?? '-' }}</td>
            <td>Department</td><td>: {{ $query->departmentRelation->name ?? '-' }}</td>
        </tr>
        <tr>
          <td>Subject</td>
            <td>: {{ $query->ticketRelation->subject ? ucfirst(strtolower($query->ticketRelation->subject)) : '-' }}</td>
            <td>Status</td><td>: {{ $query->status == 3 ? 'DONE' : 'In Progress' }}</td>
        </tr>
        <tr>
            <td>Notes</td><td colspan="3">: {{ $query->description ?? '-' }}</td>
        </tr>
    </table>

    <div class="title">Asset Information</div>
    <table>
        <tr>
            <td width="25%">Asset Code</td><td>: {{ $query->assetRelation->asset_code ?? '-' }}</td>
        </tr>
        <tr>
            <td>Category</td><td>: {{ $query->assetRelation->category ?? '-' }}</td>
            <td>Location</td><td>: {{ $query->assetRelation->locationRelation->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>User</td><td>: {{ $query->assetRelation->userRelation->name ?? '-' }}</td>
            <td>Department</td><td>: {{ $query->assetRelation->userRelation->departmentRelation->name ?? '-' }}</td>
        </tr>
    </table>
    {{-- {{$query->assetRelation->childRelation}} --}}
    @if($query->assetRelation->childRelation && $query->assetRelation->childRelation->count() > 0)
        <div class="title">Sub Asset(s)</div>
        <table class="log-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Asset Code</th>
                    <th width="20%">Category</th>
                    <th width="20%">Location</th>
                    <th width="35%">User</th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @foreach($query->assetRelation->childRelation as $child)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $child->asset_code ?? '-' }}</td>
                        <td>{{ $child->category ?? '-' }}</td>
                        <td>{{ $child->locationRelation->name ?? '-' }}</td>
                        <td>{{ $child->userRelation->name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    {{-- LOG / HISTORY --}}
    <div class="title">Log History</div>
    <table class="log-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Date</th>
                <th width="20%">User</th>
                <th width="15%">Status</th>
                <th width="40%">Remark</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach($query->historyRelation->whereIn('status', [1,3])->sortBy('id') as $log)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i:s') }}</td>
                    <td>{{ $log->userRelation->name ?? '-' }}</td>
                    <td>
                        @if($log->status == 1) In Progress
                        @elseif($log->status == 3) Done
                        @else {{ $log->status }}
                        @endif
                    </td>
                    <td>{{ $log->description ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
