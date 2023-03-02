<script>
    get_problem_type()
    $('#btn_save_problem').on('click', function(){
        save_problem_type()
    })
    $('#btn_update_problem').on('click', function(){
        update_problem()
    })
    $('#problem_table').on('change', '.is_checked', function(e) {
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
                url: "{{route('update_status_problem')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
               
                success: function(response) {
                    $('.is_checked').prop('disabled',false)
                    toastr['success'](response.message);
                    get_problem_type()
                },
                error: function(xhr, status, error) {
                   
                    toastr['error']('gagal mengambil data, silakan hubungi ITMAN');
                }
            });
          
           
    });
    $('#add_problem').on('click', function(){
        get_categories_name()
    })
    $('#select_categories').on('change', function(){
        var select_categories = $('#select_categories').val()
        $("#categories_id").val(select_categories)
    })
    $('#select_categories_update').on('change', function(){
        var select_categories_update = $('#select_categories_update').val()
        $("#categories_id_update").val(select_categories_update)
    })
    $('#problem_table').on('click', '.editProblems', function() {
            var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('detail_problems')}}",
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
                  
                  $('#problem_id').val(id)
                  $('#problem_name_update').val(response.detail.name)
                  $('#categories_id_update').val(response.detail.categories_id)
                  $('#select_categories_update').empty()
                  $('#select_categories_update').append('<option value="'+response.detail.categories_id+'">'+response.detail.categories_name+'</option>')
                  $.each(response.data,function(i,data){
                    $('#select_categories_update').append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
        });
    function get_problem_type(){
        $('#problem_table').DataTable().clear();
        $('#problem_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_problem_type')}}",
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
                                <td style="text-align: center;">
                                    @can('activation-problem_type')
                                    <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.data[i]['id']}"  data-flg_aktif="${response.data[i]['flg_aktif']}" data-id="${response.data[i]['id']}" ${response.data[i]['flg_aktif'] == 1 ?'checked':'' }>
                                    @endcan   
                                    </td>
                                <td style="text-align: center;">${response.data[i]['flg_aktif']==1?'Active':'inactive'}</td>
                                <td style="text-align: left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="text-align: center;">${response.data[i]['categories_name']==null?'':response.data[i]['categories_name']}</td>
                                <td style="width:25%;text-align:center">
                                    @can('update-problem_type')
                                    <button title="Detail" class="editProblems btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editProblems">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </button>
                                    @endcan   
                                </td>
                            </tr>
                            `;
                }
                    $('#problem_table > tbody:first').html(data);
                    $('#problem_table').DataTable({
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
    function save_problem_type()
    {
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('save_problem_type')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: {
                    'problem_name':$('#problem_name').val(),
                    'categories_id':$('#categories_id').val(),
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
                        window.location = "{{route('problem_type')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function update_problem()
    {
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('update_problem')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: {
                    'problem_name_update':$('#problem_name_update').val(),
                    'categories_id_update':$('#categories_id_update').val(),
                    'id':$('#problem_id').val(),
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
                        window.location = "{{route('problem_type')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function get_categories_name(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_categories_name')}}",
            type: "get",
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_categories').empty();
                $('#select_categories').append('<option value ="">Choose Categories</option>');
                $.each(response.data,function(i,data){
                    $('#select_categories').append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }

</script>