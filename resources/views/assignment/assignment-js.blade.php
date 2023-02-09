<script>
    $('#refresh').on('click', function(){
        get_assignment()
    })
get_assignment()
    $('#assignment_table').on('click', '.editAssignment', function() {
            var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('detail_wo')}}",
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
                $('#select_request_type').empty()
                $('#select_request_type').append('<option value ="'+response.detail.request_type+'">'+response.detail.request_type+'</option>')
                $('#select_categories').empty()
                $('#select_categories').append('<option value ="'+response.detail.categories+'">'+response.detail.categories_name+'</option>')
                $('#select_problem_type').empty()
                $('#select_problem_type').append('<option value ="'+response.detail.problem_type+'">'+response.detail.problem_type_name+'</option>')
                $('#request_type').val(response.detail.request_type)
                $('#categories').val(response.detail.categories)
                $('#problem_type').val(response.detail.problem_type)
                $('#subject').val(response.detail.subject)
                $('#add_info').val(response.detail.add_info)
                $('#request_code').val(response.detail.request_code)
                $('#username').val(response.detail.username)
                $('#wo_id').val(id)
                $('#select_user').empty()
                $('#select_user').append('<option value="">Choose PIC</option>')
                $.each(response.data,function(i,data){
                    $('#select_user').append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                 
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
    });
    $('#btn_approve_assign').on('click', function(){
        var data ={
        'user_pic': $('#user_pic').val(),
        'note': $('#note').val(),
        'id':$('#wo_id').val(),
        'approve':1
       }
       if($('#user_pic').val() == '' || $('#user_pic').val()==null){
        toastr['error']('Belum memilih PIC');
       }else{
           approve_assignment(data)
       }
    })
    $('#btn_reject_assign').on('click', function(){
        var data ={
        'user_pic': $('#user_pic').val(),
        'note': $('#note').val(),
        'id':$('#wo_id').val(),
        'approve':2
       }
       approve_assignment(data)
    })
    $('#select_user').on('change', function(){
        var select_user = $('#select_user').val()
        $('#user_pic').val(select_user)
    })
    function get_assignment(){
            $('#assignment_table').DataTable().clear();
            $('#assignment_table').DataTable().destroy();
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('get_assignment')}}",
                type: "get",
                dataType: 'json',
                async: true,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    var data=''
                    for(i = 0; i < response.data.length; i++ )
                    {
                        var satatus_wo = '';
                        var status_color = ''
                        if(response.data[i].status_wo==0){
                            status_wo ='NEW'
                            status_color ='black'
                        }else  if(response.data[i].status_wo==1){
                            status_wo ="ON PROGRESS"
                            status_color ='blue'
                        }else  if(response.data[i].status_wo==2){
                            status_wo ="DONE"
                            status_color ='green'
                        }else  if(response.data[i].status_wo==3){
                            status_wo ="REVISI"
                            status_color ='red'
                        }
                        data += `<tr style="text-align: center;">
                                    <td style="width:25%;text-align:left;">${response.data[i]['username']==null?'':response.data[i]['username']}</td>
                                    <td style="width:25%;text-align:center;" class="request_code">${response.data[i]['request_code']==null?'':response.data[i]['request_code']}</td>
                                    <td style="width:25%;text-align:center;">${response.data[i]['departement_name']==null?'':response.data[i]['departement_name']}</td>
                                    <td style="width:25%;text-align:center;">${response.data[i]['categories_name']==null?'':response.data[i]['categories_name']}</td>
                                    <td style="width:25%;text-align:center;"><b>${response.data[i]['status_wo']==null?'':status_wo}</b></td>
                                    <td style="width:25%;text-align:center">
                                            <button title="Detail" class="editAssignment btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editAssignment">
                                                <i class="fas fa-solid fa-eye"></i>
                                            </button> 
                                    </td>
                                </tr>
                                `;
                    }
                        $('#assignment_table > tbody:first').html(data);
                        $('#assignment_table').DataTable({
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
    function approve_assignment(data)
    {
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('approve_assignment')}}",
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
                    $('#save').prop('disabled', false);
                    return false;
                }else{
                    toastr['success'](response.message);
                    window.location = "{{route('work_order_assignment')}}";
                }
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }

</script>