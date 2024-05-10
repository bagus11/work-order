<script>
    const ratingStars = [...document.getElementsByClassName("rating__star")];
    const ratingResult = document.querySelector(".rating__result");
    getOfficeName('officeFilter')
    getSelect('getUserSupport',null,'selectSupportFilter','User')
    onChange('selectSupportFilter','userIdSupportFilter')
    $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
    });
    $('#refresh').on('click', function(){
        get_work_order_list();
        getNotification()
    })
    get_work_order_list()
    $('#add_wo').on('click', function(){
        getDepartementName('get_departement_name_ict','select_departement','Departement')
        $('.message_error').html('')
        $('#subject').val('')
        $('#add_info').val('')
        $('#categories_id').val('')
        $('#problem_type').val('')
        $('#request_type').val('')
    })
    onChange('select_departement', 'departement_for')
    onChange('select_categories','categories_id')
    onChange('select_problem_type','problem_type')
    $('#select_departement').on('change', function(){
        getSelect('get_categories_id',{'initial':$('#select_departement').val()},'select_categories', 'Categories')
    })
    $('#select_categories').on('change', function(){
        getSelect('get_problem_type_name',{'id': $('#select_categories').val()},'select_problem_type', 'Problem Type')
    })
    $('#btn_save_wo').on('click', function(e){
        e.preventDefault();
        var formData        = new FormData();    
        var request_type    = $('#request_type').val()
        var categories      = $('#categories').val()
        var problem_type    = $('#problem_type').val()
        var subject         = $('#subject').val()
        var add_info        = $('#add_info').val()
        var departement_for = $('#departement_for').val()
        var attachment      = $('#attachment')[0].files[0];
        formData.append('attachment',attachment)
        formData.append('request_type',request_type)
        formData.append('categories',categories)
        formData.append('problem_type',problem_type)
        formData.append('subject',subject)
        formData.append('add_info',add_info)
        formData.append('departement_for',departement_for)
       
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'save_wo',
                type: "post",
                dataType: 'json',
                async: true,
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function() {
                    SwalLoading('Inserting progress, please wait .');
                    $('#btn_save_wo').prop('disabled',true)
                },
                success: function(response) {
                    swal.close();
                    $('.message_error').html('')
                    $('#btn_save_wo').prop('disabled',false)
                    if(response.status==422)
                    {
                        $.each(response.message, (key, val) => 
                        {
                           $('span.'+key+'_error').text(val[0])
                        });
                        return false;
                    }else if(response.status==500){
                        toastr['warning'](response.message);
                    }
                    else{
                        toastr['success'](response.message);
                        window.location = "{{route('work_order_list')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        // uploadFile('save_wo',formData,'work_order_list')
    })
    $('#select_status_wo').on('change', function(){
        var select_status_wo = $('#select_status_wo').val()
        $('#status_wo').val(select_status_wo)
        var picFileName = $('#picFileName').val()
            if(select_status_wo == 4 ){
            
                if(picFileName ){
                    $('#attachment_container').hide()
                }else{
                    $('#attachment_container').show()
                }
            }else{
                $('#attachment_container').hide()
            }     
    })
    $('#btn_edit_wo').on('click', function(e){
        e.preventDefault();
        var formData        = new FormData();    
        var status_wo    = $('#status_wo').val()
        var note_pic      = $('#note_pic').val()
        var id         = $('#wo_id').val()

        var attachmentPIC      = $('#attachmentPIC')[0].files[0];
        formData.append('attachmentPIC',attachmentPIC)
        formData.append('status_wo',status_wo)
        formData.append('note_pic',note_pic)
        formData.append('id',id)
       
        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'approve_assignment_pic',
                type: "post",
                dataType: 'json',
                async: true,
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function() {
                    SwalLoading('Inserting progress, please wait .');
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
                        return false;
                    }else if(response.status==500){
                        toastr['warning'](response.message);
                    }
                    else{
                        toastr['success'](response.message);
                        window.location = "{{route('work_order_list')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        
        
    })
    $('#btn_manual_approve').on('click', function(){
        var data ={
            'id':$('#manual_assign_id_wo').val(),
            'note':$('#manual_pic_note').val(),
            'approve':1
        }
        manual_assign(data)
    })
    $('#btn_rating_pic').on('click', function(){
        var data ={
            'id':$('#wo_id_rating').val(),
            'note_pic_rating':$('#note_pic_rating').val(),
            'rating':ratingResult.innerText,
            'approve':1,
        }
        if(ratingResult.innerText ==''|| ratingResult.innerText==0){
            toastr['error']('Please give rate for PIC');
        }else{
            rating_pic(data)
        }
    })
    $('#btn_rating_pic_reject').on('click', function(){
        var data ={
            'id':$('#wo_id_rating').val(),
            'note_pic_rating':$('#note_pic_rating').val(),
            'rating':0,
            'approve':2,
        }
        rating_pic(data)
    })
    $('#wo_table').on('click', '.ratingPIC', function() {
            var id = $(this).data('id');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('detail_wo')}}",
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
              
               
                $('#select_request_type_rating').html(': '+response.detail.request_type)
                $('#select_categories_rating').html(': '+response.detail.categories_name)
                $('#select_problem_type_rating').html(': '+response.detail.problem_type_name)
                $('#request_type_rating').html(': '+response.detail.request_type)
                $('#categories_rating').html(': '+response.detail.categories)
                $('#problem_type_rating').html(': '+response.detail.problem_type)
                $('#subject_rating').html(': '+response.detail.subject)
                $('#add_info_rating').html(': '+response.detail.add_info)
                $('#request_code_rating').html(': '+response.detail.request_code)
                $('#username_rating').html(': '+response.detail.username)
                $('#wo_id_rating').val(id)
                $('#note_rating').val(response.data_log.comment)
                $('#creator_rating').html(response.data_log.username)
                  
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
    });
    $('#btn_manual_reject').on('click', function(){
        var data ={
            'id':$('#manual_assign_id_wo').val(),
            'note':$('#manual_pic_note').val(),
            'approve':2
        }
        manual_assign(data)
    })
    $('#select_request_type').on('change', function(){
        var select_request_type = $('#select_request_type').val()
        $('#request_type').val(select_request_type)
    })
    $('#select_categories').on('change', function(){
        var select_categories = $('#select_categories').val()
        $('#categories').val(select_categories)
        get_problem_type_name()
    })
    $('#select_departement').on('change', function(){
        var select_departement = $('#select_departement').val()
        $('#departement_for').val(select_departement)
    })
    $('#select_problem_type').on('change', function(){
        var select_problem_type = $('#select_problem_type').val()
        $('#problem_type').val(select_problem_type)
    })
    $('#wo_table').on('click', '.detailWO', function() {
        $('#attachment_user_detail').empty()
        $('#attachment_pic_detail').empty()
            var id = $(this).data('id');
            var request =  $(this).data('request');
            $('#oldTicketContainer').prop('hidden',true)
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('detail_wo')}}",
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
                            if(response.detail.status_wo==0){
                                status_wo ='NEW'
                            }else  if(response.detail.status_wo==1){
                                status_wo ="ON PROGRESS"
                            }else  if(response.detail.status_wo==2){
                                status_wo ="PENDING"
                            }else  if(response.detail.status_wo==3){
                                status_wo ="REVISION"
                            }else  if(response.detail.status_wo==4){
                                status_wo ="DONE"
                            }else{
                                status_wo ="REJECT"
                            }
                
                            if(response.detail.status_wo == 0)
                    {
                        $('#note_status').hide()
                    }else{
                        $('#note_status').show()
                    }
              
                $('#select_request_type_detail').html(': '+response.detail.request_type)
                $('#select_categories_detail').html(': '+response.detail.categories_name)
                $('#select_problem_type_detail').html(': '+response.detail.problem_type_name)
                $('#request_type_detail').val(response.detail.request_type)
                $('#categories_detail').val(response.detail.categories)
                $('#problem_type_detail').val(response.detail.problem_type)
                $('#subject_detail').html(': ' + response.detail.subject)
                $('#add_info_detail').html(': ' + response.detail.add_info)
                $('#request_code_detail').html(': '+ response.detail.request_code)
                $('#username_detail').html(': '+response.detail.username)
                $('#wo_id_detail').val(id)
                $('#status_wo_detail').html(': ' + status_wo)
                $('#note_detail').val(response.data_log.comment)
                $('#requestCodeWo').val(response.data_log.request_code)
              
                if(response.detail.attachment_user){
                    var fileName = response.detail.attachment_user.split('/')
                    $('#attachment_user_detail').append(`
                    <p>:
                        <a target="_blank" href="{{URL::asset('${response.detail.attachment_user}')}}" class="ml-3" style="color:blue;">
                            <i class="far fa-file" style="color: red;font-size: 20px;"></i>
                            ${fileName[2]}</a>
                    </p>
                            
                            `)
                }else{
                    $('#attachment_user_detail').append(`<span>: -<span>`)

                }
                if(response.detail.attachment_pic){
                    var fileNamePIC = response.detail.attachment_pic.split('/')
                   
                    $('#attachment_pic_detail').append(`
                    <p>:
                        <a target="_blank" href="{{URL::asset('${response.detail.attachment_pic}')}}" class="ml-3" style="color:blue;">
                            <i class="far fa-file" style="color: red;font-size: 20px;"></i>
                            ${fileNamePIC[2]}</a>
                    </p>
                            
                            `)
                }else{
                    $('#attachment_pic_detail').append(`<span>: -<span>`)

                }
                
                $('#creator_detail').html(response.data_log.username) 
                $('#pic_wo_detail').html( response.pic == null ? ': -' : ': '+ response.pic.username)  
                getStepper(request)
                getLogHistory(response.data_log.request_code)

                // Old Ticket
                    if(response.OldTicket){
                        $('#oldTicketContainer').prop('hidden',false)
                        $('#oldTicketRequestBy').html(': '+response.OldTicket.pic_name.name)
                        $('#oldTicketRequestCode').html(': '+response.OldTicket.request_code)
                        $('#oldTicketRequestType').html(': '+response.OldTicket.request_type)
                        $('#oldTicketCategories').html(': '+response.OldTicket.category_name.name)
                        $('#oldTicketProblemType').html(': '+response.OldTicket.problem_type_name.name)
                        $('#oldTicketSubject').html(': '+response.OldTicket.subject)
                        $('#oldTicketAdditionalInfo').html(': '+response.OldTicket.add_info)
                        $('#oldTicketPIC').html(': '+response.OldTicket.pic_support_name.name)
                        $('#oldTicketAttachmentUser').empty()
                        $('#oldTicketAttachmentPIC').empty()
                        if(response.OldTicket.attachment_user){
                            var fileName = response.OldTicket.attachment_user.split('/')
                            $('#oldTicketAttachmentUser').append(`
                            <p>:
                                <a target="_blank" href="{{URL::asset('${response.OldTicket.attachment_user}')}}" class="ml-3" style="color:blue;">
                                    <i class="far fa-file" style="color: red;font-size: 20px;"></i>
                                    ${fileName[2]}</a>
                            </p>
                                    
                                    `)
                        }else{
                            $('#oldTicketAttachmentUser').append(`<span>: -<span>`)

                        }
                        if(response.OldTicket.attachment_pic){
                            var fileNamePIC = response.OldTicket.attachment_pic.split('/')
                        
                            $('#oldTicketAttachmentPIC').append(`
                            <p>:
                                <a target="_blank" href="{{URL::asset('${response.OldTicket.attachment_pic}')}}" class="ml-3" style="color:blue;">
                                    <i class="far fa-file" style="color: red;font-size: 20px;"></i>
                                    ${fileNamePIC[2]}</a>
                            </p>
                                    
                                    `)
                        }else{
                            $('#oldTicketAttachmentPIC').append(`<span>: -<span>`)

                        }
                    }
                // End Old Ticket
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
    });
    $('#wo_table').on('click', '.updatePIC', function() {
            var id = $(this).data('id');
            $('#attachment_container').hide();
            $('#select_status_wo').empty()
            $('#select_status_wo').append(`
                    <option value="">Select Progress</option>
                    <option value='4'>DONE</option>
                    <option value='2'>PENDING</option>`)
            $('#note_pic').val('')
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('detail_wo')}}",
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

                $('#select_request_type_update').html(': '+response.detail.request_type)
                $('#select_categories_update').html(': '+response.detail.categories_name)
                $('#select_problem_type_update').html(': '+response.detail.problem_type_name)
                $('#request_type_update').html(': '+response.detail.request_type)
                $('#categories_update').html(': '+response.detail.categories)
                $('#problem_type_update').html(': '+response.detail.problem_type)
                $('#subject_update').html(': '+response.detail.subject)
                $('#add_info_update').html(': '+response.detail.add_info)
                $('#request_code_update').html(': '+response.detail.request_code)
                $('#username_update').html(': '+response.detail.username)
                $('#wo_id').val(id)
                $('#note').val(response.data_log.comment)
                $('#creator').html(response.data_log.username)  
                $('#picFileName').val(response.detail.attachment_pic)  
              

                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
    });
    $('#wo_table').on('click', '.manualAssign', function() {
        var id = $(this).data('id');
        $('#manual_assign_id_wo').val(id)
    });
    $('#wo_table').on('click', '.holdRFM', function() {
            var id = $(this).data('id');
            var request =  $(this).data('request');
            $('#holdProgressId').val(id)
    });
    $('#btnHoldProgress').on('click', function(){
        var data = {
            'id':$('#holdProgressId').val(),
            'holdProgressNote':$('#holdProgressNote').val()
        }
        store('holdProgressRequest',data,'work_order_list')
    })
    $('#custom-tabs-one-profile-tab').on('click', function(){
        var requestCodeWo = $('#requestCodeWo').val();
        getLogHistory(requestCodeWo)
    })
    $('#btnReportWO').on('click', function(){
        var from = $('#from').val();
        var to = $('#to').val();
        var officeFilter = $('#officeFilter').val();
        var statusFilter = $('#statusFilter').val();
        var userId = $('#userIdSupportFilter').val();

        window.open(`printWO/${from}/${to}/${officeFilter =='' ? '*':officeFilter}/${statusFilter =='' ? '*' : statusFilter}/${userId =='' ? '*' : userId}`,'_blank');
    })
    $('#wo_table').on('click','.chat', function(){
        var request_code = $(this).data('request')
        var data ={
            'request_code' :request_code
        }
        $('#remark_chat').val('')
        $('#chat_request').val(request_code)
        data_chat = setInterval(function() {
            getCallbackNoSwal('getDisscuss',data,function(response){
                swal.close()
                var data_chat =''
                for(i=0; i < response.data.length ; i++){
                    const d = new Date(response.data[i].created_at)
                    const date = d.toISOString().split('T')[0];
                    const time = d.toTimeString().split(' ')[0];
                    data_chat +=`
                            <div class="direct-chat-msg ${response.data[i].user_relation.id == $('#auth_id').val() ?'right':''}">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name ${response.data[i].user_relation.id == $('#auth_id').val() ?'float-right':'float-left'}">${response.data[i].user_relation == null ?'':response.data[i].user_relation.name}</span>
                                    <span class="direct-chat-timestamp ${response.data[i].user_relation.id == $('#auth_id').val() ?'float-left':'float-right'}">${convertDate(date)} ${time}</span>
                                </div>
                                    <img class="direct-chat-img" src="{{URL::asset('profile.png')}}" alt="message user image">
                                <div class="direct-chat-text" style="font-size:12px !important">
                                    ${response.data[i].comment}
                                </div>
                            
                            </div>
                    `
                }
                $('#chat_container').html(data_chat)
            })
            }, 10000);
        getCallback('getDisscuss',data,function(response){
            swal.close()
            var data_chat =''
            for(i=0; i < response.data.length ; i++){
                const d = new Date(response.data[i].created_at)
                const date = d.toISOString().split('T')[0];
                const time = d.toTimeString().split(' ')[0];
                data_chat +=`
                        <div class="direct-chat-msg ${response.data[i].user_relation.id == $('#auth_id').val() ?'right':''}">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name ${response.data[i].user_relation.id == $('#auth_id').val() ?'float-right':'float-left'}">${response.data[i].user_relation == null ?'':response.data[i].user_relation.name}</span>
                                <span class="direct-chat-timestamp ${response.data[i].user_relation.id == $('#auth_id').val() ?'float-left':'float-right'}">${convertDate(date)} ${time}</span>
                            </div>
                                <img class="direct-chat-img" src="{{URL::asset('profile.png')}}" alt="message user image">
                            <div class="direct-chat-text" style="font-size:12px !important">
                                ${response.data[i].comment}
                            </div>
                        
                        </div>
                `
            }
            $('#chat_container').html(data_chat)
        })
        // chat_container
    })
    $('#btn_send_chat').on('click', function(){
        var data ={
            'remark_chat'   : $('#remark_chat').val(),
            'request_code'  : $('#chat_request').val()
        }
        $('#remark_chat').val('')
        var remark = $('#remark_chat').val()
        if(remark == ''){
            toastr['error']('Remark is required');
        }else{
            postCallbackNoSwal('sendDisscuss', data, function(response){
                getCallbackNoSwal('getDisscuss',data,function(response){
                    swal.close()
                    var data_chat =''
                    for(i=0; i < response.data.length ; i++){
                        const d = new Date(response.data[i].created_at)
                        const date = d.toISOString().split('T')[0];
                        const time = d.toTimeString().split(' ')[0];
                        data_chat +=`
                                <div class="direct-chat-msg ${response.data[i].user_relation.id == $('#auth_id').val() ?'right':''}">
                                    <div class="direct-chat-infos clearfix">
                                        <span class="direct-chat-name ${response.data[i].user_relation.id == $('#auth_id').val() ?'float-right':'float-left'}">${response.data[i].user_relation == null ?'':response.data[i].user_relation.name}</span>
                                        <span class="direct-chat-timestamp ${response.data[i].user_relation.id == $('#auth_id').val() ?'float-left':'float-right'}">${convertDate(date)} ${time}</span>
                                    </div>
                                        <img class="direct-chat-img" src="{{URL::asset('profile.png')}}" alt="message user image">
                                    <div class="direct-chat-text" style="font-size:12px !important">
                                        ${response.data[i].comment}
                                    </div>
                                
                                </div>
                        `
                    }
                    $('#chat_container').html(data_chat)
                })
            })
        }
    })
    $(document).ready(function () {
    $('#chatModal').on('hidden.bs.modal', function () {
      // var detail_code = $('#detail_code_chat').val()
      clearInterval(data_chat);
    })
  })
    const progressSteps = document.querySelectorAll('.progress-step');
    let formSetpsNum =0
    function updateProgressBar()
    {
        progressSteps.forEach((progressStep, idx)=>{
            if(idx < formSetpsNum +1)
            {
                progressStep.classList.add('progress-step-active')
            }else{
                progressStep.classList.remove('progress-step-active')
            }
        });
        const progressActive = document.querySelectorAll('.progress-step-active');
        progress.style.width =((progressActive.length - 1) / (progressSteps.length -1) *100 +'%')
    }
    function getStepper(request_code){
        $('#stepperTable').DataTable().clear();
        $('#stepperTable').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getStepper')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
                'request_code':request_code,
            },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                var data=''
                var statusWo = response.statusWo.status_wo
                var statusApproval = response.statusWo.status_approval
               
                if(statusWo == 0 && statusApproval == 0){
                    formSetpsNum = 0
                }else if(statusWo == 1 && statusApproval == 0){
                    formSetpsNum = 1
                }else if((statusWo == 2 || statusWo == 3 || statusWo == 4) && (statusApproval == 0 || statusApproval ==2)){
                    formSetpsNum =2
                }else if( statusWo == 4 && statusApproval == 1){
                    formSetpsNum =3 
                }else{
                    formSetpsNum =0
                }
                for(i = 0; i < response.createdBy.length; i++ )
                {
                            const d = new Date(response.createdBy[i].created_at)
                            const date = d.toISOString().split('T')[0];
                            const time = d.toTimeString().split(' ')[0];
                           
                            var e ='';
                            var respondedDate ='';
                            var respondedTime ='';
                            var f = '';
                            var fixedDate ='';
                            var fixedTime ='';
                            var g = '';
                            var closedDate ='';
                            var closedTime ='';

                            if(response.responded.length > 0){
                                 e = new Date(response.responded[i].created_at)
                                 respondedDate = e.toISOString().split('T')[0];
                                 respondedTime = e.toTimeString().split(' ')[0];
                            }
                            if(response.fixed.length > 0){
                                 f = new Date(response.fixed[i].created_at)
                                 fixedDate = f.toISOString().split('T')[0];
                                 fixedTime = f.toTimeString().split(' ')[0];
                            }
                            if(response.closed.length > 0){
                                 g = new Date(response.closed[i].created_at)
                                 closedDate = g.toISOString().split('T')[0];
                                 closedTime = g.toTimeString().split(' ')[0];
                            }



                    data += `<tr>
                                <td style="text-align:center;width:12% !important;">${response.createdBy[i]['created_at']==null?'':date+' '+time} </td>
                                <td style="text-align:center;width:12% !important;">${response.createdBy[i].user_p_i_c==null?'':response.createdBy[i].user_p_i_c.name}</td>
                                <td style="text-align:center;width:12% !important;">${respondedDate+' '+respondedTime}</td>
                                <td style="text-align:center;width:12% !important;">${response.responded[i]==null?'':response.responded[i].user_p_i_c.name}</td>
                                <td style="text-align:center;width:12% !important;">${fixedDate+' '+fixedTime}</td>
                                <td style="text-align:center;width:12% !important;">${response.fixed[i]==null?'':response.fixed[i].user_p_i_c.name}</td>
                                <td style="text-align:center;width:12% !important;">${closedDate+' '+closedTime}</td>
                                <td style="text-align:center;width:12% !important;">${response.closed[i]==null?'':response.closed[i].user_p_i_c.name}</td>
                            </tr>
                            `;
                }
                    $('#stepperTable> tbody:first').html(data);
                    $('#stepperTable').DataTable({
                        scrollX  : true,
                        scrollY  :70,
                        autoWidth:false,
                        searching:false,
                        aaSorting:false,
                        bInfo:false,
                        paging:false
                    }).columns.adjust().draw()    
                    updateProgressBar()
                    
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    printRatingResult(ratingResult);
    function executeRating(stars, result) {
        const starClassActive = "rating__star fas fa-star";
        const starClassUnactive = "rating__star far fa-star";
        const starsLength = stars.length;
        let i;
        stars.map((star) => {
            star.onclick = () => {
                i = stars.indexOf(star);

                if (star.className.indexOf(starClassUnactive) !== -1) {
                    printRatingResult(result, i + 1);
                    for (i; i >= 0; --i) stars[i].className = starClassActive;
                } else {
                    printRatingResult(result, i);
                    for (i; i < starsLength; ++i) stars[i].className = starClassUnactive;
                }
            };
        });
    }
    function printRatingResult(result, num) {
    result.textContent = num;
    }
    $('.rating__result').on('change', function(){
        var rating__result = $('.rating__result').val()
    $('#note_pic').val(rating__result)
    })
    executeRating(ratingStars, ratingResult);
  
    function get_work_order_list(){
        $('#wo_table').DataTable().clear();
        $('#wo_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_work_order_list')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
                'officeFilter':$('#officeFilter').val(),
                'statusFilter':$('#statusFilter').val(),
                'from':$('#from').val(),
                'to':$('#to').val(),
                'userIdSupportFilter':$('#userIdSupportFilter').val(),
            },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                var data=''
            
                for(i = 0; i < response.data.length; i++ )
                {
                            const d = new Date(response.data[i].created_at)
                            const date = d.toISOString().split('T')[0];
                            const time = d.toTimeString().split(' ')[0];
                            d2 = new Date (response.data[i].created_at );
                            d2.setMinutes ( d.getMinutes() + 1 );
                            var d3 =  d2.toTimeString().split(' ')[0];
                            var date_now = new Date();
                            var date_format = date_now.toISOString().split('T')[0];
                            var time_now = date_now.toTimeString().split(' ')[0];;
                            var satatus_wo = '';
                            var status_color = ''
                            if(response.data[i].transfer_pic == 1){
                                    status_wo ='TAKE OUT'
                                    status_color ='red'
                            }else{
                                if(response.data[i].status_wo==0){
                                    status_wo ='NEW'
                                    status_color ='black'
                                }else  if(response.data[i].status_wo==1){
    
                                    if(response.data[i].hold_progress == 1){
                                        status_wo ="HOLD Request"
                                        status_color ='#213555'
    
                                    }else if(response.data[i].hold_progress == 2){
                                        status_wo ="HOLD"
                                        status_color ='#213555'
                                    }else{
                                        status_wo ="On Progress"
                                        status_color ='#5BC0F8'
                                    }
    
                                }else  if(response.data[i].status_wo==2){
    
                                    status_wo ="PENDING"
                                    status_color ='#FFC93C'
                                }else  if(response.data[i].status_wo==3){
    
                                    if(response.data[i].hold_progress == 1){
                                        status_wo ="HOLD Request"
                                        status_color ='#213555'
    
                                    }else if(response.data[i].hold_progress == 2){
                                        status_wo ="HOLD"
                                        status_color ='#213555'
                                    }else{
                                        status_wo ="REVISION"
                                        status_color ='red'
                                    }
    
                                }else if(response.data[i].status_wo==4){
    
                                    if(response.data[i].status_approval == '1'){
                                        status_wo ="DONE"
                                        status_color ='green'
                                    }else{
                                        status_wo ="CHECKING"
                                        status_color ='#F0A04B'
                                    }
                                
                                }else{
                                    status_wo ="REJECT"
                                    status_color ='red'
                                }
                            }

                          var priorityLabel ='-'
                          var priorityColor =''
                          var update_progress ='';
                          var holdButton ='';
                          var resumeButton ='';
                          var approve_manual ='';
                          var make_sure_done ='';
                          var buttonPrint   = '';
                          switch(response.data[i].priority){
                            case 1:
                                priorityLabel ='Low'
                                priorityColor ='color:grey'
                                break
                            case 2:
                                    priorityLabel ='Medium'
                                    priorityColor ='color:black'
                                break
                            case 3:
                                    priorityLabel ='High'
                                    priorityColor ='color:red;font-weight:bold'
                                break
                            case '' :
                                priorityLabel ='High'
                                priorityColor ='color:red;font-weight:bold'
                            break
                          }
                         
                          var auth_id = $('#auth_id').val()
                            if(response.data[i].status_wo == 1 || response.data[i].status_wo == 2 || response.data[i].status_wo == 3){
                                if(response.data[i].transfer_pic == 0){
                                    if(auth_id == response.data[i].user_id_support){
                                            if(response.data[i].hold_progress == 0 || response.data[i].hold_progress == 4){
                                                if(response.data[i].hold_progress == 0){
                                                    holdButton =`<button title="Hold Progress" class="holdRFM btn btn-success rounded btn-sm"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#holdProgressModal">
                                                                <i class="fas fa-pause"></i>
                                                            </button> `;
                                                }
                                                update_progress =`<button title="Update Progress" class="updatePIC btn btn-warning rounded btn-sm"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#updatePIC">
                                                    <i class="fas fa-pen"></i>
                                                </button> `;
                                            }else{
                                                status_wo ="HOLD Request"
                                                status_color ='#213555'
                                            }
                                    }
                                }
                            }
                            if( date == date_format){
                                if(d3 < time_now && response.data[i].status_wo == 0 )
                                {
                                    approve_manual =`<button title="Manual Assign" class="manualAssign btn btn-sm btn-primary rounded btn-sm"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#manualAssign">
                                                        <i class="fas fa-user"></i>
                                                    </button> `;
                                }
                            }else if(date < date_format){
                                if(response.data[i].status_wo == 0){
                                    approve_manual =`<button title="Manual Assign" class="manualAssign btn btn-sm btn-primary rounded btn-sm"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#manualAssign">
                                                        <i class="fas fa-user"></i>
                                                    </button> `;
                                }
                            }
                            if((response.data[i].status_wo == 4 && response.data[i].status_approval == 0) || (response.data[i].status_approval == 2 && response.data[i].status_wo == 4)){
                                if(auth_id == response.data[i].user_id){
                                    make_sure_done =`<button title="Approvement" class="ratingPIC btn btn-sm btn-success rounded btn-sm"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#ratingPIC">
                                                     <i class="fas fa-star"></i>
                                                </button> `;
                                }
                            }
                            if(response.data[i].status_wo != 0){
                                var requestDetailTicket = response.data[i].request_code.replace(/\//g, "&*.")
                                buttonPrint =`
                                        <a  href="reportDetailWO/${requestDetailTicket}" data-request="${response.data[i].request_code}" class="btn btn-sm btn-success" target="_blank">
                                            <i class="fa-solid fa-print"></i>
                                        </a>
                                `;
                            }
                            var detailWO = `<button title="Detail" class="detailWO btn btn-sm btn-primary rounded btn-sm"data-id="${response.data[i]['id']}" data-request="${response.data[i].request_code}" data-toggle="modal" data-target="#detailWO">
                                                 <i class="fas fa-eye"></i>    
                                            </button> `;
                            var chat ='';
                            if(response.data[i].status_wo == 4 && response.data[i].status_approval == 2){
                                chat = `<button title="Disscuss about this ticket" class="chat btn btn-sm btn-info rounded btn-sm"data-id="${response.data[i]['id']}" data-request="${response.data[i].request_code}" data-toggle="modal" data-target="#chatModal">
                                                     <i class="fas fa-comment"></i>    
                                                </button> `;
                            }
                            if(response.data[i].status_wo != 4){
                                // console.log(response.data[i])
                                chat = `<button title="Disscuss about this ticket" class="chat btn btn-sm btn-info rounded btn-sm"data-id="${response.data[i]['id']}" data-request="${response.data[i].request_code}" data-toggle="modal" data-target="#chatModal">
                                                     <i class="fas fa-comment"></i>    
                                                </button> `;
                            }
                    data += `<tr style="text-align: center;">
                                @can('priority-work_order_list')
                                <td class='details-control'></td>
                                @endcan
                                <td style="width:11%;text-align:left;">${response.data[i]['created_at']==null?'':response.data[i]['created_at']}</td>
                                <td style="width:11%;text-align:left;">${response.data[i]['username']==null?'':response.data[i]['username']}</td>
                                <td style="width:11%;text-align:left;">${response.data[i]['kantor_name']==null?'':response.data[i]['kantor_name']}</td>
                                <td style="width:11%;text-align:left;" class="request_code">${response.data[i]['request_code']==null?'':response.data[i]['request_code']}</td>
                                @can('priority-work_order_list')
                                <td style="width:11%;text-align:center;${priorityColor}">${priorityLabel}</td>
                                @endcan
                                <td style="width:11%;text-align:center;">${response.data[i]['departement_name']==null?'':response.data[i]['departement_name']}</td>
                                <td style="width:11%;text-align:center;">${response.data[i]['categories_name']==null?'':response.data[i]['categories_name']}</td>
                                <td style="width:11%;text-align:center; color:${status_color}"><b>${response.data[i]['status_wo']==null?'':status_wo}</b></td>
                                <td style="width:11%;text-align:left">
                                    ${detailWO}
                                    ${buttonPrint}
                                    @can('update-work_order_list')
                                      ${update_progress}
                                      ${holdButton}
                                      ${resumeButton}

                                    @endcan
                                    @can('manual-work_order_list')
                                      ${approve_manual}
                                    @endcan
                                    @can('rating-work_order_list')
                                    ${make_sure_done}
                                    @endcan
                                    ${chat}
                                </td>
                            </tr>
                            `;
                }
                    $('#wo_table > tbody:first').html(data);
                        var table = $('#wo_table').DataTable({
                            scrollX  : true,
                            scrollY: true,
                            scrollCollapse : true,
                            autoWidth:true
                        }).columns.adjust()    
                        $('#wo_table tbody').off().on('click', 'td.details-control', function (e) {
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
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function detail_log( callback, request_code){
       
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('get_wo_log')}}",
                type: "get",
                dataType: 'json',
                data: {
                    'request_code': request_code
                },
                beforeSend: function () {
                  $('#loading').show();
                },
                success : function(response) {

                    $('#loading').hide();
                    if(response){
                        let row = '';
                        var revision = 0;
                        for(let i = 0; i < response.log_data.length; i++){
                        var isi_survey =``;
                        var report_survey =``;
                        var akeses =``;
                           
                            $(document).ready(function() 
                            {
                                $('.table_detail').DataTable
                                ({
                                    "destroy": true,
                                    "autoWidth" : false,
                                    "searching": false,
                                    "aaSorting" : false,
                                    "paging":   false,
                                    "scrollX":true
                                }).columns.adjust()    
                            });
                            $('.table_detail tbody').append(``);
                            const d = new Date(response.log_data[i].created_at)
                            const date = d.toISOString().split('T')[0];
                            const time = d.toTimeString().split(' ')[0];
                            var satatus_wo = '';
                            var status_color = ''
                            if(response.log_data[i].status_wo==0){
                                status_wo ='NEW'
                                status_color ='black'
                            }else  if(response.log_data[i].status_wo==1){
                                if(response.log_data[i].hold_progress == 1){
                                    status_wo ="HOLD Request"
                                    status_color ='#213555'

                                }else if(response.log_data[i].hold_progress == 2){
                                    status_wo ="HOLD"
                                    status_color ='#213555'
                                }else{
                                    status_wo ="On Progress"
                                    status_color ='#5BC0F8'
                                }
                            }else  if(response.log_data[i].status_wo==2){
                                status_wo ="PENDING"
                                status_color ='#FFC93C'
                            }else  if(response.log_data[i].status_wo==3){
                                revision ++
                                if(response.log_data[i].hold_progress == 1){
                                    status_wo ="HOLD Request"
                                    status_color ='#213555'

                                }else if(response.log_data[i].hold_progress == 2){
                                    status_wo ="HOLD"
                                    status_color ='#213555'
                                }else{
                                    status_wo ="REVISION " +revision
                                    status_color ='red'
                                }
                            }else if(response.log_data[i].status_wo == 4){
                                if(response.log_data[i].status_approval == 1){
                                    status_wo ="DONE"
                                    status_color ='green'
                                }else{
                                    status_wo ="CHECKING"
                                    status_color ='#F0A04B'
                                }
                            }
                          else{
                                status_wo ="REJECT"
                                status_color ='red'
                            }
                            var assignment = '';
                            var color_assignment = ''
                            if(response.log_data[i].assignment==0){
                                assignment ='UNASSIGNED'
                                color_assignment ='black'
                            }else  if(response.log_data[i].assignment==1){
                                assignment ="CONFIRM"
                                color_assignment ='green'
                            }else{
                                assignment ="REJECT"
                                color_assignment ='red'
                            }
                            var picDuration = '-'
                            if(status_wo =='CHECKING' || status_wo =='PENDING' || status_wo =='HOLD Request' || status_wo =='HOLD'){

                                picDuration= response.log_data[i].duration == 0 ? timeConvert(response.log_data[i].duration) : timeConvert(response.log_data[i].duration)
                            }
                                row+= `<tr class="table-light">
                                            <td style="text-align:center">${i + 1}</td>
                                            <td style="text-align:center">${date} ${time}</td>
                                            <td style="text-align:center;color:${color_assignment}"><b>${assignment}<b/></td>
                                            <td style="text-align:center;color:${status_color}"><b>${status_wo}<b/></td>
                                            <td style="text-align:center">${response.log_data[i].user_p_i_c_support==null?'-':response.log_data[i].user_p_i_c_support.name}</td>
                                            <td style="text-align:center">${picDuration}</td>
                                            <td style="text-align:left">${response.log_data[i].user_p_i_c.name}</td>
                                        </tr>`;
    
                        }
                        callback($(`
                          <table class="table_detail datatable-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Created at</th>
                                    <th style="text-align:center">Assign Status</th>
                                    <th style="text-align:center">Status WO</th>
                                    <th style="text-align:center">PIC</th>
                                    <th style="text-align:center">Duration</th>
                                    <th style="text-align:center">Created By</th>
                                </tr>
                            </thead>
                          <tbody class="table-bordered">${row}</tbody>
                        </table>`)).show();
                     
                    }else{
                        toastr["error"]('Data tidak ada')
                        $('#loading').hide();
                    }
                },
                error : function(response) {
                    alert('Gagal Get Data, Tidak Ada Data / Mohon Coba Kembali Beberapa Saat Lagi');
                    $('#loading').hide();
                }
            });
        }

    function get_categories_name(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_categories_name')}}",
            type: "get",
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_categories').empty();
                $('#select_categories').append('<option value ="">Choose Categories</option>');
                $.each(response.data,function(i,data){
                    $('#select_categories').append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function get_problem_type_name(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_problem_type_name')}}",
            type: "get",
            dataType: 'json',
            data:{
                'id':$('#categories').val()
            },
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_problem_type').empty();
                $('#select_problem_type').append('<option value ="">Choose Problem Type</option>');
                $.each(response.data,function(i,data){
                    $('#select_problem_type').append('<option value="'+data.id+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    } 
    function approve_assignment(data)
    {
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('approve_assignment_pic')}}",
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
                    return false;
                }else if(response.status == 200){
                    toastr['success'](response.message);
                    window.location = "{{route('work_order_list')}}";
                }else{
                    toastr['error'](response.message);
                    return false
                }
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function rating_pic(data)
    {
        $('.message_error').val('')
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('rating_pic')}}",
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
                }else{
                    toastr['success'](response.message);
                    window.location = "{{route('work_order_list')}}";
                }
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function manual_assign(data){
     
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('manual_approve')}}",
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
                        return false;
                    }else if(response.status==500){
                        toastr['warning'](response.message);
                    }
                    else{
                        toastr['success'](response.message);
                        window.location = "{{route('work_order_list')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function get_departement_name(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_departement_name')}}",
            type: "get",
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_departement').empty();
                $('#select_departement').append('<option value ="">Pilih Departement</option>');
                $.each(response.data,function(i,data){
                    $('#select_departement').append('<option value="'+data.initial+'">' + data.name +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function getLogHistory(request_code){
        $('#logMessage').empty()
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_wo_log')}}",
            type: "get",
            data:{
                'request_code':request_code
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
              
               var data =''
               for(i = 0; i < response.log_data.length; i++){
              
                data +=`
                        <div class="direct-chat-msg ${response.log_data[i].creator_relation.id == $('#auth_id').val() ?'right':''}">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name ${response.log_data[i].creator_relation.id == $('#auth_id').val() ?'float-right':'float-left'}">${response.log_data[i].creator_relation == null ?'':response.log_data[i].creator_relation.name}</span>
                                <span class="direct-chat-timestamp ${response.log_data[i].creator_relation.id == $('#auth_id').val() ?'float-left':'float-right'}">${response.log_data[i].date}</span>
                            </div>
                            
                                <img class="direct-chat-img" src="{{URL::asset('profile.png')}}" alt="message user image">
                        
                            <div class="direct-chat-text">
                                ${response.log_data[i].comment}
                            </div>
                        
                        </div>
                `;
            }
          
               $('#logMessage').append(data)
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
</script>