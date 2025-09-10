<script>
// Initiating
    let requestArray = [];

    getCallback('getTicketSystem', null, function(response){
        swal.close()
        mappingTable(response.data, 'update_system_table')
    })
    $('#btn_refresh').on('click', function(){
        getCallback('getTicketSystem', null, function(response){
            swal.close()
            mappingTable(response.data, 'update_system_table')
        })
    })
// Initiating
// Operation
    //  Add Ticket
        $('#btn_add_ticket').on('click', function(){
             $('#addSystemModal').modal({backdrop: 'static', keyboard: false})  
            getActiveItems('getAspek', null,'select_aspect', 'Aspect')
            if(requestArray.length == 0 ){
                $("#arrayTable").hide();
                $('#btn_save_ticket').prop('hidden', true);
            }
            
        })

        onChange('select_aspect','aspect')
        onChange('select_module','module')
        onChange('select_data_type','data_type')

        $('#select_aspect').on('change', function(){
            var data={
                'aspect' : $('#select_aspect').val()
            } 
            getActiveItems('moduleFilter', data, 'select_module', 'Module')
        })

        $('#select_module').on('change', function(){
            var data={
                'module' : $('#select_module').val()
            } 
            getActiveItems('systemFilter', data, 'select_data_type', 'Data Type')
        })
        
      
        $("#btn_add_array").on("click", function (e) {
            e.preventDefault();
            $('#btn_save_ticket').prop('hidden', false);
            let aspectText = $("#select_aspect option:selected").text();
            let aspectVal = $("#select_aspect").val();
            let moduleText = $("#select_module option:selected").text();
            let moduleVal = $("#select_module").val();
            let dataTypeText = $("#select_data_type option:selected").text();
            let dataTypeVal = $("#select_data_type").val();
            let requestTypeText = $("#select_request_type option:selected").text();
            let requestTypeVal = $("#select_request_type").val();
            let remarkVal = $("#remark").summernote('code').trim();
            let imagesVal = $("#uploaded_images").val() ? $("#uploaded_images").val().split(",") : [];
            if (!aspectVal || !moduleVal || !dataTypeVal || !requestTypeVal || !remarkVal) {
                alert("Please fill all fields before adding!");
                return;
            }

            requestArray.push({
                aspect: aspectText,
                aspect_id: aspectVal,
                module: moduleText,
                module_id: moduleVal,
                data_type: dataTypeText,
                data_type_id: dataTypeVal,
                request_type: requestTypeText,
                request_type_id: requestTypeVal,
                remark: remarkVal,
                images: imagesVal
            });

            renderTable();
            $("#remark").summernote('reset');
            $("#uploaded_images").val("");
            $("#select_aspect, #select_module, #select_data_type").prop('disabled', true);
        });

        $(document).on("click", ".btn_delete", function () {
            let index = $(this).data("index");
            let deletedItem = requestArray[index];
            let imgUrls = [];
            let tempDiv = $("<div>").html(deletedItem.remark);
            tempDiv.find("img").each(function() {
                imgUrls.push($(this).attr("src"));
            });
            imgUrls.forEach(function(url) {
                var data = {
                     src: url,
                }
               postCallbackNoSwal('delete-image',data, function(response){

               })
               return false;
            });
            requestArray.splice(index, 1);
            renderTable();
        });

    //  Add Ticket

    // Save Ticket
            $('#btn_save_ticket').on('click', function(){
                let tableData = [];

                $('#arrayTable tbody tr').each(function () {
                    let rowData = {};
                    rowData.aspect       = $(this).find('td:eq(1)').text().trim();
                    rowData.module       = $(this).find('td:eq(2)').text().trim();
                    rowData.data_type    = $(this).find('td:eq(3)').text().trim();
                    rowData.request_type = $(this).find('td:eq(4)').text().trim();
                    rowData.subject      = $(this).find('td:eq(5)').text().trim();
                    
                    // ambil src image kalau ada
                    let img = $(this).find('td:eq(6) img');
                    rowData.image = img.length ? img.attr('src') : null;

                    tableData.push(rowData);
                });
                if(tableData.length > 0){
                    var data = {
                        add_info : $('#add_info').val(),
                        remark   : $('#remark').val(),
                        subject   : $('#subject').val(),
                        items    : tableData
                    };
                    postCallback('addSystemTicket', data, function(response){
                        swal.close()
                        toastr['success'](response.meta.message)
                        $('#addSystemModal').modal('hide')
                        requestArray = [];
                        $("#select_aspect, #select_module, #select_data_type, #select_request_type").prop('disabled', false);
                        $("#select_aspect, #select_module, #select_data_type, #select_request_type,#aspect,#module,#data_type, #subject,#add_info ").val('');
                        $("#select_aspect, #select_module, #select_data_type, #select_request_type").select2().trigger('change');
                        getCallbackNoSwal('getTicketSystem', null, function(response){
                                mappingTable(response.data, 'update_system_table')
                            })
                    })
                }else{
                    toastr['danger']('detail cannot be null')
                }
            });

    // Save Ticket

    // Edit Ticket 
        $('#update_system_table').on('click', '.edit', function(){           
            var ticket_code = $(this).data('ticket')
            var statusHeader = $(this).data('status')
            $('#editSystemModal').modal({backdrop: 'static', keyboard: false})
            $('#editSystemModal').modal('show');
            $('#edit_ticket_code').val(ticket_code)

            var data ={
                'ticket_code' : ticket_code
            }
            getCallbackNoSwal('getDetailERP', data, function(response){
                swal.close()
                $("#edit_subject").val(response.data.subject)
                var datetime = formatDateTime(response.data.created_at)
                var date = datetime.split(' ')[0]; 
                $('#edit_created_at').val(datetime)
                $('#edit_created_by').val(response.data.user_relation.name)
                $('#edit_add_info').val(response.data.remark)
              // Detail Task
                $("#detail_ticket_container").empty();
                let details = response.data.detail_relation ?? [];
                let html = '';
                if (details.length > 0) {
                    html += `<ul class="list-group p-0">`;
                    details.forEach((item, i) => {
                        let cleanRemark = item.remark ? item.remark.replace(/<[^>]*>/g, '').trim() : '-';
                        var status = item.status;
                        var color = '';
                        var icon = '';
                     switch (status) {
                        case 0:
                            color = 'info';
                            status = 'WAITING FOR APPROVAL';
                            icon = '<i class="fa-solid fa-users"></i>'; // bisa ganti icon sesuai selera
                            break;
                        case 1:
                            color = 'warning';
                            status = 'IN PROGRESS';
                            icon = '<i class="fa-solid fa-hourglass"></i>';
                            break;
                        case 2:
                            color = 'primary';
                            status = 'CHECKED BY PIC';
                            icon = '<i class="fas fa-check"></i>';
                            break;
                        case 3:
                            color = 'danger';
                            status = 'REVISE';
                            icon = '<i class="fa-solid fa-rotate-left"></i>';
                            break;
                        case 4:
                            color = 'success';
                            status = 'DONE';
                            icon = '<i class="fa-solid fa-check-double"></i>';
                            break;
                        case 5:
                            status  = 'REJECT'
                            color   = 'dark'
                            icon    ='<i class="fa-solid fa-circle-xmark"></i>'
                        break;
                        default:
                            color = 'secondary';
                            status = 'UNKNOWN';
                            icon = '<i class="fa-solid fa-circle-question"></i>';

                    }

                        var btn_task = '';
                        if(statusHeader == 1 || statusHeader == 3){
                            if(item.status == 0 || item.status == 3){
                                if(auth_id == item.user_id)
                                btn_task =`
                                    <button class="btn ml-2 btn-sm btn-success check float-right" 
                                        data-detail="${item.detail_code}" 
                                        data-aspect="${item.aspect_relation?.name ?? '-'}"
                                        data-module="${item.module_relation?.name ?? '-'}"
                                        data-type="${item.data_type_relation?.name ?? '-'}"
                                        data-remark="${item.subject}"
                                        data-id="${item.id}">
                                        <i class="fa-solid fa-list-check"></i>
                                    </button>
                                `;
                            }
                        }

                        // build log history dari history_relation
                        let logsHtml = '';
                        if (item.history_relation && item.history_relation.length > 0) {
                            logsHtml += `<ul class="list-group list-group-flush">`;
                            item.history_relation.forEach(log => {
                                logsHtml += `
                             <li class="list-group-item border-0 px-3 py-2 mb-2 rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i> ${formatDateTime(log.created_at) ?? '-'}
                                    </small>
                                    <small class="text-info fw-bold">
                                        <i class="fa fa-user"></i> ${log.user_relation?.name ?? '-'}
                                    </small>
                                </div>

                                <p class="mb-2 mt-2 text-dark">
                                    ${log.remark || '-'}
                                </p>

                               ${
                                    log.attachment 
                                        ? `<div class="mt-2">
                                          <img src="${BASE_URL}/storage/${log.attachment}" 
                                alt="Attachment" class="img-fluid rounded shadow-sm preview-image" data-url="${BASE_URL}/storage/${log.attachment}" 
                                style="max-width: 200px; height: auto;">
                                        </div>` 
                                        : ''
                                }

                                ${
                                    log.status == 1
                                        ? `<small class="text-success d-block mt-2">
                                                ⏳ ${formatDuration(log.duration)}
                                        </small>`
                                        : ''
                                }
                            </li>


                                `;
                            });
                            logsHtml += `</ul>`;
                        } else {
                            logsHtml = `<div class="alert alert-light mb-0">Tidak ada log</div>`;
                        }

                        html += `
                        <li class="list-group-item border-0 p-0 mb-3">
                            <div class="card border-0 shadow-sm" style="border-radius:20px;">
                                <!-- Body -->
                                <div class="card-body py-2 bg-light">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <span class="badge badge-${color}">
                                                ${icon} ${status}
                                            </span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            ${btn_task}
                                            <button class="btn btn-sm btn-outline-dark" style="border-radius :20px !important" data-toggle="collapse" data-target="#log-${i}">
                                                <i class="fas fa-history"></i> View Log
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row align-items-center">
                                        <!-- Keterangan -->
                                        <div class="col-md-7">
                                            <div class="row mb-2">
                                                <div class="col-3 mt-1">
                                                    <small class="text-muted d-block">Detail Code</small>
                                                </div>
                                                <div class="col-9">
                                                    <span class="fw-semibold text-dark">${item.detail_code}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-3 mt-1">
                                                    <small class="text-muted d-block">Aspect</small>
                                                </div>
                                                <div class="col-9">
                                                    <span class="fw-semibold text-dark">${item.aspect_relation?.name ?? '-'}</span>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-3 mt-1">
                                                    <small class="text-muted d-block">Module</small>
                                                </div>
                                                <div class="col-9">
                                                    <span class="fw-semibold text-dark">${item.module_relation?.name ?? '-'}</span>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-3 mt-1">
                                                    <small class="text-muted d-block">Data Type</small>
                                                </div>
                                                <div class="col-9">
                                                    <span class="fw-semibold text-dark">${item.data_type_relation?.name ?? '-'}</span>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-3 mt-1">
                                                    <small class="text-muted d-block">Remark</small>
                                                </div>
                                                <div class="col-9">
                                                    <span class="fw-semibold text-dark">${item.subject || '-'}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Gambar -->
                                        ${item.attachment 
                                            ? `
                                            <div class="col-md-5 text-center">
                                                <img src="${item.attachment}" 
                                                    class="img-fluid preview-image rounded-6 shadow-sm border"  data-url="${item.attachment}"
                                                    style="max-height:220px; object-fit:contain"/>
                                            </div>
                                            `
                                            : ''
                                        }
                                    </div>

                                    <!-- Collapse Log -->
                                    <div id="log-${i}" class="collapse mt-3">
                                        <div class="card card-body p-2 bg-white shadow-sm">
                                            ${logsHtml}
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="card-footer bg-white px-2 py-2 border-0 border-top">
                                    <small class="text-muted">
                                        👤 <span class="fw-semibold">${item.user_relation?.name ?? '-'}</span>
                                    </small>
                                    <small class="text-muted float-right">
                                        🕒 ${formatDateTime(item.created_at) ?? '-'}
                                    </small>
                                </div>
                            </div>
                        </li>
                        `;
                    });
                    html += `</ul>`;
                } else {
                    html = `<div class="alert alert-warning">Tidak ada detail</div>`;
                }
                $("#detail_ticket_container").html(html);

                     // Log Task
                    // ========== LOG TASK ==========
                        $("#log_task_container").empty();
                        let histories = response.data.history_relation ?? [];
                        let logHtml = '';

                        if (histories.length > 0) {
                            logHtml += `<ul class="timeline list-unstyled">`;
                            histories.forEach((log, i) => {
                                let statusText = '';
                                let statusIcon = '';
                                let badgeColor = '';

                             switch (log.status) {
                                case 0:
                                    statusText = 'WAITING FOR APPROVAL';
                                    statusIcon = '<i class="fas fa-users"></i>';
                                    badgeColor = 'info';
                                    break;
                                case 1:
                                    statusText = 'IN PROGRESS';
                                    statusIcon = '<i class="fas fa-spinner fa-spin"></i>'; // kasih animasi biar kelihatan jalan
                                    badgeColor = 'warning';
                                    break;
                                case 2:
                                    statusText = 'CHECKED BY PIC';
                                    statusIcon = '<i class="fas fa-check"></i>';
                                    badgeColor = 'primary';
                                    break;
                                case 3:
                                    statusText = 'REVISE';
                                    statusIcon = '<i class="fas fa-edit"></i>';
                                    badgeColor = 'danger';
                                    break;
                                case 4:
                                    statusText = 'DONE';
                                    statusIcon = '<i class="fas fa-check-double"></i>';
                                    badgeColor = 'success';
                                    break;
                                case 5:
                                    statusText = 'REJECT';
                                    statusIcon = '<i class="fa-solid fa-circle-xmark"></i>';
                                    badgeColor = 'dark';
                                    break;
                                default:
                                    statusText = 'UNKNOWN';
                                    statusIcon = '<i class="fas fa-question"></i>';
                                    badgeColor = 'secondary';
                            }


                             logHtml += `
                              <li class="timeline-item mb-4 position-relative ps-5">
                                <!-- ICON -->
                                <span class="timeline-icon position-absolute top-0 start-0 translate-middle 
                                    bg-${badgeColor} text-white rounded-circle d-flex align-items-center 
                                    justify-content-center shadow" 
                                    style="width:35px;height:35px; z-index:2;margin-left:15px !important;">
                                    ${statusIcon}
                                </span>

                                <!-- CARD -->
                                <div class="card border-0 shadow-sm" style="border-radius:30px;margin-left:40px !important; z-index:1; position:relative;">
                                    <div class="card-body ps-6 p-3" style="padding-left:30px !important"> <!-- dinaikin jadi ps-6 biar gak ketiban -->
                                        <div class="d-flex justify-content-between">
                                            <span class="badge bg-${badgeColor}">${statusText}</span>
                                            <small class="text-muted">🕒 ${formatDateTime(log.created_at) ?? '-'}</small>
                                        </div>
                                        <p class="mt-2 mb-1 text-dark">${log.remark || '-'}</p>
                                      ${(log.status == 4) 
                                            ? `<small class="d-block text-success fw-bold">⏳ Total Duration: ${formatDuration(log.duration)}</small>` 
                                            : (log.duration !== 0 
                                                ? `<small class="d-block text-info fw-bold">⏳ Duration: ${formatDuration(log.duration)}</small>` 
                                                : ''
                                            )
                                        }
                                        ${log.status == 0 && log.step 
                                            ? `<small class="d-block text-warning fw-bold">📌 Step Approval: ${log.step}</small>` 
                                            : ''}

                                        <small class="text-muted d-block">👤 ${log.user_relation?.name ?? '-'}</small>
                                    </div>
                                </div>
                            </li>

                                `

                            });
                            logHtml += `</ul>`;
                        } else {
                            logHtml = `<div class="alert alert-secondary">Belum ada log untuk ticket ini.</div>`;
                        }

                        $("#log_task_container").html(logHtml);

                // Log Task
                    })
               
        });
        // Update Task
            $(document).on('click', '#finish_task', function () {
                let remark = $('#finish_remark').val();
                let attachment = $('#finish_attachment')[0].files[0];
                let detailCode = $('.detail_code').text(); // misalnya buat kirim ID task

                // bikin formData biar bisa kirim file
                let formData = new FormData();
                formData.append('finish_remark', remark);
                formData.append('finish_attachment', attachment);
                formData.append('detail_code', detailCode); // kalau perlu kirim task id/code

                // panggil function yang udah lo bikin
                postAttachment('finishTask', formData, true, function (response) {
                    swal.close();
                    if (response.meta && response.meta.code == 200) {
                        toastr['success'](response.meta.message);
                        $('#checkModal').modal('hide');
                        $('#editSystemModal').modal('hide');
                        // refresh table / list
                        if (typeof table !== 'undefined') {
                             getCallback('getTicketSystem', null, function(response){
                                swal.close()
                                mappingTable(response.data, 'update_system_table')
                            })
                        }
                    } else {
                        toastr['error'](response.meta.message || 'Something went wrong');
                    }
                });
            });
        // Update Task
        $(document).on('click', '.check', function(){
            var detail = $(this).data('detail')
            var aspect = $(this).data('aspect')
            var module = $(this).data('module')
            var remark = $(this).data('remark')
            var type = $(this).data('type')
            $('#checkModal').modal({backdrop: 'static', keyboard: false})
            $('#checkModal').modal('show');
            $('#editSystemModal').modal('hide');
            $('#detail_code').val(detail)
            $('#finish_aspect').val(aspect)
            $('#finish_module').val(module)
            $('#finish_data_type').val(type)
            $('#finish_remark').val('')
            $('.detail_code').text('Detail Code : '+ detail)
        })
        $('#btn_close_check_modal').on('click', function(){
            $('#editSystemModal').modal('show');

        })
        // $('#checkModal').on('hidden.bs.modal', function () {
        // }); 
    // Edit Ticket 

    // Checking Ticket 
            $('#update_system_table').on('click', '.checking', function(){           
                    var ticket_code = $(this).data('ticket')
                    var statusHeader = $(this).data('status')
                    $('#finalizeERPModal').modal({backdrop: 'static', keyboard: false})
                    $('#finalizeERPModal').modal('show');
                    $('#finalizeERPModal').modal('show');
                    $('#check_ticket_code').val(ticket_code)

                    var data ={
                        'ticket_code' : ticket_code
                    }
                    getCallbackNoSwal('getDetailERP', data, function(response){
                        swal.close()
                        $("#check_subject").val(response.data.subject)
                        var datetime = formatDateTime(response.data.created_at)
                        var date = datetime.split(' ')[0]; 
                        $('#check_created_at').val(datetime)
                        $('#check_created_by').val(response.data.user_relation.name)
                        $('#check_add_info').val(response.data.remark)
                        $("#detail_ticket_container_check").empty();
                        let details = response.data.detail_relation ?? [];
                        let html = '';
                        if (details.length > 0) {
                            html += `<ul class="list-group p-0">`;
                            details.forEach((item, i) => {
                                let cleanRemark = item.remark ? item.remark.replace(/<[^>]*>/g, '').trim() : '-';
                                var status = item.status;
                                var color = '';
                                var icon = '';
                            switch (status) {
                                case 0:
                                    color = 'info';
                                    status = 'WAITING FOR APPROVAL';
                                    icon = '<i class="fa-solid fa-users"></i>'; // bisa ganti icon sesuai selera
                                    break;
                                case 1:
                                    color = 'warning';
                                    status = 'IN PROGRESS';
                                    icon = '<i class="fa-solid fa-hourglass"></i>';
                                    break;
                                case 2:
                                    color = 'primary';
                                    status = 'CHECKED BY PIC';
                                    icon = '<i class="fas fa-check"></i>';
                                    break;
                                case 3:
                                    color = 'danger';
                                    status = 'REVISE';
                                    icon = '<i class="fa-solid fa-rotate-left"></i>';
                                    break;
                                case 4:
                                    color = 'success';
                                    status = 'DONE';
                                    icon = '<i class="fa-solid fa-check-double"></i>';
                                    break;
                                case 5:
                                    color = 'dark';
                                    status = 'REJECT';
                                    icon = '<i class="fa-solid fa-circle-xmark"></i>';
                                    break;
                                default:
                                    color = 'secondary';
                                    status = 'UNKNOWN';
                                    icon = '<i class="fa-solid fa-circle-question"></i>';
                            }

                                var btn_task = '';
                                if(statusHeader == 1 || statusHeader == 3){
                                    if(item.status == 0 || item.status == 3){
                                        if(auth_id == item.user_id)
                                        btn_task =`
                                            <button class="btn ml-2 btn-sm btn-success check float-right" 
                                                data-detail="${item.detail_code}" 
                                                data-aspect="${item.aspect_relation?.name ?? '-'}"
                                                data-module="${item.module_relation?.name ?? '-'}"
                                                data-type="${item.data_type_relation?.name ?? '-'}"
                                                data-remark="${item.subject}"
                                                data-id="${item.id}">
                                                <i class="fa-solid fa-list-check"></i>
                                            </button>
                                        `;
                                    }
                                }

                                // build log history dari history_relation
                                let logsHtml = '';
                                if (item.history_relation && item.history_relation.length > 0) {
                                    logsHtml += `<ul class="list-group list-group-flush">`;
                                    item.history_relation.forEach(log => {
                                        logsHtml += `
                                    <li class="list-group-item border-0 px-3 py-2 mb-2 rounded shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="far fa-clock"></i> ${formatDateTime(log.created_at) ?? '-'}
                                            </small>
                                            <small class="text-info fw-bold">
                                                <i class="fa fa-user"></i> ${log.user_relation?.name ?? '-'}
                                            </small>
                                        </div>

                                        <p class="mb-2 mt-2 text-dark">
                                            ${log.remark || '-'}
                                        </p>

                                    ${
                                            log.attachment 
                                                ? `<div class="mt-2">
                                                <img src="${BASE_URL}/storage/${log.attachment}" 
                                        alt="Attachment" class="img-fluid rounded shadow-sm preview-image" data-url="${BASE_URL}/storage/${log.attachment}" 
                                        style="max-width: 200px; height: auto;">
                                                </div>` 
                                                : ''
                                        }

                                        ${
                                            log.status == 1
                                                ? `<small class="text-success d-block mt-2">
                                                        ⏳ ${formatDuration(log.duration)}
                                                </small>`
                                                : ''
                                        }
                                    </li>


                                        `;
                                    });
                                    logsHtml += `</ul>`;
                                } else {
                                    logsHtml = `<div class="alert alert-light mb-0">Tidak ada log</div>`;
                                }

                                html += `
                                <li class="list-group-item border-0 p-0 mb-3">
                                    <div class="card border-0 shadow-sm" style="border-radius:20px;">
                                        <!-- Body -->
                                        <div class="card-body py-2 bg-light">
                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <span class="badge badge-${color}">
                                                        ${icon} ${status}
                                                    </span>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    ${btn_task}
                                                    <button class="btn btn-sm btn-outline-dark" style="border-radius :20px !important" data-toggle="collapse" data-target="#log-${i}">
                                                        <i class="fas fa-history"></i> View Log
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <!-- Keterangan -->
                                                <div class="col-md-7">
                                                    <div class="row mb-2">
                                                        <div class="col-3 mt-1">
                                                            <small class="text-muted d-block">Detail Code</small>
                                                        </div>
                                                        <div class="col-9">
                                                            <span class="fw-semibold text-dark">${item.detail_code}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-3 mt-1">
                                                            <small class="text-muted d-block">Aspect</small>
                                                        </div>
                                                        <div class="col-9">
                                                            <span class="fw-semibold text-dark">${item.aspect_relation?.name ?? '-'}</span>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col-3 mt-1">
                                                            <small class="text-muted d-block">Module</small>
                                                        </div>
                                                        <div class="col-9">
                                                            <span class="fw-semibold text-dark">${item.module_relation?.name ?? '-'}</span>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col-3 mt-1">
                                                            <small class="text-muted d-block">Data Type</small>
                                                        </div>
                                                        <div class="col-9">
                                                            <span class="fw-semibold text-dark">${item.data_type_relation?.name ?? '-'}</span>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col-3 mt-1">
                                                            <small class="text-muted d-block">Remark</small>
                                                        </div>
                                                        <div class="col-9">
                                                            <span class="fw-semibold text-dark">${item.subject || '-'}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Gambar -->
                                                ${item.attachment 
                                                    ? `
                                                    <div class="col-md-5 text-center">
                                                        <img src="${item.attachment}" 
                                                            class="img-fluid preview-image rounded-6 shadow-sm border"  data-url="${item.attachment}"
                                                            style="max-height:220px; object-fit:contain"/>
                                                    </div>
                                                    `
                                                    : ''
                                                }
                                            </div>

                                            <!-- Collapse Log -->
                                            <div id="log-${i}" class="collapse mt-3">
                                                <div class="card card-body p-2 bg-white shadow-sm">
                                                    ${logsHtml}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer -->
                                        <div class="card-footer bg-white px-2 py-2 border-0 border-top">
                                            <small class="text-muted">
                                                👤 <span class="fw-semibold">${item.user_relation?.name ?? '-'}</span>
                                            </small>
                                            <small class="text-muted float-right">
                                                🕒 ${formatDateTime(item.created_at) ?? '-'}
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                `;
                            });
                            html += `</ul>`;
                        } else {
                            html = `<div class="alert alert-warning">Tidak ada detail</div>`;
                        }

                    $("#detail_ticket_container_check").html(html);

                    // Log 
                    $("#detail_ticket_container").html(html);

                            // Log Task
                            // ========== LOG TASK ==========
                                $("#log_task_container_check").empty();
                                let histories = response.data.history_relation ?? [];
                                let logHtml = '';

                                if (histories.length > 0) {
                                    logHtml += `<ul class="timeline list-unstyled">`;
                                    histories.forEach((log, i) => {
                                        let statusText = '';
                                        let statusIcon = '';
                                        let badgeColor = '';

                                    switch (log.status) {
                                        case 0:
                                            statusText = 'WAITING FOR APPROVAL';
                                            statusIcon = '<i class="fas fa-users"></i>';
                                            badgeColor = 'info';
                                            break;
                                        case 1:
                                            statusText = 'IN PROGRESS';
                                            statusIcon = '<i class="fas fa-spinner fa-spin"></i>'; // kasih animasi biar kelihatan jalan
                                            badgeColor = 'warning';
                                            break;
                                        case 2:
                                            statusText = 'CHECKED BY PIC';
                                            statusIcon = '<i class="fas fa-check"></i>';
                                            badgeColor = 'primary';
                                            break;
                                        case 3:
                                            statusText = 'REVISE';
                                            statusIcon = '<i class="fas fa-edit"></i>';
                                            badgeColor = 'danger';
                                            break;
                                        case 4:
                                            statusText = 'DONE';
                                            statusIcon = '<i class="fas fa-check-double"></i>';
                                            badgeColor = 'success';
                                            break;
                                        
                                        case 5:
                                            statusText = 'REJECT';
                                            statusIcon = '<i class="fa-solid fa-circle-xmark"></i>';
                                            badgeColor = 'dark';
                                            break;
                                        
                                        default:
                                            statusText = 'UNKNOWN';
                                            statusIcon = '<i class="fas fa-question"></i>';
                                            badgeColor = 'secondary';
                                    }


                                    logHtml += `
                                    <li class="timeline-item mb-4 position-relative ps-5">
                                        <!-- ICON -->
                                        <span class="timeline-icon position-absolute top-0 start-0 translate-middle 
                                            bg-${badgeColor} text-white rounded-circle d-flex align-items-center 
                                            justify-content-center shadow" 
                                            style="width:35px;height:35px; z-index:2;margin-left:15px !important;">
                                            ${statusIcon}
                                        </span>

                                        <!-- CARD -->
                                        <div class="card border-0 shadow-sm" style="border-radius:30px;margin-left:40px !important; z-index:1; position:relative;">
                                            <div class="card-body ps-6 p-3" style="padding-left:30px !important"> <!-- dinaikin jadi ps-6 biar gak ketiban -->
                                                <div class="d-flex justify-content-between">
                                                    <span class="badge bg-${badgeColor}">${statusText}</span>
                                                    <small class="text-muted">🕒 ${formatDateTime(log.created_at) ?? '-'}</small>
                                                </div>
                                                <p class="mt-2 mb-1 text-dark">${log.remark || '-'}</p>
                                            ${(log.status == 4) 
                                                    ? `<small class="d-block text-success fw-bold">⏳ Total Duration: ${formatDuration(log.duration)}</small>` 
                                                    : (log.duration !== 0 
                                                        ? `<small class="d-block text-info fw-bold">⏳ Duration: ${formatDuration(log.duration)}</small>` 
                                                        : ''
                                                    )
                                                }
                                                ${log.status == 0 && log.step 
                                                    ? `<small class="d-block text-warning fw-bold">📌 Step Approval: ${log.step}</small>` 
                                                    : ''}

                                                <small class="text-muted d-block">👤 ${log.user_relation?.name ?? '-'}</small>
                                            </div>
                                        </div>
                                    </li>

                                        `

                                    });
                                    logHtml += `</ul>`;
                                } else {
                                    logHtml = `<div class="alert alert-secondary">Belum ada log untuk ticket ini.</div>`;
                                }

                                $("#log_task_container_check").html(logHtml);
                    // Log 
                });
            });
    // Checking Ticket

    // Showing Approval User
            $('#update_system_table').on('click','.approval', function(){
                var ticket_code = $(this).data('ticket')
                var currentStep = $(this).data('step')
                var approval_code = $(this).data('approval')

                $('#approvalUpdateSystemModal').modal({backdrop: 'static', keyboard: false})
                $('#approvalUpdateSystemModal').modal('show');

                var data = { 'approval_code' : approval_code }
                var data_log = { 'ticket_code' : ticket_code }

                // Ambil log dulu
                getCallbackNoSwal('getDetailERP', data_log, function(response_log){
                    console.log("History log:", response_log);

                    let approvedUsers = [];
                    let remarkMap = {};
                    if(response_log.data && response_log.data.history_relation){
                        response_log.data.history_relation.forEach(h => {
                            approvedUsers.push(h.user_id);
                            remarkMap[h.user_id] = {
                                remark: h.remark ?? "-",
                                approved_at: h.created_at
                            };
                        });
                    }

                    // Ambil approver detail
                    getCallback('getApproverDetail', data, function(response){
                        swal.close()
                        let container = $('#approval_update_system_container');
                        container.empty();

                        if(response.data && response.data.length > 0){
                            // Group by step
                            let grouped = {};
                            response.data.forEach(item => {
                                if(!grouped[item.step]) grouped[item.step] = [];
                                grouped[item.step].push(item);
                            });

                            let steps = Object.keys(grouped).sort((a,b) => a-b);

                            steps.forEach((step, idx) => {
                                let users = grouped[step];

                                // highlight kalau step sama dengan currentStep
                                let stepTitleClass = (parseInt(step) === parseInt(currentStep)) 
                                    ? "step-title bg-primary text-white" 
                                    : "step-title";

                                let row = `
                                    <div class="step-wrapper mb-5 ${idx === steps.length-1 ? 'last-step' : ''}">
                                        <div class="text-center mb-4">
                                            <span class="${stepTitleClass}">Step ${step}</span>
                                        </div>
                                        <div class="d-flex justify-content-center flex-wrap gap-3">`;

                               users.forEach(u => {
                                let isApproved = approvedUsers.includes(u.user_id);

                                let cardClass = "border-0 shadow-sm position-relative";
                                let iconClass = "fa-user-circle text-primary";
                                let nameColor = "text-dark";
                                let extraSmall = "text-muted";
                                let statusBadge = `<span class="badge bg-secondary position-absolute top-0 end-0 m-2">PENDING</span>`;
                                let remarkHtml = "";

                                if (isApproved) {
                                    cardClass = "border-success bg-success text-white position-relative";
                                    iconClass = "fa-user-check text-white";
                                    nameColor = "text-white";
                                    extraSmall = "text-white-50";
                                    statusBadge = `<span class="badge bg-light text-success position-absolute top-0 end-0 m-2">APPROVED</span>`;

                                    let r = remarkMap[u.user_id];
                                    remarkHtml = `
                                        <div class="p-2 mt-2 rounded" style="background: rgba(255,255,255,0.1); font-size:12px; text-align:left;">
                                            <div><strong>Remark:</strong> ${r.remark}</div>
                                            <div class="mt-1"><i class="fa-regular fa-clock"></i> ${new Date(r.approved_at).toLocaleString()}</div>
                                        </div>`;
                                }

                                row += `
                                    <div class="card ${cardClass} rounded-3" style="width:180px; min-height: 100px;">
                                       
                                        <div class="card-body p-3 text-center d-flex flex-column justify-content-between">
                                            <div>
                                                <i class="fa-solid ${iconClass} fa-2x mb-2"></i>
                                                <div class="fw-semibold ${nameColor}" style="font-size:12px !important">${u.user_relation.name}</div>
                                                <small class="${extraSmall} d-block">${u.user_relation.nik}</small>
                                                <small class="${extraSmall} d-block">${u.user_relation.department_relation.name}</small>
                                            </div>
                                            ${remarkHtml}
                                        </div>
                                    </div>`;
                            });


                                row += `</div></div>`;
                                container.append(row);
                            });

                        } else {
                            container.html(`<div class="alert alert-warning text-center">No approvers found</div>`);
                        }
                    });
                });
            })

    // Showing Approval User
    //Export to PDF
        $('#update_system_table').on('click','.report', function(){
            var ticket_code = $(this).data('ticket')
            let result = ticket_code.replaceAll("/", "_");
            window.open('/report_system_ticket/'+result, '_blank');
        })
    //Export to PDF  
