<script>
        var arrayDetailRFP =[];
        var arraySubDetailRFP =[];
        var outputArray  =[]
        var authId = $('#authId').val()
        $('#btnEditArrayDetail').prop('hidden', true)
        $('#btnEditArraySubDetail').prop('hidden', true)
        getrfpTransaction()
        $('#addRFP').on('click', function(){
            getName('getMasterTeam','selectTeam','Team')
            getDepartementName('get_departement_name','selectDepartement','Departement')
        })
        onChange('selectDepartement','departement')
        $('#selectDepartement').on('change', function(){
            getSelect('get_categories_id',{'initial':$('#selectDepartement').val()},'selectCategories', 'Categories')
        })
        onChange('selectCategories','categories')
        onChange('selectPICSubDetail','userIdSubDetail')
        $('#detailTeamTable').prop('hidden', true)

    // Select Team
        $('#selectTeam').on('change', function(){
            var id =  $('#selectTeam').val()
            $('#team').val(id)

            $('#detailTeamTable').prop('hidden', false)
            $('#detailTeamTable').DataTable().clear();
            $('#detailTeamTable').DataTable().destroy();
                $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'getMasterTeamDetail',
                type: "get",
                dataType: 'json',
                data :{
                    'id':id
                },
                async: true,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    var data ='';
                    var x =response.table
                    for(i = 0 ;i < x.length ; i ++){
                        data += `
                                <tr>
                                    <td>${x[i].username}</td>
                                    <td>${x[i].departementName}</td>
                                    <td>${x[i].jabatanName}</td>
                                    <td>${x[i].position == 1 ?'Staff':'Leader'}</td>
                                </tr>
                        `;
                    }
                    $('#detailTeamTable > tbody:first').html(data);
                    $('#detailTeamTable').DataTable({
                        scrollX  : true,
                        scrollY  :220
                    }).columns.adjust()
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                });
        })

    // End Select Team

    // Second Modal
        $(document).ready(function () {
            $('#editSubDetailRFP').on('show.bs.modal', function () {
                $('#listSubDetailRFP').css('z-index', 1039);
            });

            $('#editSubDetailRFP').on('hidden.bs.modal', function () {
                $('#listSubDetailRFP').css('z-index', 1041);
            });
        });
        $(document).ready(function () {
            $('#updateRFPSubDetail').on('show.bs.modal', function () {
                $('#listSubDetailRFP').css('z-index', 1039);
            });

            $('#updateRFPSubDetail').on('hidden.bs.modal', function () {
                $('#listSubDetailRFP').css('z-index', 1041);
            });
        });
        $(document).ready(function () {
            $('#infoSubDetailRFP').on('show.bs.modal', function () {
                $('#listSubDetailRFP').css('z-index', 1039);
            });

            $('#infoSubDetailRFP').on('hidden.bs.modal', function () {
                $('#listSubDetailRFP').css('z-index', 1041);
            });
        });
    // End Second Modal
 

    // Add Detail RFP
        $('#btnSaveRFP').on('click', function(e){
            e.preventDefault();
            var formData        = new FormData();    
            var title    = $('#title').val()
            var description      = $('#description').val()
            var startDate      = $('#startDate').val()
            var dateline      = $('#dateline').val()
            var team      = $('#team').val()
            var departement      = $('#departement').val()
            var categories      = $('#categories').val()
        

            var attachmentRFP      = $('#attachmentRFP')[0].files[0];
            formData.append('attachmentRFP',attachmentRFP)
            formData.append('title',title)
            formData.append('description',description)
            formData.append('startDate',startDate)
            formData.append('dateline',dateline)
            formData.append('team',team)
            formData.append('categories',categories)
            formData.append('departement',departement)
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'saveRFPTransaction',
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
                        toastr['success'](response.meta.message);
                        window.location = 'rfp_transaction';
                    },
                    error: function(response) {
                        $('.message_error').html('')
                        swal.close();
                        if(response.status == 500){
                            console.log(response)
                            toastr['error'](response.responseJSON.meta.message);
                            return false
                        }
                        if(response.status === 422)
                        {
                            $.each(response.responseJSON.errors, (key, val) => 
                                {
                                    $('span.'+key+'_error').text(val)
                                });
                        }else{
                            toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    }
                });
        })
        $('#rfpTable').on('click', '.addDetailRFP', function() {
            $('#activityDetail').val('')
            $('#descriptionDetail').val('')
            $('#listDetailRFPTable').prop('hidden',true)
            $('#detailRFPTable').DataTable().clear();
            $('#detailRFPTable').DataTable().destroy();
            $('#rfpModuleTable').DataTable().clear();
            $('#rfpModuleTable').DataTable().destroy();
            var id = $(this).data('id');
            var request = $(this).data('request');
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'getrfpTransactionDetail',
                type: "get",
                dataType: 'json',
                async: true,
                data :{
                    'id':id,
                    'request_code':request,
                },
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    var dateline = response.detail.dateline.split(' ')
                    var start_date = response.detail.start_date.split(' ')
                    $('#rfpIdDetail').val(id)
                    $('#requestCodeDetail').val(response.detail.request_code)
                    $('#departementDetail').val(response.detail.departement_relation.name)
                    $('#titleDetail').val(response.detail.title)
                    $('#locationDetail').val(response.detail.location.name)
                    $('#userNameDetail').val(response.detail.user_relation.name)
                    $('#categoryDetail').val(response.detail.category_relation.name)
                    $('#startDateMaster').val(start_date[0])
                    $('#deadlineMaster').val(dateline[0])
                    $('#datelineDetail').val(start_date[0])
                    $('#startDateDetail').val(start_date[0])

                    var data =''
                    for(i= 0; i < response.module.length; i++){
                        var deadline = response.module[i].dateline.split(' ')
                        data += `
                            <tr>
                                <td style="text-align:center">${response.module[i].start_date}</td>
                                <td style="text-align:center">${deadline[0]}</td>
                                <td>${response.module[i].title}</td>
                            </tr>
                        `;
                    }
                $('#rfpModuleTable > tbody:first').html(data);
                // $('#rfpModuleTable').DataTable({
                //     scrollX  : true,
                //     autoWidth:true
                // }).columns.adjust()
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                });
        });
        $('#btnAddArrayDetail').on('click',function(){
            if($('#activityDetail').val() =='' || $('#descriptionDetail').val() ==''){
                toastr['warning']('Activity and Description cannot be null');
            }else{
                var detailRFP =[
                    $('#requestCodeDetail').val(),
                    $('#activityDetail').val(),
                    $('#descriptionDetail').val(),
                    $('#datelineDetail').val(),
                    $('#startDateDetail').val(),
                ];
                arrayDetailRFP.push(detailRFP)
                $('#listDetailRFPTable').prop('hidden', false)
                $('#detailRFPTable').DataTable().clear();
                $('#detailRFPTable').DataTable().destroy();
                var data =''
                for(i =0 ; i < arrayDetailRFP.length; i++){
                    data +=`
                        <tr>
                            <td style="text-align:center">${arrayDetailRFP[i][0]}</td>
                            <td>${arrayDetailRFP[i][1]}</td>
                            <td style="text-align:center">${arrayDetailRFP[i][4]}</td>
                            <td style="text-align:center">${arrayDetailRFP[i][3]}</td>
                            <td style="text-align:center">
                                <button class="btn btn-sm btn-danger deleteArrayRFP" data-id ="${i}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-info editArrayRFP" data-id ="${i}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    `
                }
                $('#detailRFPTable > tbody:first').html(data);
                $('#detailRFPTable').DataTable({
                    scrollX  : true,
                   
                    autoWidth:true
                }).columns.adjust()
                var datelineBefore = $('#datelineDetail').val()
                $('#activityDetail').val('')    
                $('#descriptionDetail').val('')    
                $('#startDateDetail').val(datelineBefore)
            }
        })
        $('#detailRFPTable').on('click', '.deleteArrayRFP', function(){
            var id = $(this).data("id");
            $('#detailRFPTable').DataTable().clear();
            $('#detailRFPTable').DataTable().destroy();
            arrayDetailRFP.splice(id,1)
            var data =''
            for(i = 0; i < arrayDetailRFP.length; i++){
                data +=`
                    <tr>
                        <td style="text-align:center">${arrayDetailRFP[i][0]}</td>
                        <td>${arrayDetailRFP[i][1]}</td>
                        <td style="text-align:center">${arrayDetailRFP[i][4]}</td>
                        <td style="text-align:center">${arrayDetailRFP[i][3]}</td>
                        <td style="text-align:center">
                            <button class="btn btn-sm btn-danger deleteArrayRFP" data-id ="${i}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-info editArrayRFP" data-id ="${i}">
                                    <i class="fas fa-edit"></i>
                                </button>
                        </td>
                    </tr>
                `
            }
            $('#detailRFPTable > tbody:first').html(data);
            $('#detailRFPTable').DataTable({
                scrollX  : true,
             
                autoWidth:true
            }).columns.adjust()    
        });
        // $('#btnSaveRFPDetail').on('click', function(){
        //     if(arrayDetailRFP.length == 0){
        //         toastr['error']('please insert data');
        //     }else{
        //         var data ={
        //             'array':arrayDetailRFP
        //         }
        //         saveRepo('saveRFPDetail',data,'rfp_transaction')
        //     }
        // })
        $('#detailRFPTable').on('click', '.editArrayRFP', function(){
            var id = $(this).data("id");
            $('#idArrayDetail').val(id)
            $('#btnEditArrayDetail').prop('hidden', false)
            $('#btnAddArrayDetail').prop('hidden', true)
            $('#activityDetail').val(arrayDetailRFP[id][1])
            $('#descriptionDetail').val(arrayDetailRFP[id][2])
            $('#startDateDetail').val(arrayDetailRFP[id][4])
            $('#datelineDetail').val(arrayDetailRFP[id][3])
        });
        $('#btnEditArrayDetail').on('click', function(){
            $('#btnEditArrayDetail').prop('hidden', true)
            $('#btnAddArrayDetail').prop('hidden', false)
            $('#detailRFPTable').DataTable().clear();
            $('#detailRFPTable').DataTable().destroy();
            var id =   $('#idArrayDetail').val()
            arrayDetailRFP[id][1] = $('#activityDetail').val()
            arrayDetailRFP[id][2] = $('#descriptionDetail').val()
            arrayDetailRFP[id][4] = $('#startDateDetail').val()
            arrayDetailRFP[id][3] = $('#datelineDetail').val()
            var data =''
            for(i = 0; i < arrayDetailRFP.length; i++){
                data +=`
                    <tr>
                        <td style="text-align:center">${arrayDetailRFP[i][0]}</td>
                        <td>${arrayDetailRFP[i][1]}</td>
                        <td style="text-align:center">${arrayDetailRFP[i][4]}</td>
                        <td style="text-align:center">${arrayDetailRFP[i][3]}</td>
                        <td style="text-align:center">
                            <button class="btn btn-sm btn-danger deleteArrayRFP" data-id ="${i}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-sm btn-info editArrayRFP" data-id ="${i}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                `
            }
            $('#detailRFPTable > tbody:first').html(data);
            $('#detailRFPTable').DataTable({
                scrollX  : true,
           
                autoWidth:true
            }).columns.adjust()    
            var datelineBefore = $('#datelineDetail').val()
                $('#activityDetail').val('')    
                $('#descriptionDetail').val('')    
                $('#startDateDetail').val(datelineBefore)
        })
        $('#btnSaveRFPDetail').on('click', function(){
            if(arrayDetailRFP.length == 0){
                toastr['error']('please insert data');
            }else{
                var data ={
                    'array':arrayDetailRFP
                }
                saveRepo('saveRFPDetail',data,'rfp_transaction')
            }
        })
    // End Add Detail RFP\

    // Add SubDetail RFP
        $(document).on("click", ".addSubDetailRFP", function(){
            $('#SubdetailRFPTable').prop('hidden', true)
            var id = $(this).data('id');
            var detail = $(this).data('detail');
            var request = $(this).data('request');
            $('#activitySubDetail').val('')    
            $('#descriptionSubDetail').val('')    
               
            $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'editRFPDetail',
            type: "get",
            data:{
                'id':id,
                'request_code':request,
                'detail':detail,
            },
            dataType: 'json',
            async: true,
            success: function(response) {
                var deadline = response.data.dateline.split(' ')
                $('#detailCodeRFPDetail').val(response.data.detail_code)
                $('#requestCodeRFPDetail').val(request)
                $('#idRFPDetail').val(id)
                $('#deadlineRFPSubDetail').val(deadline[0])
                $('#startDateRFPSubDetail').val(response.data.start_date)
                $('#startDateSubDetail').val(response.data.start_date)
                $('#datelineSubDetail').val(response.data.start_date)
                $('#activityRFPDetail').val(response.data.title)
                $('#requestBySubDetail').val(response.data.user_relation.name)
                $('#selectPICSubDetail').empty()
                $('#selectPICSubDetail').append('<option value="">Choose PIC</option>')
                $('#rfpSubModuleTable').DataTable().clear();
                $('#rfpSubModuleTable').DataTable().destroy();
                    var data =''
                    for(i = 0 ; i < response.module.length ; i++){
                        var deadline = response.module[i].dateline.split(' ');
                        data +=`
                            <tr>
                                <td style="text-align:center">${response.module[i].start_date}</td>
                                <td style="text-align:center">${deadline[0]}</td>
                                <td>${response.module[i].title}</td>
                                <td>${response.module[i].user_relation.name}</td>
                            </tr>
                        `

                    }
                    $('#rfpSubModuleTable > tbody:first').html(data);
                    // $('#rfpSubModuleTable').DataTable({
                    //     scrollX  : true,
                    //     autoWidth:true
                    // }).columns.adjust()    
                $.each(response.user,function(i,data,param){
                    $('#selectPICSubDetail').append('<option value="'+data.id+'" data-name="'+data.name+'">'+data.id +' - ' + data.name +'</option>');
                });
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
        })

        $('#btnAddArraySubDetail').on('click', function(){
            if($('#userIdSubDetail').val() == '' || $('#activitySubDetail').val() == '' || $('#descriptionSubDetail').val() =='' ){
                toastr['warning']('Activity,PIC, and Description cannot be null');
            }else{
                var pic = $("#selectPICSubDetail").select2().find(":selected").data("name");
                var subDetailRFP =[
                    $('#detailCodeRFPDetail').val(),
                    $('#activitySubDetail').val(),
                    $('#descriptionSubDetail').val(),
                    $('#datelineSubDetail').val(),
                    $('#userIdSubDetail').val(),
                    $('#startDateSubDetail').val(),
                    $('#requestCodeRFPDetail').val(),
                    pic
                ];
                arraySubDetailRFP.push(subDetailRFP)
                $('#SubdetailRFPTable').prop('hidden', false)
                $('#SubdetailRFPTable').DataTable().clear();
                $('#SubdetailRFPTable').DataTable().destroy();
                var data =''
                for(i =0 ; i < arraySubDetailRFP.length; i++){
                    data +=`
                        <tr>
                            <td style="text-align:center">${arraySubDetailRFP[i][0]}</td>
                            <td>${arraySubDetailRFP[i][1]}</td>
                            <td style="text-align:center">${arraySubDetailRFP[i][5]}</td>
                            <td style="text-align:center">${arraySubDetailRFP[i][3]}</td>
                            <td style="text-align:center">${arraySubDetailRFP[i][7]}</td>
                            <td style="text-align:center">
                                <button class="btn btn-sm btn-danger deleteArrayRFP" data-id ="${i}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-info editArrayRFP" data-id ="${i}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    `
                }
                $('#SubdetailRFPTable > tbody:first').html(data);
                $('#SubdetailRFPTable').DataTable({
                    scrollX  : true,
                   
                    autoWidth:true
                }).columns.adjust()
                $('#activitySubDetail').val('')    
                $('#descriptionSubDetail').val('')    
                var datelineSubDetail = $('#datelineSubDetail').val()
                $('#startDateSubDetail').val(datelineSubDetail)
                $('#selectPICSubDetail').val('')
                $('#selectPICSubDetail').select2().trigger('change');
            }
        })

        $('#SubdetailRFPTable').on('click', '.deleteArrayRFP', function(){
            var id = $(this).data("id");
            $('#SubdetailRFPTable').DataTable().clear();
            $('#SubdetailRFPTable').DataTable().destroy();
            arraySubDetailRFP.splice(id,1)
            var data =''
            for(i = 0; i < arraySubDetailRFP.length; i++){
                data +=`
                    <tr>
                        <td style="text-align:center">${arraySubDetailRFP[i][0]}</td>
                        <td>${arraySubDetailRFP[i][1]}</td>
                        <td style="text-align:center">${arraySubDetailRFP[i][5]}</td>
                        <td style="text-align:center">${arraySubDetailRFP[i][3]}</td>
                        <td style="text-align:center">${arraySubDetailRFP[i][4]}</td>
                        <td style="text-align:center">
                                <button class="btn btn-sm btn-danger deleteArrayRFP" data-id ="${i}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-info editArrayRFP" data-id ="${i}">
                                    <i class="fas fa-edit"></i>
                                </button>
                        </td>
                    </tr>
                `
            }
            $('#SubdetailRFPTable > tbody:first').html(data);
            $('#SubdetailRFPTable').DataTable({
                scrollX  : true,
                autoWidth:true
            }).columns.adjust()    
        });
        $('#SubdetailRFPTable').on('click', '.editArrayRFP', function(){
            $('#btnEditArraySubDetail').prop('hidden', false)
            $('#btnAddArraySubDetail').prop('hidden', true)
            var id = $(this).data("id");
            $('#idSubArrayDetail').val(id)
            $('#selectPICSubDetail').val(arraySubDetailRFP[id][4])
            $('#selectPICSubDetail').select2().trigger('change');
            $('#activitySubDetail').val(arraySubDetailRFP[id][1])
            $('#descriptionSubDetail').val(arraySubDetailRFP[id][2])
            $('#startDateSubDetail').val(arraySubDetailRFP[id][5])
            $('#datelineSubDetail').val(arraySubDetailRFP[id][3])
            $('#userIdSubDetail').val(arraySubDetailRFP[id][4])
        });
        $('#btnSaveSubDetailRFP').on('click', function(){
            if(arraySubDetailRFP.length == 0){
                toastr['error']('please insert data');
            }else{
                var data ={
                    'array':arraySubDetailRFP,
                    'request_code':$('#requestCodeRFPDetail').val(),
                }
                saveRepo('saveRFPSubDetail',data,'rfp_transaction')
            }
        })
        $('#btnEditArraySubDetail').on('click', function(){
            $('#btnEditArraySubDetail').prop('hidden', true)
            $('#btnAddArraySubDetail').prop('hidden', false)
            $('#SubdetailRFPTable').DataTable().clear();
            $('#SubdetailRFPTable').DataTable().destroy();
            var id = $('#idSubArrayDetail').val()
            arraySubDetailRFP[id][1] = $('#activitySubDetail').val()
            arraySubDetailRFP[id][2] = $('#descriptionSubDetail').val()
            arraySubDetailRFP[id][3] = $('#datelineSubDetail').val()
            arraySubDetailRFP[id][4] = $('#userIdSubDetail').val()
            arraySubDetailRFP[id][5] = $('#startDateSubDetail').val()
            var data =''
            for(i = 0; i < arraySubDetailRFP.length; i++){
                data +=`
                    <tr>
                        <td style="text-align:center">${arraySubDetailRFP[i][0]}</td>
                        <td>${arraySubDetailRFP[i][1]}</td>
                        <td style="text-align:center">${arraySubDetailRFP[i][5]}</td>
                        <td style="text-align:center">${arraySubDetailRFP[i][3]}</td>
                        <td style="text-align:center">${arraySubDetailRFP[i][4]}</td>
                        <td style="text-align:center">
                                <button class="btn btn-sm btn-danger deleteArrayRFP" data-id ="${i}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-info editArrayRFP" data-id ="${i}">
                                    <i class="fas fa-edit"></i>
                                </button>
                        </td>
                    </tr>
                `
            }
            $('#SubdetailRFPTable > tbody:first').html(data);
            $('#SubdetailRFPTable').DataTable({
                scrollX  : true,
                autoWidth:true
            }).columns.adjust()    
            $('#activitySubDetail').val('')    
            $('#descriptionSubDetail').val('')    
            var datelineSubDetail = $('#datelineSubDetail').val()
            $('#startDateSubDetail').val(datelineSubDetail)
            $('#selectPICSubDetail').val('')
            $('#selectPICSubDetail').select2().trigger('change');
        })
        $('#startDateDetail').on('change', function(){
            var startDateMaster = $('#startDateMaster').val()
            const d = new Date(startDateMaster)
            const startDateMasterDate = d.toISOString().split('T')[0];
            const e = new Date($('#startDateDetail').val())
            const startDateDetailDate = e.toISOString().split('T')[0];
            if(startDateDetailDate < startDateMasterDate) {
                toastr['error']('Cannot backdate'); 
                $('#startDateDetail').val(startDateMaster)
                return false 
            }
        })
        $('#datelineDetail').on('change', function(){
            var startDateDetail = $('#startDateDetail').val()
            const d = new Date(startDateDetail)
            const startDateDetailDate = d.toISOString().split('T')[0];
            const e = new Date($('#datelineDetail').val())
            const datelineDetailDate = e.toISOString().split('T')[0];
            const f = new Date($('#deadlineMaster').val())
            const deadlineMasterDate = f.toISOString().split('T')[0];
            if(datelineDetailDate < startDateDetailDate || datelineDetailDate > deadlineMasterDate) {
                toastr['error']('Cannot backdate'); 
                $('#datelineDetail').val(startDateDetail)
                return false 
            }
        })

        $('#startDateSubDetail').on('change', function(){
            var startDateRFPSubDetail = $('#startDateRFPSubDetail').val()
            const d = new Date(startDateRFPSubDetail)
            const startDateRFPSubDetailDate = d.toISOString().split('T')[0];
            const e = new Date($('#startDateSubDetail').val())
            const startDateSubDetailDate = e.toISOString().split('T')[0];
            if(startDateSubDetailDate < startDateRFPSubDetailDate) {
                toastr['error']('Cannot backdate'); 
                $('#startDateSubDetail').val(startDateRFPSubDetail)
                return false 
            }
        })
        $('#datelineSubDetail').on('change', function(){
            var startDateSubDetail = $('#startDateSubDetail').val()
            var deadlineRFPSubDetail = $('#deadlineRFPSubDetail').val()
            const d = new Date(startDateSubDetail)
            const startDateSubDetailDate = d.toISOString().split('T')[0];
            const e = new Date($('#datelineSubDetail').val())
            const datelineSubDetailDate = e.toISOString().split('T')[0];
            const f = new Date($('#deadlineRFPSubDetail').val())
            const deadlineRFPDetailDate = f.toISOString().split('T')[0];
            if(datelineSubDetailDate < startDateSubDetailDate || datelineSubDetailDate > deadlineRFPDetailDate ) {
                toastr['error']('Cannot backdate'); 
                $('#datelineSubDetail').val(startDateSubDetail)
                return false 
            }
          
        })
        $('#dateline').on('change', function(){
            var startDate = $('#startDate').val()
            const d = new Date(startDate)
            const startDateDate = d.toISOString().split('T')[0];
            const e = new Date($('#dateline').val())
            const datelineDate = e.toISOString().split('T')[0];
            if(datelineDate < startDateDate) {
                toastr['error']('Cannot backdate'); 
                $('#dateline').val(startDate)
                return false 
            }
        })
    // End Add SubDetail RFP

    // Edit RFP
        $(document).on("click", ".editDetailRFP", function(){
            var id = $(this).data('id');
            var request = $(this).data('request');
            var detail = $(this).data('detail');
         
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'editRFPDetail',
                type: "get",
                dataType: 'json',
                async: true,
                data :{
                    'id':id
                },
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    var dateline = response.data.dateline.split(' ')
                    $('#rfpIdEdit').val(id)
                    $('#detailCodeEdit').val(detail)
                    $('#requestCodeEdit').val(request)
                    $('#titleEdit').val(response.data.title)
                    $('#descriptionEdit').val(response.data.description)
                    $('#startDateEdit').val(response.data.start_date)
                    $('#datelineEdit').val(dateline[0])
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                });
        })
        $('#btnEditRFP').on('click', function(){
            var data ={
                'id':$('#rfpIdEdit').val(),
                'detailCodeEdit':$('#detailCodeEdit').val(),
                'requestCodeEdit':$('#requestCodeEdit').val(),
                'titleEdit':$('#titleEdit').val(),
                'descriptionEdit':$('#descriptionEdit').val(),
                'startDateEdit':$('#startDateEdit').val(),
                'datelineEdit':$('#datelineEdit').val(),
            }
            store('updateRFPDetail',data,'rfp_transaction')
        })
    // End Edit RFP
    
    // Edit RFP Master    
        $('#rfpTable').on('click', '.editMasterRFP', function() {
            var id = $(this).data('id');
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'getrfpTransactionDetail',
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data :{
                        'id':id
                    },
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                        var dateline = response.detail.dateline.split(' ')
                        var startDate = response.detail.start_date.split(' ')
                        $('#rfpMasterIdEdit').val(id)
                        $('#requestCodeMasterEdit').val(response.detail.request_code)
                        $('#titleMasterEdit').val(response.detail.title)
                        $('#descriptionMasterEdit').val(response.detail.description)
                        $('#startDateMasterEdit').val(startDate[0])
                        $('#datelineMasterEdit').val(dateline[0])
                    
                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    });
        })
        $('#rfpTable').on('click', '.detailRFPMaster', function() {
            var id = $(this).data('id');
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'getrfpTransactionDetail',
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data :{
                        'id':id
                    },
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                        var dateline = response.detail.dateline.split(' ')
                        var startDate = response.detail.start_date.split(' ')
                        $('#rfpMasterIdInfo').val(id)
                        $('#requestCodeMasterInfo').val(response.detail.request_code)
                        $('#titleMasterInfo').val(response.detail.title)
                        $('#descriptionMasterInfo').val(response.detail.description)
                        $('#startDateMasterInfo').val(startDate[0])
                        $('#datelineMasterInfo').val(dateline[0])
                        $('#attachmentRFPMaster').empty()
                        if(response.detail.attachment){
                            var fileName = response.detail.attachment.split('/')
                            $('#attachmentRFPMaster').append(`
                            <a target="_blank" href="{{URL::asset('${response.detail.attachment}')}}" class="ml-3" style="color:blue;">
                                <i class="far fa-file" style="color: red;font-size: 20px;"></i>
                                ${fileName[2]}</a>
                            `);
                        }else{
                            $('#attachmentRFPMaster').append(`: -`);
                        }
                    
                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    });
        })
        $('#btnMasterEditRFP').on('click',function(){
            var data ={
                'id':$('#rfpMasterIdEdit').val(),
                'requestCodeMasterEdit':$('#requestCodeMasterEdit').val(),
                'titleMasterEdit':$('#titleMasterEdit').val(),
                'descriptionMasterEdit':$('#descriptionMasterEdit').val(),
                'startDateMasterEdit':$('#startDateMasterEdit').val(),
                'datelineMasterEdit':$('#datelineMasterEdit').val(),
            }
            store('updateMasterRFP',data,'rfp_transaction')
        })
    // End Edit RFP Master

    // List Sub Detail RFP
        $(document).on("click", ".editRFPSubDetail", function(){
            var id = $(this).data('id');  
            var subdetail = $(this).data('subdetail');  
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'getSubDetailRFP',
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data :{
                        'id':id
                    },
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                    
                    var dateline = response.data.dateline.split(' ')
                    
                    $('#rfpSubDetailIdEdit').val(id)
                    $('#subDetailCodeSubDetailEdit').val(subdetail)
                    $('#titleSubDetailEdit').val(response.data.title)
                    $('#descriptionSubDetailEdit').val(response.data.description)
                    $('#startDateSubDetailEdit').val(response.data.start_date)
                    $('#usernameSubDetailEdit').val(response.data.user_relation.name)
                    $('#datelineSubDetailEdit').val(dateline[0])
                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    });

        })
        $(document).on("click", ".updateRFPSubDetail ", function(){
            var id = $(this).data('id');  
            var subdetail = $(this).data('subdetail');
             $('#addInfoUpdate').val('') 
             $('#progressUpdate').val('') 
             $('#selectProgressUpdate').empty() 
             $('#selectProgressUpdate').append('<option value=""> Choose Progress </option>') 
             $('#selectProgressUpdate').append('<option value="0">On Progress </option>') 
             $('#selectProgressUpdate').append('<option value="1">Done </option>') 
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'getSubDetailRFP',
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data :{
                        'id':id
                    },
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                    console.log(response)
                    var dateline = response.data.dateline.split(' ')
                        $('#rfpSubDetailIdUpdate').val(id)
                        $('#subDetailCodeSubDetailUpdate').val(subdetail)
                        $('#titleSubDetailUpdate').val(response.data.title)
                        $('#descriptionSubDetailUpdate').val(response.data.description)
                        $('#startDateSubDetailUpdate').val(response.data.start_date)
                        $('#requestCodeUpdateProgress').val(response.data.request_code)
                        $('#usernameSubDetailUpdate').val(response.data.user_relation.name)
                        $('#datelineSubDetailUpdate').val(dateline[0])
                        
                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    });

        })
        $(document).on("click", ".listSubDetailRFP", function(){
            var id = $(this).data('id');
            var request = $(this).data('request');
            $('#listSubDetailTable').DataTable().clear();
            $('#listSubDetailTable').DataTable().destroy();
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'getRFPSubDetail',
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data :{
                        'detail_code':request
                    },
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                        var data=''
                        $('#listDetailCode').val(request)
                        for(i = 0 ; i < response.data.length; i++ ){
                            var dateline = response.data[i].dateline.split(' ')
                            var editButton = ``;
                            var updateProgress= ``;
                           
                            if(response.data[i].rfp_detail_relation.user_id == authId){
                                editButton      = `<button title="Edit RFP Sub Detail" class="editRFPSubDetail btn btn-sm btn-primary rounded"data-id="${response.data[i]['id']}" data-subdetail="${response.data[i].subdetail_code}" data-toggle="modal" data-target="#editSubDetailRFP">
                                            <i class="fas fa-edit"></i> 
                                        </button>`;
                            }
                            var infoSubDetailRFP =`<button title="RFP Sub Detail" class="infoRFPSubDetail btn btn-sm btn-info rounded"data-id="${response.data[i]['id']}" data-subdetail="${response.data[i].subdetail_code}" data-toggle="modal" data-target="#infoSubDetailRFP">
                                            <i class="fas fa-eye"></i> 
                                        </button>`
                                if(response.data[i].user_id == authId){
                                  
                                        if(response.data[i].status ==  0)
                                updateProgress      = `<button title="Update RFP Sub Detail" class="updateRFPSubDetail btn btn-sm btn-warning rounded"data-id="${response.data[i]['id']}" data-subdetail="${response.data[i].subdetail_code}" data-toggle="modal" data-target="#updateRFPSubDetail">
                                                            <i class="fas fa-edit"></i> 
                                                        </button>`
                                }
                               
                            data +=`
                                <tr>
                                    <td class='subdetails-control'></td>
                                    <td style="text-align:center;">${response.data[i].start_date}</td>
                                    <td style="text-align:center;">${dateline[0]}</td>
                                    <td style="text-align:center;" class="subdetail_code">${response.data[i].subdetail_code}</td>
                                    <td style="text-align:left;">${response.data[i].title}</td>
                                    <td style="text-align:left;">${response.data[i].user_relation.name}</td>
                                    <td style="text-align:center;">${response.data[i].status  == 0 ?'On Progress' : 'Done'}</td>
                                    <td style="width:5%">
                                        ${editButton} ${updateProgress} ${infoSubDetailRFP}
                                    
                                    </td>
                                </tr>
                            `;
                        }
                        $('#listSubDetailTable > tbody:first').html(data);
                            var table = $('#listSubDetailTable').DataTable({
                                scrollX  : true,
                                scrollY  :305,
                                autoWidth:true
                            }).columns.adjust()    
                            $('#listSubDetailTable tbody').off().on('click', 'td.subdetails-control', function (e) {
                            var tr = $(this).closest("tr");
                            var row =   table.row( tr );
                            if ( row.child.isShown() ) {
                                // This row is already open - close it
                                row.child.hide();
                                tr.removeClass( 'shown' );
                            }
                            else {
                                // Open this row
                                subdetail_log(row.child,$(this).parents("tr").find('td.subdetail_code').text()) ;
                                tr.addClass( 'shown' );
                            }
                        } );  
                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    });
        })
        $('#btnSubDetailEditRFP').on('click', function(){
            var data={
                'id' :$('#rfpSubDetailIdEdit').val(),
                'subDetailCodeSubDetailEdit':$('#subDetailCodeSubDetailEdit').val(),
                'titleSubDetailEdit':$('#titleSubDetailEdit').val(),
                'descriptionSubDetailEdit':$('#descriptionSubDetailEdit').val(),
                'startDateSubDetailEdit':$('#startDateSubDetailEdit').val(),
                'datelineSubDetailEdit':$('#datelineSubDetailEdit').val(),
            }
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'updateRFPSubDetail',
                    type: "POST",
                    dataType: 'json',
                    async: true,
                    data: data,
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                        $('.message_error').html('')
                        toastr['success'](response.meta.message);
                        $('#editSubDetailRFP').modal('hide');
                        getSubDetailList()
                        
                    },
                    error: function(response) {
                        $('.message_error').html('')
                        swal.close();
                        if(response.status == 500){
                            console.log(response)
                            toastr['error'](response.responseJSON.meta.message);
                            return false
                        }
                        if(response.status === 422)
                        {
                            $.each(response.responseJSON.errors, (key, val) => 
                                {
                                    $('span.'+key+'_error').text(val)
                                });
                        }else{
                            toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    }
                }); 
            
        })
        onChange('selectProgressUpdate','progressUpdate')
        $('#btnSubDetailUpdateRFP').on('click', function(){
            var data ={
                'addInfoUpdate':$('#addInfoUpdate').val(),
                'progressUpdate':$('#progressUpdate').val(),
                'request_code':$('#requestCodeUpdateProgress').val(),
                'startDateSubDetailUpdate':$('#startDateSubDetailUpdate').val(),
                'id':$('#subDetailCodeSubDetailUpdate').val(),
                'detail_code':$('#listDetailCode').val(),

            }
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'updateRFPSubDetailProgress',
                    type: "POST",
                    dataType: 'json',
                    async: true,
                    data: data,
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                        $('.message_error').html('')
                        toastr['success'](response.meta.message);
                        $('#updateRFPSubDetail').modal('hide');
                        getSubDetailList()
                        getrfpTransaction()
                    },
                    error: function(response) {
                        $('.message_error').html('')
                        swal.close();
                        if(response.status == 500){
                            console.log(response)
                            toastr['error'](response.responseJSON.meta.message);
                            return false
                        }
                        if(response.status === 422)
                        {
                            $.each(response.responseJSON.errors, (key, val) => 
                                {
                                    $('span.'+key+'_error').text(val)
                                });
                        }else{
                            toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    }
                }); 
        })
    // End List Sub Detail RFP

    // info RFP Sub Detail
        $(document).on("click", ".infoRFPSubDetail", function(){
            var id = $(this).data('id');  
            var subdetail = $(this).data('subdetail');  
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'getSubDetailRFP',
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data :{
                        'id':id
                    },
                    beforeSend: function() {
                        SwalLoading('Please wait ...');
                    },
                    success: function(response) {
                        swal.close();
                    
                    var dateline = response.data.dateline.split(' ')
                    
                    $('#rfpSubDetailIdInfo').val(id)
                    $('#subDetailCodeSubDetailInfo').val(subdetail)
                    $('#titleSubDetailInfo').val(response.data.title)
                    $('#descriptionSubDetailInfo').val(response.data.description)
                    $('#startDateSubDetailInfo').val(response.data.start_date)
                    $('#usernameSubDetailInfo').val(response.data.user_relation.name)
                    $('#datelineSubDetailInfo').val(dateline[0])
                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                        }
                    });

        })
    // End info RFP Sub Detail

    // Function
        function getSubDetailList(){
            var request =$('#listDetailCode').val()
            $('#listSubDetailTable').DataTable().clear();
            $('#listSubDetailTable').DataTable().destroy();
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'getRFPSubDetail',
                type: "get",
                dataType: 'json',
                async: true,
                data :{
                    'detail_code':request
                },
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    var data=''
                    $('#listDetailCode').val(request)
                    for(i = 0 ; i < response.data.length; i++ ){
                        var dateline = response.data[i].dateline.split(' ')
                        var editButton = ``;
                        var updateProgress= ``;
                        var infoSubDetailRFP =`<button title="RFP Sub Detail" class="infoRFPSubDetail btn btn-sm btn-info rounded"data-id="${response.data[i]['id']}" data-subdetail="${response.data[i].subdetail_code}" data-toggle="modal" data-target="#infoSubDetailRFP">
                                          <i class="fas fa-eye"></i> 
                                    </button>`
                            if(response.data[i].user_id == authId){
                                editButton      = `<button title="Edit RFP Sub Detail" class="editRFPSubDetail btn btn-sm btn-primary rounded"data-id="${response.data[i]['id']}" data-subdetail="${response.data[i].subdetail_code}" data-toggle="modal" data-target="#editSubDetailRFP">
                                          <i class="fas fa-edit"></i> 
                                    </button>`;
                                    if(response.data[i].status ==  0)
                            updateProgress      = `<button title="Update RFP Sub Detail" class="updateRFPSubDetail btn btn-sm btn-warning rounded"data-id="${response.data[i]['id']}" data-subdetail="${response.data[i].subdetail_code}" data-toggle="modal" data-target="#updateRFPSubDetail">
                                                        <i class="fas fa-edit"></i> 
                                                    </button>`
                            }
                        data +=`
                            <tr>
                                <td class='subdetails-control'></td>
                                <td style="text-align:center;">${response.data[i].start_date}</td>
                                <td style="text-align:center;">${dateline[0]}</td>
                                <td style="text-align:center;" class="subdetail_code">${response.data[i].subdetail_code}</td>
                                <td style="text-align:left;">${response.data[i].title}</td>
                                <td style="text-align:left;">${response.data[i].user_relation.name}</td>
                                <td style="text-align:center;">${response.data[i].status  == 0 ?'On Progress' : 'Done'}</td>
                                <td style="width:5%">
                                    ${editButton} ${updateProgress} ${infoSubDetailRFP}
                                 
                                </td>
                            </tr>
                        `;
                    }
                    $('#listSubDetailTable > tbody:first').html(data);
                        var table = $('#listSubDetailTable').DataTable({
                            scrollX  : true,
                            scrollY  :305,
                            autoWidth:true
                        }).columns.adjust()    
                        $('#listSubDetailTable tbody').off().on('click', 'td.subdetails-control', function (e) {
                        var tr = $(this).closest("tr");
                        var row =   table.row( tr );
                        if ( row.child.isShown() ) {
                            // This row is already open - close it
                            row.child.hide();
                            tr.removeClass( 'shown' );
                        }
                        else {
                            // Open this row
                            subdetail_log(row.child,$(this).parents("tr").find('td.subdetail_code').text()) ;
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
        function getrfpTransaction(){
        $('#rfpTable').DataTable().clear();
        $('#rfpTable').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getrfpTransaction')}}",
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
                    var status ='';
                    if(response.data[i].status == 0){
                        status ='New'
                    }
                    else if(response.data[i].status == 1){
                        status ='On Progress'
                    }
                    else if(response.data[i].status == 2){
                        status = 'Done'
                    }
                    else{
                        status ='Reject'
                    }
                    var addRFPDetail ='';
                    var editRFPMaster =``
                    if(response.data[i].user_id == authId){
                        addRFPDetail =`<button title="Add Detail RFP" class="addDetailRFP btn btn-sm btn-success rounded"data-id="${response.data[i]['id']}" data-request="${response.data[i].request_code}" data-toggle="modal" data-target="#addRFPDetail">
                            <i class="fas fa-plus"></i> 
                            </button>`
                        editRFPMaster =`<button title="Edit RFP Master" class="editMasterRFP btn btn-sm btn-primary rounded"data-id="${response.data[i]['id']}" data-request="${response.data[i].request_code}" data-toggle="modal" data-target="#editMasterRFP">
                            <i class="fas fa-edit"></i> 
                            </button>`
                        }
                    var detailRFPMaster =`<button title="detail Master RFP" class="detailRFPMaster btn btn-sm btn-info rounded"data-id="${response.data[i]['id']}" data-request="${response.data[i].request_code}" data-toggle="modal" data-target="#detailRFPMaster">
                            <i class="fas fa-eye"></i> 
                            </button>`
                        
                    data += `<tr style="text-align: center;">
                                <td class='details-control' style="width:5%"></td>
                                <td class="request_code" style="width:15%">${response.data[i].request_code}</td>
                                <td style="width:5%">${response.data[i].location.name}</td>
                              
                                <td  style="width:55%;">
                                <div class="progress-group">
                                    <div class="progress-group">
                                        ${response.data[i].title}
                                        <span class="float-right" style="font-size:10px">${response.data[i].progress}%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: ${response.data[i].progress}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="width:10%">${status}</td>
                                <td style="width:10%">
                                    ${addRFPDetail} ${editRFPMaster} ${detailRFPMaster}
                                </td>
                            </tr>
                            `;
                }
                    $('#rfpTable > tbody:first').html(data);
                        var table = $('#rfpTable').DataTable({
                            scrollX  : true,
                            scrollY  :320,
                            autoWidth:true
                        }).columns.adjust()    
                        $('#rfpTable tbody').off().on('click', 'td.details-control', function (e) {
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
        function removeDuplicates(arr) {
            let unique = [];
            for (i = 0; i < arr.length; i++) {
                if (unique.indexOf(arr[i]) === -1) {
                    unique.push(arr[i]);
                }
            }
            return unique;
        }
        function detail_log( callback, request_code){
            
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('getRFPDetail')}}",
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
                            for(let i = 0; i < response.data.length; i++){  
                                
                            
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
                             
                                var addSubDetailRFP = ''
                                var editSubDetailRFP = ''
                                if(response.data[i].user_id == authId){
                                    addSubDetailRFP =`<button title="Add Sub Detail RFP" class="addSubDetailRFP btn btn-sm btn-success rounded"data-id="${response.data[i]['id']}" data-request="${response.data[i].request_code}" data-detail="${response.data[i].detail_code}" data-toggle="modal" data-target="#addSubDetailRFP">
                                        <i class="fas fa-plus"></i> 
                                        </button>`
                                    editSubDetailRFP = ` <button title="Edit Detail RFP" class="editDetailRFP btn btn-sm btn-primary rounded"data-id="${response.data[i]['id']}" data-detail="${response.data[i].detail_code}" data-request="${response.data[i].request_code}" data-toggle="modal" data-target="#editRFPTransaction">
                                                        <i class="fas fa-edit"></i> 
                                                        </button>`
                                }
                                var picName = '';
                                var arrPIC = []
                                var arrPICNAME = []
                                    for(j=0;j < response.data[i].rfp_relation.length ; j++){
                                         arrPIC.push(response.data[i].rfp_relation[j].user_relation.name)
                                       
                                    }
                                    arrPICNAME.push(removeDuplicates(arrPIC))
                                   
                                    if(arrPICNAME.length > 0){
                                        for(k = 0 ; k < arrPICNAME[0].length; k++){
                                            picName +=`
                                                <ul>
                                                    <li>${arrPICNAME[0][k]}</li>
                                                </ul>
                                            `
                                        }
                                    }
                                var dateline =  response.data[i].dateline.split(' ');
                                var startDate =  response.data[i].start_date.split(' ');
                                    row+= `<tr class="table-light">
                                                <td style="text-align:center">${i + 1}</td>
                                                <td style="text-align:${picName == '' ? 'center' :'left'}">${picName == '' ? '-' : picName}</td>
                                                
                                                <td style="text-align:left">
                                                    <div class="progress-group">
                                                        <div class="progress-group">
                                                            ${response.data[i].title}
                                                        <span class="float-right" style="font-size:10px">${response.data[i].percentage}%</span>
                                                        <div class="progress progress-sm">
                                                        <div class="progress-bar bg-success" style="width: ${response.data[i].percentage}%"></div>
                                                        </div>
                                                        </div>
                                                    </td>
                                                <td style="text-align:center">${response.data[i].status == 0 ? 'On Progress' : 'Done'}</td>
                                                <td style="text-align:center">${response.data[i].start_date}</td>
                                                <td style="text-align:center">${dateline[0]}</td>
                                                <td>
                                                        ${editSubDetailRFP}
                                                        ${addSubDetailRFP}
                                                        <button title="List Sub Detail RFP" class="listSubDetailRFP btn btn-sm btn-info rounded"data-id="${response.data[i]['id']}" data-request="${response.data[i].detail_code}" data-toggle="modal" data-target="#listSubDetailRFP">
                                                        <i class="fas fa-list"></i> 
                                                        </button>
                                                      
                                                </td>
                                            </tr>`;
        
                            }
                            callback($(`
                                <table class="table_detail datatable-stepper" style="width:100%!important">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">No</th>
                                        <th style="text-align:center">PIC</th>
                                        <th style="text-align:center">Activity</th>
                                        <th style="text-align:center">Status</th>
                                        <th style="text-align:center">Start Date</th>
                                        <th style="text-align:center">Deadline</th>
                                        <th style="text-align:center">Action</th>
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
       
        function subdetail_log( callback, subdetail_code){
            
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('getLogSubDetailRFP')}}",
                    type: "get",
                    dataType: 'json',
                    data: {
                        'subdetail_code': subdetail_code
                    },
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success : function(response) {

                        $('#loading').hide();
                        if(response){
                            let row = '';
                            var revision = 0;
                            for(let i = 0; i < response.data.length; i++){  
                                const d = new Date(response.data[i].created_at)
                                const date = d.toISOString().split('T')[0];
                                const time = d.toTimeString().split(' ')[0];
                            
                                $(document).ready(function() 
                                {
                                    $('.table_subDetail').DataTable
                                    ({
                                        "destroy": true,
                                        "autoWidth" : false,
                                        "searching": false,
                                        "aaSorting" : false,
                                        "paging":   false,
                                        "scrollX":true
                                    }).columns.adjust()    
                                });
                                var statusCss = ''
                                if(response.data[i].status == 1){
                                    statusCss = 'font-weight:bold;color:green'
                                    
                                }
                                $('.table_subDetail tbody').append(``);
                                    row+= ` <tr class="table-light">
                                                <td style="width:10%">${date} ${time}</td>
                                                <td style="width:30%">${response.data[i].user_relation.name}</td>
                                                <td style="width:50%">${response.data[i].description}</td>
                                                <td style="width:10%;text-align:center"><span style="${statusCss}">${response.data[i].status == 0 ?'On Progress' : 'Done'} </span></td>
                                            </tr>`;
        
                            }
                            callback($(`
                                <table class="table_subDetail datatable-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;width:10%">Created At</th>
                                        <th style="text-align:center;width:30%">PIC</th>
                                        <th style="text-align:center;width:50%">Description</th>
                                        <th style="text-align:center;width:10%">Status</th>
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
    // End Function
</script>