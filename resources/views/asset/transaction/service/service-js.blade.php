<script>
    getCallbackNoSwal('getServiceTicket', null, function(response){
        console.log(response)
    })
     $(document).ready(function () {
   
        let table = $('#service_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `getService`,
            type: 'GET',
        },
        columns: [
            {
                className: 'text-center detail',
                orderable: false,
                data: null,
                defaultContent: '<i class="fas fa-plus-circle text-primary" style="cursor: pointer;"></i>',
            },
            { data: 'service_code', name: 'service_code' },
            { data: 'request_code', name: 'request_code' },
            { data: 'asset_code', name: 'asset_code' },
            { data: 'location_relation.name', name: 'location_relation.name' },
            { data: 'user_relation.name', name: 'user_relation.name' },
            { data: 'department_relation.name', name: 'department_relation.name' },
            {
                data: 'status',
                name: 'status',
                render: function (data) {
                    let badgeClass = 'badge fs-5 d-block text-center fw-bold px-2 py-1 mx-2';
                    switch (data) {
                        case 0: return `<span class="${badgeClass} bg-secondary text-white">New</span>`;
                        case 1: return `<span class="${badgeClass} bg-info text-white">IN PROGRESS</span>`;
                        case 2: return `<span class="${badgeClass} bg-danger text-white">PENDING</span>`;
                        case 3: return `<span class="${badgeClass} bg-success text-white">DONE</span>`;
                        default: return `<span class="${badgeClass} bg-secondary text-white">UNKNOWN</span>`;
                    }
                }
            },
            {
                data: 'duration',
                name: 'duration',
                render: function (data, type, row, meta) {
                    // console.log(data)
                    // if (data.status === 1 && data.start_time) {
                    //     // alert('test')
                    //     return `<span class="live-duration" data-start="${row.start_time}" data-row="${meta.row}">Loading...</span>`;
                    // }
                    // return data ?? '-';
                     const jam = Math.floor(data / 60);
                        const menit = data % 60;
                        return `${jam} jam ${menit} menit`;
                }
            }
        ]
    });

