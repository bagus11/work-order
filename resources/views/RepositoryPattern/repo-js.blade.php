<script>
//   Repository Pattern
var auth_id = $('#auth_id').val()
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
                console.log(error)
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
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }
    function convertDate(inputDate) {
        // Parse the input date string
        const dateParts = inputDate.split("-");
        const year = parseInt(dateParts[0]);
        const month = parseInt(dateParts[1]);
        const day = parseInt(dateParts[2]);

        // Create a Date object
        const date = new Date(year, month - 1, day);

        // Define month names
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        // Format the date
        const formattedDate = day + " " + monthNames[month - 1] + " " + year;

        return formattedDate;
    }
    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        
        // get input value
        var input_val = input.val();
        
        // don't validate empty input
        if (input_val === "") { return; }
        
        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");
            
        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);
            
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
            right_side += "00";
            }
            
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val =  input_val;
            
            // final formatting
            if (blur === "blur") {
            input_val += ".00";
            }
        }
        
        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }
    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
    function formatRupiah(money) {
            return new Intl.NumberFormat('id-ID',
                { style: 'currency', currency: 'IDR' }
            ).format(money);
        }
 // End Repository Pattern
</script>