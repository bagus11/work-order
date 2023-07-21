<script>
    
    get_role();
    get_permission();
    // Operation
    $('#btn_save_roles').on('click', function(){
        save_role()
    })
    $('#btn_update_roles').on('click', function(){
        update_role()
    })
    $('#roles_table').on('click', '.editRoles', function() {
            var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getDetailRoles')}}",
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
                  $('#roles_name_update').val(response.detail.name)
                  $('#roles_id').val(response.detail.id)
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
        });
    $('#roles_table').on('click', '.deleteRoles', function() {
            var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('delete_role')}}",
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
                    if(response.status==200){
                    toastr['success'](response.message);
                    window.location = "{{route('role_permission')}}";
                    }else{
                    toastr['error'](response.message);
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
        });
    $('#permission_table').on('click', '.deletePermission', function() {
            var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('delete_permission')}}",
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
                    if(response.status==200){
                    toastr['success'](response.message);
                    window.location = "{{route('role_permission')}}";
                    }else{
                    toastr['error'](response.message);
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
        });
   
    $('#option').on('change', function(){
        var option = $('#option').val()
        var menus_name = $('#menus_name').val()
        $('#permission_name').val(option+'-'+menus_name)
    })
    $('#menus_name').on('change', function(){
        var option = $('#option').val()
        var menus_name = $('#menus_name').val()
        $('#permission_name').val(option+'-'+menus_name)
    })
    $('#btn_save_permission').on('click', function(){
        save_permission()
    })
    // End Operation
    
    // Function
    function clear_roles(){
        $('.message_error').html('')
        $('#roles_name').val('')
    }
    function get_role(){
        $('#roles_table').DataTable().clear();
        $('#roles_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_role')}}",
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
                                <td style="text-align: left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="width:25%;text-align:center">
                                       
                                        <button title="Detail" class="editRoles btn btn-sm btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editRolesModal">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                        <button title="Delete" class="deleteRoles btn btn-sm btn-danger"data-id="${response.data[i]['id']}">
                                        <i class="fas fa-solid fa-trash"></i>
                                        </button>   
                                        
                                </td>
                            </tr>
                            `;
                }
                    $('#roles_table > tbody:first').html(data);
                    $('#roles_table').DataTable({
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
    function get_permission(){
        $('#permission_table').DataTable().clear();
        $('#permission_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_permission')}}",
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
                                <td style="text-align: left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="width:25%;text-align:center">
                                        <button title="Delete" class="deletePermission btn-sm btn btn-danger"data-id="${response.data[i]['id']}">
                                        <i class="fas fa-solid fa-trash"></i>
                                        </button>   
                                        
                                </td>
                            </tr>
                            `;
                }
                    $('#permission_table > tbody:first').html(data);
                    $('#permission_table').DataTable({
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
    function save_role()
    {
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('save_role')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: {'roles_name':$('#roles_name').val()},
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
                        window.location = "{{route('role_permission')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function update_role(){
        var data ={
            'roles_name_update':$('#roles_name_update').val(),
            'roles_id':$('#roles_id').val(),
        }
        
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('update_role')}}",
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
                    window.location = "{{route('role_permission')}}";
                }
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function permission_menus_name()
    {
        $('.message_error').html('')
        $.ajax({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: "{{route('permission_menus_name')}}",
           type: "get",
           dataType: 'json',
           async: true,
           beforeSend: function() {
               SwalLoading('Please wait ...');
           },
           success: function(response) {
               swal.close();
               $('#menus_name').empty();
               $('#menus_name').append('<option value ="">Pilih Menu</option>');
               $.each(response.menus_name,function(i,data){
                   $('#menus_name').append('<option value="'+data.link+'">' + data.name +'</option>');
               });
               
           },
           error: function(xhr, status, error) {
               swal.close();
               toastr['error']('Failed to get data, please contact ICT Developer');
           }
       });
    }
    function save_permission(){
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('save_permission')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: {'permission_name':$('#permission_name').val()},
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
                        window.location = "{{route('role_permission')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    // End Function
</script>