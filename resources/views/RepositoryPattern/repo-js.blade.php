<script>
//   Repository Pattern
var auth_id = $('#auth_id').val()
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
        function getName(route, id, name){
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
                    $('#'+id).append('<option value="'+data.id+'">' + data.name +'</option>');
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
             
              if(response.data.length == 0){
                $('#notifikasi').hide()
              }else{
                $('#notifikasi').show()
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
              }
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
        function master_chart(title,labels,type,id,data_a,color){
            const data = {
                labels: labels,
                datasets: [{
                label: title,
                backgroundColor:color,
                borderColor: 'rgb(255, 99, 132)',
                datalabels: {
                    color: 'black',
                            anchor:'end',
                            align: 'end',
                            formatter: (value, ctx) => {
                            let sum = 0;
                            for( i =0; i< ctx.dataset.data.length ; i++){
                                sum +=ctx.dataset.data[i]
                            }
                            let percentage = (value * 100 / sum).toFixed(2) + "%";
                            
                            return percentage;
                            }
                         
                        },
                data:data_a
                }]
            }
            var chart = new Chart(id, {
                type: type,
                data: data,
                options:{
                    legend: {
                        display: false
                    },
                    // tooltips: {
                    //     callbacks: {
                    //         label: function(tooltipItem, data) 
                    //                     {
                    //                     return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    //                     }
                    //     }
                    // },
                    layout:{
                            padding: 30
                        },
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {if (value % 1 === 0) {return value;}}
                                },
                            }
                        ]
                    }
            }
            
            
            });
        }
        function pieChart(title,label,data,color,type,id){
        
            const x = {
            labels:label,
            datasets:[{
                    data: data,
                    backgroundColor:color,
                    borderColor: "#fff"
                }], 
            };
            const config = {
                type: type,
            
            }
            const option={
                responsive: true,
                    legend: {
                        display: true,
                        position:'bottom',
                       
                        labels:{
                            usePointStyle:true,
                          
                        }
                    },
                    tooltips: {
                        enabled: true
                    },
                
                    plugins: {
                        legend:{
                            labels: {
                                // This more specific font property overrides the global property
                                font: {
                                    size: 14
                                }
                            }
                        },
                        datalabels: {
                        formatter: (value, ctx) => {
                            let sum = 0;
                            for( i =0; i< ctx.dataset.data.length ; i++){
                                sum +=ctx.dataset.data[i]
                            }
                            let percentage = (value * 100 / sum).toFixed(2) + "%";
                            return percentage;
                        },
                        color: '#fff',
                    }
                    
                    },
                
            }
            var chart = new Chart(id, {
                type: type,
                data: x,
                options:option
            
            
            });
        }
        function timeConvert(n) {
            var num = n;
            var hours = (num / 60);
            var rhours = Math.floor(hours);
            var minutes = (hours - rhours) * 60;
            var rminutes = Math.round(minutes);
            var label = rhours == 0 ?  rminutes +' menit' : rhours + ' jam ' + rminutes + ' menit'
            return label 
        }
        function uploadFile(url,data, route){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: route,
                type: "post",
                dataType: 'json',
                async: true,
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function() {
                    SwalLoading('Inserting progress, please wait .');
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
        function saveRepo(url,data,route){
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
                    if(response.status==500){
                        toastr['warning'](response.message);
                    }
                    else{
                        toastr['success'](response.message);
                        window.location = route;
                    }
                    
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        }
        function getCallback(route,data,callback){
            $.ajax({
            url: route,
            type: "get",
            dataType: 'json',
            data:data,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: callback,
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }); 
        }
        function postAttachment(route,data,withFile,callback){
            $.ajax({
                    url: route,
                    type: 'POST',
                    type: "post",
                    dataType: 'json',
                    async: true,
                    processData: withFile,
                    contentType: withFile,
                    data: data,
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success:callback,
                    error: function(response) {
                        $('.message_error').html('')
                        swal.close();
                        if(response.status == 500){
                            console.log(response)
                            toastr['error'](response.responseJSON.meta.message);
                            return false
                        }
                        if(response.status === 422){
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
        function postCallback(route,data,callback){
            $.ajax({
                url: route,
                type: "post",
                dataType: 'json',
                data:data,
                async: true,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success:callback,
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
        function postCallbackNoSwal(route,data,callback){
            $.ajax({
                url: route,
                type: "post",
                dataType: 'json',
                data:data,
                async: true,
                success:callback,
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
        function getCallbackNoSwal(route,data,callback){
            $.ajax({
            url: route,
            type: "get",
            dataType: 'json',
            data:data,
            success: callback,
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            }); 
        }
        function getActiveItems(url,data,id,name){
        $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                async: true,
                data : data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                swal.close();
                    $('#'+id).empty()
                    $('#'+id).append('<option value ="">Choose '+ name +'</option>');
                    $.each(response.data,function(i,data){
                        $('#'+id).append('<option data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                    });
                },
                error: function(response) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact Developer');
                }
            });   
    }
 // End Repository Pattern
</script>