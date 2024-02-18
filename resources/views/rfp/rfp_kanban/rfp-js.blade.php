<script>
  var request_code = $('#request_code').val()
  var dataStart ={
    'request_code' : request_code
  }
  getData(dataStart)
  function getData(data){
    $('#kanban_new').empty()
    $('#kanban_progress').empty()
    $('#kanban_pending').empty()
    $('#kanban_done').empty()
        $('#wo_table').DataTable().clear();
        $('#wo_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getRFPDetail')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:data,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                var data_new =''
                var data_progress =''
                var data_pending =''
                var data_done =''
                for(i = 0; i < response.data.length ; i++ ){
                  if(response.data[i].status == 0){
                    data_new += `
                      <div class="card mb-3 cursor-grab"  id="${response.data[i].detail_code}" onclick="show('${response.data[i].detail_code}','${response.data[i].title}')">
                        <div class="card-body detail_kanban">
                          <p class="mb-0" style="font-weight:bold">${response.data[i].title}</p>
                          <div class="text-right">
                            <small class="text-muted mb-1 d-inline-block" style="font-size:9px;font-weight:bold;">${response.data[i].percentage}%</small>
                          </div>
                          <div class="progress" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: ${response.data[i].percentage}%;" aria-valuenow="${response.data[i].percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                            
                          </div>
                        </div>
                      </div>
                    `;
                  }
                  else if(response.data[i].status == 1){
                    data_progress += `
                      <div class="card mb-3 cursor-grab" id="${response.data[i].detail_code}" onclick="show('${response.data[i].detail_code}','${response.data[i].title}')">
                        <div class="card-body detail_kanban">
                          <p class="mb-0" style="font-weight:bold">${response.data[i].title}</p>
                          <div class="text-right">
                            <small class="text-muted mb-1 d-inline-block" style="font-size:9px;font-weight:bold;">${response.data[i].percentage}%</small>
                          </div>
                          <div class="progress" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: ${response.data[i].percentage}%;" aria-valuenow="${response.data[i].percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                            
                          </div>
                        </div>
                      </div>`;
                  }
                }
                $('#kanban_new').append(data_new)
                $('#kanban_progress').append(data_progress)

            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
   function show(id,title){
    $('#detailKanbanModal').modal('show')
    $('#detail_label').html(title)
    $('#detail_code_chat').val(id)
    $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getSubDetailKanban')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
              'detail_code' :id
            },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                // Mapping Activity
                  $('#subDetailTable').DataTable().clear();
                  $('#subDetailTable').DataTable().destroy();
                  
                  $('#chat_container').empty()
                  var chat = ''
                  var data = ''
                  var auth_id = $('#auth_id').val()
                  for(i=0 ; i < response.data.length; i ++){
                    var label = response.data[i].status == 1 ? `<s>${response.data[i].title}</s>` : `${response.data[i].title}`
                    var disabled = response.data[i].user_id == auth_id ? '' : 'disabled'
                    data +=`
                      <tr>
                          <td style="width:5%;text-align:center">
                            <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.data[i]['id']}"  data-status="${response.data[i]['status']}" data-id="${response.data[i]['id']}" ${response.data[i]['status'] == 1 ?'checked':'' } ${disabled}>
                          </td>
                          <td>
                            ${label}
                          </td>
                          <td style="width:30%;">
                              ${response.data[i].user_relation.name}
                          </td>
                      </tr>
                      
                  
                    `;
                  }
                  $('#subDetailTable > tbody:first').html(data);
                      $('#subDetailTable').DataTable({
                          scrollX  : true,
                      }).columns.adjust()                    
                // Mapping Activity

                // Mapping Chat
                    for(j = 0; j < response.chat.length; j++){
                                    const d = new Date(response.chat[j].created_at)
                                    const date = d.toISOString().split('T')[0];
                                    const time = d.toTimeString().split(' ')[0];
                                    var auth = $('#authId').val()
                                    var name_img = response.chat[j].user_relation.gender == 1 ? 'profile.png' : 'female_final.png';
                                            if(response.chat[j].user_relation.id == 999){
                                           
                                              remark = `
                                                  <div class="direct-chat-msg">
                                                        <div class="direct-chat-infos clearfix">
                                                            <span style='font-size:9px;' class="direct-chat-timestamp">${formatDate(date)} ${time}</span>
                                                        </div>
                                                       <div class="desk">
                                                        <span style="font-size:9px !important;color:black;font-weight:normal !important; margin-left:auto;margin-right:auto;text-align:center !important;background-color:#d2d6de" class="badge badge-secondary p-2">${response.chat[j].remark}</span>
                                                        </div>
                                                        
                                                    </div>

                                              `
                                            }else{
                                              remark =`
                                              <div class="direct-chat-msg ${response.chat[j].user_relation.id == $('#authId').val() ?'right':''}">
                                                        <div class="direct-chat-infos clearfix">
                                                            <span class="direct-chat-name ${response.chat[j].user_relation.id == $('#authId').val() ?'float-right':'float-left'}" style='font-size:12px;'>${response.chat[j].user_relation == null ?'':response.chat[j].user_relation.name}</span>
                                                            <span style='font-size:9px;' class="direct-chat-timestamp ${response.chat[j].user_relation.id == $('#authId').val() ?'float-left':'float-right'}">${formatDate(date)} ${time}</span>
                                                        </div>
                                                        
                                                            <img class="direct-chat-img" src="{{URL::asset('${name_img}')}}" alt="message user image">
                                                    
                                                        <div class="direct-chat-text" style='font-size:9px;'>
                                                            ${response.chat[j].remark}
                                                        </div>
                                                    </div>
                                              `;
                                            }
                                            chat += remark;
                  }
                  $('#chat_container').append(chat)
                // Mapping Chat

                // Mapping Detail
                  $('#request_code_kanban').html(': ' + response.detail.request_code)
                  $('#detail_code_kanban').html(': ' + response.detail.detail_code)
                  $('#title_kanban').html(': ' + response.detail.title)
                  $('#status_kanban').html( response.detail.status == 1 ? ': ' + 'DONE' : ': ' + 'On Progress')
                  $('#percentage_kanban').html(': ' + response.detail.percentage)
                  $('#description_kanban').html(': ' + response.detail.description)
                  $('#request_code_chat').val(response.detail.request_code)
                  $('#detail_code_chat').val(id)
                // Mapping Detail
                },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
 
   }

  //  Add Chat Comment
    $('#send_chat').on('click', function(){
      var data ={
        'detail_code' : $('#detail_code_chat').val(),
        'remark'      : $('#remark').val()
      }
      $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('sendChat')}}",
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
    
  //  Add Chat Comment

  // Update Status SubDetail
    $('#subDetailTable').on('change','.is_checked', function(){
      
      var data ={
        'id'      : $(this).data('id'),
        'status'  : $(this).data('status')
      }
      var detail_code = $('#detail_code_chat').val()
      $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('updateStatusSubDetail')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
                success: function(response) {
                    if(response.status==500){
                        toastr['warning'](response.message);
                    }
                    else{
                        toastr['success'](response.message);
                        showNoSwal(detail_code)

                    }
                    
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    })
  // Update Status SubDetail
  document.addEventListener('DOMContentLoaded', function () {
    // Set up Dragula for the kanban board
    const kanbanBoard = document.getElementById('kanban-board');
    const columns = Array.from(document.querySelectorAll('.kanban-cards'));
    const drake = dragula(columns);

    // Add event listeners for when a card is dropped
    drake.on('drop', async function (el, target, source, sibling) {
      // Handle the card's new position and update status
      const cardId = el.id;
      const oldColumn = source.parentElement.id;
      const newColumn = target.parentElement.id;

      console.log('Card dropped:', cardId, 'from', oldColumn, 'to', newColumn);

      // Example: If moving from "To Do" to "In Progress," update status
      if (oldColumn === 'todo' && newColumn === 'in-progress') {
        console.log('Task started!');
        // Simulate an asynchronous update (replace with your actual update logic)
        await updateStatus(cardId, 'in-progress');
        console.log('Task status updated!');
      }
    });

    // Simulate an asynchronous update function (replace with your actual logic)
    async function updateStatus(cardId, newStatus) {
      // This is where you might make an API call to update the status on the server
      console.log(`Updating status for ${cardId} to ${newStatus}`);
      // Replace this with your actual update logic (e.g., fetch or axios call)
      // await fetch('/api/update-status', { method: 'POST', body: JSON.stringify({ cardId, newStatus }) });
    }
  });

  // Function
      function getChat(detail_code)
      {
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('getChat')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
              'detail_code' : detail_code
            },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#chat_container').empty()
                for(j = 0; j < response.chat.length; j++){
                                    const d = new Date(response.chat[j].created_at)
                                    const date = d.toISOString().split('T')[0];
                                    const time = d.toTimeString().split(' ')[0];
                                    var auth = $('#authId').val()
                                    var name_img = response.chat[j].user_relation.gender == 1 ? 'profile.png' : 'female_final.png';
                                    chat +=`
                                            <div class="direct-chat-msg ${response.chat[j].user_relation.id == $('#authId').val() ?'right':''}">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name ${response.chat[j].user_relation.id == $('#authId').val() ?'float-right':'float-left'}" style='font-size:12px;'>${response.chat[j].user_relation == null ?'':response.chat[j].user_relation.name}</span>
                                                    <span style='font-size:9px;' class="direct-chat-timestamp ${response.chat[j].user_relation.id == $('#authId').val() ?'float-left':'float-right'}">${formatDate(date)} ${time}</span>
                                                </div>
                                                
                                                    <img class="direct-chat-img" src="{{URL::asset('${name_img}')}}" alt="message user image">
                                            
                                                <div class="direct-chat-text" style='font-size:9px;'>
                                                    ${response.chat[j].remark}
                                                </div>
                                            </div>
                                    `;
                  }
                  $('#chat_container').append(chat)

            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
      }

      function showNoSwal(id){
            $('#detailKanbanModal').modal('show')
            $('#detail_code_chat').val(id)
            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('getSubDetailKanban')}}",
                    type: "get",
                    dataType: 'json',
                    async: true,
                    data:{
                      'detail_code' :id
                    },
                    success: function(response) {
                      
                        // Mapping Activity
                          $('#subDetailTable').DataTable().clear();
                          $('#subDetailTable').DataTable().destroy();
                          
                          $('#chat_container').empty()
                          var chat = ''
                          var data = ''
                          var auth_id = $('#auth_id').val()
                          for(i=0 ; i < response.data.length; i ++){
                            var label = response.data[i].status == 1 ? `<s>${response.data[i].title}</s>` : `${response.data[i].title}`
                            var disabled = response.data[i].user_id == auth_id ? '' : 'disabled'
                            data +=`
                              <tr>
                                  <td style="width:5%;text-align:center">
                                    <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.data[i]['id']}"  data-status="${response.data[i]['status']}" data-id="${response.data[i]['id']}" ${response.data[i]['status'] == 1 ?'checked':'' } ${disabled}>
                                  </td>
                                  <td>
                                    ${label}
                                  </td>
                                  <td style="width:30%;">
                                      ${response.data[i].user_relation.name}
                                  </td>
                              </tr>
                              
                          
                            `;
                          }
                          $('#subDetailTable > tbody:first').html(data);
                              $('#subDetailTable').DataTable({
                                  scrollX  : true,
                              }).columns.adjust()                    
                        // Mapping Activity

                        // Mapping Chat
                        for(j = 0; j < response.chat.length; j++){
                                    const d = new Date(response.chat[j].created_at)
                                    const date = d.toISOString().split('T')[0];
                                    const time = d.toTimeString().split(' ')[0];
                                    var auth = $('#authId').val()
                                    var name_img = response.chat[j].user_relation.gender == 1 ? 'profile.png' : 'female_final.png';
                                            if(response.chat[j].user_relation.id == 999){
                                           
                                              remark = `
                                                  <div class="direct-chat-msg">
                                                        <div class="direct-chat-infos clearfix">
                                                            <span style='font-size:9px;' class="direct-chat-timestamp">${formatDate(date)} ${time}</span>
                                                        </div>
                                                       <div class="desk">
                                                        <span style="font-size:9px !important;color:black;font-weight:normal !important; margin-left:auto;margin-right:auto;text-align:center !important;background-color:#d2d6de" class="badge badge-secondary p-2">${response.chat[j].remark}</span>
                                                        </div>
                                                        
                                                    </div>

                                              `
                                            }else{
                                              remark =`
                                              <div class="direct-chat-msg ${response.chat[j].user_relation.id == $('#authId').val() ?'right':''}">
                                                        <div class="direct-chat-infos clearfix">
                                                            <span class="direct-chat-name ${response.chat[j].user_relation.id == $('#authId').val() ?'float-right':'float-left'}" style='font-size:12px;'>${response.chat[j].user_relation == null ?'':response.chat[j].user_relation.name}</span>
                                                            <span style='font-size:9px;' class="direct-chat-timestamp ${response.chat[j].user_relation.id == $('#authId').val() ?'float-left':'float-right'}">${formatDate(date)} ${time}</span>
                                                        </div>
                                                        
                                                            <img class="direct-chat-img" src="{{URL::asset('${name_img}')}}" alt="message user image">
                                                    
                                                        <div class="direct-chat-text" style='font-size:9px;'>
                                                            ${response.chat[j].remark}
                                                        </div>
                                                    </div>
                                              `;
                                            }
                                            chat += remark;
                  }
                  $('#chat_container').append(chat)
                        // Mapping Chat

                        // Mapping Detail
                          $('#request_code_kanban').html(': ' + response.detail.request_code)
                          $('#detail_code_kanban').html(': ' + response.detail.detail_code)
                          $('#title_kanban').html(': ' + response.detail.title)
                          $('#status_kanban').html( response.detail.status == 1 ? ': ' + 'DONE' : ': ' + 'On Progress')
                          $('#percentage_kanban').html(': ' + response.detail.percentage)
                          $('#description_kanban').html(': ' + response.detail.description)
                          $('#request_code_chat').val(response.detail.request_code)
                          $('#detail_code_chat').val(id)
                        // Mapping Detail
                        },
                    error: function(xhr, status, error) {
                        swal.close();
                        toastr['error']('Failed to get data, please contact ICT Developer');
                    }
                });
    
      }
  // Function

 
</script>