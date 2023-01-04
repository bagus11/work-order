<script>
   
   get_user()
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
                            <td style="text-align: left;">${response.data[i]['email']==null?'':response.data[i]['email']}</td>
                            <td style="width:25%;text-align:center">
                                
                                    <button title="Detail" class="editeSubmenus btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editSubmenusModal">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </button>
                            </td>
                        </tr>
                        `;
            }
                $('#user_table > tbody:first').html(data);
                $('#user_table').DataTable({
                    autoWidth:true
                });
        },
        error: function(xhr, status, error) {
            swal.close();
            toastr['error']('Failed to get data, please contact ICT Developer');
        }
    });
   }
</script>