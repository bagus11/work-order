<script>
    $('.select2').select2()
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
                                <td style="text-align: left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="text-align: left;">${response.data[i]['link']==null?'':response.data[i]['link']}</td>
                                <td style="text-align: center;">${response.data[i]['status']== 0 ?'inactive':'active'}</td>
                                <td style="width:25%;text-align:center">
                                       
                                        <button title="Detail" class="editBobot btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editMenusModal">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                        <button title="Delete" class="deleteBobot btn btn-danger"data-id="${response.data[i]['id']}">
                                        <i class="fas fa-solid fa-trash"></i>
                                        </button>   
                                        
                                </td>
                            </tr>
                            `;
                }
                    $('#menus_table > tbody:first').html(data);
                    $('#menus_table').DataTable();
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
                var data=''
                for(i = 0; i < response.data.length; i++ )
                {
                    data += `<tr style="text-align: center;">
                                <td style="text-align: left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="text-align: left;">${response.data[i]['link']==null?'':response.data[i]['link']}</td>
                                <td style="text-align: center;">${response.data[i]['status']== 0 ?'inactive':'active'}</td>
                                <td style="width:25%;text-align:center">
                                       
                                        <button title="Detail" class="editBobot btn btn-primary rounded"data-id="${response.data[i]['id']}">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                        <button title="Delete" class="deleteBobot btn btn-danger"data-id="${response.data[i]['id']}">
                                        <i class="fas fa-solid fa-trash"></i>
                                        </button>   
                                        
                                </td>
                            </tr>
                            `;
                }
                    $('#submenus_table > tbody:first').html(data);
                    $('#submenus_table').DataTable();
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    // End Function

</script>