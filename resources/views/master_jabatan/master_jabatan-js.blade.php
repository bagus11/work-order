<script>
    get_jabatan()
    $('#add_jabatan').on('click', function(){
        get_departement_name()
    })
    $('#select_departement').on('change', function(){
        var select_departement = $('#select_departement').val()
        $('#departement_id').val(select_departement)
    })
    $('#btn_save_jabatan').on('click', function(){
        save_jabatan()
    })
    $('#btn_update_jabatan').on('click', function(){
        update_jabatan()
    })
    $('#jabatan_table').on('change', '.is_checked', function(e) {
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
                url: "{{route('update_status_jabatan')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
               
                success: function(response) {
                    $('.is_checked').prop('disabled',false)
                    toastr['success'](response.message);
                    get_jabatan()
                },
                error: function(xhr, status, error) {
                   
                    toastr['error']('gagal mengambil data, silakan hubungi ITMAN');
                }
            });
          
           
    });
    
    $('#jabatan_table').on('click', '.editJabatan', function() {
            var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('detail_jabatan')}}",
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
                    $('#jabatan_id').val(id)
                    $('#jabatan_name_update').val(response.detail.name)
                    $('#departement_id_update').val(response.detail.departement_id)
                    $('#select_departement_update').empty();
                    $('#select_departement_update').append('<option value ="'+response.detail.departement_id+'">'+response.detail.departement_name+'</option>');
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
        });
    function get_jabatan(){
        $('#jabatan_table').DataTable().clear();
        $('#jabatan_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_jabatan')}}",
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
                                 @can('activation-master_jabatan')
                                <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.data[i]['id']}"  data-flg_aktif="${response.data[i]['flg_aktif']}" data-id="${response.data[i]['id']}" ${response.data[i]['flg_aktif'] == 1 ?'checked':'' }></td>
                                @else
                                <td style="text-align: center;">
                               <h6><span class="badge badge-secondary"><i class="fas fa-warning"></i> Tidak ada Akses</span></h6>
                                </td>
                                @endcan
                                <td style="text-align: center;">${response.data[i]['flg_aktif']==1?'Active':'inactive'}</td>
                                <td style="text-align: left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="text-align: center;">${response.data[i]['departement_name']==null?'':response.data[i]['departement_name']}</td>
                                <td style="width:25%;text-align:center">
                                    @can('update-master_jabatan')
                                    <button title="Detail" class="editJabatan btn btn-sm btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editJabatan">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </button>
                                    @else
                                    <h6><span class="badge badge-secondary"><i class="fas fa-warning"></i> Tidak ada Akses</span></h6>
                                    @endcan  
                                </td>
                            </tr>
                            `;
                }
                    $('#jabatan_table > tbody:first').html(data);
                    $('#jabatan_table').DataTable({   
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

    function get_departement_name(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_departement_name')}}",
            type: "get",
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_departement').empty();
                $('#select_departement').append('<option value ="">Pilih Departement</option>');
                $.each(response.data,function(i,data){
                    $('#select_departement').append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function save_jabatan()
    {
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('save_jabatan')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: {
                    'departement_id':$('#departement_id').val(),
                    'jabatan_name':$('#jabatan_name').val(),
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
                    }else if(response.status==500){
                        toastr['error'](response.message);
                    }else{
                        toastr['success'](response.message);
                        window.location = "{{route('master_jabatan')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function update_jabatan()
    {
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('update_jabatan')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: {
                    'jabatan_name_update':$('#jabatan_name_update').val(),
                    'id':$('#jabatan_id').val(),
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
                        window.location = "{{route('master_jabatan')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
</script>