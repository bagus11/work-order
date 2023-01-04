<script>

    get_work_order_list()
    $('#add_wo').on('click', function(){
        get_categories_name()
        get_problem_type_name()
    })
    $('#select_request_type').on('change', function(){
        var select_request_type = $('#select_request_type').val()
        $('#request_type').val(select_request_type)
    })
    $('#select_categories').on('change', function(){
        var select_categories = $('#select_categories').val()
        $('#categories').val(select_categories)
    })
    $('#select_problem_type').on('change', function(){
        var select_problem_type = $('#select_problem_type').val()
        $('#problem_type').val(select_problem_type)
    })
    function get_work_order_list(){
        $('#wo_table').DataTable().clear();
        $('#wo_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_work_order_list')}}",
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
                    data += `<tr style="text-align: center;">
                                <td style="width:25%;text-align:left;">${response.data[i]['user_id']==null?'':response.data[i]['user_id']}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['request_code']==null?'':response.data[i]['request_code']}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['category']==null?'':response.data[i]['category']}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['created_at']==null?'':response.data[i]['created_at']}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['status_wo']==null?'':response.data[i]['status_wo']}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['assignment']==null?'':response.data[i]['assignment']}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['user_id_support']==null?'':response.data[i]['user_id_support']}</td>
                                <td style="width:25%;text-align:center">
                                        <button title="Detail" class="editKantor btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editMasterKantor">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button> 
                                </td>
                            </tr>
                            `;
                }
                    $('#wo_table > tbody:first').html(data);
                    $('#wo_table').DataTable({
                        scrollX  : true,
                        scrollY:220
                    }).columns.adjust()
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
    function get_problem_type_name(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_problem_type_name')}}",
            type: "get",
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_problem_type').empty();
                $('#select_problem_type').append('<option value ="">Choose Problem Type</option>');
                $.each(response.data,function(i,data){
                    $('#select_problem_type').append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function save_wo(){
        data ={
            'request_type':$('#request_type').val(),
            'categories':$('#categories').val(),
            'problem_type':$('#problem_type').val(),
            'subject':$('#subject').val(),
            'add_info':$('#add_info').val(),
        }
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('save_wo')}}",
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
                        window.location = "{{route('work_order_list')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
</script>