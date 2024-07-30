<script>
    getRatingLog()
    get_wo_summary()
    problemType()
    $('#level2TableContainer').prop('hidden', true)
    $(document).on('click', '#filter', function (e) {
        e.stopPropagation();
    });
    $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });
    $('#selectFilter').on('change', function(){
        var selectFilter = $('#selectFilter').val()
        if(selectFilter == 2){
            $('#paramterFilter').empty()
            $('#paramterFilter').append(`
                <input type="month" class="form-control" id="filter" value="{{date('Y-m')}}">
            `);
        }else if(selectFilter == 3){
            $('#paramterFilter').empty()
            $('#paramterFilter').append(`
                <input type="number" style="text-align:center" class="form-control" id="filter" value="{{date('Y')}}">
            `);
        }else{
            $('#paramterFilter').empty()
            $('#paramterFilter').append(
                `
                    <label class="mt-2">All Periode</label>
                `
            )
        }
    })
    $('#selectTicketFilter').on('change', function(){
        var selectTicketFilter = $('#selectTicketFilter').val()
        if(selectTicketFilter == 2){
            $('#paramterTicketFilter').empty()
            $('#paramterTicketFilter').append(`
                <input type="month" class="form-control" id="filter_level" value="{{date('Y-m')}}">
            `);
        }else if(selectTicketFilter == 3){
            $('#paramterTicketFilter').empty()
            $('#paramterTicketFilter').append(`
                <input type="number" style="text-align:center" class="form-control" id="filter_level" value="{{date('Y')}}">
            `);
        }else{
            $('#paramterTicketFilter').empty()
            $('#paramterTicketFilter').append(
                `
                    <label class="mt-2">All Periode</label>
                `
            )
        }
    })
    $('#btnLevel2').on('click', function(){
        var data ={
            'filter' : $('#filter_level').val(),
            'filter_level' : $('#selectTicketFilter').val(),
        }
        getCallback('getLevel2Filter', data, function(response){
            swal.close()
            mappingLevel2(response.data)
        })
    })
    $('#selectPercentageFilter').on('change', function(){
        var selectPercentageFilter = $('#selectPercentageFilter').val()
        if(selectPercentageFilter == 2){
            $('#paramterPercentageFilter').empty()
            $('#paramterPercentageFilter').append(`
                <input type="month" class="form-control" id="filterPercentage" value="{{date('Y-m')}}">
            `);
        }else if(selectPercentageFilter == 3){
            $('#paramterPercentageFilter').empty()
            $('#paramterPercentageFilter').append(`
                <input type="number" style="text-align:center" class="form-control" id="filterPercentage" value="{{date('Y')}}">
            `);
        }else{
            $('#paramterPercentageFilter').empty()
            $('#paramterPercentageFilter').append(
                `
                    <label class="mt-2">All Periode</label>
                `
            )
        }
    })
    $('#selectRatingFilter').on('change', function(){
        var selectRatingFilter = $('#selectRatingFilter').val()
        if(selectRatingFilter == 2){
            $('#paramterRatingFilter').empty()
            $('#paramterRatingFilter').append(`
                <input type="month" class="form-control" id="filterRating" value="{{date('Y-m')}}">
            `);
        }else if(selectRatingFilter == 3){
            $('#paramterRatingFilter').empty()
            $('#paramterRatingFilter').append(`
                <input type="number" style="text-align:center" class="form-control" id="filterRating" value="{{date('Y')}}">
            `);
        }else{
            $('#paramterRatingFilter').empty()
            $('#paramterRatingFilter').append(
                `
                    <label class="mt-2">All Periode</label>
                `
            )
        }
    })
    $('#btnRankingFilter').on('click', function(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getRankingFilter')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
                    'selectFilter':$('#selectFilter').val(),
                    'filter':$('#filter').val(),
                },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                getClassement(response)
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    })
    $('#btnRatingFilter').on('click', function(){
        $('#ratingUser').html('')

        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('logRating')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
                    'selectFilter':$('#selectRatingFilter').val(),
                    'filter':$('#filterRating').val(),
                },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                mapping_ratingLog(response)
                var rating =0;
                    if(response.ratingUser.rating != null){
                        rating = parseFloat(response.ratingUser.rating).toFixed(2)
                    }
                $('#ratingUser').html('Rating : ' + rating +' / 5.0')
               
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    })
    $('#btnPercentageFilter').on('click', function(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('percentageType')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
                    'selectFilter':$('#selectPercentageFilter').val(),
                    'filter':$('#filterPercentage').val(),
                },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
              
                $('canvas#percentageChart').remove()
                $('canvas#percentageChart_container').remove();
                if(response.data.length > 0){
                    $('#percentageLabel').html('')
                    var data = []
                    var label =[]
                    var masterColor =['#F7464A','#46BFBD','#FDB45C','#293462']
                    var color = []
                    for(i=0; i < response.data.length ; i++){
                        data.push(response.data[i].count)
                        label.push(response.data[i].problemName)
                        color.push(masterColor[i])
                    }
                 
                    $('#percentageChart_container').append('<canvas id="percentageChart" style="width:400px !important; height:400px !important" ></canvas>')
                    var canvas = document.getElementById("percentageChart");
                    var chart = canvas.getContext('2d')
                    pieChart('Percentage',label,data,color,'doughnut',chart)
                }else{
                   $('#percentageLabel').html('Data is Null')
                }
               
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    })
    $('#btnNewLog').on('click', function(){
        var data ={
            'from_date':$('#from_date').val(),
            'end_date':$('#end_date').val(),
            'status':0
        }
        datatableHelper(data,'logNewTable')
    })
    $('#btnProgressLog').on('click', function(){
        var data ={
            'from_date':$('#from_date').val(),
            'end_date':$('#end_date').val(),
            'status':1
        }
        datatableHelper(data,'logProgressTable')
    })
    $('#btnPendingLog').on('click', function(){
        var data ={
            'from_date':$('#from_date').val(),
            'end_date':$('#end_date').val(),
            'status':2
        }
        datatableHelper(data,'logPendingTable')
    })
    $('#btnRevisionLog').on('click', function(){
        var data ={
            'from_date':$('#from_date').val(),
            'end_date':$('#end_date').val(),
            'status':3
        }
        datatableHelper(data,'logRevisionTable')
    })
    $('#btnDoneLog').on('click', function(){
        var data ={
            'from_date':$('#from_date').val(),
            'end_date':$('#end_date').val(),
            'status':4
        }
        datatableHelper(data,'logDoneTable')
    })
    $('#btnCheckingLog').on('click', function(){
        var data ={
            'from_date':$('#from_date').val(),
            'end_date':$('#end_date').val(),
            'status':5
        }
        datatableHelper(data,'logCheckingTable')
    })
    $('#from_date').on('change', function(){
        get_wo_summary()
    })
    $('#end_date').on('change', function(){
        get_wo_summary()
    })
    function getRatingLog(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('logRating')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
                    'from_date':$('#from_date').val(),
                    'end_date':$('#end_date').val(),
                },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                mapping_ratingLog(response)
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function mapping_ratingLog(response){
        $('#ratingLog').DataTable().clear();
        $('#ratingLog').DataTable().destroy();
        var data=''
                var avg =0;
                var avgDuration =0;
                for(i = 0; i < response.data.length; i++ )
                {
                    avg += response.data[i]['rating'] == null ? 0 :response.data[i]['rating']
                    avgDuration += response.data[i]['duration'] == null ? 0 :response.data[i]['duration']
                    data += `<tr style="text-align: center;">
                                <td style="width:2%;text-align:center;">${i + 1}</td>
                                <td style="width:19%;text-align:center;">${response.data[i]['date']==null?'':response.data[i]['date']}</td>
                                <td style="width:23%;text-align:center;">${response.data[i]['request_code']==null?'':response.data[i]['request_code']}</td>
                                <td style="width:15%;text-align:center;">${response.data[i]['rating']==null?'':response.data[i]['rating']}</td>
                                <td style="width:19%;text-align:center;">${response.data[i]['duration']==null?'':timeConvert(response.data[i]['duration'])}</td>
                            </tr>
                            `;
                }
                if( response.data.length > 1){
                    data +=`
                            <tr>
                                <td></td>
                                <td style="text-align:right;font-weight:bold"> Average</td>
                                <td></td>
                                <td style="width:25%;text-align:center;;font-weight:bold"> ${parseFloat(avg /response.data.length).toFixed(2) }</td>
                                <td style="width:25%;text-align:center;;font-weight:bold"> ${timeConvert(avgDuration/response.data.length)}</td>
                            </tr>
                    `;
                }
                    $('#ratingLog > tbody:first').html(data);
                    $('#ratingLog').DataTable({
                        "destroy": true,
                        "autoWidth" : false,
                        "searching": false,
                        "aaSorting" : true,
                        "ordering":false,
                        "paging":   false,
                        "scrollX":true,
                        'scrollY':150,
                       "bInfo" : false
                    }).columns.adjust()
    }
    function getClassement(response){
        $('#classementTable').DataTable().clear();
        $('#classementTable').DataTable().destroy();
        var data=''
                var avg =0;
                for(i = 0; i < response.classementPIC.length; i++ )
                {
                  
                    data += `<tr style="text-align: center;">
                                <td style="width5%;text-align:center;">${i + 1}</td>
                                <td style="width:59%;text-align:left;">${response.classementPIC[i]['name']==null?'':response.classementPIC[i]['name']}</td>
                                <td style="width:12%;text-align:center;">${response.classementPIC[i]['count']==null?'':response.classementPIC[i]['count']}</td>
                                <td style="width:12%;text-align:center;">${response.classementPIC[i]['classement']==null?'': parseFloat(response.classementPIC[i].classement).toFixed(2)}</td>
                                <td style="width:12%;text-align:center;">${response.classementPIC[i]['duration']==null?'': timeConvert(response.classementPIC[i].duration)}</td>
                            </tr>
                            `;
                }
            
                    $('#classementTable > tbody:first').html(data);
                    $('#classementTable').DataTable({
                        "destroy": true,
                        "autoWidth" : true,
                        "searching": false,
                        "aaSorting" : true,
                        "ordering":false,
                        "paging":   false,
                        "scrollX":true,
                        'scrollY':150,
                       "bInfo" : false
                    }).columns.adjust()
    }
    function get_wo_summary(){
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('get_wo_summary')}}",
                type: "get",
                dataType: 'json',
                async: true,
                data:{
                    'from_date':$('#from_date').val(),
                    'end_date':$('#end_date').val(),
                },
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                   
                    var rating =0;
                    if(response.ratingUser.rating != null){
                        rating = parseFloat(response.ratingUser.rating).toFixed(2)
                    }
                    $('#status_new').html(response.status_new.status_new)
                    $('#status_on_progress').html(response.status_on_progress.status_on_progress)
                    $('#status_pending').html(response.status_pending.status_pending)
                    $('#status_revision').html(response.status_revision.status_revision)
                    $('#status_done').html(response.status_done.status_done)
                    $('#status_checking').html(response.status_checking.status_checking)
                    $('#jabatanUser').html(response.jabatan)
                    $('#ratingUser').html('Rating : ' + rating +' / 5.0')
                    $('#totalTask').html('Total Task : '+response.ratingUser.total)
                    // master_chart('Supplier',bulan,type,chart,data)
                    response.classementPIC == null ? '': getClassement(response)
                   
                    if(response.ticketLevel2.length > 0){
                        $('#level2TableContainer').prop('hidden', false)
                        mappingLevel2(response.ticketLevel2)
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function problemType(){
        $('#percentageLabel').hide()
            $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('percentageType')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
                    'selectFilter':$('#selectPercentageFilter').val(),
                    'filter':$('#filterPercentage').val(),
                },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
               if(response.data.length > 0 ){
                    var data = []
                    var label =[]
                    var masterColor =['#F7464A','#46BFBD','#FDB45C','#293462']
                    var color = []
                    for(i=0; i < response.data.length ; i++){
                        data.push(response.data[i].count)
                        label.push(response.data[i].problemName)
                        color.push(masterColor[i])
                    }
                    console.log(response.data)
                    $('canvas#percentageChart').remove()
                    $('canvas#percentageChart_container').remove();
                    $('#percentageChart_container').append('<canvas id="percentageChart" style="width:400px !important; height:400px !important" ></canvas>')
                    var canvas = document.getElementById("percentageChart");
                    var chart = canvas.getContext('2d')
                    pieChart('Percentage',label,data,color,'doughnut',chart)
               }
               else{
                $('#percentageLabel').show();
                $('#percentageLabel').html('Data is Null')
               }
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function datatableHelper(data,idTable){
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getWorkOrderByStatus')}}",
                type: "get",
                dataType: 'json',
                async: true,
                data:data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    mappingDatatableHelper(response,idTable)
                 
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function mappingDatatableHelper(response,id){
        $('#'+id).DataTable().clear();
        $('#'+id).DataTable().destroy();
        var data=''
              
                for(i = 0; i < response.data.length; i++ )
                {
                    data += `<tr>
                                <td style="width:5%;text-align:center;">${i + 1}</td>
                                <td style="width:30%;text-align:center;">${response.data[i]['date']==null?'':response.data[i]['date']}</td>
                                <td style="width:35%;text-align:center;">${response.data[i]['request_code']==null?'':response.data[i]['request_code']}</td>
                                <td style="width:30%;text-align:left;">${response.data[i]['categories_name']==null?'':response.data[i]['categories_name']}</td>
                            </tr>
                            `;
                }
                    $('#'+id+' > tbody:first').html(data);
                    $('#'+id).DataTable({
                        "destroy": true,
                        "autoWidth" : false,
                        "searching": false,
                        "aaSorting" : true,
                        "ordering":false,
                        "paging":   false,
                        "scrollX":true,
                        'scrollY':150,
                       "bInfo" : false
                    }).columns.adjust()
    }
    function mappingLevel2(response){
        $('#level2Table').DataTable().clear();
        $('#level2Table').DataTable().destroy();
            var data=''
            for(i = 0; i < response.length; i++ )
            {
                console.log(response[i])
                        picDuration= response[i].duration == 0 ? timeConvert(response[i].duration) : timeConvert(response[i].duration)
                        
                        data += `<tr>
                                    <td>${response[i].request_code}</td>
                                    <td>${response[i].departement_name.name}</td>
                                    <td>${response[i].category_name.name}</td>
                                    <td>${response[i].problem_type_name.name}</td>
                                    <td>${response[i].pic_support_name.name}</td>
                                    <td>${picDuration}</td>
                                </tr>
                                `;
                }
        $('#level2Table'+' > tbody:first').html(data);
        $('#level2Table').DataTable({
            "destroy": true,
            "autoWidth" : false,
            "searching": false,
            "aaSorting" : true,
            "ordering":false,
            "paging":   false,
            "scrollX":true,
            'scrollY':150,
            "bInfo" : false
        }).columns.adjust()
    }
</script>