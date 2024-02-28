<script>
    getCallback('getOPex',null, function(response){
        swal.close()
        mappingTable(response.data)
    })
    // Operation
        $('#btn_add_head').on('click', function(){
            getActiveItems('get_kantor',null,'select_location','Location')
        })
        onChange('select_location','location_id')
        $('#btn_save_head').on('click', function(e){
                e.preventDefault()
                var data = new FormData();
                data.append('title',$('#title').val())
                data.append('description',$('#description').val())
                data.append('start_date',$('#start_date').val())
                data.append('end_date',$('#end_date').val())
                data.append('location_id',$('#location_id').val())
                data.append('attachment',$('#attachment')[0].files[0]);
                postAttachment('addHeadOpex',data,false,function(response){
                    swal.close()
                    toastr['success'](response.meta.message);
                    $('#addHeadModal').modal('hide')
                    $('.message_error').html('')
                    clearModalAdd()
                    toastr['success'](response.responseJSON.meta.message);
                    getCallback('getOPex',null, function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })

            $('#timeline_table').on('click','.edit', function(){
                var request = $(this).data('request')
                getActiveItems('get_kantor',null,'select_location_edit')
                var data ={
                    'request_code' : request
                }
                getCallback('detailHeadOpex',data, function(response){
                    swal.close()
                    $('#request_code').val(request)
                    var output =response.detail.attachment !='' ? response.detail.attachment.split('/').pop() : '-'
                    $('#attachment_container').empty()
                    $('#title_edit').val(response.detail.title)
                    $('#description_edit').val(response.detail.description)
                    $('#start_date_edit').val(response.detail.start_date)
                    $('#end_date_edit').val(response.detail.end_date)
                    $('#select_location_edit').val(response.detail.location_id)
                    $('#select_location_edit').trigger("change")
                    $('#created_by').html(': ' +  response.detail.user_relation.name)
                    $('#attachment_container').append(`
                        <p>:
                            <a target="_blank" href="{{URL::asset('${response.detail.attachment}')}}" class="ml-3" style="color:blue;">
                                <i class="far fa-file" style="color: red;font-size: 20px;"></i>
                                ${output}</a>
                        </p>`
                    )
                })
            })
            $('#btn_update_head').on('click', function(){
                var data ={
                    'title_edit'        : $('#title_edit').val(),
                    'request_code'      : $('#request_code').val(),
                    'description_edit'  : $('#description_edit').val(),
                    'end_date_edit'     : $('#end_date_edit').val(),
                }
                postCallback('updateHeadOpex',data, function(response){
                    swal.close()
                    $('.message_error').html('')
                    toastr['success'](response.responseJSON.meta.message);
                    $('#editHeadModal').modal('hide')
                    getCallback('getOPex',null, function(response){
                        swal.close()
                        mappingTable(response.data)
                    })
                })
            })
    // Operation

    // Function 
        function mappingTable(response){
           
            var data=''
            $('#timeline_table').DataTable().clear();
            $('#timeline_table').DataTable().destroy();      
                for(i = 0; i < response.length; i++ )
                {
                            var status =0;
                            switch(response[i].status) {
                            case 1:
                                status = 'NEW'
                                break;
                            case 2:
                                status = 'In Progress'
                                break;
                            case 3:
                                status = 'Revision'
                                break;
                            case 4:
                                status = 'DONE'
                                break;
                                
                            default:
                                status = 'REJECT'
                            }

                    data += `<tr style="text-align: center;">
                                <td style="width:5%" class='details-control'></td>
                                <td style="width:11%;text-align:left;">${response[i].request_code}</td>
                                <td style="width:11%;text-align:center;">${response[i].location_relation.initial}</td>
                                <td style="width:11%;text-align:left;">  ${response[i].title}</td>
                                <td>
                                    <div class="progress-group">
                                        <div class="progress-group">
                                            <span class="float-right" style="font-size:10px">${response[i].percentage}%</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-success" style="width: ${response[i].percentage}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="width:11%;text-align:left;">${status}</td>
                                <td style="width:5%;text-align:left;">
                                    <button type="button" class="edit btn btn-sm btn-primary" data-request="${response[i].request_code}" data-toggle="modal" data-target="#editHeadModal" style="float:right">
                                        <i class="fas fa-eye"></i>
                                    </button>    
                                </td>
                            </tr>
                            `;
                }
                    $('#timeline_table > tbody:first').html(data);
                        var table = $('#timeline_table').DataTable({
                            scrollX  : true,
                            scrollY: true,
                            scrollCollapse : true,
                            autoWidth:true
                        }).columns.adjust()    
                        $('#timeline_table tbody').off().on('click', 'td.details-control', function (e) {
                        var tr = $(this).closest("tr");
                        var row =   table.row( tr );
                        if ( row.child.isShown() ) {
                            // This row is already open - close it
                            row.child.hide();
                            tr.removeClass( 'shown' );
                        }
                        else {
                            // Open this row
                            detail_log(row.child,$(this).parents("tr").find('td.request_code').text()) ;
                            tr.addClass( 'shown' );
                        }
                    } );  
                   
        }
        function clearModalAdd(){
            $('#title').val('')
            $('#description').val('')
            $('#attachment').val('')
            $('#location_id').val('')
        }
    // Function
</script>