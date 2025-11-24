<script>
    getCallback('getmasterCategoryOPX', null, function(response){
        swal.close()
        mapping(response.data)
    })
    onChange('select_type','type')
    $('#btn_save_category').on('click', function(){
        var data ={
            'name':$('#name').val(),
            'type':$('#type').val()
        }
        postCallback('addCategoryOPX',data, function(response){
            swal.close()
            $('#addCategoryModal').modal('hide')
            toastr['success'](response.meta.message)
            getCallbackNoSwal('getmasterCategoryOPX', null, function(response){
                swal.close()
                mapping(response.data)
            })
        })
    })
    
    $('#category_table').on('click', '.edit', function(){
        var id = $(this).data('id')
        var name = $(this).data('name')
        var type = $(this).data('type')

        $('#id_edit').val(id)
        $('#type_edit').val(type)
        $('#name_edit').val(name)
        $('#select_type_edit').val(type)
        $('#select_type_edit').select2().trigger('change')
    })
    onChange('select_type_edit', 'type_edit')
    $('#btn_update_category').on('click', function(){
        var data ={
            'id'        : $('#id_edit').val(),
            'name_edit' : $("#name_edit").val(),
            'type_edit' : $("#type_edit").val(),
        }
        postCallback('updateCategoryOPX',data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            $('#editCategoryModal').modal('hide')
            getCallback('getmasterCategoryOPX', null, function(response){
                swal.close()
                mapping(response.data)
            })
        })
    })
    $('#category_table').on('change','.is_checked', function(){
        var id = $(this).data('id')
        var data ={
            'id': id
        }
        postCallbackNoSwal('updateStatusCategoryOPX', data, function(response){
            toastr['success'](response.message)
            getCallbackNoSwal('getmasterCategoryOPX', null, function(response){
                swal.close()
                mapping(response.data)
            })
        })
    })
    function mapping(response){
        var data =''
        $('#category_table').DataTable().clear();
        $('#category_table').DataTable().destroy();
        for(i = 0; i < response.length; i++){
            var type = response[i].type ==1 ?'Single' :'Detervative'
            data += `
                <tr>
                    <td style="text-align:center">
                        <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response[i]['id']}"  data-status="${response[i]['status']}" data-id="${response[i]['id']}" ${response[i]['status'] == 1 ?'checked':'' }>
                    
                    </td>
                    <td style="text-align:center">${response[i].status ==0 ? "Inactive" : "Active"}</td>
                    <td>${response[i].name}</td>
                    <td>${type}</td>
                    <td style="text-align:center">
                        <button  type="button" class="btn edit btn-sm btn-info" data-toggle="modal" data-target="#editCategoryModal" data-name="${response[i].name}" data-id="${response[i].id}" data-type="${response[i].type}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    
                </tr>
            `;
        }
        $('#category_table > tbody:first').html(data);
        $('#category_table').DataTable({
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