<script>
    // Call Function
        getCallback('getCategoryInv', null, function(response){
                swal.close()
                mappingTable(response.data)
        })
    // Call Function

    // Operation
        onChange('select_type','type_id')
        // Add Category
            $('#add_category').on('click', function(){
                $('.message_error').html('')
                getActiveItems('getTypeInv',null,'select_type','type')
                $('#type_id').val('')
                $('#name').val('')
                $('#description').val('')
            })

            $('#btn_save_category').on('click', function(){
                var data ={
                   'type_id' :$('#type_id').val(),
                    'name' :$('#name').val(),
                    'description' :$('#description').val(),
                }
                postCallback('saveCategoryInv', data, function(response){
                    swal.close()
                    $('#addMasterCategory').modal('hide')
                    toastr['success'](response.meta.message);
                    getCallbackNoSwal('getCategoryInv', null, function(response){
                        mappingTable(response.data)
                    })
                })
            })
        // Add Category
        // Edit Category
    // Operation

    // Function
    function mappingTable(response){
        var data =''
            $('#category_table').DataTable().clear();
            $('#category_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="width:5%">${i + 1}</td>
                                <td style="width:85%;text-align:left">${response[i].name}</td>
                                <td style="width:85%;text-align:left">${response[i].type_relation.name}</td>
                                <td style="width:10%;text-align:center">
                                        <button title="Detail Master Approver" class="edit btn btn-sm btn-info rounded"   data-id="${response[i]['id']}" data-toggle="modal" data-target="#editMasterCategory">
                                            <i class="fas fa-solid fa-edit"></i>
                                        </button>
                                </td>
                            </tr>
                            `;
                    }
            $('#category_table > tbody:first').html(data);
            $('#category_table').DataTable({
                scrollX  : true,
            }).columns.adjust()
    }
    // Function
</script>