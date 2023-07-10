<script>
      
      get_role_user()
      get_role()
      $('#select_user').on('change', function(){
        var select_user = $('#select_user').val()
        $('#user_id').val(select_user)
      })
      $('#select_role').on('change', function(){
        var select_role = $('#select_role').val()
        $('#role_id').val(select_role)
      })
      $('#btn_save_role_user').on('click', function(){
        save_role_user()
      })
      $('#select_role_update').on('change', function(){
        var select_role_update = $('#select_role_update').val()
        $('#role_id_update').val(select_role_update);
      })
      $('#btn_update_role_user').on('click', function(){
        update_role_user()
    })
      $('#role_user_table').on('click', '.editRoles', function() {
       var id = $(this).data('id');
       $.ajax({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: "{{route('detail_role_user')}}",
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
               $('#user_name').val(response.detail.user_name)
               $('#user_id_update').val(response.detail.model_id)
               $('#role_id_update').val(response.detail.role_id)
               $('#select_role_update').empty();
               $('#select_role_update').append('<option value ="'+response.detail.role_id+'">'+response.detail.roles_name+'</option>');
               $.each(response.role,function(i,data){
                   $('#select_role_update').append('<option value="'+data.id+'">' + data.name +'</option>');
               });
               
           },
           error: function(xhr, status, error) {
               swal.close();
               toastr['error']('Failed to get data, please contact ICT Developer');
           }
       });

   });
      $('#role_permission_table').on('click', '.addPermission', function() {
       var id = $(this).data('id');
       $('#permission_table').DataTable().clear();
       $('#permission_table').DataTable().destroy();
       $.ajax({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: "{{route('get_permisssion')}}",
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
               $('#role_id_permission').val(id)
               var data ="";
               for(i = 0; i < response.permission_inactive.length; i++ )
               {
                   data += `<tr style="text-align: center;">
                               <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.permission_inactive[i]['id']}"  data-name="${response.permission_inactive[i]['name']}"></td>
                               <td style="text-align: left;">${response.permission_inactive[i]['name']==null?'':response.permission_inactive[i]['name']}</td>
                           </tr>
                           `;
               }
                   $('#permission_table > tbody:first').html(data);
                       $(document).ready(function() 
                    {
                        $('#permission_table').DataTable({
                            scrollX  : true,
                            scrollY  :280
                      }).columns.adjust()
                    });
               
           },
           error: function(xhr, status, error) {
               swal.close();
               toastr['error']('Failed to get data, please contact ICT Developer');
           }
       });

   });
   $('#check_all_delete_permission').on('click', function(){
     // Get all rows with search applied
       var table = $('#edit_permission_table').DataTable();
     var rows = table.rows({ 'search': 'applied' }).nodes();
     // Check/uncheck checkboxes for all rows in the table
     $('input[type="checkbox"]', rows).prop('checked', this.checked);
  });
   $('#check_all_add_permission').on('click', function(){
     // Get all rows with search applied
       var table = $('#permission_table').DataTable();
     var rows = table.rows({ 'search': 'applied' }).nodes();
     // Check/uncheck checkboxes for all rows in the table
     $('input[type="checkbox"]', rows).prop('checked', this.checked);
  });
    $('#role_permission_table').on('click', '.editPermission', function() {
       var id = $(this).data('id');
       $('#edit_permission_table').DataTable().clear();
       $('#edit_permission_table').DataTable().destroy();
       $.ajax({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: "{{route('get_permisssion')}}",
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
               $('#edit_role_id_permission').val(id)
               var data ="";
               for(i = 0; i < response.permission_active.length; i++ )
               {
                   data += `<tr style="text-align: center;">
                               <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.permission_active[i]['id']}"  data-name="${response.permission_active[i]['name']}"></td>
                               <td style="text-align: left;">${response.permission_active[i]['name']==null?'':response.permission_active[i]['name']}</td>
                           </tr>
                           `;
               }
                   $('#edit_permission_table > tbody:first').html(data);
                       $(document).ready(function() 
                    {
                        $('#edit_permission_table').DataTable({
                            scrollX  : true,
                            scrollY  :280
                      }).columns.adjust()
                        
                    });
               
           },
           error: function(xhr, status, error) {
               swal.close();
               toastr['error']('Failed to get data, please contact ICT Developer');
           }
       });

   });

   $('#btn_add_permission').click(function () {
        var checkArray = [];
        var lengthParsed = 0;
        var role_permission_table = $('#permission_table').dataTable();
        var rowcollection =  role_permission_table.$("input:checkbox[name=check]:checked",{"page": "all"});
        rowcollection.each(function(){
            checkArray.push($(this).data("name"));
        });

        lengthParsed = checkArray.length;
        if(lengthParsed == 0)
        {
            toastr['error']('Belum memilih permission sama sekali !');
            return false;
        }

        var data ={
            'checkArray':checkArray,
            'role_id_permission':$('#role_id_permission').val(),

        }
        add_role_permission(data);
                  
    }); 
   $('#btn_delete_permission').click(function () {
        var checkArray = [];
        var lengthParsed = 0;
        var role_permission_table = $('#edit_permission_table').dataTable();
        var rowcollection =  role_permission_table.$("input:checkbox[name=check]:checked",{"page": "all"});
        rowcollection.each(function(){
            checkArray.push($(this).val());
        });

        lengthParsed = checkArray.length;
        if(lengthParsed == 0)
        {
            toastr['error']('Belum memilih permission sama sekali !');
            return false;
        }

        var data ={
            'checkArray':checkArray,
            'role_id_permission':$('#edit_role_id_permission').val(),

        }
        delete_role_permission(data);
                  
    }); 
 //   Function
    function get_role_user(){
        $('#role_user_table').DataTable().clear();
        $('#role_user_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_role_user')}}",
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
                                <td style="text-align: left;">${response.data[i]['user_name']==null?'':response.data[i]['user_name']}</td>
                                <td style="text-align: left;">${response.data[i]['roles_name']==null?'':response.data[i]['roles_name']}</td>
                                <td style="width:25%;text-align:center">
                                        <button title="Detail" class="editRoles btn btn-primary rounded"data-id="${response.data[i]['user_id']}" data-toggle="modal" data-target="#editRolesUserModal">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                </td>
                            </tr>
                            `;
                }
                    $('#role_user_table > tbody:first').html(data);
                    $('#role_user_table').DataTable({
                        scrollX  : true,
                        scrollY  :280
                    }).columns.adjust()
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function get_username(){
       $.ajax({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: "{{route('get_username')}}",
           type: "get",
           dataType: 'json',
           async: true,
           beforeSend: function() {
               SwalLoading('Please wait ...');
           },
           success: function(response) {
               swal.close();
               $('#select_user').empty();
               $('#select_user').append('<option value ="">Pilih User</option>');
               $.each(response.data,function(i,data){
                   $('#select_user').append('<option value="'+data.id+'">' + data.name +'</option>');
               });
               $('#select_role').empty();
               $('#select_role').append('<option value ="">Pilih Role</option>');
               $.each(response.role,function(i,data){
                   $('#select_role').append('<option value="'+data.id+'">' + data.name +'</option>');
               });
               
           },
           error: function(xhr, status, error) {
               swal.close();
               toastr['error']('Failed to get data, please contact ICT Developer');
           }
       });
   }
   function save_role_user(){
    var data ={
        'role_id':$('#role_id').val(),
        'user_id':$('#user_id').val(),
    }
    $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('save_role_user')}}",
            type: "post",
            dataType: 'json',
            async: true,
            data:data,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('.message_error').html('')
                if(response.status==422)
               {
                   toastr['error'](response.message);
                   return false
               }else{
                   toastr['success'](response.message);
                   window.location = "{{route('user_access')}}";
               }
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
   }
   function get_role(){
        $('#role_permission_table').DataTable().clear();
        $('#role_permission_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_role')}}",
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
                                <td style="text-align: left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="width:25%;text-align:center">
                                    <button title="Add Permission" class="addPermission btn btn-success rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#addPermissionModal">
                                            <i class="fas fa-solid fa-plus"></i>
                                    </button>    
                                    <button title="List" class="editPermission btn btn-danger rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editPermissionModal">
                                            <i class="fas fa-solid fa-list"></i>
                                    </button>
                                </td>
                            </tr>
                            `;
                }
                    $('#role_permission_table > tbody:first').html(data);
                    $('#role_permission_table').DataTable({
                        scrollX  : true,
                        scrollY  :280,
                    }).columns.adjust()
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function update_role_user(){
       var role_id_update = $('#role_id_update').val()
       var user_id_update = $('#user_id_update').val()
       $.ajax({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: "{{route('update_roles_user')}}",
           type: "post",
           dataType: 'json',
           data:{
               'user_id':user_id_update,
               'role_id':role_id_update,
           },
           async: true,
           beforeSend: function() {
               SwalLoading('Please wait ...');
           },
           success: function(response) {
               swal.close();
               if(response.status==422)
               {
                   toastr['error'](response.message);
                   return false
               }else{
                   toastr['success'](response.message);
                   window.location = "{{route('user_access')}}";
               }
               
           },
           error: function(xhr, status, error) {
               swal.close();
               toastr['error']('Failed to get data, please contact ICT Developer');
           }
       });
   }
   function add_role_permission(data){
    $.ajax({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: "{{route('add_role_permission')}}",
           type: "post",
           dataType: 'json',
           data:data,
           async: true,
           beforeSend: function() {
               SwalLoading('Please wait ...');
           },
           success: function(response) {
               swal.close();
               if(response.status==422)
               {
                   toastr['error'](response.message);
                   return false
               }else{
                   toastr['success'](response.message);
                   window.location = "{{route('user_access')}}";
               }
               
           },
           error: function(xhr, status, error) {
               swal.close();
               toastr['error']('Failed to get data, please contact ICT Developer');
           }
       });
   }
   function delete_role_permission(data){
       $.ajax({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: "{{route('delete_role_permission')}}",
           type: "get",
           dataType: 'json',
           data:data,
           async: true,
           beforeSend: function() {
               SwalLoading('Please wait ...');
           },
           success: function(response) {
               swal.close();
               if(response.status==500)
               {
                   toastr['error'](response.message);
                   return false
               }else{
                   toastr['success'](response.message);
                   window.location = "{{route('user_access')}}";
               }
               
           },
           error: function(xhr, status, error) {
               swal.close();
               toastr['error']('Failed to get data, please contact ICT Developer');
           }
       });
   }
    //   End Function


</script>