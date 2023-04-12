<script>
    getData()
   $('#btnSaveName').on('click', function(){
        var data = {
            'teamName':$('#teamName').val()
        }
        store('addMasterTeam',data,'masterTeamProject')
   })
   $('#btnUpdateName').on('click', function(){
        var data = {
            'teamNameUpdate':$('#teamNameUpdate').val(),
            'leaderId':$('#leaderId').val(),
            'id':$('#teamHeadId').val()
        }
        store('updateMasterTeam',data,'masterTeamProject')
   })
   $('#checkAll').on('click', function(){
     // Get all rows with search applied
        var table = $('#detailTeamTable').DataTable();
        var rows = table.rows({ 'search': 'applied' }).nodes();
     // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
  });
  onChange('selectLeader','leaderId')
   $('#masterTeamTable').on('click', '.editTeamHead', function() {
        $('#listTeamProject').DataTable().clear();
        $('#listTeamProject').DataTable().destroy();
       var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getMasterTeamDetail')}}",
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
                    $('#teamNameUpdate').val(response.detail.name)
                    $('#teamHeadId').val(id)
                    $('#selectLeader').empty()
                    $('#leaderId').val(response.leader == null? '': response.leader.id)
                    response.leader == null ? $('#selectLeader').append('<option value ="">Choose PIC</option>') : $('#selectLeader').append('<option value ="'+response.leader.userId+'">'+response.leader.username+'</option>')
                    $.each(response.table,function(i,data){
                    $('#selectLeader').append('<option value="'+data.userId+'">' + data.username +'</option>');
                    });
                    var data =''
                    for(i =0 ; i < response.table.length; i++){
                        data +=`
                            <tr>
                                <td>${response.table[i].username}</td>
                                <td>${response.table[i].departementName}</td>
                                <td>${response.table[i].jabatanName}</td>
                                <td>${response.table[i].position == 1 ?'Staff':'Leader'}</td>
                            </tr>
                        `
                    }
                    $('#listTeamProject > tbody:first').html(data);
                    $('#listTeamProject').DataTable({
                        scrollX  : true,
                        scrollY  :220
                    }).columns.adjust()
                    
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
    });
   $('#masterTeamTable').on('click', '.addTeamDetail', function() {
    $('#titleDetail').html('Form Add Team Project')
    $('#btnEditDetail').prop('hidden', true)
    $('#btnSaveDetail').prop('hidden', false)
       var id = $(this).data('id');
        $('#detailTeamTable').DataTable().clear();
        $('#detailTeamTable').DataTable().destroy();
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getDetailTeam')}}",
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
                    $('#masterIdDetail').val(id)
                    mappingDetail(response.innactive)
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
    });
   $('#masterTeamTable').on('click', '.detailTeam', function() {
    $('#titleDetail').html('List Team Project')
    $('#btnEditDetail').prop('hidden', false)
    $('#btnSaveDetail').prop('hidden', true)
       var id = $(this).data('id');
        $('#detailTeamTable').DataTable().clear();
        $('#detailTeamTable').DataTable().destroy();
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getDetailTeam')}}",
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
                    $('#masterIdDetail').val(id)
                    mappingDetail(response.active)
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
    });
    $('#btnSaveDetail').on('click', function(){
        var checkArray = [];
        var lengthParsed = 0;
        var detailTeamTable = $('#detailTeamTable').DataTable();
        var rowcollection =  detailTeamTable.$("input:checkbox[name=check]:checked",{"page": "all"});
        rowcollection.each(function(){
            checkArray.push($(this).val());
        });
        lengthParsed = checkArray.length;
        if(lengthParsed == 0)
        {
            toastr['error']('Please select 1 or more user');
            return false;
        }

        var data ={
            'checkArray':checkArray,
            'id':$('#masterIdDetail').val(),
        }
    
        saveRepo('addDetailTeam',data,'masterTeamProject')
    })
    $('#btnEditDetail').on('click', function(){
        var checkArray = [];
        var lengthParsed = 0;
        var detailTeamTable = $('#detailTeamTable').DataTable();
        var rowcollection =  detailTeamTable.$("input:checkbox[name=check]:checked",{"page": "all"});
        rowcollection.each(function(){
            checkArray.push($(this).val());
        });
        lengthParsed = checkArray.length;
        if(lengthParsed == 0)
        {
            toastr['error']('Please select 1 or more user');
            return false;
        }

        var data ={
            'checkArray':checkArray,
            'id':$('#masterIdDetail').val(),
        }
    
        saveRepo('updateDetailTeam',data,'masterTeamProject')
    })



// Function\
    function mappingDetail(x){
        var data =''
        for(i = 0; i < x.length ; i++){
            data +=`
                    <tr>
                        <td style="text-align: center;"> <input type="checkbox" id="checkAll" name="check" class="is_checked" style="border-radius: 5px !important;" value="${x[i]['id']}"  data-name="${x[i]['name']}"></td>
                        <td>${x[i].name}</td>
                        <td>${x[i].departementName}</td>
                        <td>${x[i].jabatanName}</td>
                    </tr>
            `;

        }
        $('#detailTeamTable > tbody:first').html(data);
        $('#detailTeamTable').DataTable({
            scrollX  : true,
            scrollY  :220
        }).columns.adjust()
    }
    function getData(){
        $('#masterTeamTable').DataTable().clear();
        $('#masterTeamTable').DataTable().destroy();
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('getMasterTeam')}}",
                    type: "get",
                    dataType: 'json',
                    async: true,
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                        var data = ''
                        for(i = 0; i < response.data.length; i++){
                            data += `
                                    <tr>
                                        <td>${response.data[i].name == null ? '': response.data[i].name}</td>
                                        <td  style="text-align:center">
                                            <button title="Detail" class="editTeamHead btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editMasterTeam">
                                                <i class="fas fa-solid fa-users"></i>
                                            </button>
                                            @can('create_detail-masterTeamProject')
                                            <button title="Add Detail Team" class="addTeamDetail btn btn-success rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#addTeamDetail">
                                                <i class="fas fa-solid fa-plus"></i>
                                            </button>
                                            @endcan
                                            @can('update_detail-masterTeamProject')
                                            <button title="List Team" class="detailTeam btn btn-danger rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#addTeamDetail">
                                                <i class="fas fa-solid fa-list"></i>
                                            </button>
                                            @endcan
                                        </td>
                                    </tr>
                            `;
                        }
                    $('#masterTeamTable > tbody:first').html(data);
                    $('#masterTeamTable').DataTable({
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
// EndFunction
    
</script>