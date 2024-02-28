<script>
    get_departement()
    $('#btn_save_departement').on('click', function(){
        save_departement()
    })
    $('#btn_update_categories').on('click', function(){
        update_categories()
    })
    $('#departement_table').on('change', '.is_checked', function(e) {
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
                url: "{{route('update_status_departement')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
               
                success: function(response) {
                    $('.is_checked').prop('disabled',false)
                    toastr['success'](response.message);
                    get_departement()
                },
                error: function(xhr, status, error) {
                   
                    toastr['error']('gagal mengambil data, silakan hubungi ITMAN');
                }
            });
          
           
    });
    $('#btn_update_departement').on('click', function(){
        var data ={
            'id':$('#departement_id').val(),
            'departement_name_update':$('#departement_name_update').val(),
            'initial_name_update':$('#initial_name_update').val()
        }
        store('update_departement',data,'master_departement' )
    })
    $('#departement_table').on('click', '.editDepartement', function() {
            var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('detail_departement')}}",
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
                  $('#departement_id').val(id)
                  $('#departement_name_update').val(response.detail.name)
                  $('#initial_name_update').val(response.detail.initial)
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
        });
    function get_departement(){
        $('#departement_table').DataTable().clear();
        $('#departement_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_departement')}}",
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
                                 @can('activation-master_departement')
                                <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.data[i]['id']}"  data-flg_aktif="${response.data[i]['flg_aktif']}" data-id="${response.data[i]['id']}" ${response.data[i]['flg_aktif'] == 1 ?'checked':'' }></td>
                                @else
                                <td style="text-align: center;">
                               <h6><span class="badge badge-secondary"><i class="fas fa-warning"></i> Tidak ada Akses</span></h6>
                                </td>
                                @endcan
                                <td style="text-align: center;">${response.data[i]['flg_aktif']==1?'Active':'inactive'}</td>
                                <td style="text-align: left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="text-align: left;">${response.data[i]['initial']==null?'':response.data[i]['initial']}</td>
                                <td style="width:25%;text-align:center">
                                    @can('update-master_departement')
                                    <button title="Detail" class="editDepartement btn btn-sm btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editDepartement">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </button>
                                    @else
                                    <h6><span class="badge badge-secondary"><i class="fas fa-warning"></i> Tidak ada Akses</span></h6>
                                    @endcan  
                                </td>
                            </tr>
                            `;
                }
                    $('#departement_table > tbody:first').html(data);
                    $('#departement_table').DataTable({   
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
    function save_departement()
    {
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('save_departement')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: {
                    'departement_name':$('#departement_name').val(),
                    'initial_name':$('#initial_name').val(),
                },
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('.message_error').html('')
                    if(response.status==422)
                    {
                        $.each(response.message, (key, val) => 
                        {
                           $('span.'+key+'_error').text(val[0])
                        });
                        return false;
                    }else{
                        toastr['success'](response.message);
                        window.location = "{{route('master_departement')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function update_categories()
    {
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('update_categories')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: {
                    'categories_name_update':$('#categories_name_update').val(),
                    'id':$('#categories_id').val(),
                },
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('.message_error').html('')
                    if(response.status==422)
                    {
                        $.each(response.message, (key, val) => 
                        {
                           $('span.'+key+'_error').text(val[0])
                        });
                        return false;
                    }else{
                        toastr['success'](response.message);
                        window.location = "{{route('master_category')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
</script>