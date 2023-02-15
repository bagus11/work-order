<script>
    $(document).on('click', '#filter', function (e) {
        e.stopPropagation();
    });
    getRatingLog()
    get_wo_summary()
    $('#from_date').on('change', function(){
        get_wo_summary()
    })
    $('#end_date').on('change', function(){
        get_wo_summary()
    })
    function getRatingLog(){
        $('#ratingLog').DataTable().clear();
        $('#ratingLog').DataTable().destroy();
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
                var data=''
                var avg =0;
                for(i = 0; i < response.data.length; i++ )
                {
                    avg += response.data[i]['rating'] == null ? 0 :response.data[i]['rating']
                    data += `<tr style="text-align: center;">

                                <td style="width:25%;text-align:center;">${i + 1}</td>
                                <td style="width:25%;text-align:left;">${response.data[i]['date']==null?'':response.data[i]['date']}</td>
                                <td style="width:25%;text-align:left;">${response.data[i]['request_code']==null?'':response.data[i]['request_code']}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['rating']==null?'':response.data[i]['rating']}</td>
                            </tr>
                            `;
                }
            
                    data +=`
                            <tr>
                                <td></td>
                                <td style="text-align:right;font-weight:bold"> Average</td>
                                <td></td>
                                <td style="width:25%;text-align:center;;font-weight:bold"> ${parseFloat(avg /response.data.length).toFixed(2) }</td>
                            </tr>
                    `;
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
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function getClassement(response){
        $('#classementTable').DataTable().clear();
        $('#classementTable').DataTable().destroy();
        var data=''
                var avg =0;
                for(i = 0; i < response.classementPIC.length; i++ )
                {
                  
                    data += `<tr style="text-align: center;">
                                <td style="width:25%;text-align:center;">${i + 1}</td>
                                <td style="width:25%;text-align:left;">${response.classementPIC[i]['name']==null?'':response.classementPIC[i]['name']}</td>
                                <td style="width:25%;text-align:center;">${response.classementPIC[i]['classement']==null?'':response.classementPIC[i]['classement']}</td>
                            </tr>
                            `;
                }
            
                    $('#classementTable > tbody:first').html(data);
                    $('#classementTable').DataTable({
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
                    console.log()
                    var rating =0;
                    if(response.ratingUser.rating != null){
                        rating = parseFloat(response.ratingUser.rating).toFixed(2)
                    }
                    $('#status_new').html(response.status_new.status_new)
                    $('#status_on_progress').html(response.status_on_progress.status_on_progress)
                    $('#status_pending').html(response.status_pending.status_pending)
                    $('#status_revision').html(response.status_revision.status_revision)
                    $('#status_done').html(response.status_done.status_done)
                    $('#status_reject').html(response.status_reject.status_reject)
                    $('#jabatanUser').html(response.jabatan)
                    $('#ratingUser').html('Rating : ' + rating +' / 5.0')
                    $('#totalTask').html('Total Task : '+response.ratingUser.total)
                    // master_chart('Supplier',bulan,type,chart,data)
                    console.log(response)
                    response.classementPIC == null ? '': getClassement(response)
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function master_chart(title,labels,type,id,data_a){
        const data = {
            labels: labels,
            datasets: [{
            label: title,
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: data_a,
            }]
        }
        const config = {
            type:type,
            data: data,
            options: {}
        };
       
        var myChart = new Chart(
            id,
            config
        );
    }
</script>