// Interval timer untuk update live duration setiap detik
setInterval(function () {
    $('.live-duration').each(function () {
        const startAttr = $(this).data('start');
        if (!startAttr) return;

        const start = new Date(startAttr);
        const now = new Date();
        const diffMs = now - start;
        const diffDate = new Date(diffMs);

        const hours = String(Math.floor(diffMs / 1000 / 3600)).padStart(2, '0');
        const minutes = String(Math.floor((diffMs / 1000 / 60) % 60)).padStart(2, '0');
        const seconds = String(Math.floor((diffMs / 1000) % 60)).padStart(2, '0');

        $(this).text(`${hours}:${minutes}:${seconds}`);
    });
}, 1000);


        $('#service_table tbody').on('click', 'td.detail', function () {
            var tr = $(this).closest('tr');
            var row = $('#service_table').DataTable().row(tr);

            if (row.child.isShown()) {
                // Close
                row.child.hide();
                tr.find('td.detail i').removeClass('fa-minus-circle text-danger').addClass('fa-plus-circle text-primary');
            } else {
                // Open
                tr.find('td.detail i').removeClass('fa-plus-circle text-primary').addClass('fa-minus-circle text-danger');

                let data = row.data();
                let asset = data.asset_relation;
                let history = data.history_relation;
                let html = `
                    <div class="p-3 bg-light rounded">
                        <h6 class="fw-bold mb-2">🧾 Asset Details</h6>
                        <ul class="mb-3">
                            <li style="font-size:10px">Asset Code: ${asset?.asset_code ?? '-'}</li>
                            <li style="font-size:10px">Category: ${asset?.category ?? '-'}</li>
                            <li style="font-size:10px">Brand: ${asset?.brand ?? '-'}</li>
                            <li style="font-size:10px">Type: ${asset?.type == 1 ? 'Parent' : 'Child'}</li>
                            <li style="font-size:10px">Current User: ${asset?.user_relation.name}</li>
                        </ul>

                        <h6 class="fw-bold mb-2">📜 Work Log</h6>
                        <ul>
                            ${
                                (() => {
                                    const statusMap = {0: 'New', 1: 'On Progress', 2: 'Pending', 3: 'Done'};

                                    const formatTanggal = (tanggal) => {
                                        if (!tanggal) return '-';
                                        return new Intl.DateTimeFormat('en-GB', {
                                            day: '2-digit',
                                            month: 'long',
                                            year: 'numeric'
                                        }).format(new Date(tanggal));
                                    };

                                    return history?.length > 0
                                        ? history.map(h => {
                                            const status = statusMap[h.status] || 'Unknown';
                                            const formattedDate = formatTanggal(h.updated_at);
                                            return `
                                                <li>
                                                    <strong>${status}</strong> by ${h.user_relation?.name || 'Unknown'} on ${formattedDate}<br/>
                                                    <em>${h.description ?? 'No notes available'}</em>
                                                </li>
                                            `;
                                        }).join('')
                                        : '<li>No history available.</li>';
                                })()
                            }
                        </ul>
                    </div>
                `;
                row.child(html).show();
            }
        });
    // Add Service Ticket
        $('#btn_add_service').on('click', function() {
            $('#addServiceModal').modal('show');
            $('#form_serialize')[0].reset();
            $('#request_code_id').val('');
            $('#subject').val('');
            $('#request_code_info').prop('hidden', true);
            getCallbackNoSwal('getRequestCode', null, function(response){
                $('#select_request_code').empty();
                $('#select_request_code').append('<option value="">Choose Request Code</option>');
                $.each(response.data, function(index, item) {
                    $('#select_request_code').append('<option value="' + item.request_code + '">' + item.request_code + '</option>');
                });
            });
        });
        $('#select_request_code').on('change', function() {
            var requestCode = $(this).val();
            if (requestCode) {
                getCallbackNoSwal('detailRequestCode', {request_code: requestCode}, function(response){
                    var statusLabel = response.detail.status_wo == 2 ? "On Progress" :"Waiting For Approval"
                    $('#label_location').text( ': ' + response.detail.pic_name.location_relation.name);
                    $('#location_id').val(response.detail.pic_name.location_relation.id);
                    $('#department_id').val(response.detail.pic_name.departement);
                    $('#label_user_request').text( ': ' + response.detail.pic_name.name);
                    $('#label_category').text( ': ' + response.detail.category_name.name);
                    $('#label_problem_type').text( ': ' + response.detail.problem_type_name.name);
                    $('#label_subject').text( ': ' + response.detail.subject);
                    $('#label_pic_support').text( ': ' + response.detail.pic_support_name.name);
                    $('#label_status').text( ': ' + statusLabel);
                    $('#label_additional_info').text( ': ' + response.detail.add_info);
                    if(response.detail.attachment == null) {
                        $('#label_attachment').html(': No Attachment');
                    } else {
                        $('#label_attachment').html('<a href="{{ url('storage') }}/' + response.detail.attachment + '" target="_blank">Attachment</a>');
                    }
                    mappingTableAsset(response.data)
                });
                $('#request_code_info').prop('hidden', false);
            } else {
                $('#request_code_info').prop('hidden', true);
            }
        });

        function mappingTableAsset(response) {
            $('#array_table_asset tbody').empty();
            var data = '';
            console.log(response)
            for(i = 0 ; i < response.length ; i++){
                data += `
                    <tr>
                        <td style="text-align:center"><input type="checkbox" id="check" name="check" class="ict_asset_checkbox" style="border-radius: 5px !important;" value="${response[i].asset_code}"   data-asset="${response[i].asset_code}"></td>
                        <td>${response[i].asset_code}</td>
                        <td>${response[i].category}</td>
                        <td>${response[i].type == 1 ?"Parent" : "Child"}</td>
                        <td>${response[i].brand}</td>
                    </tr>
                ` 
            }
            $('#array_table_asset tbody').html(data);
            $('.ict_asset_checkbox').on('change', function () {
                $('.ict_asset_checkbox').not(this).prop('checked', false);
            });
        }
        $('#select_request_code').on('change', function() {
            var requestCode = $(this).val();
            $('#request_code_id').val(requestCode);
        });
        $('#btn_save_service').on('click', function(e) {
            e.preventDefault();
            var formData = new FormData($('#form_serialize')[0]);
            formData.append('asset_code', $('#check').val());
            formData.append('location_id', $('#location_id').val());
            formData.append('department_id', $('#department_id').val());
            formData.append('request_code_id', $('#request_code_id').val());
            formData.append('subject', $('#subject').val());
            formData.append('description', $('#description').val());
            formData.append('attachment', $('#attachment')[0].files[0]);
            postAttachment('addService', formData, false, function(response){
                swal.close();
                $('#addServiceModal').modal('hide');
                toastr['success'](response.meta.message)
                $('#service_table').DataTable().ajax.reload(null, false);
            });
        })
    // Add Service Ticket

    // Edit Ticket
        $('#service_table tbody').on('click', 'tr', function (e) {
            if ($(e.target).closest('td.detail').length) {
                return; // Do nothing if the click is on td.dt-control
            }
            const row = table.row(this).data();
            
            if(row.status == 0){
                $('#btn_start_service').prop('hidden', false);
                $('#btn_update_service').prop('hidden', true);
                
            }else if (row.status == 1 || row.status == 2){
                $('#btn_start_service').prop('hidden', true);
                $('#btn_update_service').prop('hidden', false);
            }else{
                $('#btn_start_service').prop('hidden', true);
                $('#btn_update_service').prop('hidden', true);
            }
            $('#detailServiceModal').modal('show');
            $('#detail_service_code').text(': ' + row.service_code);
            $('#update_service_code').text(': ' + row.service_code);
            $('#update_service_asset_code').text(': ' + row.asset_code);
            $('#service_code').val(row.service_code);
            $('#asset_code_detail').val(row.asset_code);
            $('#detail_created_by').text(': ' + row.user_relation.name);
            $('#detail_request_code').text(': ' + row.request_code);
            $('#detail_asset_code').text(': ' + row.asset_code);
            $('#detail_location').text(': ' + row.location_relation.name);
            $('#detail_department').text(': ' + row.department_relation.name);
            $('#detail_subject').text(': ' + row.subject);
            $('#update_service_condition_id_error').val(row.asset_relation.condition);
            $('#select_service_condition').val(row.asset_relation.condition);
            $('#select_service_condition').select2().trigger('change');
            $('#btn_export_pdf_service').prop('hidden', true)
            switch (row.status) {
                case 0:
                    $('#detail_status').text(': New');
                    break;
                case 1:
                    $('#detail_status').text(': In Progress');
                    break;
                case 2:
                    $('#detail_status').text(': Pending');
                    break;
                case 3:
                    $('#detail_status').text(': Done');
                     $('#btn_export_pdf_service').prop('hidden', false)
                    break;
                default:
                    $('#detail_status').text(': Unknown Status');
            }
            $('#detail_notes').text(': ' + row.description);
            if(row.attachment == null) {
                $('#detail_attachment').html(': No Attachment');
                    } else {
                        const attachmentUrl = window.location.origin + '/' + row.attachment;
                        $('#detail_attachment').html(': <a href="' + attachmentUrl + '" target="_blank"><i class="fa-solid fa-file"></i> Click Here </a>');
                    }
                    
                    // Log Transaction
                        // Clear isi sebelumnya
                        $('#detail_history_log').html('');
                        function formatDuration(minutes) {
                            const jam = Math.floor(minutes / 60);
                            const menit = minutes % 60;
                            return `${jam} jam ${menit} menit`;
                        }
                    if (row.history_relation && row.history_relation.length > 0) {
                        let html = '<ul class="timeline">';
                        var x = 0;

                        row.history_relation.forEach(function (log) {
                            ++x;

                            const date = new Date(log.created_at);
                            const formattedDate = date.toLocaleDateString('en-EN', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                            });

                            const statusText = x == 2 ? '<span class="badge bg-success">Start</span>' : getStatusText(log.status);
                            const userName = log.user_relation?.name || 'Unknown';
                            const description = log.description || '-';

                        let attachmentHTML = '';
                            if (log.attachment) {
                                const attachmentUrl = window.location.origin + '/' + log.attachment;
                                if (isImageFile(log.attachment)) {
                                    // langsung tampilkan gambar
                                    attachmentHTML = `
                                        <div class="mt-2">
                                            <img src="${attachmentUrl}" 
                                                alt="Attachment" 
                                                class="img-fluid rounded shadow-sm border" 
                                                style="max-width:100%;">
                                        </div>
                                    `;
                                } else {
                                    attachmentHTML = `
                                        <div class="mt-2">
                                            <i class="fa-solid fa-file text-secondary me-1"></i> 
                                            <span class="text-muted">File tersedia: </span>
                                            <span class="fw-bold">${log.attachment.split('/').pop()}</span>
                                        </div>
                                    `;
                                }
                            }
                            const timelineIcon = getTimelineIcon(log.status);

                           html += `
                                <li class="timeline-item">
                                    <span class="timeline-icon ${timelineIcon.cls}">${timelineIcon.icon}</span>
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body p-3">
                                            <div class="row g-3">
                                                <!-- Info Kiri -->
                                                <div class="col-md-8 col-12">
                                                    <strong class="mb-1" style="font-size:14px"><i class="fa-regular fa-clock me-1"></i> ${formattedDate}</strong>
                                                    <p style="font-size:14px" class="mb-1"><b>By:</b> <span class="text-primary">${userName}</span></p>
                                                    <p style="font-size:14px" class="mb-1"><b>Status:</b> ${statusText}</p>
                                                    <p style="font-size:14px" class="mb-1"><b>Duration:</b> ${log.duration == 0 ? '-' : formatDuration(log.duration)}</p>
                                                    <p style="font-size:14px" class="mb-0"><b>Description:</b> <span class="text-muted">${description}</span></p>
                                                </div>
                                                <!-- Attachment Kanan -->
                                                <div class="col-md-4 col-12 d-flex align-items-center justify-content-center">
                                                    ${attachmentHTML}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            `;

                        });

                        html += '</ul>';
                        $('#detail_history_log').html(html);
        } else {
            $('#detail_history_log').html('<p class="text-muted">: No history log available.</p>');
        }
                    // Log Transaction

              function getStatusText(status) {
                    switch (status) {
                        case 0:
                            return '<span class="badge bg-secondary">New</span>';
                        case 1:
                            return '<span class="badge bg-info text-white">In Progress</span>';
                        case 2:
                            return '<span class="badge bg-warning text-white">Pending</span>';
                        case 3:
                            return '<span class="badge bg-success">Done</span>';
                        default:
                            return '<span class="badge bg-white">Unknown</span>';
                    }
                }

                function isImageFile(filename) {
                    return (/\.(jpg|jpeg|png|gif|webp)$/i).test(filename);
                }

                //Request Code
                    $('#wo_request_code').text(': ' + row.request_code);
                    $('#wo_request_type').text(row.ticket_relation.request_type == 1 ?": Request For Maintenance" : ": Request For Project");
                    $('#wo_category').text(': ' + row.ticket_relation.category_name.name);
                    $('#wo_problem_type').text(': ' + row.ticket_relation.problem_type_name.name);
                    $('#wo_subject').text(': ' + row.ticket_relation.subject);
                    $('#wo_additional_info').text(': ' + row.ticket_relation.add_info);
                    $('#wo_pic').text(': ' + row.ticket_relation.pic_name.name);
                    if(row.ticket_relation.attachment == null) {
                        $('#wo_attachment').html(': No Attachment');
                    } else {
                        $('#wo_attachment').html(': <a href="{{ url('storage') }}/' + row.ticket_relation.attachment_user + '" target="_blank">Attachment</a>');
                    }
                //Request Code 

                // Detail Asset
                    $('#wo_asset_code').text(': ' + row.asset_code);
                    $('#wo_asset_category').text(': ' + row.asset_relation.category);
                    $('#wo_asset_type').text(': ' + (row.asset_relation.type == 1 ? 'Parent' : 'Child'));
                    $('#wo_asset_brand').text(': ' + row.asset_relation.brand);
                    switch(row.asset_relation.condition){
                        case 1:
                            $('#wo_asset_condition').html(': <span class="badge bg-success">Good</span>');
                            break;
                        case 2:
                            $('#wo_asset_condition').html(': <span class="badge bg-warning text-dark">Partially Good</span>') ;
                            break;
                        case 3: 
                            $('#wo_asset_condition').html(': <span class="badge bg-danger">Broken</span>');
                            break;
                        default:
                            $('#wo_asset_condition').html(': <span class="badge bg-secondary">-</span>');
                    }
                // Detail Asset


            // Log Transaction
        })
    // Edit Ticket

    // Start Service
        $("#btn_start_service").on('click', function(){
            var data = {
                'service_code': $('#service_code').val(),
            }
            postCallback('startService', data, function(response){
                swal.close();
                $('#detailServiceModal').modal('hide');
                toastr['success'](response.meta.message)
                $('#service_table').DataTable().ajax.reload();
            })
        })
    // Start Service

    // Update Service   
        $('#btn_update_service').on('click', function(){
          $('#detailServiceModal').modal('hide');
          $('#updateServiceModal').modal('show');
          
        })

        $('#updateServiceModal').on('hide.bs.modal', function () {
            $('#update_description').val('');
            $('#attachment_update').val('');
            $('#detailServiceModal').modal('show');
        });
        onChange('select_service_condition', 'update_service_condition_id')
        onChange('select_service_progress', 'update_service_progress_id')
        $('#btn_save_update_service').on('click', function(e){
            e.preventDefault();
            var formData = new FormData($('#form_update_service')[0]);
            formData.append('service_code', $('#service_code').val());
            formData.append('update_service_description', $('#update_service_description').val());
            formData.append('update_service_condition_id', $('#update_service_condition_id').val());
            formData.append('update_service_progress_id', $('#update_service_progress_id').val());
            formData.append('update_service_attachment', $('#update_service_attachment')[0].files[0]);
            postAttachment('updateService', formData, false, function(response){
                swal.close();
                $('#updateServiceModal', '#detailServiceModal').modal('hide');
                toastr['success'](response.meta.message)
                $('#service_table').DataTable().ajax.reload(null, false);
            });
        })
    // Update Service
})
function getTimelineIcon(status) {
    switch(status) {
        case 1: // Start / Success
            return { icon: '<i class="fa-solid fa-play"></i>', cls: 'success' };
        case 2: // Pending
            return { icon: '<i class="fa-solid fa-hourglass-half"></i>', cls: 'pending' };
        case 3: // Approved
            return { icon: '<i class="fa-solid fa-check"></i>', cls: 'approved' };
        case 4: // Rejected
            return { icon: '<i class="fa-solid fa-xmark"></i>', cls: 'rejected' };
        default:
            return { icon: '<i class="fa-regular fa-circle"></i>', cls: 'pending' };
    }
}

// Export PDF
    $('#btn_export_pdf_service').on('click', function(){
        var serviceCode = $('#service_code').val();
        var servicereplace = serviceCode.replace(/\//g, '_');
        var url = `/exportPdfService/${servicereplace}`;
        window.open(url, '_blank');
    })
    $('#btn_print_service_history').on('click', function(){
        var asset_code_detail = $('#asset_code_detail').val();
        var servicereplace = asset_code_detail.replace(/\//g, '_');
        var url = `/exportPdfServiceHistory/${servicereplace}`;
        window.open(url, '_blank');
    })
</script>