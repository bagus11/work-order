<script>
    
    get_menus()
    get_submenus()
    $('#select_menus_type').on('change', function(){
        var select_menus_type = $('#select_menus_type').val()
        $('#menus_type').val(select_menus_type)
    })
    $('#btn_save_menus').on('click', function(){
        save_menus()
    })
    $('#select_menus_id').on('change', function(){
        var select_menus_id = $('#select_menus_id').val()
        $('#menus_id').val(select_menus_id)
    })
    $('#submenus_save').on('click', function(){
        save_submenus()
    })
    $('#btn_menus_update').on('click', function(){
        update_menus()
    })
    $('#menus_table').on('click', '.editMenus', function() {
            var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getDetailMenus')}}",
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
                    var output = response.detail;
                    $('#status_menus_update').val(output.status)
                    $('#id_menus_update').val(output.id)
                    $('#menus_name_update').val(output.name)
                    $('#menus_icon_update').val(output.icon)
                    $('#menus_link_update').val(output.link)
                    $('#menus_description_update').val(output.description)
                  if(output.status == 1){
                    document.getElementById("menus_status_update").checked = true;
                    $('#label_menus_status').html('Active')
                }else{
                    document.getElementById("menus_status_update").checked = false;
                      $('#label_menus_status').html('inactive')
                }
                    
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
        });
    $('#menus_table').on('click', '.deleteMenus', function() {
        var id = $(this).data('id');
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('deleteMenus')}}",
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
                toastr['success'](response.message);
                window.location = "{{route('menus')}}";
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });

    });
    $('#submenus_table').on('click', '.deleteSubmenus', function() {
        var id = $(this).data('id');
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('deleteSubmenus')}}",
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
                toastr['success'](response.message);
                window.location = "{{route('menus')}}";
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });

    });
    $('#select_submenus').on('change', function(){
        var select_submenus = $('#select_submenus').val()
        $('#derivative_update').val(select_submenus)
    })
    $('#submenus_table').on('click', '.editeSubmenus', function() {
        var id = $(this).data('id');
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getDetailSubmenus')}}",
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
                var output = response.detail;
                $('#status_submenus_update').val(output.status)
                $('#id_submenus_update').val(output.id)
                $('#submenus_name_update').val(output.name)
                $('#submenus_link_update').val(output.link)
                $('#derivative_update').val(output.id_menus)
                $('#select_submenus').empty();
                $('#select_submenus').append('<option>'+output.menus_name+'</option>')
                $.each(response.menus,function(i,data){
                        $('#select_submenus').append('<option value="'+data.id+'">' + data.name +'</option>');
                    });
                $('#submenus_description_update').val(output.description)
                if(output.status == 1){
                document.getElementById("submenus_status_update").checked = true;
                $('#label_submenus_status').html('Active')
            }else{
                document.getElementById("submenus_status_update").checked = false;
                    $('#label_submenus_status').html('inactive')
            }
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });

    });
    $('#btn_submenus_update').on('click', function(){
        update_submenus()
    })
    function clear_menus(){
        $('.message_error').html('')
        $('#menus_name').val('')
        $('#menus_icon').val('')
        $('#menus_type').val('')
        $('#menus_link').val('')
        $('#menus_description').val('')
    }
    function clear_submenus(){
        $('.message_error').html('')
        $('#submenus_name').val('')
        $('#menus_id').val('')
        $('#submenus_link').val('')
        $('#submenus_description').val('')
        get_menus_name()
    }
    // Function
    function get_menus(){
        $('#menus_table').DataTable().clear();
        $('#menus_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_menus')}}",
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
                                <td style="width:25%;text-align:left">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="width:25%;text-align:left">${response.data[i]['link']==null?'':response.data[i]['link']}</td>
                                <td style="width:25%;text-align:center">${response.data[i]['status']== 0 ?'inactive':'active'}</td>
                                <td style="width:25%;text-align:center">
                                       
                                        <button title="Detail" class="editMenus btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editMenusModal">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                        <button title="Delete" class="deleteMenus btn btn-danger"data-id="${response.data[i]['id']}">
                                        <i class="fas fa-solid fa-trash"></i>
                                        </button>   
                                        
                                </td>
                            </tr>
                            `;
                }
                    $('#menus_table > tbody:first').html(data);
                    $('#menus_table').DataTable({
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

    function save_menus(){
        var data ={
            'menus_name':$('#menus_name').val(),
            'menus_icon':$('#menus_icon').val(),
            'menus_type':$('#menus_type').val(),
            'menus_link':$('#menus_link').val(),
            'menus_description':$('#menus_description').val(),
        }
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('save_menus')}}",
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
                        window.location = "{{route('menus')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }

    function get_menus_name(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_menus_name')}}",
            type: "get",
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_menus_id').empty();
                $('#select_menus_id').append('<option value ="">Pilih Menu</option>');
                $.each(response.data,function(i,data){
                    $('#select_menus_id').append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }

    function save_submenus(){
        var data ={
            'submenus_name':$('#submenus_name').val(),
            'menus_id':$('#menus_id').val(),
            'submenus_link':$('#submenus_link').val(),
            'submenus_description':$('#submenus_description').val(),
        }
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('save_submenus')}}",
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
                        window.location = "{{route('menus')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function get_submenus(){
        $('#submenus_table').DataTable().clear();
        $('#submenus_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_submenus')}}",
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
                var data_array =[]
                data_array.push(response)

                var data=''
                for(i = 0; i < response.data.length; i++ )
                {
                    data += `<tr style="text-align: center;">
                                <td style="width:25%;text-align:left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="width:25%;text-align:left;">${response.data[i]['link']==null?'':response.data[i]['link']}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['status']== 0 ?'inactive':'active'}</td>
                                <td style="width:25%;text-align:center">
                                    
                                        <button title="Detail" class="editeSubmenus btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editSubmenusModal">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                        <button title="Delete" class="deleteSubmenus btn btn-danger"data-id="${response.data[i]['id']}">
                                        <i class="fas fa-solid fa-trash"></i>
                                        </button>   
                                        
                                </td>
                            </tr>
                            `;
                }
                    $('#submenus_table > tbody:first').html(data);
                    $('#submenus_table').DataTable({
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

    function update_menus(){
        var is_active = '';
            var status = document.getElementById("menus_status_update");
            status.checked==true?is_active='1':is_active='0'
        var data ={
            'status':is_active,
            'id_menus_update':$('#id_menus_update').val(),
            'menus_name_update':$('#menus_name_update').val(),
            'menus_icon_update':$('#menus_icon_update').val(),
            'menus_description_update':$('#menus_description_update').val(),
        }
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('update_menus')}}",
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
                    $('#addSubmenusModal').hide()
                    window.location = "{{route('menus')}}";
                }
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function update_submenus(){
        var is_active = '';
            var status = document.getElementById("submenus_status_update");
            status.checked==true?is_active='1':is_active='0'
        var data = {
            'status_submenus_update':$('#status_submenus_update').val(),
            'id_submenus_update': $('#id_submenus_update').val(),
            'submenus_name_update': $('#submenus_name_update').val(),
            'derivative_update': $('#derivative_update').val(),
            'submenus_description_update': $('#submenus_description_update').val(),
            'status':is_active
        }
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('update_submenus')}}",
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
                    window.location = "{{route('menus')}}";
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