<script>
    getCallback('getSystem', null, function(response){
        swal.close();
        mappingTable(response.data,'master_system_table')
    })
    getActiveItems('getModule','null','select_module', 'Module')
    getActiveItems('getModule','null','edit_select_module', 'Module')

    onChange('select_module','module')
    onChange('edit_select_module','edit_module')
    $('#btn_save_system').on('click', function(){
        var data = {
            'description': $('#description').val(),
            'name': $('#name').val(),
            'module': $('#module').val(),
        }
        postCallback('addSystem', data, function(response){
            swal.close();
            $('#addSystemModal').modal('hide');
            $('#description').val('')
            $('#name').val('')
            $('#module').val('')
            $('#select_module').val('')
            $('#select_module').select2().trigger('change')
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getSystem', null, function(response){
                mappingTable(response.data,'master_system_table')
            })
        })
    })
    $('#btn_update_system').on('click', function(){
        var data = {
            'id': $('#id').val(),
            'edit_description': $('#edit_description').val(),
            'edit_name': $('#edit_name').val(),
            'edit_module': $('#edit_module').val(),
        }
        postCallback('updateSystem', data, function(response){
            swal.close();
            $('#editSystemModal').modal('hide');
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getSystem', null, function(response){
                mappingTable(response.data,'master_system_table')
            })
        })
    })
    $('#master_system_table').on('click', '.edit', function(){
        var name = $(this).data('name');
        var description = $(this).data('description');
        var id = $(this).data('id');
        var module = $(this).data('module');
        $('.message_error').html('')
        $('#id').val(id)
        $('#edit_select_module').val(module)
        $('#edit_module').val(module)
        $('#edit_select_module').select2().trigger('change')
        $('#edit_name').val(name)
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
                                <td style="width:75%;text-align:left">${response[i].module_relation?.name || '-'}</td>
                                <td style="width:75%;text-align:left">${response[i].name}</td>
                                <td style="width:25%;text-align:center">
                                        <button title="Edit Category" class="edit btn btn-sm btn-info rounded" data-module="${response[i].module_id}"  data-description="${response[i].description}"  data-name="${response[i].name}" data-location="${response[i].location_id}"  data-id="${response[i]['id']}" data-toggle="modal" data-target="#editSystemModal">
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