// Operation

// Function
        function renderTable() {
            let tbody = $("#arrayTable tbody");
            tbody.empty();

            if (requestArray.length === 0) {
                $("#arrayTable").hide();
                return;
            } else {
                $("#arrayTable").show();
            }

            requestArray.forEach((item, index) => {
                let imgCell = "-";
                if (item.images.length > 0) {
                    imgCell = `<img src="${item.images[0]}" style="width:60px;height:auto;">`;
                }
                // Parse HTML ke DOM
                var htmlResponse  = item.remark
                let parser = new DOMParser();
                let doc = parser.parseFromString(htmlResponse, 'text/html');
                doc.querySelectorAll('img').forEach(img => img.remove());
                let remark = doc.body.innerHTML;
                tbody.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.aspect}</td>
                        <td>${item.module}</td>
                        <td>${item.data_type}</td>
                        <td>${item.request_type}</td>
                        <td>${remark}</td>
                        <td>${imgCell}</td>
                        <td>
                            <button class="btn btn-sm btn-danger btn_delete" data-url="${item.images[0]}" data-index="${index}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }

        function uploadImage(file) {
            let data = new FormData();
            data.append("file", file);
            data.append("_token", $('meta[name="csrf-token"]').attr('content'));
            postCallbackNoSwal("{{ url('upload-image') }}", data, function(response) {
                // Ambil URL dari response JSON
                let url = response.url;  

                // Masukin ke Summernote
                $('#remark').summernote("insertImage", url);

                // Update hidden input
                let currentImages = $("#uploaded_images").val();
                let imageArray = currentImages ? currentImages.split(",") : [];
                imageArray.push(url);
                $("#uploaded_images").val(imageArray.join(","));
            });
        }

        function deleteImage(src) {
            $.ajax({
                url: "/delete-image",
                type: "POST",
                data: { src: src, _token: $('meta[name="csrf-token"]').attr('content') },
                success: function() {
                    console.log("Image deleted from server");
                },
                error: function(err) {
                    console.error("Image delete failed", err);
                }
            });
        }

        function mappingTable(response,table){
            var data =''
            $('#'+ table).DataTable().clear();
            $('#'+ table).DataTable().destroy();
            var data=''
                  for (i = 0; i < response.length; i++) {
                    var status = '';
                    var btnCheck = '';
                    var btnReport = '';
                    var btnApproval = '';
                    var btnDetail =`
                          <button title="Information About Ticket" 
                                        class="edit btn btn-sm btn-info rounded"  
                                        data-ticket="${response[i].ticket_code}"  
                                        data-name="${response[i].name}" 
                                        data-location="${response[i].location_id}" 
                                        data-system="${response[i].aspek}"  
                                        data-id="${response[i]['id']}" 
                                        data-status="${response[i]['status']}" 
                                        data-toggle="modal" 
                                        data-target="#editModuleModal">
                                 <i class="fa-solid fa-circle-info"></i>
                                </button>
                    `
                   switch (response[i].status) {
                        case 0:
                            status = `
                                <span style="font-size:9px !important; border-radius:20px !important" 
                                    class="badge  badge-status badge-info px-3 py-2">
                                    <i class="fas fa-hourglass-half"></i> WAITING FOR APPROVAL
                                </span>`;
                            btnApproval = `
                                <button title="Approver List" 
                                        class="approval btn btn-sm btn-primary rounded"  
                                        data-ticket="${response[i].ticket_code}"  
                                        data-step="${response[i].step}"  
                                        data-approval="${response[i].approval_code}">
                                    <i class="fa-solid fa-user-check"></i>
                                </button>
                            `;
                            break;

                        case 1:
                            status = `
                                <span style="font-size:9px !important; border-radius:20px !important" 
                                    class="badge  badge-status badge-warning px-3 py-2">
                                    <i class="fas fa-spinner fa-spin"></i> IN PROGRESS
                                </span>`;
                            break;

                        case 2:
                            status = `
                                <span style="font-size:9px !important; border-radius:20px !important" 
                                    class="badge  badge-status badge-primary px-3 py-2">
                                    <i class="fas fa-user-check"></i> CHECKED BY USER
                                </span>`;
                            if(auth_id == response[i].user_id){
                                var btnCheck = `
                                    <button title="Check Task" 
                                            class="checking btn btn-sm btn-dark rounded"  
                                            data-ticket="${response[i].ticket_code}"  
                                            data-name="${response[i].name}" 
                                            data-location="${response[i].location_id}" 
                                            data-system="${response[i].aspek}"  
                                            data-id="${response[i]['id']}" 
                                            data-status="${response[i]['status']}">
                                        <i class="fa-solid fa-user-tie"></i>
                                    </button>
                                `;
                            }
                            break;

                        case 3:
                            status = `
                                <span style="font-size:9px !important; border-radius:20px !important" 
                                    class="badge  badge-status badge-danger px-3 py-2">
                                    <i class="fas fa-edit"></i> REVISE
                                </span>`;
                            break;

                        case 4:
                            status = `
                                <span style="font-size:9px !important; border-radius:20px !important" 
                                    class="badge  badge-status badge-success px-3 py-2">
                                    <i class="fas fa-check-circle"></i> DONE
                                </span>`;

                            btnReport = `<button title="Report Task" 
                                        class="report btn btn-sm btn-success rounded"  
                                        data-ticket="${response[i].ticket_code}"  
                                        data-name="${response[i].name}" 
                                        data-location="${response[i].location_id}" 
                                        data-system="${response[i].aspek}"  
                                        data-id="${response[i]['id']}" 
                                        data-status="${response[i]['status']}" 
                                        >
                                    <i class="fas fa-file-alt"></i>
                                </button>`;
                            break;
                        case 5:
                        status = `
                            <span style="font-size:9px !important; border-radius:20px !important" 
                                class="badge  badge-status badge-dark px-3 py-2">
                               <i class="fa-solid fa-circle-xmark"></i>  REJECT
                            </span>`;
                        break;
                    }


                    data += `
                        <tr style="text-align: center; vertical-align: middle;">
                            <td style="text-align:cneter">${formatDateTime(response[i].created_at)}</td>
                            <td style="text-align:cneter">${response[i].ticket_code}</td>
                            <td style="text-align:left">${response[i].user_relation.location_relation.name}</td>
                            <td style="text-align:left">${response[i].user_relation.department_relation.name}</td>
                            <td style="text-align:left">${response[i].user_relation.name}</td>
                            <td style="text-align:center">${status}</td>
                            <td style="text-align:right">
                                ${btnApproval}
                                ${btnDetail}
                                ${btnCheck}
                                ${btnReport}
                            </td>
                        </tr>
                    `;
                }

            $(`#${table}> tbody:first`).html(data);
            $('#'+ table).DataTable({
                scrollX  : true,
            }).columns.adjust()
        }
        
// Function

// Initiating
    $('#remark').summernote({
        height: 50,
        placeholder: 'Write remark here...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontsize', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                for (let i = 0; i < files.length; i++) {
                    uploadImage(files[i]);
                }
            },
            onMediaDelete: function(target) {
                deleteImageFromServer(target.attr('src'));
            }
        }
    });

    // Fungsi hapus image
    function deleteImageFromServer(imageUrl) {
        let data = { src: imageUrl };
        postCallbackNoSwal('delete-image', data, function(response) {
            console.log('done');
        });
    }
    // Detect delete/backspace
    $('#remark').on('keydown', function(e) {
        if (e.key === 'Delete' || e.key === 'Backspace') {
            // Cari gambar yang udah ilang dibanding sebelumnya
            let currentImages = [];
            $('#remark').next('.note-editor').find('.note-editable img').each(function() {
                currentImages.push($(this).attr('src'));
            });
            if (window._lastImages) {
                let deletedImages = window._lastImages.filter(src => !currentImages.includes(src));
                deletedImages.forEach(src => deleteImageFromServer(src));
            }
            window._lastImages = currentImages;
        }
    });

    // Simpan list gambar setiap ada perubahan
    $('#remark').on('summernote.change', function(we, contents) {
        let currentImages = [];
        $(contents).find('img').each(function() {
            currentImages.push($(this).attr('src'));
        });
        window._lastImages = currentImages;
    });
// Initiating
</script>