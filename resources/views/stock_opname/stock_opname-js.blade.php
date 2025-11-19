<script>
    $(document).ready(function() {
        // Initialize the DataTable
            var table = $('#stock_opname_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'getStockOpname',
                    type: 'GET'
                },
                columns: [
                    { data: 'ticket_code', name: 'id',  className: 'text-center', },
                    { 
                        data: 'status', 
                        name: 'status',
                        className: 'text-center',
                        render: function(data, type, row) {
                            switch(data) {
                                    case 0: return '<span class="badge bg-secondary">Draft</span>';
                                    case 1: return '<span class="badge bg-warning">Waiting Approval</span>';
                                    case 2: return '<span class="badge bg-info">In Progress</span>';
                                    case 3: return '<span class="badge bg-primary">Checking</span>';
                                    case 4: return '<span class="badge bg-success">Done</span>';
                                    case 5: return '<span class="badge bg-danger">Rejected</span>';
                                    default: return '<span class="badge bg-dark">Unknown</span>';
                            }
                        }
                    },
                    {
                        data: 'start_date', 
                        name: 'start_date',  
                        className: 'text-center',
                        render: function(data, type, row) {
                            return row.status == 0 || row.status ==1 ? '-' : data;
                        }
                    },
                    { data: 'subject', name: 'subject' },
                    { data: 'location_relation.name', name: 'location_relation.name' },
                    { data: 'department_relation.name', name: 'department_relation.name' },
                ]
            });
     $('#stock_opname_table tbody').on('click', 'tr', function (e) {
        const row = table.row(this).data();
        if (row) {
          var status = '';
            switch(row.status) {
                case 0:
                    status = '<span class="badge bg-secondary">Draft</span>';
                    break;
                case 1:
                    status = '<span class="badge bg-warning">Waiting Approval</span>';
                    break;
                case 2:
                    status = '<span class="badge bg-info">In Progress</span>';
                    break;
                case 3:
                    status = '<span class="badge bg-primary">Checking</span>';
                    break;
                case 4:
                    status = '<span class="badge bg-success">Done</span>';
                    break;
                case 5:
                    status = '<span class="badge bg-danger">Rejected</span>';
                    break;
                default:
                    status = '<span class="badge bg-dark">Unknown</span>';
            }

            e.stopPropagation();
            $('#so_ticket_code_label').text(" : " +row.ticket_code);
            $('#so_created_by_label').text(" : " +row.user_relation.name);
            $('#so_location_label').text(" : " +row.location_relation.name);
            $('#so_department_label').text(" : " +row.department_relation.name);
            $('#so_subject_label').text(" : " +row.subject);
            $('#so_description_label').text(" : " +row.description);
            $('#so_ticket_code').val(row.ticket_code);
            $('#so_status_label').html( " : " +status);
            $('#infoSoModal').modal('show');
            let formattedStartDate = ': -';
            if (row.status !== 0 && row.status !== 1) {
                let dateObj = new Date(row.start_date);
                const options = { day: '2-digit', month: 'long', year: 'numeric' };
                formattedStartDate = ' : ' + dateObj.toLocaleDateString('id-ID', options);
            }
            $("#so_start_date_label").text(formattedStartDate);
            let formattedEndDate = ': -';
            if (row.status === 4 && row.end_date) {
                let dateObj = new Date(row.end_date);
                const options = { day: '2-digit', month: 'long', year: 'numeric' };
                formattedEndDate = ' : ' + dateObj.toLocaleDateString('id-ID', options);
            }
            $("#so_end_date_label").text(formattedEndDate);
        }
          $("#so_detail_content").empty(); // reset isi lama

         if (row.list_relation && row.list_relation.length > 0) {
            let html = `
                <div class="table-responsive">
                    <table id="so_detail_table" class="table table-sm table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Asset Code</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Condition Before</th>
                                <th>Condition After</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            row.list_relation.forEach(function (item, index) {
                // mapping condition
                let conditionLabel = '<span class="badge bg-secondary">Not Checked</span>';
                let conditionLabelBefore = '<span class="badge bg-secondary">Not Checked</span>';
                if (item.status == 1) {
                    console.log(item.asset_relation.condition == 1)
                    switch(item.condition_after) {
                        case 1:
                            conditionLabel = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Good</span>';
                            break;
                        case 2:
                            conditionLabel = '<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle"></i> Partially Good</span>';
                            break;
                        case 3:
                            conditionLabel = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Damaged</span>';
                            break;
                        default:
                            conditionLabel = '<span class="badge bg-dark">Unknown</span>';
                    }
                    switch(item.condition_before) {
                        case 1:
                            conditionLabelBefore = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Good</span>';
                            break;
                        case 2:
                            conditionLabelBefore = '<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle"></i> Partially Good</span>';
                            break;
                        case 3:
                            conditionLabelBefore = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Damaged</span>';
                            break;
                        default:
                            conditionLabelBefore = '<span class="badge bg-dark">Unknown</span>';
                    }
                }

                let assetCode = item.asset_code ?? '-';
                let categoryName = item.asset_relation && item.asset_relation.category_relation 
                    ? item.asset_relation.category_relation.name 
                    : '-';
                let brandName = item.brand_relation ? item.brand_relation.name : '-';
                console.log(item);
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td><strong>${assetCode}</strong></td>
                        <td>${item.asset_relation.category}</td>
                        <td>${item.asset_relation.brand || '-'}</td>
                        <td>${conditionLabelBefore}</td>
                        <td>${conditionLabel}</td>
                    </tr>
                `;
            });

            html += `
                        </tbody>
                    </table>
                </div>
            `;

            $("#so_detail_content").html(html);

            // 🔥 Aktifin DataTable untuk search + paginate + sort
            $('#so_detail_table').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: "Search Asset:",
                    lengthMenu: "Show _MENU_ entries",
                    zeroRecords: "No matching assets found",
                    info: "Showing _START_ to _END_ of _TOTAL_ assets",
                    infoEmpty: "No assets available",
                    infoFiltered: "(filtered from _MAX_ total assets)"
                }
            });

        } else {
            $("#so_detail_content").html('<p class="text-muted">No asset list available.</p>');
        }


    
      })

      $('#btn_refresh_stock_opname').on('click', function() {
            table.ajax.reload();
        });

        $('#btn_add_stock_opname').on('click', function() {
            $('#subject').val('');
            $('#description').val('');
        });
    });

    

    $('#btn_save_stock_opname').on('click', function(){
        var data ={
            'subject': $('#subject').val(),
            'currentPath': $('#currentPath').val(),
            'description': $('#description').val(),
        }
        postCallback('addStockOpname', data, function(response) {
            swal.close()
           toastr['success'](response.meta.message);
            $('#addStockOpnameModal').modal('hide');
            $('#stock_opname_table').DataTable().ajax.reload(); 
        });
    })
</script>