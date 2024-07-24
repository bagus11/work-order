<script>
    getCallback('getProductOPX', null, function(response){
        swal.close()
        mappingTable(response.data)
    })
    getActiveItems('getDevCategoryOPX', null, 'select_category_edit','category')
    $('#add_product').on('click', function(){
        getActiveItems('getDevCategoryOPX', null, 'select_category','category')
      
        $('#name').val('')
        $('#category').val('')
        $('#description').val('')
    })
   
    onChange('select_category','category')
    onChange('select_category_edit','category_edit')
    $('#btn_save_product').on('click', function(){
        var data ={
            'name':$('#name').val(),
            'description':$('#description').val(),
            'category':$('#category').val(),
        }
        postCallback('addProductOPX',data, function(response){
            $('#addProductModal').modal('hide')
            toastr['success'](response.meta.message)
            getCallback('getProductOPX', null, function(response){
                swal.close()
                mappingTable(response.data)
            })
        })
    })
    $('#product_table').on('click', '.edit', function(){
      
        var id = $(this).data('id')
        var name = $(this).data('name')
        var description = $(this).data('desc')
        var category = $(this).data('category')

        $('#id_edit').val(id)
        $('#name_edit').val(name)
        $('#description_edit').val(description)
        $('#category_edit').val(category)
        $('#select_category_edit').val(category)
        $('#select_category_edit').select2().trigger('change')
    })

    $('#btn_update_product').on('click', function(){
        var data ={
            'id' :$('#id_edit').val(),
            'name_edit' :$('#name_edit').val(),
            'description_edit' :$('#description_edit').val(),
            'category_edit' :$('#category_edit').val(),
        }
        postCallback('updateProductOPX', data, function(response){
            swal.close()
            $('#editProductModal').modal('hide')
            toastr['success'](response.message)
            getCallbackNoSwal('getProductOPX', null, function(response){
                swal.close()
                mappingTable(response.data)
            })
        })
    })
    $('#product_table').on('change','.is_checked', function(){
        var id = $(this).data('id')
        var data ={
            'id': id
        }
        postCallbackNoSwal('updateStatusProductOPX', data, function(response){
            toastr['success'](response.message)
            getCallbackNoSwal('getProductOPX', null, function(response){
                swal.close()
                mappingTable(response.data)
            })
        })
    })
    function mappingTable(response){
        var data =''
        $('#product_table').DataTable().clear();
        $('#product_table').DataTable().destroy();
        for(i = 0; i < response.length; i++){
            data += `
                <tr>
                    <td style="text-align:center">
                        <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-status="${response[i]['status']}" data-id="${response[i]['id']}" ${response[i]['status'] == 1 ?'checked':'' }>
                    
                    </td>
                    <td style="text-align:center">${response[i].status ==0 ? "Inactive" : "Active"}</td>
                    <td>${response[i].name}</td>
                    <td>${response[i].category_relation.name}</td>
                    <td style="text-align:center">
                        <button  type="button" class="btn edit btn-sm btn-info" data-toggle="modal" data-target="#editProductModal" data-name="${response[i].name}" data-id="${response[i].id}" data-category="${response[i].category}" data-desc="${response[i].description}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    
                </tr>
            `;
        }
        $('#product_table > tbody:first').html(data);
        $('#product_table').DataTable({
            // scrollX  : true,
            language: {
            'paginate': {
            'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
            'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
            }
        },
            ordering : false
        }).columns.adjust()
    }
</script>