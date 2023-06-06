<script>
    // Call Function
        getData()
    // Call Function

    // Operation
            $('#btnAddTransfer').on('click', function(){
                $('#detailTicketContainer').prop('hidden', true)
                $.ajax({
                    url: 'getWOActive',
                    type: "get",
                    dataType: 'json',
                    async: true,
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                        $('#selectRequestCode').empty();
                        $('#selectRequestCode').append(`<option value ="" >Choose Request Code</option>`);
                        $.each(response.data,function(i,data,param){
                            $('#selectRequestCode').append('<option value="'+data.request_code+'">' + data.request_code +'</option>');
                        });
                        $('#selectPIC').empty();
                        $('#selectPIC').append(`<option value ="" >Choose PIC</option>`);
                        $.each(response.pic,function(i,data,param){
                            $('#selectPIC').append('<option value="'+data.id+'">' + data.name +'</option>');
                        });
                    
                    },
                    error: function(response) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                });   
            })
            onChange('selectRequestCode','requestCode')
            onChange('selectPIC','picId')

            // Get Detail Ticket
                $('#selectRequestCode').on('change', function(){
                    $('#detailTicketContainer').prop('hidden', false)
                    $.ajax({
                    url: 'getWODetail',
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data:{
                        'requestCode':$('#requestCode').val()
                    },
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                        $('#detailRequestBy').val(response.detail.pic_name.name)
                        $('#selectPIC').val(response.detail.user_id_support)
                        $('#selectPIC').select2().trigger('change');
                        $('#detailDepartement').val(response.detail.departement_name.name)
                        $('#detailCategory').val(response.detail.category_name.name)
                        $('#detailProblemType').val(response.detail.problem_type_name.name)
                        $('#detailSubject').val(response.detail.subject)
                    
                    },
                    error: function(response) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                });   
                })
            // Get Detail Ticket
        // Save Add PIC Transafer 
            $('#btnSaveType').on('click', function(){
                var data={
                    'name':$('#name').val(),
                    'description':$('#description').val(),
                    'initial':$('#initial').val(),
                    'status':1
                }
                saveHelper('saveMasterType',data,'masterType')
            })        
        // End Save Add PIC Transafer 

        // Hold Assignment
            // Get Detail Assignment
                $('#holdRequestTable').on('click', '.editHoldProgress', function(){
                    var id = $(this).data('id');
                    var request_code = $(this).data('request_code');
                
                    $.ajax({
                        url: 'getWODetail',
                        type: "get",
                        dataType: 'json',
                        data:{
                            'requestCode':request_code
                        },
                        async: true,
                        beforeSend: function() {
                            SwalLoading('Please wait ...');
                        },
                        success: function(response) {
                            swal.close();
                            $('#hold_request_code').val(response.detail.request_code)
                            $('#holdRequestCode').html(': '+response.detail.request_code)
                            $('#holdRequestBy').html(': '+response.detail.user_p_i_c.name)
                            $('#holdDepartement').html(': '+response.detail.departement_name.name)
                            $('#holdCategory').html(': '+response.detail.category_name.name)
                            $('#holdProblemType').html(': '+response.detail.problem_type_name.name)
                            $('#holdPICName').html(': '+response.detail.user_p_i_c_support.name)
                            $('#holdPICReason').html(': '+response.detail.comment)
                        },
                        error: function(response) {
                            swal.close();
                            toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    });      
                })
                $('#holdRequestTable').on('click', '.editResumeProgress', function(){
                    var id = $(this).data('id');
                    var request_code = $(this).data('request_code');
                
                    $.ajax({
                        url: 'getWODetail',
                        type: "get",
                        dataType: 'json',
                        data:{
                            'requestCode':request_code
                        },
                        async: true,
                        beforeSend: function() {
                            SwalLoading('Please wait ...');
                        },
                        success: function(response) {
                            swal.close();
                            console.log(response.detail)
                            $('#resume_request_code').val(response.detail.request_code)
                            $('#resumeRequestCode').html(': '+response.detail.request_code)
                            $('#resumeRequestBy').html(': '+response.detail.user_p_i_c.name)
                            $('#resumeDepartement').html(': '+response.detail.departement_name.name)
                            $('#resumeCategory').html(': '+response.detail.category_name.name)
                            $('#resumeProblemType').html(': '+response.detail.problem_type_name.name)
                            $('#resumePICName').html(': '+response.detail.user_p_i_c_support.name)
                          
                        },
                        error: function(response) {
                            swal.close();
                            toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    });      
                })
            // End  Get Detail Assignment

            // Accept Assignment
                $('#btnAccept').on('click', function(){
                    var data ={
                        'request_code':$('#hold_request_code').val(),
                        'holdComment':$('#holdComment').val(),
                        'hold_progress': '2'
                    }
                    store('updateHoldRequest', data, 'hold_request')
                })
            // End Accept Assignment
                
            // Reject Assignment
                $('#btnReject').on('click', function(){
                    var data ={
                        'request_code':$('#hold_request_code').val(),
                        'holdComment':$('#holdComment').val(),
                        'hold_progress': '3'
                    }
                    store('updateHoldRequest', data, 'hold_request')
                })

            // End Reject Assignment

            // Resume Request 
                $('#btnResume').on('click', function(){
                var request_code = $('#resume_request_code').val()
                    $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "updateResumeRequest",
                        type: "post",
                        dataType: 'json',
                        async: true,
                        data: {
                            'request_code':request_code
                        },
                        beforeSend: function() {
                            SwalLoading('Please wait ...');
                        },
                        success: function(response) {
                            swal.close();
                            toastr['success'](response.message);
                            $('#editResumeProgress').modal('hide');
                            getData()
                        },
                        error: function(xhr, status, error) {
                            swal.close();
                            toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    });
                })
            // end Resume Request 

        // End Hold Assignment

    

    // End Operation

    // Function
        function getData(){
            $.ajax({
                url: 'getHoldRequest',
                type: "get",
                dataType: 'json',
                async: true,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    mapping(response.data)
                },
                error: function(response) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });   
        }

        function mapping(response){
            var data ="";
            $('#holdRequestTable').DataTable().clear();
            $('#holdRequestTable').DataTable().destroy();
            for(i = 0; i < response.length; i ++)
            {
                var btnHold = '';
                var btnResume = '';
                var btnTransfer = '';
                if(response[i].hold_progress == 1 ){
                    btnHold = `  <button title="Hold Request" class="editHoldProgress btn btn-sm btn-primary rounded"data-id="${response[i]['id']}" data-request_code ="${response[i].request_code}" data-toggle="modal" data-target="#editHoldProgress">
                                <i class="fas fa-edit"></i>
                            </button>`
                }else if(response[i].hold_progress ==2){
                    btnResume = `  <button title="Resume Request" class="editResumeProgress btn btn-sm btn-warning rounded"data-id="${response[i]['id']}" data-request_code ="${response[i].request_code}" data-toggle="modal" data-target="#editResumeProgress">
                                <i class="fas fa-play"></i>
                            </button>`
                }
                data += `
                    <tr>
                        <td style="text-align:left" >${response[i].pic_name.name}</td>
                        <td style="text-align:center" >${response[i].request_code}</td>
                        <td style="text-align:left" >${response[i].departement_name.name}</td>
                        <td style="text-align:left" >${response[i].category_name.name}</td>
                        <td style="text-align:center">   
                            ${btnHold}
                            ${btnResume}
                        </td>
                    </tr>
                `;
            }
            $('#holdRequestTable > tbody:first').html(data);    
            $('#holdRequestTable').DataTable({
                    scrollX  : true,
                    scrollY  :280
                }).columns.adjust()
        }
    // End Function
</script>