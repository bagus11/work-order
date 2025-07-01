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