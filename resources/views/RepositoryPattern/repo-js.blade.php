<script>
//   Repository Pattern
        function onChange(selectId, id){
            $('#'+selectId).on('change', function(){
                var x = $('#'+ selectId).val()
                $('#'+id).val(x)
            })
        }
        function getDepartementName(route, id, name){
            $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: route,
            type: "get",
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#'+id).empty();
                $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                $.each(response.data,function(i,data,param){
                    $('#'+id).append('<option value="'+data.initial+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        }
        function getSelect(route,data, id, name){
            $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: route,
            type: "get",
            data:data,
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#'+id).empty();
                $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                $.each(response.data,function(i,data,param){
                    $('#'+id).append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        }
        function store(url,data,route){
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
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
                    toastr['success'](response.meta.message);
                    window.location = route;
                },
                error: function(response) {
                    $('.message_error').html('')
                    swal.close();
                    if(response.status == 500){
                        console.log(response)
                        toastr['error'](response.responseJSON.meta.message);
                        return false
                    }
                    if(response.status === 422)
                    {
                        $.each(response.responseJSON.errors, (key, val) => 
                            {
                                $('span.'+key+'_error').text(val)
                            });
                    }else{
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                }
            });
        }
        function getOfficeName(id){
            $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'get_kantor_name',
            type: "get",
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#'+id).empty();
                $('#'+id).append('<option value =""> * - All Office </option>');
                $.each(response.data,function(i,data,param){
                    $('#'+id).append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        }
 // End Repository Pattern
</script>