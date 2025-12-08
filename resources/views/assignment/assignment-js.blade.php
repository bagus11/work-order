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
                $('#editAssignment').modal('show')
                $('#select_request_type').html(': '+response.detail.request_type)
                $('#select_categories').html(': '+response.detail.categories_name)
                $('#select_problem_type').html(': '+response.detail.problem_type_name)
                $('#request_type').html(': '+response.detail.request_type)
                $('#subject').html(': '+response.detail.subject)
                $('#add_info').html(': '+response.detail.add_info)
                $('#request_code').html(': '+response.detail.request_code)
                $('#username').html(': '+response.detail.username)
                $('#wo_id').val(id)
                $('#select_user').empty()
                $('#select_user').append('<option value="">Choose PIC</option>')
                // $('#selectPriority').append('<option value="">Choose Level</option>')
                $.each(response.data,function(i,data){
                    $('#select_user').append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                // $.each(response.priority,function(i,data){
                //     $('#selectPriority').append('<option value="'+data.id+'">' + data.name +'</option>');
                // });
                
                 
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
    });
    $('#assignment_table').on('click', '.edit_priority', function() {
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
                $('#select_request_type_priority').html(': '+response.detail.request_type)
                $('#select_categories_priority').html(': '+response.detail.categories_name)
                $('#select_problem_type_priority').html(': '+response.detail.problem_type_name)
                $('#request_type_priority').html(': '+response.detail.request_type)
                $('#subject_priority').html(': '+response.detail.subject)
                $('#add_info_priority').html(': '+response.detail.add_info)
                $('#request_code_priority').html(': '+response.detail.request_code)
                $('#username_priority').html(': '+response.detail.username)
                $('#pic_priority').html(': '+response.pic.username)
                $('#wo_id_priority').val(response.detail.request_code)   
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    });
    //  $(document).ready(function() {
    //     $('#select_request_type_priority').select2()
    //     $('#select_categories_priority').select2()
    //     $('#select_problem_type_priority').select2()
    //  })
    $('#btn_approve_assign').on('click', function(){

        var data ={
        'user_pic': $('#user_pic').val(),
        'priority': $('#priority').val(),
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
        'priority': $('#priority').val(),
        'note': $('#note').val(),
        'id':$('#wo_id').val(),
        'approve':2
       }
       approve_assignment(data)
    })
    $('#btnAssignPriority').on('click', function(){
        var data ={
            'request_code':$('#wo_id_priority').val(),
            'select_level_priority':$('#select_level_priority').val()
        }
        if($('#select_level_priority').val() == '')
        {
            toastr['error']('Choose priority level first');
            return false
        }else{   
            store('updateLevel',data,'work_order_assignment')
        }
    })
    $('#select_user').on('change', function(){
        var select_user = $('#select_user').val()
        $('#user_pic').val(select_user)
    })
    $('#selectPriority').on('change', function(){
        var selectPriority = $('#selectPriority').val()
        $('#priority').val(selectPriority)
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
                                status_color ='#5BC0F8'
                            }else  if(response.data[i].status_wo==2){
                                status_wo ="PENDING"
                                status_color ='#FFC93C'
                            }else  if(response.data[i].status_wo==3){
                                status_wo ="REVISION"
                                status_color ='red'
                            }else if(response.data[i].status_wo==4){
                                if(response.data[i].status_approval == '1'){
                                    status_wo ="DONE"
                                    status_color ='green'
                                }else{
                                    status_wo ="CHECKING"
                                    status_color ='#F0A04B'
                                }
                            }else{
                                status_wo ="REJECT"
                                status_color ='red'
                            }
                            var assignPIC =''
                            var priority =''
                            if(response.data[i].status_wo ==0){
                                assignPIC =` <button title="Assign PIC" class="editAssignment btn btn-sm btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editAssignment">
                                                <i class="fas fa-solid fa-user"></i>
                                            </button> `;
                            }
                            if(response.data[i].status_wo != 0 && response.data[i].priority == null){
                                priority =` <button title="Assign Priority" class="edit_priority btn btn-sm btn-warning rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editPriority">
                                                <i class="fas fa-solid fa-city"></i>
                                            </button> `;
                            }
                        data += `<tr style="text-align: center;">
                                    <td style="width:25%;text-align:left;">${response.data[i]['username']==null?'':response.data[i]['username']}</td>
                                    <td style="width:25%;text-align:center;" class="request_code">${response.data[i]['request_code']==null?'':response.data[i]['request_code']}</td>
                                    <td style="width:25%;text-align:center;">${response.data[i]['departement_name']==null?'':response.data[i]['departement_name']}</td>
                                    <td style="width:25%;text-align:center;">${response.data[i]['categories_name']==null?'':response.data[i]['categories_name']}</td>
                                    <td style="width:25%;text-align:center;color:${status_color}"><b>${response.data[i]['status_wo']==null?'':status_wo}</b></td>
                                    <td style="width:25%;text-align:center">
                                          ${assignPIC} ${priority}
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
                }else if(response.status == 500){
                    toastr['warning'](response.message);
                }
                else{
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