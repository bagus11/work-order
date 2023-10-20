<script>

    // Call Function
        getCallback('getTypeInv', null, function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
        // Add Type
            $('#btn_save_type').on('click', function(){
                var data ={
                    'name' : $('#name').val(),
                    'description' : $('#description').val(),
                }
                postCallback('saveTypeInv', data, function(response){
                    swal.close()
                    $('#addMasterCategory').modal('hide')
                    toastr['success'](response.meta.message);
                    getCallbackNoSwal('getTypeInv', null, function(response){
                        mappingTable(response.data)
                    })
                })
            })
        // Add Type

        // Edit Type
            $('#type_table').on('click', '.edit', function(){
                var id = $(this).data('id')
                var data ={
                    'id':id
                }
                getCallback('detailTypeInv',data, function(response){
                    swal.close()
                    console.log(response.detail)
                    $('#type_id').val(id)
                    $('#name_edit').val(response.detail.name)
                    $('#description_edit').val(response.detail.description)
                    
                })
            })

            $('#btn_update_type').on('click', function(){
                var data ={
                    'id':$('#type_id').val(),
                    'name_edit':$('#name_edit').val(),
                    'description_edit':$('#description_edit').val(),
                }
                postCallback('updateTypeInv', data, function(response){
                    swal.close()
                    $('#editMasterCategory').modal('hide')
                    toastr['success'](response.meta.message);
                    getCallbackNoSwal('getTypeInv', null, function(response){
                        mappingTable(response.data)
                    })
                })
            })
        // Edit Type
        
    // Operation

    // Function
    function mappingTable(response){
        var data =''
            $('#type_table').DataTable().clear();
            $('#type_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="width:5%">${i + 1}</td>
                                <td style="width:85%;text-align:left">${response[i].name}</td>
                                <td style="width:10%;text-align:center">
                                        <button title="Detail Master Approver" class="edit btn btn-sm btn-info rounded"   data-id="${response[i]['id']}" data-toggle="modal" data-target="#editMasterCategory">
                                            <i class="fas fa-solid fa-edit"></i>
                                        </button>
                                </td>
                            </tr>
                            `;
                    }
            $('#type_table > tbody:first').html(data);
            $('#type_table').DataTable({
                scrollX  : true,
            }).columns.adjust()
    }
    // Function
</script>