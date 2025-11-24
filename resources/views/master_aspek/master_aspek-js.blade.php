<script>
    getCallback('getAspek', null, function(response){
        swal.close();
        mappingTable(response.data,'master_system_table')
    })
    $('#btn_save_system').on('click', function(){
        var data = {
            'name': $('#name').val(),
        }
        postCallback('addAspek', data, function(response){
            swal.close();
            $('#addSystemModal').modal('hide');
            $('#name').val('')
            $('.message_error').html('')
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getAspek', null, function(response){
                mappingTable(response.data,'master_system_table')
            })
        })
    })
    $('#btn_update_system').on('click', function(){
        var data = {
            'id': $('#id').val(),
            'edit_name': $('#edit_name').val(),
        }
        postCallback('updateAspek', data, function(response){
            swal.close();
            $('#editSystemModal').modal('hide');
            $('#edit_name').val('')
            $('.message_error').html('')
            toastr['success'](response.meta.message);
            getCallbackNoSwal('getAspek', null, function(response){
                mappingTable(response.data,'master_system_table')
            })
        })
    })
    $('#master_system_table').on('click', '.edit', function(){
        var name = $(this).data('name');
        var id = $(this).data('id');
        $('.message_error').html('')
        $('#id').val(id)
        $('#edit_name').val(name)
    })
      function mappingTable(response, table){
        var data =''
            $('#'+ table).DataTable().clear();
            $('#'+ table).DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        console.log(response[i].aspek)
                        data += `<tr style="text-align: center;">
                                <td style="width:75%;text-align:left">${response[i].name}</td>
                                <td style="width:25%;text-align:center">
                                        <button title="Edit Category" class="edit btn btn-sm btn-info rounded" data-name="${response[i].name}"  data-id="${response[i]['id']}" data-toggle="modal" data-target="#editSystemModal">
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