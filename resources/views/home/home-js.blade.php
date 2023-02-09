<script>
    get_wo_summary()
    $('#from_date').on('change', function(){
        get_wo_summary()
    })
    $('#end_date').on('change', function(){
        get_wo_summary()
    })
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
                    $('#status_new').html(response.status_new.status_new)
                    $('#status_on_progress').html(response.status_on_progress.status_on_progress)
                    $('#status_pending').html(response.status_pending.status_pending)
                    $('#status_revision').html(response.status_revision.status_revision)
                    $('#status_done').html(response.status_done.status_done)
                    $('#status_reject').html(response.status_reject.status_reject)
                    master_chart('Supplier',bulan,type,chart,data)
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