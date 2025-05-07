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
            $('#category_table').on('click', '.edit', function(){
                getActiveItems('getTypeInv',null,'select_type_edit','Type')
                var id = $(this).data('id');
                var data ={
                    'id':id
                }
                getCallback('detailCategoryInv',data,function(response){
                    swal.close()
                    $('#type_id_edit').val(response.detail.type_id)
                    $('#select_type_edit').val(response.detail.type_id)
                    $('#select_type_edit').select2().trigger('change')
                    $('#categoryId').val(response.detail.id)
                    $('#name_edit').val(response.detail.name)
                    $('#description_edit').val(response.detail.description)
                })
            })
            onChange('select_type_edit','type_id_edit')
            $('#btn_update_category').on('click', function(){
                var data={
                    'id'                : $('#categoryId').val(),
                    'type_id_edit'      : $('#type_id_edit').val(),
                    'name_edit'         : $('#name_edit').val(),
                    'description_edit'  : $('#description_edit').val(),
                }
                postCallback('updateCategoryInv', data, function(response){
                    swal.close()
                    $('#editMasterCategory').modal('hide')
                    toastr['success'](response.meta.message);
                    getCallbackNoSwal('getCategoryInv', null, function(response){
                        mappingTable(response.data)
                    })
                })
            })
        // Edit Category

        // Delete Category
            $('#category_table').on('click','.delete', function(){
                var id = $(this).data('id');
                var data ={
                    'id':id
                }
                getCallback('deleteCategoryInv', data, function(response){
                    swal.close()
                    toastr['success'](response.message);
                    getCallbackNoSwal('getCategoryInv', null, function(response){
                        mappingTable(response.data)
                    })
                })
            })
        // Delete Category

        // Import
            $('#btn_upload').on('click', function(e){
                e.preventDefault()
                var data = new FormData();
                var upload_file =$('#upload_file')[0].files[0]
                data.append('upload_file',$('#upload_file')[0].files[0]);
                console.log(upload_file)
                postAttachment('uploadCategory',data,false,function(response){
                    swal.close()
                    toastr['success'](response.meta.message);
                    $('#importMasterCategory').modal('hide')
                    getCallback('getCategoryInv', null, function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })

            })
        // Import


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
                                        <button title="Edit Category" class="edit btn btn-sm btn-info rounded"   data-id="${response[i]['id']}" data-toggle="modal" data-target="#editMasterCategory">
                                            <i class="fas fa-solid fa-edit"></i>
                                        </button>
                                        <button title="Delete Category" class="delete btn btn-sm btn-danger rounded"   data-id="${response[i]['id']}" >
                                            <i class="fas fa-solid fa-trash"></i>
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