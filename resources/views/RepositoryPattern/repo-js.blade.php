<script>
//   Repository Pattern
getNotification()
        $(document).ready(function() {
            $('#notifikasi').on('click', function(){
                getNotification()
                updateNotif()
            })
        })
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
        function timeSince(date) {
            var seconds = Math.floor((new Date() - date) / 1000);

            var interval = seconds / 31536000;

            // if (interval > 1) {
            // return Math.floor(interval) + " years";
            // }
            // interval = seconds / 2592000;
            // if (interval > 1) {
            // return Math.floor(interval) + " months";
            // }
            // interval = seconds / 86400;
            // if (interval > 1) {
            // return Math.floor(interval) + " days";
            // }
            interval = seconds / 3600;
            if (interval > 1) {
            return Math.floor(interval) + " hours";
            }
            interval = seconds / 60;
            if (interval > 1) {
            return Math.floor(interval) + " minutes";
            }
            return Math.floor(seconds) + " seconds";
        }
        function getNotification(){
          
            $('#notificationBody').empty()
            $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'getNotification',
            type: "get",
            dataType: 'json',
            async: true,
            success: function(response) {
             
                if(response.countStatus.new == 0){
                    $('#notificationCount').hide()
                  
                }else{
                    $('#notificationCount').show()
                }
                    var data =''
                    $('#notificationCount').html(response.countStatus.new)
                    for(i = 0; i < response.data.length; i++ )
                    {
                        var status = '';
                        if(response.data[i].status == 0){
                            status ="#E8E2E2";
                        }else{
                            status ="white";
                        }
                        data += `
                        <a href="${response.data[i].link}" class="dropdown-item"  style="background:${status}">

                        <div class="media">
                            
                            <div class="media-body">
                                <strong style="font-size:12px;color:#85CDFD" class="dropdown-item-title">
                                ${response.data[i].subject} </strong>
                            
                                <p  style="font-size:11px">${response.data[i].message}</p>
                                <p class="text-muted" style="font-size:9px"><i class="far fa-clock mr-1"></i>${response.data[i].date}, ${response.data[i].time}</p>
                            </div>
                        </div>

                        </a>
                        <div class="dropdown-divider"></div>
                                                   `;
                    }
                    $('#notificationBody').html(data)

                 
                    
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        }
        function updateNotif(){
           
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'updateNotif',
                type: "post",
                dataType: 'json',
                async: true,
                success: function(response) {
                    swal.close();
                    $('#notificationCount').hide()
                },
                error: function(response) {
                    toastr['error']('Failed to get notification, please contact ICT Developer');
                }
            }); 
        }

 // End Repository Pattern
</script>