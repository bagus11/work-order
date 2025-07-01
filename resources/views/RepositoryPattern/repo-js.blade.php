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
                    var data_approval =''
                    $('#notificationCount').html(response.countStatus.new)
                    if(response.countNotification.count == 0){
                        $('#notifTabCount').hide()  
                    }else{
                        $('#notifTabCount').show()
                        $('#notifTabCount').html(response.countNotification.count)
                    }
                    if(response.countApproval.count == 0){
                        $('#approvalTabCount').hide()
                    }else{
                        $('#approvalTabCount').show()
                        $('#approvalTabCount').html(response.countApproval.count)
                    }
                   
                    for(i = 0; i < response.data.length; i++ )
                    {
                        var status = '';
                        if(response.data[i].status == 0){
                            status ="#E8E2E2";
                        }else{
                            status ="white";
                        }
                        if(response.data[i].type == 1){
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
                        }else if(response.data[i].type == 2){
                            if(response.data[i].status == 0){
                                data_approval += `<div data-request="${response.data[i].request_code}" class="dropdown-item approvalList" data-link="${response.data[i].link}"  style="background:${status}">
                                    <div class="media">
                                        
                                        <div class="media-body">
                                            <strong style="font-size:12px;color:#85CDFD" class="dropdown-item-title">
                                            ${response.data[i].subject} </strong>
                                        
                                            <p  style="font-size:11px">${response.data[i].message}</p>
                                            <p class="text-muted" style="font-size:9px"><i class="far fa-clock mr-1"></i>${response.data[i].date}, ${response.data[i].time}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                `
                            }
                        }
                    }
                    $('#notificationBody').html(data)
                    $('#approvalBody').html(data_approval)
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
        function postAttachment(route, data, withFile, callback) {
            $.ajax({
                url: route,
                type: 'POST',
                dataType: 'json',
                async: true,
                processData: false,  // Important: Set to false for file uploads
                contentType: false,  // Important: Set to false for file uploads
                data: data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: callback,
                error: function(response) {
                    $('.message_error').html('');
                    swal.close();
                    if (response.status == 500) {
                        console.log(response);
                        toastr['error'](response.responseJSON.meta.message);
                        return false;
                    }
                    if (response.status === 422) {
                        $.each(response.responseJSON.errors, (key, val) => {
                            $('span.' + key + '_error').text(val);
                        });
                    } else {
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                }
            });
        }
    function postCallback(route,data,callback){
        $('.message_error').html('')
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
        getNotification()
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
            getNotification()
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
                // beforeSend: function() {
                //     SwalLoading('Please wait ...');
                // },
                success: function(response) {
                // swal.close();
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
 let approvalData = [];
 $('#asset_notification').on("click", function(){
    
      approvalData =[];
      getCallbackNoSwal('getApprovalAssetNotification', null, function(response){
            const data = response.data;
            const modalBody = $('#approvalAssetModal .modal-body');
            modalBody.empty();
               if(data.length === 0){
                toastr['info']('No new approval asset notifications.');
               }
                if (data.length === 1) {
                    // 1 tiket, tampilkan langsung detailnya
                    $('#approvalAssetModal').modal('show');
                    const ticket = data[0];
                    modalBody.append(generateTicketDetailHtml(ticket));
                   
                } else if (data.length > 1) {
                    
                    $('#approvalAssetModal').modal('show');
                    // Banyak tiket, tampilkan daftar
                    let listHtml = `<ul class="list-group mx-2 my-2">`;
                    data.forEach((ticket, index) => {
                        listHtml += `
                       <li class="list-group-item border rounded shadow-sm mb-2 px-3 py-2">
                            <div class="d-flex align-items-center">
                                <!-- Avatar -->
                                <div class="me-3">
                                    <img src="${ticket.user_relation.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(ticket.user_relation.name)}"
                                        alt="avatar"
                                        class="rounded-circle"
                                        width="40"
                                        height="40"
                                        style="object-fit: cover;">
                                </div>

                                <!-- Info -->
                                <div class="flex-grow-1 ml-2" style="font-size: 11px;">
                                    <strong style="font-size: 11px;">${ticket.request_code}</strong><br>
                                    <span style="font-size: 10px;">From: ${ticket.location_relation.name}</span><br>
                                    <span style="font-size: 10px;">To: ${ticket.des_location_relation.name}</span><br>
                                    <span style="font-size: 10px;">PIC: ${ticket.user_relation.name}</span>
                                </div>

                                <!-- View Button -->
                                <div class="ms-2">
                                    <button type="button" class="btn btn-sm btn-info view-ticket" data-index="${index}"
                                        style="font-size: 10px; padding: 3px 8px;">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </div>
                            </div>
                        </li>


                        `;
                    });
                    listHtml += `</ul><div id="ticketDetailContainer" class="mt-3"></div>`;
                    modalBody.append(listHtml);
                }
    
              
                $(document).on('click', '.view-ticket', function(e) {
                    e.preventDefault();
                    const index = $(this).data('index');
                    const ticket = response.data[index]; // pastikan ini sesuai scope lo
        
                    $('#ticketDetailContainer').html(generateTicketDetailHtml(ticket));
                });
        })
      
    })

// Approval Asset Notification  
        function generateTicketDetailHtml(ticket) {
            let assetDetailsHtml = '';
            // Loop through the asset details and create a table
            if (ticket.detail_relation && ticket.detail_relation.length > 0) {
                assetDetailsHtml = `
                    <fieldset class="border p-3 rounded shadow-sm mt-3">
                        <legend class="w-auto px-2" style="font-size: 11px; font-weight: bold;">Asset Details</legend>
                        <table class="table table-sm table-bordered table-striped" style="font-size: 11px;">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px;">#</th>
                                    <th style="font-size: 11px;">Asset Code</th>
                                    <th style="font-size: 11px;">Category</th>
                                    <th style="font-size: 11px;">Brand</th>
                                    <th style="font-size: 11px;">Type</th>
                                    <th style="font-size: 11px;">Condition</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                
                ticket.detail_relation.forEach((asset, index) => {
                    var condition = ''
                    switch(asset.condition) {
                        case 1: condition = 'Good'; break;
                        case 2: condition = 'Bad'; break;
                        case 3: condition = 'Lost'; break;
                        default: condition = 'Unknown';
                    }
                    assetDetailsHtml += `
                        <tr class="asset-row" data-asset='${JSON.stringify(asset)}' style="cursor:pointer;">
                            <td style="font-size: 10px;">${index + 1}</td>
                            <td style="font-size: 10px;">${asset.asset_code}</td>
                            <td style="font-size: 10px;">${asset.asset_relation?.category_relation?.name || '-'}</td>
                            <td style="font-size: 10px;">${asset.asset_relation?.brand_relation?.name || '-'}</td>
                            <td style="font-size: 10px;">${asset.type == 1 ? 'Parent' : 'Child'}</td>
                            <td style="font-size: 10px;">${condition}</td>
                        </tr>`;
                });

                assetDetailsHtml += `
                            </tbody>
                        </table>
                    </fieldset>
                `;
            }

            return `
            <fieldset class="border p-3 rounded shadow-sm">
                <legend class="w-auto px-2" style="font-size: 11px; font-weight: bold;">Detail Ticket</legend>
                <fieldset class="border p-3 rounded shadow-sm">
                    <legend class="w-auto px-2" style="font-size: 11px; font-weight: bold;">General Information</legend>
                    <div class="row px-2 py-2" style="font-size: 11px;">
                        <div class="col-md-2 mb-1">
                            <label style="font-size: 11px;">Request Code</label><br>
                        </div>
                        <div class="col-md-4 mb-1">
                            <span style="font-size: 10px;"> : ${ticket.request_code}</span>
                        </div>
                        <div class="col-md-2 mb-1">
                            <label style="font-size: 11px;">Type</label><br>
                        </div>
                        <div class="col-md-4 mb-1">
                            <span style="font-size: 10px;"> : 
                                ${ticket.request_type == 1 ? 'Distribution' : ticket.request_type == 2 ? 'Hand Over' : 'Return'}
                            </span>
                        </div>
                        <div class="col-md-2 mb-1">
                            <label style="font-size: 11px;">From</label><br>
                        </div>
                        <div class="col-md-4 mb-1">
                            <span style="font-size: 10px;"> : ${ticket.location_relation.name}</span>
                        </div>
                        <div class="col-md-2 mb-1">
                            <label style="font-size: 11px;">To</label><br>
                        </div>
                        <div class="col-md-4 mb-1">
                            <span style="font-size: 10px;"> : ${ticket.des_location_relation.name}</span>
                        </div>
                        <div class="col-md-2 mb-1">
                            <label style="font-size: 11px;">User</label><br>
                        </div>
                        <div class="col-md-4 mb-1">
                            <span style="font-size: 10px;"> : ${ticket.user_relation?.name ||'-'}</span>
                        </div>
                        <div class="col-md-2 mb-1">
                            <label style="font-size: 11px;">Receiver</label><br>
                        </div>
                        <div class="col-md-4 mb-1">
                            <span style="font-size: 10px;"> : ${ticket.receiver_relation?.name || '-'}</span>
                        </div>

                        ${ticket.attachment ? `
                        <div class="col-md-2 mt-2">
                            <label style="font-size: 11px;">Attachment</label><br>
                        </div>
                        <div class="col-md-10 mt-2">
                            <a href="/storage/Asset/Distribution/attachment/${ticket.attachment}" target="_blank"
                            style="font-size: 10px; color: #007bff;">
                               :  ${ticket.attachment}
                            </a>
                        </div>` : ''}
                    
                    </div>
                </fieldset>
                    <div class="row">
                        <div class="col-12">
                            ${assetDetailsHtml}
                        </div>
                        <div class="col-12">
                            <div id="asset-detail-container" class="mt-3 mb-2"></div>
                        </div>
                        <div class="col-2">
                            <span style="font-size:11px">Notes</span>
                        </div>
                        <div class="col-10">
                          <textarea class="form-control" id="approval_notes" rows="3"></textarea>
                            <span  style="color:red;" class="message_error text-red block approval_notes_error"></span>
                        </div>
                        <div class="col-md-12 mt-3 text-end">
                            <button class="btn btn-sm btn-success" id="btn_approve_ticket" type="button"
                                data-request-code="${ticket.request_code}" style="font-size: 10px;float:right">
                                <i class="fas fa-check"></i> Approve
                            </button>
                            <button class="btn btn-sm btn-danger mr-2" id="btn_reject_ticket" type="button"
                                data-request-code="${ticket.request_code}" style="font-size: 10px;float:right">
                                <i class="fas fa-xmark"></i> Reject
                            </button>
                        </div>
                    </div>
            </fieldset>
        
            `;
        }
        $(document).on('click', '.asset-row', function () {
            const asset = $(this).data('asset');
            
            const conditionLabel = asset.condition == 1 ? 
                '<span class="badge bg-success">Good</span>' : 
                asset.condition == 2 ? 
                '<span class="badge bg-warning text-dark">Bad</span>' : 
                '<span class="badge bg-danger">Lost</span>';
            const html = `
            <fieldset class="border p-3 rounded shadow-sm">
                <legend class="w-auto px-2" style="font-size: 11px; font-weight: bold;">Detail Asset</legend>
                <div class="row" style="font-size: 11px;">
                    <div class="col-md-2 mb-1">
                        <strong>Asset Code</strong> 
                    </div>
                    <div class="col-md-4">
                        <span>: ${asset.asset_code} </span>
                    </div>
                    <div class="col-md-2 mb-1">
                        <strong>Category</strong> 
                    </div>
                    <div class="col-md-4">
                        <span>: ${asset.asset_relation?.category_relation?.name || '-'} </span>
                    </div>
                    <div class="col-md-2 mb-1">
                        <strong>Brand</strong> 
                    </div>
                    <div class="col-md-4">
                        <span> : ${asset.asset_relation?.brand_relation?.name || '-'}</span>
                    </div>
                    <div class="col-md-2 mb-1">
                        <strong>Type</strong>
                    </div>
                        
                    <div class="col-md-4">
                         : ${asset.type == 1 ? 'Parent' : 'Child'}
                    </div>
                    <div class="col-md-2 mb-1">
                        <strong>Parent Code</strong>
                    </div>
                    <div class="col-md-4 mb-1">
                        <span>  : ${asset.asset_relation?.parent_code || '-'}</span>
                    </div>
                    <div class="col-md-2 mb-1">
                        <strong>Condition</strong>
                    </div>
                    <div class="col-md-4 mb-1">
                        <span>  : ${conditionLabel}</span>
                    </div>
                    <div class="col-md-2 mb-1">
                        <strong>Location</strong>
                    </div>
                    <div class="col-md-4 mb-1">
                        <span>  :   ${asset.asset_relation?.location_relation?.name || '-'}</span>
                    </div>
                   <div class="col-md-2 mb-1">
                        <strong>Join Date</strong>
                    </div>
                    <div class="col-md-4 mb-1">
                        <span>  :   ${asset.join_date || '-'}</span>
                    </div>
                     <div class="col-md-2 mb-1">
                        <strong>Image</strong>
                    </div>
                    <div class="col-md-4 mb-1">
                        <span>: ${asset.asset_relation?.image ? `<img src="/storage/Asset/${asset.asset_relation.image}" alt="Asset Image" width="50">` : '-'}</span>
                    </div>
                     <div class="col-md-2 mb-1">
                        <strong>QR Code</strong>
                    </div>
                    <div class="col-md-4 mb-1">
                        <span>: ${asset.asset_relation?.qr_code ? `<img src="/storage/Asset/${asset.asset_relation.qr_code}" alt="Asset Image" width="50">` : '-'}</span>
                    </div>
                  
                </div>
            </fieldset>
            `;

            $('#asset-detail-container').html(html);
        });

        $(document).on('click', '#btn_approve_ticket, #btn_reject_ticket', function () {
            const isApprove = $(this).attr('id') === 'btn_approve_ticket';
            const request_code = $(this).data('request-code');
            const approval_notes = $('#approval_notes').val().trim();

            if (approval_notes === '') {
                $('.approval_notes_error').text('Notes is required');
                return;
            } else {
                $('.approval_notes_error').text('');
            }

            const data = {
                request_code,
                approval_notes,
                status: isApprove ? 1 : 2
            };

            $(this).prop('disabled', true);
            postCallback('approvalAssetProgress', data, function (response) {
                swal.close();
                toastr['success'](response.meta.message);
                $('#approvalAssetModal').modal('hide');
                $('#btn_approve_ticket, #btn_reject_ticket').prop('disabled', false);
            });
        });
    // Approval Asset Notification

    $(document).on('click', '.approvalList', function() {
        var link = $(this).data('link');
        var request = $(this).data('request');
        $(link).modal('show');
        if(link == "#stockOpnameApproval"){
            getCallback('getApprovalStockOpname', {'ticket_code': request}, function(response){
                swal.close();
                $('#approval_so_ticket_code_label').html(': ' + response.detail.ticket_code);
                $('#approval_so_created_by_label').html(': ' + response.detail.user_relation.name);
                $('#approval_so_location_label').html(': ' + response.detail.location_relation.name)
                $('#approval_so_department_label').html(': ' + response.detail.department_relation.name)
                $('#approval_so_subject_label').html(': ' + response.detail.subject)
                $('#approval_so_description_label').html(': ' + response.detail.description)
                $('#approval_so_ticket_code').val(response.detail.ticket_code)
                console.log(response.detail)
                onChange('approval_so_select_status','approval_so_status')
                $('#btn_update_so').on('click', function(){
                    var data = {
                        'approval_so_status' : $('#approval_so_status').val(),
                        'approval_so_start_date' : $('#approval_so_start_date').val(),
                        'approval_so_description' : $('#approval_so_description').val(),
                        'approval_so_ticket_code' : $('#approval_so_ticket_code').val(),
                    }
                    postCallback('approveSO', data, function(response){
                        swal.close()
                        toastr['success'](response.meta.message)
                        $('#stockOpnameApproval').modal('hide')
                        getNotification()
                    })
                })
            });
        }else if(link =='work_order_list' || link =="work_order_assignment"){
            getCallbackNoSwal("detailWO", {'request_code' : request}, function(response){
                var id = response.detail.id
                getCallback('detail_wo', {'id': id}, function(response){
                    swal.close();
                    $('#editAssignment').modal('show');
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
                });
            });

               $('#select_user').on('change', function(){
                    var select_user = $('#select_user').val()
                    $('#user_pic').val(select_user)
                })
                $('#selectPriority').on('change', function(){
                    var selectPriority = $('#selectPriority').val()
                    $('#priority').val(selectPriority)
                })

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
        }
    });
</script>