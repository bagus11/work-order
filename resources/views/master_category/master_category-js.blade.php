<script>
    get_categories()
    $('#btn_save_categories').on('click', function(){
      var data ={
        'categories_name':$('#categories_name').val(),
        'departement_id':$('#departement_id').val()
      }
      store('save_categories',data,'master_category')
    })
    $('#btn_update_categories').on('click', function(){
        var data ={
            'id':$('#categories_id').val(),
            'categories_name_update':$('#categories_name_update').val(),
            'departement_id_update':$('#departement_id_update').val()
        }
      store('update_categories',data,'master_category')
    })
    $('#categories_table').on('change', '.is_checked', function(e) {
            $('.is_checked').prop('disabled',true)
            e.preventDefault();
            var status = $(this).data('status')
            var data ={
                    'id': $(this).data('id'),     
                    'flg_aktif': $(this).data('flg_aktif'),     
            }
            
                $.ajax({
                    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('update_status_categories')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
               
                success: function(response) {
                    $('.is_checked').prop('disabled',false)
                    toastr['success'](response.message);
                    get_categories()
                },
                error: function(xhr, status, error) {
                   
                    toastr['error']('gagal mengambil data, silakan hubungi ITMAN');
                }
            });
          
           
    });
    $('#add_categories').on('click', function(){
        getSelect('get_departement_name', null,'select_departement','Departement')
    })
    onChange('select_departement','departement_id')
    onChange('select_departement_update','departement_id_update')
    
    $('#categories_table').on('click', '.editCategories', function() {
            var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('detail_categories')}}",
                type: "get",
                dataType: 'json',
                async: true,
                data:{
                    'id':id
                },
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                  $('#categories_id').val(id)
                  $('#categories_name_update').val(response.detail.name)
                  $('#departement_id_update').val(response.detail.departement_id)
                  $('#select_departement_update').empty()
                  $('#select_departement_update').append('<option value="'+response.detail.departement_id+'">'+response.detail.departement.name+'</option>')
                  $.each(response.data,function(i,data,param){
                    $('#select_departement_update').append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
        });
    function get_categories(){
        $('#categories_table').DataTable().clear();
        $('#categories_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_categories')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
                'select_aspek':$('#select_aspek').val(),
                'select_departement':$('#select_departement').val(),
            },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                var data=''
                for(i = 0; i < response.data.length; i++ )
                {
                    data += `<tr style="text-align: center;">
                                <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.data[i]['id']}"  data-flg_aktif="${response.data[i]['flg_aktif']}" data-id="${response.data[i]['id']}" ${response.data[i]['flg_aktif'] == 1 ?'checked':'' }></td>
                                <td style="text-align: center;">${response.data[i]['flg_aktif']==1?'Active':'inactive'}</td>
                                <td style="text-align: left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="text-align: center;">${response.data[i].departement.name==null?'':response.data[i].departement.name}</td>
                                <td style="width:25%;text-align:center">
                                    <button title="Detail" class="editCategories btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editCategories">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </button>   
                                </td>
                            </tr>
                            `;
                }
                    $('#categories_table > tbody:first').html(data);
                    $('#categories_table').DataTable({   
                        scrollX  : true,
                        scrollY  :220
                    }).columns.adjust()
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }

  
</script>