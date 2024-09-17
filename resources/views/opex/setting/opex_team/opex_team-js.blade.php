<script>
    getCallback('getOpexTeam',null,function(response){
        swal.close()
        mappingTable(response.data)
    })
    onChange('selectLeader','leaderId')
    // Add Taem
        $('#btn_save_head').on('click', function(){
            var data ={
                'teamName'  : $('#teamName').val(),
                'mode'      : 2
            }
            postCallback('addMasterTeam',data,function(response){
                swal.close()
                $('.message_error').html('')
                $('#addHeadModal').modal('hide')
                toastr['success'](response.meta.message);

                getCallback('getOpexTeam',null,function(response){
                    swal.close()
                    mappingTable(response.data)
                })
            })
        })
    // Add Taem
    // Edit Team Detail
        $('#teamTable').on('click', '.addTeamDetail', function() {
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
        $('#teamTable').on('click', '.detailTeam', function() {
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
            postCallback('addDetailTeam',data,function(response){
                swal.close()
                    $('.message_error').html('')
                    $('#addTeamDetail').modal('hide')
                    toastr['success'](response.message);

                    getCallback('getOpexTeam',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
            })
        
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
        
            postCallback('updateDetailTeam',data,function(response){
                swal.close()
                    $('.message_error').html('')
                    $('#addTeamDetail').modal('hide')
                    toastr['success'](response.message);

                    getCallback('getOpexTeam',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
            })
        })
    // Edit Team Detail

    // Edit Team Lead
    $('#teamTable').on('click', '.editTeamHead', function() {
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

    $('#btnUpdateName').on('click', function(){
        var data = {
            'teamNameUpdate':$('#teamNameUpdate').val(),
            'leaderId':$('#leaderId').val(),
            'id':$('#teamHeadId').val()
        }
        console.log(data)
        postCallback('updateMasterTeam',data,function(response){
                swal.close()
                    $('.message_error').html('')
                    $('#editMasterTeam').modal('hide')
                    toastr['success'](response.meta.message);

                    getCallback('getOpexTeam',null,function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
            })
   })
    // Edit Team Lead

    // Function
        function mappingTable(response){
            var data =''
            $('#teamTable').DataTable().clear();
            $('#teamTable').DataTable().destroy();

            var data=''
            for(i = 0; i < response.length; i++ )
            {
                        data += `<tr style="text-align: center;">
                                    <td style="text-align:left;">${response[i].name}</td>
                                    <td style="text-align:left;">
                                        <button title="Detail" class="editTeamHead btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#editMasterTeam">
                                                <i class="fas fa-solid fa-users"></i>
                                            </button>
                                            @can('create_detail-masterTeamProject')
                                            <button title="Add Detail Team" class="addTeamDetail btn btn-sm btn-success rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#addTeamDetail">
                                                <i class="fas fa-solid fa-plus"></i>
                                            </button>
                                            @endcan
                                            @can('update_detail-masterTeamProject')
                                            <button title="List Team" class="detailTeam btn btn-sm btn-danger rounded"data-id="${response[i]['id']}" data-toggle="modal" data-target="#addTeamDetail">
                                                <i class="fas fa-solid fa-list"></i>
                                            </button>
                                            @endcan
                                    </td>
                                </tr>
                            `;
                    }
            $('#teamTable > tbody:first').html(data);
            $('#teamTable').DataTable({
                scrollX  : true,
                language: {
                    'paginate': {
                    'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
                    }
                },
                searching :true,
                pagingType: "simple",
                scrollY:300
                
            }).columns.adjust()   
        }

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
    // Function
</script>