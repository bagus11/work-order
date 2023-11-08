<script>
    // Call Function
        getCallback('getBrand', null, function(response){
            swal.close()
            mappingTable(response.data)
        })
    // Call Function

    // Operation
        // Add Brand
            $('#add_brand').on('click', function(){
                $('.message_error').html('')
                $('#name').val('')
            })
            $('#btn_save_brand').on('click', function(){
                $('.message_error').html('')
                var data ={
                    'name' : $('#name').val()
                }
                postCallback('addBrand',data,function(response){
                    swal.close()
                    $('#addMasterBrandModal').modal('hide')
                    toastr['success'](response.meta.message);
                    getCallbackNoSwal('getBrand', null, function(response){
                        mappingTable(response.data)
                    })
                })

            })
        // Add Brand

        // Edit Brand
            $('#brand_table').on('click', '.edit', function(){
                var id = $(this).data('id')
                var data ={
                    'id' : id
                }
                getCallback('detailBrand', data, function(response){
                    swal.close()
                    $('#brandId').val(id)
                    $('#name_edit').val(response.detail.name)
                })
            })
            $('#btn_update_brand').on('click', function(){
                var data ={
                    'name_edit' : $('#name_edit').val(),
                    'id' : $('#brandId').val(),
                }
                postCallback('updateBrand',data,function(response){
                    swal.close()
                    $('#editMasterBrandModal').modal('hide')
                    toastr['success'](response.meta.message);
                    getCallbackNoSwal('getBrand', null, function(response){
                        mappingTable(response.data)
                    })
                })
            })
        // Edit Brand

        // Delete Brand
            $('#brand_table').on('click','.delete', function(){
                var id = $(this).data('id');
                var data ={
                    'id':id
                }
                getCallback('deleteBrand', data, function(response){
                    swal.close()
                    toastr['success'](response.message);
                    getCallbackNoSwal('getBrand', null, function(response){
                        mappingTable(response.data)
                    })
                })
            })
        // Delete Brand
    // Operation

    // Function
        function mappingTable(response){
            var data =''
            $('#brand_table').DataTable().clear();
            $('#brand_table').DataTable().destroy();
            var data=''
                    for(i = 0; i < response.length; i++ )
                    {
                        data += `<tr style="text-align: center;">
                                <td style="width:5%">${i + 1}</td>
                                <td style="width:85%;text-align:left">${response[i].name}</td>
                                <td style="width:10%;text-align:center">
                                        <button title="Edit Category" class="edit btn btn-sm btn-info rounded"   data-id="${response[i]['id']}" data-toggle="modal" data-target="#editMasterBrandModal">
                                            <i class="fas fa-solid fa-edit"></i>
                                        </button>
                                        <button title="Delete Category" class="delete btn btn-sm btn-danger rounded"   data-id="${response[i]['id']}" >
                                            <i class="fas fa-solid fa-trash"></i>
                                        </button>
                                </td>
                            </tr>
                            `;
                    }
            $('#brand_table > tbody:first').html(data);
            $('#brand_table').DataTable({
                scrollX  : true,
            }).columns.adjust()
        }
    // Function
</script>