<script>
    getData()
    $('#add_priority').on('click', function(){
        $('.message_error').html('')
    })
    $('#btnAddPriority').on('click', function(){
        var data ={
            'name':$('#name').val(),
            'duration':$('#duration').val(),
            'duration_lv2':$('#duration_lv2').val(),
        }
        store('addPriority',data,'master_priority')
    })
    $('#btnEditPriority').on('click', function(){
        var data ={
            'id':$('#id').val(),
            'nameUpdate':$('#nameUpdate').val(),
            'durationUpdate':$('#durationUpdate').val(),
            'duration_lv2Update':$('#duration_lv2Update').val(),
        }
        store('updatePriority',data,'master_priority')
    })
    $('#masterPriorityTable').on('click','.editPriority', function(){
        $('.message_error').html('')
        var id = $(this).data('id');
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getPriorityDetail')}}",
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
                   $('#id').val(id);
                   $('#nameUpdate').val(response.data.name)
                   $('#durationUpdate').val(response.data.duration)
                   $('#duration_lv2Update').val(response.data.duration_lv2)
                
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    })
  
   function getData(){
    $('#masterPriorityTable').DataTable().clear();
    $('#masterPriorityTable').DataTable().destroy();
    $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('getPriority')}}",
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
                                    <td style="text-align:center;font-weight:bold">${response.data[i].duration == null ? 0 : response.data[i].duration} Jam</td>
                                    <td style="text-align:center;font-weight:bold">${response.data[i].duration_lv2 == null ? 0 : response.data[i].duration_lv2} Jam</td>
                                    <td  style="text-align:center">
                                        <button title="Detail" class="editPriority btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editPriority">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                        `;
                    }
                $('#masterPriorityTable > tbody:first').html(data);
                $('#masterPriorityTable').DataTable({
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
</script>