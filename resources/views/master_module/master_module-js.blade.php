<script>
    getCallback('getModule', null, function(response){
        swal.close();
        mappingTable(response.data,'master_module_table')
    })
    getActiveItems('getAspek', null,'select_aspek', 'Aspek')
    getActiveItems('getAspek', null,'edit_select_aspek', 'Aspek')
    onChange('select_aspek','aspek_id')
    onChange('edit_select_aspek','edit_aspek_id')
    $('#btn_save_module').on('click', function(){
        var data = {
            'description': $('#description').val(),
            'name': $('#name').val(),
            'aspek_id': $('#aspek_id').val(),
        }
        postCallback('addModule', data, function(response){
            swal.close();
            $('#addModuleModal').modal('hide');
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getModule', null, function(response){
                mappingTable(response.data,'master_module_table')
            })
        })
    })
    $('#btn_update_module').on('click', function(){
        var data = {
            'id': $('#id').val(),
            'edit_description': $('#edit_description').val(),
            'edit_name': $('#edit_name').val(),
            'edit_aspek_id': $('#edit_aspek_id').val(),
        }
        postCallback('updateModule', data, function(response){
            swal.close();
            $('#editModuleModal').modal('hide');
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getModule', null, function(response){
                mappingTable(response.data,'master_module_table')
            })
        })
    })
    $('#master_module_table').on('click', '.edit', function(){
        var name = $(this).data('name');
        var description = $(this).data('description');
        var system = $(this).data('system');
        var id = $(this).data('id');
        $('.message_error').html('')
        $('#id').val(id)
        $('#edit_name').val(name)
        $('#edit_aspek_id').val(system)
        $('#edit_select_aspek').val(system)
        $('#edit_select_aspek').select2().trigger('change')
        $('#edit_description').val(description)
    })
      function mappingTable(response, table){
        var data =''
            $('#'+ table).DataTable().clear();
            $('#'+ table).DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="width:40%;text-align:left">${response[i].aspek_relation?.name || '-'}</td>
                                <td style="width:40%;text-align:left">${response[i].name}</td>
                                <td style="width:20%;text-align:center">
                                        <button title="Edit Category" class="edit btn btn-sm btn-info rounded"  data-description="${response[i].description}"  data-name="${response[i].name}" data-location="${response[i].location_id}" data-system="${response[i].aspek}"  data-id="${response[i]['id']}" data-toggle="modal" data-target="#editModuleModal">
                                            <i class="fas fa-solid fa-edit"></i>
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
</script>