<script>
const ratingStars = [...document.getElementsByClassName("rating__star")];
const ratingResult = document.querySelector(".rating__result");
getOfficeName('officeFilter')
$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});
get_work_order_list()
    $('#add_wo').on('click', function(){
        getDepartementName('get_departement_name','select_departement','Departement')
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
    $('#btn_save_wo').on('click', function(){
        save_wo()
    })
    $('#select_status_wo').on('change', function(){
        var select_status_wo = $('#select_status_wo').val()
        $('#status_wo').val(select_status_wo)
    })
    $('#btn_edit_wo').on('click', function(){
        var data ={
            'status_wo':$('#status_wo').val(),
            'note_pic':$('#note_pic').val(),
            'id':$('#wo_id').val()
        }
        approve_assignment(data)
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
            toastr['error']('Anda belum memberi penilaian');
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
              
                $('#select_request_type_rating').empty()
                $('#select_request_type_rating').append('<option value ="'+response.detail.request_type+'">'+response.detail.request_type+'</option>')
                $('#select_categories_rating').empty()
                $('#select_categories_rating').append('<option value ="'+response.detail.categories+'">'+response.detail.categories_name+'</option>')
                $('#select_problem_type_rating').empty()
                $('#select_problem_type_rating').append('<option value ="'+response.detail.problem_type+'">'+response.detail.problem_type_name+'</option>')
                $('#request_type_rating').val(response.detail.request_type)
                $('#categories_rating').val(response.detail.categories)
                $('#problem_type_rating').val(response.detail.problem_type)
                $('#subject_rating').val(response.detail.subject)
                $('#add_info_rating').val(response.detail.add_info)
                $('#request_code_rating').val(response.detail.request_code)
                $('#username_rating').val(response.detail.username)
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
                            if(response.detail.status_wo==0){
                                status_wo ='NEW'
                            }else  if(response.detail.status_wo==1){
                                status_wo ="ON PROGRESS"
                            }else  if(response.detail.status_wo==2){
                                status_wo ="PENDING"
                            }else  if(response.detail.status_wo==3){
                                status_wo ="REVISI"
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
                $('#select_request_type_detail').empty()
                $('#select_request_type_detail').append('<option value ="'+response.detail.request_type+'">'+response.detail.request_type+'</option>')
                $('#select_categories_detail').empty()
                $('#select_categories_detail').append('<option value ="'+response.detail.categories+'">'+response.detail.categories_name+'</option>')
                $('#select_problem_type_detail').empty()
                $('#select_problem_type_detail').append('<option value ="'+response.detail.problem_type+'">'+response.detail.problem_type_name+'</option>')
                $('#request_type_detail').val(response.detail.request_type)
                $('#categories_detail').val(response.detail.categories)
                $('#problem_type_detail').val(response.detail.problem_type)
                $('#subject_detail').val(response.detail.subject)
                $('#add_info_detail').val(response.detail.add_info)
                $('#request_code_detail').val(response.detail.request_code)
                $('#username_detail').val(response.detail.username)
                $('#wo_id_detail').val(id)
                $('#status_wo_detail').val(status_wo)
                $('#note_detail').val(response.data_log.comment)
                $('#creator_detail').html(response.data_log.username)  
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    
    });
  
    $('#wo_table').on('click', '.updatePIC', function() {
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
                $('#select_request_type_update').empty()
                $('#select_request_type_update').append('<option value ="'+response.detail.request_type+'">'+response.detail.request_type+'</option>')
                $('#select_categories_update').empty()
                $('#select_categories_update').append('<option value ="'+response.detail.categories+'">'+response.detail.categories_name+'</option>')
                $('#select_problem_type_update').empty()
                $('#select_problem_type_update').append('<option value ="'+response.detail.problem_type+'">'+response.detail.problem_type_name+'</option>')
                $('#request_type_update').val(response.detail.request_type)
                $('#categories_update').val(response.detail.categories)
                $('#problem_type_update').val(response.detail.problem_type)
                $('#subject_update').val(response.detail.subject)
                $('#add_info_update').val(response.detail.add_info)
                $('#request_code_update').val(response.detail.request_code)
                $('#username_update').val(response.detail.username)
                $('#wo_id').val(id)
                $('#note').val(response.data_log.comment)
                $('#creator').html(response.data_log.username)  
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
                            if(response.data[i].status_wo==0){
                                status_wo ='NEW'
                                status_color ='black'
                            }else  if(response.data[i].status_wo==1){
                                status_wo ="ON PROGRESS"
                                status_color ='#5BC0F8'
                            }else  if(response.data[i].status_wo==2){
                                status_wo ="PENDING"
                                status_color ='#FFC93C'
                            }else  if(response.data[i].status_wo==3){
                                status_wo ="REVISI"
                                status_color ='red'
                            }else  if(response.data[i].status_wo==4){
                                status_wo ="DONE"
                                status_color ='green'
                            }else{
                                status_wo ="REJECT"
                                status_color ='red'
                            }
                          var update_progress ='';
                          var approve_manual ='';
                          var make_sure_done ='';
                          var auth_id = $('#auth_id').val()
                        
                            if(response.data[i].status_wo == 1 || response.data[i].status_wo == 2 || response.data[i].status_wo == 3){
                                if(auth_id == response.data[i].user_id_support)
                                update_progress =`<button title="Detail" class="updatePIC btn btn-warning rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#updatePIC">
                                            <i class="fas fa-pen"></i>
                                        </button> `;
                            }
                            if(date < date_format || date == date_format){
                           
                                if(d3 < time_now && response.data[i].status_wo == 0 )
                                {
                                    approve_manual =`<button title="Manual Assign" class="manualAssign btn btn-sm btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#manualAssign">
                                                <ion-icon name="checkmark-circle"></ion-icon>
                                            </button> `;
                                }
                            }
                            if((response.data[i].status_wo == 4 && response.data[i].status_approval == 0) || (response.data[i].status_approval == 2 && response.data[i].status_wo == 4)){
                                if(auth_id == response.data[i].user_id){
                                    make_sure_done =`<button title="Approvement" class="ratingPIC btn btn-sm btn-success rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#ratingPIC">
                                                     <ion-icon name="star"></ion-icon>
                                                </button> `;
                                }
                            }
                            var detailWO = `<button title="Detail" class="detailWO btn btn-sm btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#detailWO">
                                                 <ion-icon name="eye"></ion-icon>        
                                            </button> `;
                    data += `<tr style="text-align: center;">
                                <td class='details-control'></td>
                                <td style="width:25%;text-align:left;">${response.data[i]['username']==null?'':response.data[i]['username']}</td>
                                <td style="width:25%;text-align:left;">${response.data[i]['kantor_name']==null?'':response.data[i]['kantor_name']}</td>
                                <td style="width:25%;text-align:left;" class="request_code">${response.data[i]['request_code']==null?'':response.data[i]['request_code']}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['departement_name']==null?'':response.data[i]['departement_name']}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['categories_name']==null?'':response.data[i]['categories_name']}</td>
                                <td style="width:25%;text-align:center; color:${status_color}"><b>${response.data[i]['status_wo']==null?'':status_wo}</b></td>
                                <td style="width:25%;text-align:center">
                                    ${detailWO}
                                    @can('update-work_order_list')
                                      ${update_progress}
                                    @endcan
                                    @can('manual_approval-work_order_list')
                                      ${approve_manual}
                                    @endcan
                                    @can('rating-work_order_list')
                                    ${make_sure_done}
                                    @endcan
                                    
                                </td>
                            </tr>
                            `;
                }
                    // $('#wo_table > tbody:first').html(data);
                    // $('#wo_table').DataTable({
                    //     scrollX  : true,
                    //     scrollY:220
                    // }).columns.adjust()

                    $('#wo_table > tbody:first').html(data);
                        var table = $('#wo_table').DataTable({
                            scrollX  : true,
                            scrollY  :215
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
        console.log('test')
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
                    // alert(response.length);
                    $('#loading').hide();
                    if(response){
                        let row = '';
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
                                status_wo ="ON PROGRESS"
                                status_color ='#5BC0F8'
                            }else  if(response.log_data[i].status_wo==2){
                                status_wo ="PENDING"
                                status_color ='#FFC93C'
                            }else  if(response.log_data[i].status_wo==3){
                                status_wo ="REVISI"
                                status_color ='red'
                            }else  if(response.log_data[i].status_wo==4  && response.log_data.status_approval == 1){
                                status_wo ="DONE"
                                status_color ='green'
                            }else if(response.log_data[i].status_wo == 4 && (response.log_data[i].status_approval ==0 || response.log_data[i].status_approval == 2)){
                                status_wo ="ON PROGRESS"
                                status_color ='#5BC0F8'
                            }
                            else  if(response.log_data[i].status_wo==5){
                                status_wo ="Complete"
                                status_color ='black'
                            }else{
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
                            // console.log(i + ' - '+response.log_data[i].user_p_i_c_support)
                                row+= `<tr class="table-light">
                                            <td style="text-align:center">${i + 1}</td>
                                            <td style="text-align:center">${date} ${time}</td>
                                            <td style="text-align:center">${response.log_data[i].subject}</td>
                                            <td style="text-align:center;color:${color_assignment}"><b>${assignment}<b/></td>
                                                <td style="text-align:center;color:${status_color}"><b>${status_wo}<b/></td>
                                                    <td style="text-align:center">${response.log_data[i].user_p_i_c_support==null?'-':response.log_data[i].user_p_i_c_support.name}</td>
                                                    <td style="text-align:center">${response.log_data[i].user_p_i_c.name}</td>
                                        </tr>`;
    
                        }
                        callback($(`
                          <table class="table_detail datatable-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No</th>
                                    <th style="text-align:center">Created at</th>
                                    <th style="text-align:center">Subject</th>
                                    <th style="text-align:center">Assign Status</th>
                                    <th style="text-align:center">Status WO</th>
                                    <th style="text-align:center">PIC</th>
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
                    console.log('failed :' + response);
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
    function save_wo(){
        data ={
            'request_type':$('#request_type').val(),
            'categories':$('#categories').val(),
            'problem_type':$('#problem_type').val(),
            'subject':$('#subject').val(),
            'add_info':$('#add_info').val(),
            'departement_for':$('#departement_for').val(),
        }
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('save_wo')}}",
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
</script>