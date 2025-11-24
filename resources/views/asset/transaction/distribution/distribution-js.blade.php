<script>
    $(document).ready(function () {
        $('#distribution_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `getDistributionTicket`,
                type: 'GET',
            },
            columns: [
                { data: 'request_code', name: 'request_code' },
                { data: 'location_relation.name', name: 'location_relation.name' },
                { data: 'des_location_relation.name', name: 'des_location_relation.name' },
                {
                    data: 'request_type',
                    name: 'request_type',
                    render: function (data) {
                        switch (data) {
                            case 1:
                                return 'Distribution';
                            case 2:
                                return 'Hand Over';
                            case 3:
                                return 'Return';
                            default:
                                return '';
                        }
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data) {
                        let badgeClass = 'badge fs-5 d-block text-center fw-bold px-2 py-1 mx-2';
                        switch (data) {
                            case 0:
                                return `<span class="${badgeClass} bg-secondary text-white">DRAFT</span>`;
                            case 1:
                                return `<span class="${badgeClass} bg-info text-white">APPROVAL</span>`;
                            case 2:
                                return `<span class="${badgeClass} bg-warning text-dark">IN PROGRESS</span>`;
                            case 3:
                                return `<span class="${badgeClass} bg-primary text-white">CHECKING</span>`;
                            case 4:
                                return `<span class="${badgeClass} bg-success text-white">DONE</span>`;
                            case 5:
                                return `<span class="${badgeClass} bg-danger text-white">REJECT</span>`;
                            default:
                                return `<span class="${badgeClass} bg-secondary text-white">UNKNOWN</span>`;
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                }

            ]
        });
    })
    $('#btn_refresh_distribution').on('click', function(){
        $('#distribution_table').DataTable().ajax.reload();
    })
    let selectedAssets = [];
    $('#btn_add_distribution').on('click', function () {
        $('#form_serialize')[0].reset();
        $('.message_error').text('');
        $('.destination_location_container').prop('hidden', false);
        $('#detail_item_table').DataTable().clear().destroy();
        $('.receiver_container').prop('hidden', false);
        getActiveItems('get_kantor', null, 'select_location','Location');
        getActiveItems('get_kantor', null,'select_destination_location','Des Location');
        onChange('select_location', 'location_id');
        onChange('select_asset_type', 'asset_type');
        onChange('select_destination_location', 'destination_location_id');
        onChange('select_current_user', 'current_user_id');
        onChange('select_receiver', 'receiver_id');
           $('#item_container').prop('hidden', true);
            $('#array_container').prop('hidden', true);
    });
    $("#select_request_type").on('change', function () {
        const currentVal = $(this).val();
        if (currentVal === '3') {
            $('#detail_item_table').DataTable().clear().destroy();
            $('.destination_location_container').prop('hidden', true);
            $('.receiver_container').prop('hidden', true);
            $('.user_container').prop('hidden', true);
           
             $('#item_container').prop('hidden', true);
            $('#array_container').prop('hidden', true);
        } else if(currentVal === '2'){
             $('#item_container').prop('hidden', false);
             $('#array_container').prop('hidden', false);
            var select_location = $('#select_location').val();
            $('.receiver_container').prop('hidden', false);
            $('.user_container').prop('hidden', true);
            $('#detail_item_table').DataTable().clear().destroy();
            $('#detail_item_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `getInactiveAsset`,
                    data: {
                        'location_id': select_location,
                    },
                    type: 'GET',
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `<input type="checkbox" class="row-checkbox" value="${row.asset_code}">`;
                        }
                    },
                    { data: 'asset_code', name: 'asset_code' },
                    { data: 'category', name: 'category' },
                    { data: 'brand', name: 'brand' },
                   {
                        data: 'type',
                        name: 'type',
                        render: function (data, type, row) {
                            return row.type == '1' ? 'Parent' : 'Child';
                        }
                    },
                    { data: 'parent_code', name: 'parent_code' },
                    { data: 'user_relation.departement.name', name: 'user_relation.departement.name' },
                    { data: 'user_relation.location_relation.name', name: 'user_relation.location_relation.name' },
                    { data: 'user_relation.name', name: 'user_relation.name' },
                ],
                drawCallback: function () {
                    $('.row-checkbox').each(function () {
                        const assetCode = $(this).val();
                        if (selectedAssets.includes(assetCode)) {
                            $(this).prop('checked', true);
                        }
                    });
                }
            });

        }else {
            $('#detail_item_table').DataTable().clear().destroy();
            $('.destination_location_container').prop('hidden', false);
            $('.receiver_container').prop('hidden', false);
            $('.user_container').prop('hidden', false);
             $('#item_container').prop('hidden', false);
            $('#array_container').prop('hidden', false);
        }
    });
    $('#select_current_user').on('change', function () {
         const currentVal = $(this).val();
        if(currentVal == null) {
            return;
        }else{
            $('#detail_item_table').DataTable().clear().destroy();
            $('#detail_item_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `getAssetUser`,
                    data: {
                        'id': currentVal,
                    },
                    type: 'GET',
                },
                success: function (data) {
                    console.log(data);
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `<input type="checkbox" class="row-checkbox" value="${row.asset_code}">`;
                        }
                    },
                    { data: 'asset_code', name: 'asset_code' },
                    { data: 'category', name: 'category' },
                    { data: 'brand', name: 'brand' },
                   {
                        data: 'type',
                        name: 'type',
                        render: function (data, type, row) {
                            return row.type == 1 ? 'Parent' : 'Child';
                        }
                    },
                    { data: 'parent_code', name: 'parent_code' },
                    { data: 'user_relation.departement.name', name: 'user_relation.departement.name' },
                    { data: 'user_relation.location_relation.name', name: 'user_relation.location_relation.name' },
                    { data: 'user_relation.name', name: 'user_relation.name' },
                ],
                drawCallback: function () {
                    $('.row-checkbox').each(function () {
                        const assetCode = $(this).val();
                        if (selectedAssets.includes(assetCode)) {
                            $(this).prop('checked', true);
                        }
                    });
                }
            });
        }
    });
    $('#select_location').on('change', function(){
        var data = {
           'id' : $(this).val(), 
        }
      getActiveItems('getUserLocation', data, 'select_current_user', 'Current User');
    })
    $('#select_destination_location').on('change', function(){
        var data = {
           'id' : $(this).val(), 
        }
      getActiveItems('getUserLocation', data, 'select_receiver', 'Receiver User');
    })
  
    $('#btn_save_distributuibn').on('click', function(e) {
        e.preventDefault();
        var request_type = $('#select_request_type').val();
        if(request_type == 3){
            return
        }else{
             if (selectedAssets.length === 0) {
                toastr['warning']('Please select at least one asset before submitting.');
                return;
            }
        }

        const formData = new FormData($('#form_serialize')[0]);
        formData.append('selected_assets', JSON.stringify(selectedAssets));
        formData.append('asset_type', $('#select_asset_type').val());
        formData.append('currentPath', $('#currentPath').val());
        formData.append('location_id', $('#location_id').val());
        formData.append('request_type', request_type);
        formData.append('destination_location_id', $('#destination_location_id').val());
        formData.append('current_user_id', $('#current_user_id').val());
        formData.append('receiver_id', $('#receiver_id').val());
        
        var attachment = $('#attachment')[0].files[0];
        formData.append('attachment', attachment);
        formData.append('notes', $('#notes').val());

        postAttachment('addDistribution', formData, false, function(response){
            swal.close();
            $('#addDistributionModal').modal('hide');
            toastr['success'](response.meta.message);
            $('#distribution_table').DataTable().ajax.reload();
        });
    });


    // info
        $('#distribution_table').on('click', '.edit', function(){
            $('#detailDistributionModal').modal('show')
            $('#ict_asset_fieldset').prop('hidden', true);
            var id = $(this).data('id')
            var data = {
                'id' : id,
            }
            getCallback('detailDistributionTicket', data, function(response){
                swal.close()
               
                $('#ict_request_code').val(response.detail.request_code)
                    if(user_role == 'Developer' || user_role == "Support"){
                        if(response.detail.status === 2){
                            $('#ict_progress_btn').prop('hidden', false);
                        }else{
                            $('#ict_progress_btn').prop('hidden', true);
                        }
                    }else{
                        $('ict_progress_btn').prop('hidden', true);

                    }
               

                if(response.detail.status === 3){
                    $('#ict_incoming_btn').prop('hidden', false);
                }else{
                    $('#ict_incoming_btn').prop('hidden', true);
                }
                switch(response.detail.request_type) {
                    case 1:
                        $('#ict_request_type').text(': Distribution');
                        break;
                    case 2:
                        $('#ict_request_type').text(': Hand Over');
                        break;
                    case 3:
                        $('#ict_request_type').text(': Return');
                        break;
                    default:
                        $('#ict_request_type').text(': Unknown');
                }
                $('#ict_request_code').text(': ' + response.detail.request_code)
                $('#ict_current_location').text(': ' + response.detail.location_relation.name)
                $('#ict_destination_location').text(': ' + response.detail.des_location_relation.name)
                $('#ict_current_user').text(': ' + response.detail.current_relation.name)
               $('#ict_receiver_user').text(': ' + (response.detail.receiver_relation?.name || '-'));

                $('#ict_notes').text(': ' + response.detail.notes)
                if(response.detail.attachment){
                    $('#ict_attachment').html(`:
                        <a target="_blank" href="{{URL::asset('storage/Asset/Distribution/attachment/${response.detail.attachment}')}}" class="text-primary">
                            <i class="fa-solid fa-file" style="color: red;font-size: 20px;"></i>
                            ${response.detail.attachment}</a>
                            `)
                }else{
                    $('#ict_attachment').html(`<span>: -<span>`)
                }


                  // asset table
                    $('#ict_asset_table tbody').empty();
                
                    if (response.detail.detail_relation && response.detail.detail_relation.length > 0) {
                        response.detail.detail_relation.forEach(function(asset) {
                            let conditionBadge = '';
                            switch(asset.condition){
                                case 1:
                                    conditionBadge = '<span class="badge bg-success">Good</span>';
                                    break;
                                case 2:
                                    conditionBadge = '<span class="badge bg-warning text-dark">Partially Good</span>';
                                    break;
                                case 3:
                                    conditionBadge = '<span class="badge bg-danger">Damaged</span>';
                                    break;
                                default:
                                    conditionBadge = '<span class="badge bg-secondary">-</span>';
                            }
                            $('#ict_info_condition').html(conditionBadge);
                            var statusLabel =''  
                            switch(asset.status){
                                case 0:
                                    statusLabel = '<span class="badge bg-secondary">Prepare</span>';
                                    break;
                                case 1:
                                    statusLabel = '<span class="badge bg-warning text-white">In Progress</span>';
                                    break;
                                case 2:
                                    statusLabel = '<span class="badge bg-track text-white">Sending Progress</span>';
                                    break;
                                case 3:
                                    statusLabel = '<span class="badge bg-success text-white">DONE</span>';
                                    break;
                                default:
                                    statusLabel = '<span class="badge bg-secondary">UNKNOWN</span>';
                            }

                             var attachment ='-'
                             if(asset.status == 3){
                                    if(asset.attachment !== ''){
                                        console.log(asset.attachment)
                                        let attachmentPath = asset.attachment; 
                                        let fileName = attachmentPath.split('/').pop()
                                        attachment = `<a target="_blank" href="{{URL::asset('storage/${asset.attachment}')}}" class="text-primary">
                                                <i class="fa-solid fa-file" style="color: red;font-size: 16px;"></i> ${fileName}
                                        </a>`
                                    }
                             }
                            let row = `
                                <tr>
                                    <td>${asset.asset_code || '-'}</td>
                                    <td>${asset.asset_relation.category_relation?.name || '-'}</td>
                                    <td>${asset.asset_relation.brand_relation?.name || '-'}</td>
                                    <td>${asset.type ? 'Parent' : 'Child' || '-'}</td>
                                    <td style="text-align: center !important;">
                                        ${conditionBadge}
                                    </td>
                                    <td style="text-align: center !important;">
                                        ${statusLabel}
                                    </td>
                                    <td style="text-align: center !important;">
                                        ${attachment}
                                    </td>
                                </tr>
                            `;
                            $('#ict_asset_table tbody').append(row);
                        });
                    } else {
                        $('#ict_asset_table tbody').append('<tr><td colspan="5" class="text-center">Tidak ada data aset</td></tr>');
                    }

                    // Delegasi klik ke tbody
                    $('#ict_asset_table tbody').on('click', 'tr', function () {
                        $('#ict_asset_fieldset').prop('hidden', false);
                        const rowIndex = $(this).index(); // ambil index row
                        const asset = response.detail.detail_relation[rowIndex]; // ambil data yang sesuai index-nya

                        let condition = '';
                        switch (asset.condition) {
                            case 1:
                                condition = '<span class="badge bg-success">Good</span>';
                                break;
                            case 2:
                                condition = '<span class="badge bg-warning text-dark">Partially Good</span>';
                                break;
                            case 3:
                                condition = '<span class="badge bg-danger">Broken</span>';
                                break;
                            default:
                                condition = '<span class="badge bg-secondary">-</span>';
                        }

                        // Image
                        let imageHtml = '-';
                        if (asset.asset_relation?.image) {
                            const imageUrl = `{{ URL::asset('storage/Asset/ICT/') }}/${asset.asset_relation.image}`;
                            imageHtml = `<img src="${imageUrl}" alt="Asset Image" class="img-fluid rounded" style="max-height: 150px;">`;
                        }

                     // Software List
                        let softwareHtml = '-';
                        if (asset.asset_relation?.software_relation && asset.asset_relation.software_relation.length > 0) {
                            softwareHtml = `
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 40%">Name</th>
                                            <th style="width: 60%">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${asset.asset_relation.software_relation.map(soft => `
                                            <tr>
                                                <td>${soft.name || '-'}</td>
                                                <td>${soft.details || '-'}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            `;
                        }


                        // Template isi detail asset
                        let detailHtml = `
                            <div class="row">
                                <div class="col-2"><p>Asset Code</p></div>
                                <div class="col-4"><p>: ${asset.asset_code || '-'}</p></div>
                                <div class="col-2"><p>Category</p></div>
                                <div class="col-4"><p>: ${asset.asset_relation?.category_relation?.name || '-'}</p></div>

                                <div class="col-2"><p>Brand</p></div>
                                <div class="col-4"><p>: ${asset.asset_relation?.brand_relation?.name || '-'}</p></div>
                                <div class="col-2"><p>Type</p></div>
                                <div class="col-4"><p>: ${asset.type ? 'Parent' : 'Child'}</p></div>

                                <div class="col-2"><p>Parent Code</p></div>
                                <div class="col-4"><p>: ${asset.asset_relation?.parent_code || '-'}</p></div>
                                <div class="col-2"><p>Condition</p></div>
                                <div class="col-4"><p>: ${condition}</p></div>

                                <div class="col-2"><p>Owner</p></div>
                                <div class="col-4"><p>: ${asset.asset_relation?.owner_relation?.name || '-'}</p></div>
                                <div class="col-2"><p>Location</p></div>
                                <div class="col-4"><p>: ${asset.asset_relation?.location_relation?.name || 'Sending Proggress'}</p></div>

                                <div class="col-2"><p>Join Date</p></div>
                                <div class="col-4"><p>: ${asset.asset_relation?.join_date || '-'}</p></div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-2"><p>Image</p></div>
                                <div class="col-10"><p>${imageHtml}</p></div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-2"><p>Software</p></div>
                                <div class="col-10">
                                    ${softwareHtml}
                                </div>
                            </div>
                        `;


                        $('#ict_asset_info').html(detailHtml);
                    });

                    $('#ict_asset_incoming_table tbody').empty();
                
                    if (response.detail.detail_relation && response.detail.detail_relation.length > 0) {
                        response.detail.detail_relation.forEach(function(asset) {
                            let conditionBadge = '';
                          
                            $('#ict_info_condition').html(conditionBadge);
                            var statusLabel =''  
                            switch(asset.status){
                                case 0:
                                    statusLabel = '<span class="badge bg-secondary">Prepare</span>';
                                    break;
                                case 1:
                                    statusLabel = '<span class="badge bg-warning text-white">In Progress</span>';
                                    break;
                                case 2:
                                    statusLabel = '<span class="badge bg-track text-white">Sending Progress</span>';
                                    break;
                                case 3:
                                    statusLabel = '<span class="badge bg-success text-white">DONE</span>';
                                    break;
                                default:
                                    statusLabel = '<span class="badge bg-secondary">UNKNOWN</span>';
                            }
                            var check = ''
                            var attachment =''
                            var remarkIncoming =''
                            if(asset.status == 2){
                                check = `   <input type="checkbox" id="check" name="check" class="ict_asset_checkbox" style="border-radius: 5px !important;" value="${asset.asset_code}"   data-asset="${asset.asset_code}">`;
                                attachment =`
                                    <input type="file" class="form-control attachment-file" id="ict_attachment" name="ict_attachment" accept=".jpg, .jpeg, .png, .pdf" style="width: 100%;">
                                `
                                conditionBadge =`
                                  <select class="form-select condition-select" aria-label="Please Update Condition">
                                            <option value="0">Open this select menu</option>
                                            <option value="1">Good</option>
                                            <option value="2">Partially Good</option>
                                            <option value="4">Damaged</option>
                                        </select>    
                                `
                                remarkIncoming =`
                                    <textarea name="remark" class="form-control remark-input" id="remark" cols="30" rows="2" placeholder="Enter remark..."></textarea>
                                `
                              
                            }else if(asset.status == 3){
                                check = '<span class="badge bg-success text-white">Arrived</span>';
                                if(asset.attachment !== ''){
                                    attachment = `<a target="_blank" href="{{URL::asset('storage/Asset/Distribution/attachment/${asset.attachment}')}}" class="text-primary">
                                            <i class="fa-solid fa-file" style="color: red;font-size: 16px;"></i> ${asset.attachment}
                                    </a>`
                                }
                                switch(asset.condition){
                                    case 1:
                                        conditionBadge = '<span class="badge bg-success">Good</span>';
                                        break;
                                    case 2:
                                        conditionBadge = '<span class="badge bg-warning text-dark">Partially Good</span>';
                                        break;
                                    case 4:
                                        conditionBadge = '<span class="badge bg-danger">Broken</span>';
                                        break;
                                    default:
                                        conditionBadge = '<span class="badge bg-secondary">-</span>';
                                }
                                remarkIncoming = asset.remark || '-'
                            }
                            let row = `
                                <tr>
                                    <td style="text-align:center;">
                                        ${check}
                                    </td>
                                    <td>${asset.asset_code || '-'}</td>op
                                    <td>${asset.asset_relation?.category_relation?.name || '-'}</td>
                                    <td>${asset.asset_relation.brand_relation?.name || '-'}</td>
                                    <td>${asset.type ? 'Parent' : 'Child' || '-'}</td>
                                    <td style="text-align:center;"> ${conditionBadge}</td>
                                    <td style="text-align:center;">${statusLabel}</td>
                                    <td style="text-align:center;">${remarkIncoming}</td>
                                    <td>
                                        ${attachment}
                                    </td>
                                </tr>
                                `;
                                $('#ict_asset_incoming_table tbody').append(row);

                        });
                    } else {
                        $('#ict_asset_incoming_table tbody').append('<tr><td colspan="5" class="text-center">Tidak ada data aset</td></tr>');
                    }

                    // Delegasi klik ke tbody
                 
                     
                    $('#ict_log_list').empty();
                    if (response.detail.history_relation && response.detail.history_relation.length > 0) {
                        let logList = `<div class="timeline">`;

                        response.detail.history_relation.forEach(function(log) {
                            const location = log.location_relation?.name || '-';
                            const desLocation = log.des_location_relation?.name || '-';
                            const user = log.user_relation?.name || '-';
                            const pic = log.pic_relation?.name || '-';
                            const receiver = log.receiver_relation?.name || '-';
                            const approval = log.approval_relation?.name || '-';
                            const notes = log.notes || '-';
                            const createdAt = log.created_at ? moment(log.created_at).format("DD MMMM YYYY, HH:mm:ss") : '-';

                            const attachment = log.attachment
                                ? `<a target="_blank" href="{{URL::asset('storage/Asset/Distribution/attachmentLog/${log.attachment}')}}" class="text-primary">
                                        <i class="fa-solid fa-file" style="color: red;font-size: 14px;"></i> ${log.attachment}
                                </a>`
                                : '-';

                            let statusBadge = '';
                            let statusIcon = '';
                            let statusColor = '';
                            switch (log.status) {
                                case 0: 
                                    statusBadge = '<span class="badge bg-secondary">DRAFT</span>'; 
                                    statusIcon = '<i class="fas fa-file-alt text-white"></i>'; 
                                    statusColor = 'secondary';
                                    break;
                                case 1: 
                                    statusBadge = '<span class="badge bg-info text-white">APPROVAL</span>'; 
                                    statusIcon = '<i class="fas fa-check-circle text-white"></i>'; 
                                    statusColor = 'info';
                                    break;
                                case 2: 
                                    statusBadge = '<span class="badge bg-warning text-dark">IN PROGRESS</span>'; 
                                    statusIcon = '<i class="fas fa-spinner fa-spin text-white"></i>'; 
                                    statusColor = 'warning';
                                    break;
                                case 3: 
                                    statusBadge = '<span class="badge bg-primary text-white">CHECKING</span>'; 
                                    statusIcon = '<i class="fas fa-search text-white"></i>'; 
                                    statusColor = 'primary';
                                    break;
                                case 4: 
                                    statusBadge = '<span class="badge bg-success text-white">DONE</span>'; 
                                    statusIcon = '<i class="fas fa-check-double text-white"></i>'; 
                                    statusColor = 'success';
                                    break;
                                case 5: 
                                    statusBadge = '<span class="badge bg-danger text-white">REJECT</span>'; 
                                    statusIcon = '<i class="fas fa-times-circle text-white"></i>'; 
                                    statusColor = 'danger';
                                    break;
                                default: 
                                    statusBadge = '<span class="badge bg-secondary">UNKNOWN</span>';
                                    statusIcon = '<i class="fas fa-question-circle text-white"></i>'; 
                                    statusColor = 'secondary';
                            }

                            logList += `
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-${statusColor}" style="margin-left: 5px !important">
                                        ${statusIcon}
                                    </div>
                                 <div class="timeline-content card shadow-sm p-3">
                                    <div class="fw-bold text-primary mb-1">${user} ${statusBadge}</div>
                                    <table class="table table-sm mb-0 text-dark">
                                        <tbody>
                                            <tr>
                                                <th style="width:120px;">Location</th><td>: ${location}</td>
                                                <th style="width:120px;">Des Location</th><td>: ${desLocation}</td>
                                            </tr>                            <tr>
                                                <th>PIC</th><td>: ${pic}</td>
                                                <th>Receiver</th><td>: ${receiver}</td>
                                            </tr>
                                            ${approval !== '-' ? `
                                            <tr>
                                                <th>Approval</th><td colspan="3">: ${approval}</td>
                                            </tr>` : ``}
                                            <tr>
                                                <th>Attachment</th><td colspan="3">: ${attachment}</td>
                                            </tr>
                                            <tr>
                                                <th>Remark</th><td colspan="3">: ${notes}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="text-muted small mt-2" style="font-size:10px;">
                                        <i class="fas fa-clock"></i> ${createdAt}
                                    </div>
                                </div>

                                </div>
                            `;
                        });

                        logList += `</div>`;
                        $('#ict_log_list').html(logList);

                        // inject CSS timeline
                        const style = `
                            <style id="timeline-style">
                            .timeline {
                                position: relative;
                                margin: 20px 0;
                                padding: 0 0 0 30px;
                                border-left: 2px solid #dee2e6;
                            }
                            .timeline-item {
                                position: relative;
                                margin-bottom: 20px;
                            }
                            .timeline-marker {
                                position: absolute;
                                left: -23px;
                                top: 5px;
                                border-radius: 50%;
                                width: 40px;
                                height: 40px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-size: 18px;
                                color: #fff;
                            }
                            .timeline-content {
                                margin-left: 25px;
                                background: #fff;
                                border-radius: 8px;
                            }
                                /* Style umum untuk select */
                            select.form-control {
                                appearance: none; /* hilangin default arrow */
                                -webkit-appearance: none;
                                -moz-appearance: none;
                                
                                background-color: #fff;
                                border: 1px solid #ccc;
                                border-radius: 10px;
                                padding: 10px 35px 10px 15px;
                                font-size: 14px;
                                font-weight: 500;
                                color: #333;
                                cursor: pointer;
                                transition: all 0.3s ease;
                                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                                position: relative;
                            }

                            /* Hover & focus efek */
                            select.form-control:hover {
                                border-color: #007bff;
                                box-shadow: 0 0 8px rgba(0,123,255,0.3);
                            }

                            select.form-control:focus {
                                outline: none;
                                border-color: #0056b3;
                                box-shadow: 0 0 10px rgba(0,86,179,0.4);
                            }

                            /* Tambahin custom arrow */
                            select.form-control::after {
                                content: '▼';
                                font-size: 12px;
                                color: #555;
                                position: absolute;
                                right: 15px;
                                pointer-events: none;
                            }

                            </style>
                        `;
                        if (!$('head').find('#timeline-style').length) {
                            $('head').append(style);
                        }

                    } else {
                        $('#ict_log_list').html('<div class="text-center text-muted">Tidak ada riwayat distribusi</div>');
                    }
                    // log Transaction

                    // Software Information
                   let details = response.detail.detail_relation;
                    $("#software_container").empty(); // clear dulu biar nggak numpuk
                    
                    details.forEach(detail => {
                        if (detail.asset_relation) {
                            let assetCode = detail.asset_relation.asset_code ?? "Unknown Asset";
                            let conditionVal = detail.condition ?? null;

                            // Mapping condition → teks
                            let getConditionOptions = (selected) => {
                                let options = [
                                    { val: 1, text: "Good" },
                                    { val: 2, text: "Partially Good" },
                                    { val: 3, text: "Damaged" }
                                ];
                                return options.map(opt => 
                                    `<option value="${opt.val}" ${selected == opt.val ? "selected" : ""}>${opt.text}</option>`
                                ).join("");
                            };
                            let groupHtml = `
                                <fieldset class="mb-3 p-3 border">
                                    <legend>${assetCode}</legend>
                                    <div class="row">
                                        <div class="col-1 mt-2">
                                            <p>Condition</p>
                                        </div>
                                        <div class="col-4">
                                               <select name="condition[${assetCode}]" class="select2">
                                                    ${getConditionOptions(conditionVal)}
                                                </select>
                                         </div>
                                         
                                    </div>
                                   
                                    <div class="software-list"></div>
                                   
                                    <button type="button" class="btn btn-sm btn-success mt-2 addSoftwareBtn">
                                        <i class="fa fa-plus"></i> 
                                    </button>
                                </fieldset>
                            `;

                            let $group = $(groupHtml);
                            let $list = $group.find(".software-list");

                          if (detail.asset_relation.software_relation && detail.asset_relation.software_relation.length > 0) {
                                detail.asset_relation.software_relation.forEach(soft => {
                                    $list.append(`
                                        <div class="software-item row g-2 align-items-center mb-2">
                                            <div class="col-md-1 mt-3">
                                                <p>Name</p>
                                            </div>
                                            <div class="col-md-4">
                                              
                                                <input type="text" class="form-control"
                                                    name="software_name[${assetCode}][]"
                                                    value="${soft.name ?? ''}"
                                                    placeholder="Software Name">
                                            </div>
                                             <div class="col-md-1 mt-3">
                                                <p>Detail</p>
                                            </div>
                                            <div class="col-md-4">
                                                
                                                <input type="text" class="form-control"
                                                    name="software_detail[${assetCode}][]"
                                                    value="${soft.details ?? ''}"
                                                    placeholder="Software Detail">
                                            </div>
                                            <div class="col-auto d-flex align-items-end mt-1">
                                                <button type="button" class="btn btn-sm btn-danger deleteSoftwareBtn">
                                                    ×
                                                </button>
                                            </div>
                                        </div>
                                    `);
                                });
                            } else {
                                $list.append(`
                                    <div class="software-item row g-2 align-items-center mb-2">
                                        <div class="col-md-1 mt-3">
                                                <p>Name</p>
                                            </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control"
                                                name="software_name[${assetCode}][]"
                                                placeholder="Software Name">
                                        </div>
                                        <div class="col-md-1 mt-3">
                                                <p>Detail</p>
                                            </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control"
                                                name="software_detail[${assetCode}][]"
                                                placeholder="Software Detail">
                                        </div>
                                        <div class="col-auto d-flex align-items-end mt-1">
                                            <button type="button" class="btn btn-sm btn-danger deleteSoftwareBtn">
                                                ×
                                            </button>
                                        </div>
                                    </div>
                                `);
                            }


                            $("#software_container").append($group);
                            $('.select2').select2();
                        }
                    });

                    // Event tombol Add Software (per asset group)
                    $(document).off("click", ".addSoftwareBtn").on("click", ".addSoftwareBtn", function() {
                        let $list = $(this).siblings(".software-list");
                        let assetCode = $(this).closest("div.mb-3").find("h6").text();

                        $list.append(`
                             <div class="software-item row g-2 align-items-center mb-2">
                                        <div class="col-md-1 mt-3">
                                                <p>Name</p>
                                            </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control"
                                                name="software_name[${assetCode}][]"
                                                placeholder="Software Name">
                                        </div>
                                        <div class="col-md-1 mt-3">
                                                <p>Detail</p>
                                            </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control"
                                                name="software_detail[${assetCode}][]"
                                                placeholder="Software Detail">
                                        </div>
                                        <div class="col-auto d-flex align-items-end mt-1">
                                            <button type="button" class="btn btn-sm btn-danger deleteSoftwareBtn">
                                                ×
                                            </button>
                                        </div>
                                    </div>
                        `);
                    });

                    // Event tombol Delete Software
                    $(document).off("click", ".deleteSoftwareBtn").on("click", ".deleteSoftwareBtn", function() {
                        $(this).closest(".software-item").remove();
                    });

                    // Software Information
            })

          
        })
    // info

    // Prorgress Button
        $('#ict_progress_btn').on('click', function () {
            $('#detailDistributionModal').modal('hide');
            $('#progressModal').modal('show');
            $('#progress_form')[0].reset();
            $('.message_error').text('');
            
            $('#progressModal').on('hidden.bs.modal', function () {
                $('#detailDistributionModal').modal('show');
            });
        });
        
        $('#ict_incoming_btn').on('click', function () {
            $('#detailDistributionModal').modal('hide');
            $('#progress_form')[0].reset();
            $('.message_error').text('');
                $('#incomingModal').modal('show');
            $('#incomingModal').on('hidden.bs.modal', function () {
                $('#detailDistributionModal').modal('show');
            });
        });

       $('#btn_progress_asset').on('click', function(e){
            e.preventDefault();

            const formData = new FormData($('#progress_form')[0]);
            formData.append('ict_request_code', $('#ict_request_code').val());
            formData.append('ict_notes_progress', $('#ict_notes_progress').val());

            var attachment = $('#ict_progress_attachment')[0].files[0];
            formData.append('ict_progress_attachment', attachment);

            // 🔹 Ambil data Software Information
            let assets = [];
            $("#software_container fieldset").each(function(){
                let assetCode = $(this).find("legend").text().trim();
                let condition = $(this).find("select[name^='condition']").val();

                let softwares = [];
                $(this).find(".software-item").each(function(){
                    if(name !== '' || detail !== ''){
                        toastr.warning('Please fill all software fields or remove empty rows for asset '+assetCode);
                        return false
                    }else{
                        softwares.push({
                            name: $(this).find("input[name^='software_name']").val(),
                            detail: $(this).find("input[name^='software_detail']").val()
                        });
                    }
                });

                assets.push({
                    asset_code: assetCode,
                    condition: condition,
                    softwares: softwares
                });
            });
            // Tambahin ke FormData (jadi JSON biar gampang parsing di backend)
            formData.append('assets', JSON.stringify(assets));

            // 🔹 Kirim
            postAttachment('sendingDistribution', formData, false, function(response){
                swal.close();
                $('#progressModal').modal('hide');
                toastr['success'](response.meta.message);
                $('#distribution_table').DataTable().ajax.reload();
            });
        });

    // Prorgress Button

    // Incoming Button
       $('#incoming_btn').on('click', function(e) {
        e.preventDefault();

        let dataToSend = new FormData();
        let checkedCount = 0; 
        let hasConditionError = false;

        $('#ict_asset_incoming_table tbody tr').each(function(index, row) {
            let $row = $(row);
            let checkbox = $row.find('.ict_asset_checkbox');

            if (checkbox.is(':checked')) {
                let assetCode = checkbox.val();
                let conditionSelect = $row.find('.condition-select');
                let conditionVal = parseInt(conditionSelect.val());
                let remarkVal = $row.find('.remark-input').val()?.trim() || ''; // ambil remark

                if (conditionVal === 0 || isNaN(conditionVal)) {
                    toastr.info(assetCode + ' please set condition');
                    hasConditionError = true;
                    return false; // stop loop kalau ada error
                } else {
                    checkedCount++;

                    // ambil file attachment
                    let fileInput = $row.find('.attachment-file')[0];
                    let file = fileInput && fileInput.files.length > 0 ? fileInput.files[0] : null;

                    // append ke FormData
                    dataToSend.append(`assets[${assetCode}][condition]`, conditionVal);
                    dataToSend.append(`assets[${assetCode}][remark]`, remarkVal); // ⬅️ ditambahin remark
                    if (file) {
                        dataToSend.append(`assets[${assetCode}][attachment]`, file);
                    }

                    console.log(`✔️ Asset: ${assetCode}, Condition: ${conditionVal}, Remark: ${remarkVal}, File: ${file ? file.name : 'No file'}`);
                }
            }
        });

        dataToSend.append('ict_request_code', $('#ict_request_code').val());
        dataToSend.append('ict_incoming_notes', $('#ict_incoming_notes').val());
        var request_type = $('#select_request_type').val();
        if (request_type == 3) {
            console.log('test')
        } else {
            if (hasConditionError) {
                return false; // stop kalau ada asset yg belum isi condition
            }

            if (checkedCount === 0) {
                toastr.warning('Please select at least one asset!');
                return false;
            } else {
                $.ajax({
                    url: '/incoming-progress', // Ganti ke route kamu
                    type: 'POST',
                    data: dataToSend,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        SwalLoading('Please wait...');
                    },
                    success: function(response) {
                        swal.close()
                        console.log(response);
                        toastr.success('Data uploaded successfully');
                    },
                    error: function(xhr) {
                        swal.close()
                        console.log(xhr.responseText);
                        toastr.error('Upload failed');
                    }
                });
            }
        }
    });

    // Incoming Button
// Function
    // Operation 
    $('#detail_item_table').on('change', '.row-checkbox', function () {
        const table = $('#detail_item_table').DataTable();
        const row = table.row($(this).closest('tr')).data();
        const assetCode = row.asset_code;

        if ($(this).is(':checked')) {
            if (!selectedAssets.find(item => item.asset_code === assetCode)) {
                selectedAssets.push(row);
            }
        } else {
            selectedAssets = selectedAssets.filter(item => item.asset_code !== assetCode);
        }

        renderDistributionArray();
    });
    $('#distribution_array').on('click', '.remove-asset', function () {
        const code = $(this).data('code');

        // hapus dari array
        selectedAssets = selectedAssets.filter(item => item.asset_code !== code);

        // uncheck checkbox
        $('.row-checkbox').each(function () {
            if ($(this).val() === code) {
                $(this).prop('checked', false);
            }
        });

        renderDistributionArray();
    });
    $('#distribution_table').on('click', '.print', function(){
        var id = $(this).data('id')
        var data = {
            'id' : id,
        }
            window.open('/print-distribution-pdf/'+id, '_blank');
    })
    // Operation 
    function renderDistributionArray() {
        let html = '';
        selectedAssets.forEach((item, index) => {
            html += `
                <tr>
                    <td>${item.asset_code}</td>
                    <td>${item.category}</td>
                    <td>${item.brand}</td>
                    <td>${item.type == '1' ? 'Parent' : 'Child'}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-asset" data-code="${item.asset_code}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        $('#distribution_array tbody').html(html);
    }
// Function
</script>