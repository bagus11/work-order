<script>
    getCallback('getRoom', null, function(response){
        swal.close();
        mappingTable(response.data,'master_room_table')
    })
 getActiveItems('get_kantor', null, 'edit_select_location', 'Location')
    $('#btn_add_room').on('click', function(){
        $('.message_error').html('')
        getActiveItems('get_kantor', null, 'select_location', 'Location')
        $('#location_id').val('')
        $('#name').val('')
    })
    onChange('select_location', 'location_id')
    $('#btn_save_room').on('click', function(){
        var data = {
            'location_id': $('#location_id').val(),
            'name': $('#name').val(),
        }
        postCallback('addRoom', data, function(response){
            swal.close();
            $('#addRoomModal').modal('hide');
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getRoom', null, function(response){
                mappingTable(response.data,'master_room_table')
            })
        })
    })
    onChange('edit_select_location', 'edit_location_id')
    $('#btn_update_room').on('click', function(){
        var data = {
            'id': $('#id').val(),
            'location_id': $('#edit_location_id').val(),
            'name': $('#edit_name').val(),
        }
        postCallback('updateRoom', data, function(response){
            swal.close();
            $('#editRoomModal').modal('hide');
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getRoom', null, function(response){
                mappingTable(response.data,'master_room_table')
            })
        })
    })
    $('#master_room_table').on('click', '.edit', function(){
        var name = $(this).data('name');
        var location = $(this).data('location');
        var id = $(this).data('id');
        $('.message_error').html('')
        $('#id').val(id)
        $('#edit_location_id').val(location_id)
        $('#edit_select_location').val(location)
        $('#edit_select_location').select2().trigger('change')
        $('#edit_name').val(name)
    })
      function mappingTable(response, table){
        var data =''
            $('#'+ table).DataTable().clear();
            $('#'+ table).DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="width:85%;text-align:left">${response[i].location_relation.name}</td>
                                <td style="width:85%;text-align:left">${response[i].name}</td>
                                <td style="width:10%;text-align:center">
                                        <button title="Edit Category" class="edit btn btn-sm btn-info rounded"  data-name="${response[i].name}" data-location="${response[i].location_id}"  data-id="${response[i]['id']}" data-toggle="modal" data-target="#editRoomModal">
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