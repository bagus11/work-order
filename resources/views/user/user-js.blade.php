<script>
   
   get_user()
   $('#btn_update_user').on('click', function(){
    update_user()
   })
   $('#user_table').on('change', '.is_checked', function(e) {
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
            url: "{{route('update_status_user')}}",
            type: "post",
            dataType: 'json',
            async: true,
            data: data,
            
            success: function(response) {
                $('.is_checked').prop('disabled',false)
                toastr['success'](response.message);
                get_user()
            },
            error: function(xhr, status, error) {
                
                toastr['error']('gagal mengambil data, silakan hubungi ITMAN');
            }
        });
        
        
    });
   
    function get_user(){
        $('#user_table').DataTable().clear();
        $('#user_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_username')}}",
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
                                <td style="text-align: left;">${response.data[i]['nik']==null?'':response.data[i]['nik']}</td>
                                <td style="text-align: left;">${response.data[i]['email']==null?'':response.data[i]['email']}</td>
                                <td style="width:25%;text-align:center">
                                    
                                        <button title="Detail" class="editUser btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editUser">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                </td>
                            </tr>
                            `;
                }
                    $('#user_table > tbody:first').html(data);
                    $('#user_table').DataTable({
                                scrollX  : true,
                                scrollY  :230
                        }).columns.adjust()
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
   }
   $('#select_departement').on('change', function(){
     var select_departement = $('#select_departement').val()
     $('#departement_id').val(select_departement)
     get_jabatan()
   })
   $('#select_kantor').on('change', function(){
     var select_kantor = $('#select_kantor').val()
     $('#kode_kantor').val(select_kantor)
   })
   $('#select_jabatan').on('change', function(){
     var select_jabatan = $('#select_jabatan').val()
     $('#jabatan_id').val(select_jabatan)
   })
   $('#user_table').on('click', '.editUser', function(e) {
            $('#editKantorModal').show();
            var id =$(this).data('id')
            e.preventDefault()       
                $.ajax({
                    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('detail_user')}}",
                type: "get",
                dataType: 'json',
                async: true,
                data: {
                    'id': id
                },
                success: function(response) { 
                console.log(response.detail.departement)                  
                  $('#user_id').val(id)
                  $('#user_name').val(response.detail.name)
                  $('#departement_id').val(response.detail.departement_id)
                  $('#select_departement').empty()
                  $('#select_departement').append(`<option value="${response.detail.departement}">${response.detail.departement == '' ? 'Belum set departement' : response.detail.departement_name}</option>`)
                  $.each(response.departement,function(i,data){
                      $('#select_departement').append('<option value="'+data.id+'">' + data.name +'</option>');
                    });
                    $('#jabatan_id').val(response.detail.jabatan_id)
                    $('#select_jabatan').empty()
                    $('#select_jabatan').append(`<option>${response.detail.jabatan == '' ? 'Belum set jabatan' : response.detail.jabatan_name}</option>`)
                    $('#kode_kantor').val(response.detail.kode_kantor)
                    $('#select_kantor').empty()
                    $('#select_kantor').append(`<option value="${response.detail.kode_kantor}">${response.detail.kode_kantor == '' ? 'Belum set kantor' : response.detail.kantor_name}</option>`)
                    $.each(response.kantor,function(i,data){
                        $('#select_kantor').append('<option value="'+data.id+'">' + data.name +'</option>');
                        });

                },
                error: function(xhr, status, error) {
                   
                    toastr['error']('gagal mengambil data, silakan hubungi ITMAN');
                }
            });
          
           
    });

    function get_jabatan(){
        $.ajax({
                    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('get_jabatan_name')}}",
                type: "get",
                dataType: 'json',
                async: true,
                data: {
                    'id': $('#departement_id').val()
                },
                success: function(response) { 

                  $('#jabatan_id').val('')
                  $('#select_jabatan').empty()
                  $('#select_jabatan').append(`<option value="">Pilih Jabatan</option>`)
                  $.each(response.data,function(i,data){
                      $('#select_jabatan').append('<option value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(xhr, status, error) {
                   
                    toastr['error']('gagal mengambil data, silakan hubungi ITMAN');
                }
            });
    }
   
    function update_user(){
    var data ={
        'id':$('#user_id').val(),
        'user_name':$('#user_name').val(),
        'departement_id':$('#departement_id').val(),
        'jabatan_id':$('#jabatan_id').val(),
        'kode_kantor':$('#kode_kantor').val(),
    }
    $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('update_user_setting')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
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
                        window.location = "{{route('user_setting')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });

   }

    // Import User
        $('#btnImportUser').on('click', function(){
            $.ajax({
            url: 'getUserHris',
            type: "get",
            dataType: 'json',
            success: function(response){
                if(response.status == 200){
                    get_user()
                    toastr['success'](response.message);
                }else{
                    toastr['error'](response.message);
                }
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }); 
        })
    // Import User
</script>