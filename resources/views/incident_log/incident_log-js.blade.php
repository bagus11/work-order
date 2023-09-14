<script>
    
    // Call Function
        getCallback('getIncident',null, function(response){
            swal.close()
            mappingTable(response.data)
        })
        onChange('select_categories','categories_id')
        onChange('select_problem','problem_id')
        onChange('select_location','location_id')
    // Call Function

    // Operation
        // Setup Date Time Picker
            $(document).ready(function(){
                $('#start_date_incident_datetimepicker').datetimepicker({
                    format:'Y-MM-DD HH:mm:ss',
                });
            })
            $(document).ready(function(){
                $('#end_date_incident_datetimepicker_edit').datetimepicker({
                    format:'Y-MM-DD HH:mm:ss',
                });
            })
        // Setup Date Time Picker
        // Add Incident
            $('#btnAddHeader').on('click', function(){
                $('#select_problem').empty()
                $('#select_problem').append('<option value=""> Select Categories First <option>')
                getSelect('getCategoryIncident',null ,'select_categories','Categories')
                getSelect('get_kantor',null,'select_location','Location')
            })
            $('#select_categories').on('change', function(){
                var data ={
                    'id':$('#categories_id').val()
                }
                getSelect('getIncidentProblem',data ,'select_problem','Problem')
            })
            $('#btn_save_incident').on('click', function(e){
                e.preventDefault()
                var data = new FormData();
                data.append('categories_id',$('#categories_id').val())
                data.append('problem_id',$('#problem_id').val())
                data.append('start_date_incident',$('#start_date_incident').val())
                data.append('title_incident',$('#title_incident').val())
                data.append('location_id',$('#location_id').val())
                data.append('description_incident',$('#description_incident').val())
                data.append('attachment_start',$('#attachment_start')[0].files[0]);
                postAttachment('addIncident',data,false,function(response){
                    swal.close()
                    toastr['success'](response.meta.message);
                    window.location = 'incident_log';
                })
            })
        // Add Incident

        // Detail Incident
            $('#incidentTable').on('click','.detailIncident', function(){
                var id = $(this).data('incidentcode')
                var data = {
                    'incident_code': id
                }
                getCallback('getIncidentDetail',data,function(response){
                    swal.close()
                 
                    $('#select_categories_detail').empty()
                    $('#select_categories_detail').append('<option value="'+ response.detail.categories_relation.id + '">' + response.detail.categories_relation.name + '</option>')
                    $('#select_problem_detail').empty()
                    $('#select_problem_detail').append('<option value="' + response.detail.problem_relation.id + '">' + response.detail.problem_relation.name + '</option>')
                    $('#select_location_detail').empty()
                    $('#select_location_detail').append('<option value="' + response.detail.location_relation.id + '">' + response.detail.location_relation.name + '</option>')
                    $('#start_date_incident_detail').val(response.detail.start_date)
                    $('#end_date_incident_detail').val(response.detail.end_date =='0000-00-00 00:00:00' ? '' : response.detail.end_date)
                    $('#title_incident_detail').val(response.detail.subject)
                    $('#description_incident_detail').val(response.detail.description)
                    $('#user_id_detail').val(response.detail.user_relation.name)
                    $('#incident_code_detail').val(response.detail.incident_code)
                    mappingTableLog(response.data)
                })
            })
        // Detail Incident

        // Update Icident
            $('#incidentTable').on('click', '.editHeader', function(){
                var id = $(this).data('incidentcode')
                var data = {
                    'incident_code': id
                }
                $('#incidentIdEdit').val(id)
                getCallback('getIncidentDetail',data,function(response){
                    swal.close()
                    $('#select_categories_edit').empty()
                    $('#select_categories_edit').append('<option value="'+ response.detail.categories_relation.id + '">' + response.detail.categories_relation.name + '</option>')
                    $('#select_problem_edit').empty()
                    $('#select_problem_edit').append('<option value="' + response.detail.problem_relation.id + '">' + response.detail.problem_relation.name + '</option>')
                    $('#select_location_edit').empty()
                    $('#select_location_edit').append('<option value="' + response.detail.location_relation.id + '">' + response.detail.location_relation.name + '</option>')
                    $('#start_date_incident_edit').val(response.detail.start_date)
                    $('#title_incident_edit').val(response.detail.subject)
                    $('#end_date_incident_edit').val(response.detail.end_date == '0000-00-00 00:00:00'?'': response.detail.end_date)
                    $('#description_incident_edit').val(response.detail.description)
                    $('#user_id_edit').val(response.detail.user_relation.name)
                })
            })

            $('#btn_update_incident').on('click', function(e){
                e.preventDefault()
                var data = new FormData();
                data.append('id',$('#incidentIdEdit').val())
                data.append('comment_incident_edit',$('#comment_incident_edit').val())
                data.append('end_date_incident_edit',$('#end_date_incident_edit').val())
                data.append('attachment_end',$('#attachment_end')[0].files[0]);

                postAttachment('updateIncident',data,false,function(response){
                    swal.close()
                    toastr['success'](response.meta.message);
                    window.location = 'incident_log';
                })

            })
        // Update Icident
    // Operation

    // Function
        function mappingTable(response){
            $('#incidentTable').DataTable().clear();
            $('#incidentTable').DataTable().destroy();
            var data=''
           
                for(i = 0; i < response.length; i++ )
                {
                 
                    var button ='';
                    if(auth_id == response[i].user_id && response[i].status == 1){
                        button =`   <button title="Update Incident" class="editHeader btn btn-sm btn-warning rounded" data-incidentcode="${response[i]['incident_code']}" data-toggle="modal" data-target="#editHeader">
                                        <i class="fas fa-solid fa-edit"></i>
                                    </button>`;
                    }
                    data += `<tr style="text-align: center;">
                                <td>${response[i].incident_code}</td>
                                <td style="text-align:left">${response[i].location_relation.name}</td>
                                <td style="text-align:left">${response[i].categories_relation.name}</td>
                                <td style="text-align:left">${response[i].problem_relation.name}</td>
                                <td style="color : ${response[i].status == 1 ?'#8ECDDD' :'black'}; font-weight:bold"><strong>${response[i]['status']== 1 ?'START':'END'}</strong></td>
                                <td>${response[i].status == 1 ?'-' : response[i].duration}</td>
                                <td>
                                    <button title="Detail" class="detailIncident btn btn-sm btn-primary rounded" data-incidentcode="${response[i]['incident_code']}" data-toggle="modal" data-target="#detailIncident">
                                        <i class="fas fa-solid fa-eye"></i>
                                    </button>
                                    ${button}
                                </td>
                            </tr>
                            `;
                }
                    $('#incidentTable > tbody:first').html(data);
                    $('#incidentTable').DataTable({   
                        scrollX  : true,
                        scrollY  : 450
                    }).columns.adjust()
        }
        function mappingTableLog(response){
            $('#incidentLogTable').DataTable().clear();
            $('#incidentLogTable').DataTable().destroy();
            var data=''
            var data=''
                for(i = 0; i < response.length; i++ )
                {
                    var fileName = response[i].attachment.split('/')
                    data += `<tr style="text-align: center;">
                            <td style="width:5%">${i + 1}</td>
                                <td style="width:20%;text-align:left">
                                    <a target="_blank" href="{{URL::asset('${response[i].attachment}')}}" class="ml-3" style="color:blue;">
                                        <i class="far fa-file" style="color: red;font-size: 20px;"></i>
                                        ${fileName[2]} </a>
                                </td>
                                <td style="text-align:left;width:65%">${response[i].comment}</td>
                                <td style="width:10%">${response[i].status == 1 ?'-' : response[i].duration}</td>
                            </tr>
                            `;
                }
                    $('#incidentLogTable > tbody:first').html(data);
                    $('#incidentLogTable').DataTable({   
                        scrollX  : false,
                    }).columns.adjust()
        }
    // Function
</script>