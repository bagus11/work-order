<script>
    getData();
      function getData(){
        $('#kpiReportTable').DataTable().clear();
        $('#kpiReportTable').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getKPIUser')}}",
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
                    data += `<tr>
                             
                                <td style="text-align: left;">${response.data[i].name==null?'':response.data[i].name}</td>
                                <td style="text-align: center;">${response.data[i].departement.name}</td>
                                <td style="text-align: center;">${response.data[i].jabatan.name}</td>
                                <td style="width:25%;text-align:center">
                                    <button title="Detail" class="editKPIUser btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editKPIUser">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            `;
                }
                    $('#kpiReportTable > tbody:first').html(data);
                    $('#kpiReportTable').DataTable({
                        scrollX  : true,
                        scrollY  :220
                    }).columns.adjust()
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function getKPIUserDetail(data){
        $('#userNameLabel').html(' :')
        $('#departementUserLabel').html(' : ')
        $('#positionUserLabel').html(' :')
        $('#totalWOLabel').html(': ')
        $('#completeWOLabel').html(': ')
        $('#durationLv1').html(': ')
        $('#durationLv2').html(': ')
        $('#totalDurationLv1').html(': ')
        $('#totalDurationLv2').html(': ')
        $('#percentageLabel').html(': ')
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getKPIUserDetail')}}",
            type: "get",
            data:data,
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                
                // Chart Counting By Location
                    var labelName =[]
                    var totalCount =[]
                    for(i=0; i < response.data.length; i++){
                        labelName.push(response.data[i].officeName)
                        totalCount.push(response.data[i].totalWO)
                    }
                    $('canvas#countingByCategory').remove()
                    $('canvas#countingByCategoryContainer').remove();
                    $('#countingByCategoryContainer').append('<canvas id="countingByCategory" width="20" height="20" ></canvas>')
                    var canvas = document.getElementById("countingByCategory");
                    var chart = canvas.getContext('2d')
                    var color =['#344D67','#6ECCAF','#ADE792','#F3ECB0']
                    master_chart('Total Ticket',labelName,'bar',chart,totalCount,color)
                // End Chart Counting By Location

                // Pie Chart Percentage Category
                    $('canvas#percentageCategory').remove()
                    $('canvas#percentageCategoryContainer').remove();
                    $('#percentageCategoryContainer').append('<canvas id="percentageCategory" width="20" height="20" ></canvas>')
                    var percentageCategory      = document.getElementById("percentageCategory");
                    var percentageCategorychart = percentageCategory.getContext('2d')
                    var masterColor             = ['#F7464A','#46BFBD','#FDB45C','#293462']
                    var percentageColor         = []
                    var labelPercentageName     = []
                    var totalPercentageCount    = []
                    for(j= 0 ; j< response.percentage.length; j ++){
                        totalPercentageCount.push(response.percentage[j].count)
                        labelPercentageName.push(response.percentage[j].problemName)
                        percentageColor.push(masterColor[j])
                    }
                    pieChart('Percentage',labelPercentageName,totalPercentageCount,percentageColor,'pie',percentageCategorychart)
                // End Pie Chart Percentage Category

                // Set Label
              
                    var level2Label             =   response.level2 == null ? 0 :response.level2.count;
                    var percentageLabel         =   response.result == null ? '-' : parseFloat(response.result.done / response.result.wo_total * 100).toFixed(2)
                    var durationLv1Label        =   response.result ==null ? '-' : timeConvert(response.result.duration_lv2 /level2Label)
                    var durationLv2Label        =   response.result == null ? '-' :  timeConvert(response.result.duration / response.result.wo_total - level2Label)
                    $('#userNameLabel').html(' :'+response.user.name)
                    $('#departementUserLabel').html(' : '+response.user.departement.name)
                    $('#positionUserLabel').html(' :'+response.user.jabatan.name)
                    $('#totalWOLabel').html(response.result ==null ? ' : 0':' : '+response.result.wo_total)
                    $('#completeWOLabel').html(response.result == null ? ' : 0' : ': '+response.result.done)
                    $('#totalDurationLv1').html(response.result == null ? ' : 0' : ': '+ timeConvert(response.result.duration))
                    $('#totalDurationLv2').html(response.result == null ? ' : 0' : ': '+ timeConvert(response.result.duration_lv2))
                    $('#percentageLabel').html(response.result == null ? ' : 0 %' : ': ' + percentageLabel + ' %')
                    $('#durationLv2').html(response.level2 == null ? ' : 0' : ': '+durationLv1Label )
                    $('#durationLv1').html(response.level2 == null ? ' : 0' : ': '+durationLv2Label )
                // End Set Label
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    $('#kpiReportTable').on('click','.editKPIUser', function(){
        var id = $(this).data('id');
        $('#user_id').val(id)
        var data ={
            'dateFilter':$('#dateFilter').val(),
            'id':id
        }
        getKPIUserDetail(data)
        
    })
    $('#dateFilter').on('change', function(){
        var data ={
            'dateFilter':$('#dateFilter').val(),
            'id':$('#user_id').val()
        }
        getKPIUserDetail(data)
    })
    $('#btnPrintKPI').on('click', function(){
        var dateFilter = $('#dateFilter').val();
        var id = $('#user_id').val();

        window.open(`printKPIUser/${dateFilter}/${id}`,'_blank');
      
    })
</script>