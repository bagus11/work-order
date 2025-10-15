<script>
    var data_first ={
        'department': $('#department_filter').val(),
        'user_filter': $('#user_filter').val(),
    }
    getCallback('getFileSharing', data_first, function(response){
        swal.close()
        mappingTable(response.data, 'file_sharing_table')
    })
    $('#btnFilter').on('click', function(){
        var data_first ={
            'department': $('#department_filter').val(),
            'user_filter': $('#user_filter').val(),
        }
        console.log(data_first)
        getCallback('getFileSharing', data_first, function(response){
        swal.close()
        mappingTable(response.data, 'file_sharing_table')
    })
    })
     $(document).ready(function() {
    // Biar dropdown Bootstrap nggak tertutup
    $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });

    // Init Select2
    $('#department_filter, #user_filter').select2({
        dropdownParent: $('#filter')
    });

    // Biar select2 nggak nutup dropdown saat dibuka/ditutup
    $('.dropdown-menu').on('select2:opening select2:closing', function(e) {
        e.stopPropagation();
    });
});

    getActiveItems('get_departement', null, 'select_department', 'Department')
    getActiveItems('get_departement', null, 'department_filter', 'Department')
    getActiveItems('get_username', null, 'user_filter', 'User')
    $('#btn_add_file').on('click', function(){
        $('#title').val('')
        $('#description').val('')
        $('#department_id').val('')
        $('#select_department').val('')
        $('#select_department').select().trigger('change')
    })
     $('#form_add_file_sharing').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $('#btn_save_file_sharing').prop('disabled', true);
        $('.message_error').text(''); // Clear previous errors
        
        $.ajax({
            url: '/addFileSharing', // Ganti dengan route Laravel kamu
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close()
                $('#btn_save_file_sharing').prop('disabled', false);
                $('#addFileSharingModal').modal('hide');
                $('#form_add_file_sharing')[0].reset();
                $('#select_department').val(null).trigger('change');

                toastr.success('File sharing added successfully!', 'Success');
            
            },
            error: function(xhr) {
                swal.close()
                $('#btn_save_file_sharing').prop('disabled', false);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong!', 'Error');
                }
            }
        });
    });
    $('#file_sharing_table').on('click', '.info', function(){
        $('#btn_cancel').prop('hidden', true)
        $('#btn_edit').prop('hidden', false)
        $('.edit_container').prop('hidden', true)

        var desc = $(this).data('desc')
        var id = $(this).data('id')
        var department = $(this).data('department')
        var created_at = $(this).data('created')
        var user = $(this).data('user')
        var attachment = $(this).data('attachment')
        var title = $(this).data('title')
        $('#edit_id').val(id)
        $('#title_label').html(': ' + title)
        $('#description_label').html(': ' + desc)
        $('#department_label').html(': ' + department)
        $('#created_at_label').html(': ' + created_at)
        $('#created_by_label').html(': ' + user)

        getCallback('getFileHistory', {'id' : id }, function(response){
            swal.close()
            mappingTableHistory(response.data, 'log_table')
        })
        $('#infoFileSharingModal').modal('show')
    })
    $('#btn_edit').on('click', function(e){
        e.preventDefault()
        $('#btn_cancel').prop('hidden', false)
        $('#btn_edit').prop('hidden', true)
        $('.edit_container').prop('hidden', false)
    })
    $('#btn_cancel').on('click', function(e){
           e.preventDefault()
        $('#btn_cancel').prop('hidden', true)
        $('#btn_edit').prop('hidden', false)
        $('.edit_container').prop('hidden', true)
    })

     $('#form_update_file_sharing').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData();
        formData.append('edit_id', $('#edit_id').val());
        formData.append('remark', $('#remark').val());

        let fileInput = $('#attachment_update')[0].files[0];
        if (fileInput) {
            formData.append('attachment_update', fileInput);
        }

        // Clear error messages
        $('.message_error').text('');

        $.ajax({
            url: '/fileSharingUpdate', // Ubah sesuai route-mu
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#btn_update_file_sharing').prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i>');
            },
            success: function (response) {
                toastr.success(response.message || 'File updated successfully!');
                $('#btn_update_file_sharing').prop('disabled', false)
                    .html('<i class="fas fa-check"></i>');
                $('.edit_container').slideUp();
                $('#btn_edit').show();
                $('#btn_cancel').hide();
                mappingTableHistory(response.data, 'log_table')
            },
            error: function (xhr) {
                $('#btn_update_file_sharing').prop('disabled', false)
                    .html('<i class="fas fa-check"></i>');

                if (xhr.status === 422) {
                    // Menampilkan pesan validasi dari Laravel
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong, please try again.');
                }
            }
        });
    });

    function mappingTable(response, table){
        var data =''
            $('#'+ table).DataTable().clear();
            $('#'+ table).DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                            const d = new Date(response[i].created_at)
                            const date = d.toISOString().split('T')[0];
                            const time = d.toTimeString().split(' ')[0];
                            var date_format = date + ' ' +time
                            let fileUrl = '/storage/' + response[i].attachment;
                        data += `<tr style="text-align: center;">
                                    <td style="text-align:left">${date_format}</td>
                                    <td style="text-align:left">${response[i].title}</td>
                                    <td style="text-align:left">${response[i].department_relation.name}</td>
                                    <td style="text-align:left">${response[i].user_relation.name}</td>
                                    <td style="text-align:left">
                                         ${
                                                response[i].attachment
                                                    ? `<a href="${fileUrl}" target="_blank" class="text-primary">
                                                        <i class="fas fa-paperclip"></i> View File
                                                    </a>`
                                                    : '-'
                                            }
                                    </td>
                                    <td>
                                       <button class="btn btn-sm btn-info info"
                                        data-id="${response[i].id}"
                                        data-created="${date_format}"
                                        data-desc="${response[i].description ?? ''}"
                                        data-department="${response[i].department_relation?.name ?? ''}"
                                        data-user="${response[i].user_relation?.name ?? ''}"
                                        data-attachment="${response[i].attachment ?? ''}"
                                        data-title="${response[i].title ?? ''}">
                                        <i class="fas fa-eye"></i>
                                    </button>                    
                                    </td>                                
                            </tr>
                            `;
                    }
            $(`#${table}> tbody:first`).html(data);
            $('#'+ table).DataTable({
                scrollX  : true,
            }).columns.adjust()
    }

    function mappingTableHistory(response, table){
        var data =''
            $('#'+ table).DataTable().clear();
            $('#'+ table).DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                            const d = new Date(response[i].created_at)
                            const date = d.toISOString().split('T')[0];
                            const time = d.toTimeString().split(' ')[0];
                            var date_format = date + ' ' +time
                            let fileUrl = '/storage/' + response[i].attachment_before;
                        data += `<tr style="text-align: center;">
                                    <td style="text-align:left">${date_format}</td>
                                    <td style="text-align:left">${response[i].user_relation.name}</td>
                                    <td style="text-align:left">${response[i].remark}</td>
                                    <td style="text-align:left">
                                         ${
                                                response[i].attachment_before
                                                    ? `<a href="${fileUrl}" target="_blank" class="text-primary">
                                                        <i class="fas fa-paperclip"></i> View File
                                                    </a>`
                                                    : '-'
                                            }
                                    </td>                         
                            </tr>
                            `;
                    }
            $(`#${table}> tbody:first`).html(data);
            $('#'+ table).DataTable({
                scrollX  : true,
            }).columns.adjust()
    }
</script>