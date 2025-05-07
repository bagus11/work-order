<script>
     $(document).ready(function () {
        $('#service_table').DataTable({
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
                            case 3: return `<span class="${badgeClass} bg-primary text-white">DONE</span>`;
                            default: return `<span class="${badgeClass} bg-secondary text-white">UNKNOWN</span>`;
                        }
                    }
                },
                { data: 'duration', name: 'duration' }
            ]
        });

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
                                    const statusMap = {0: 'Draft', 1: 'On Progress', 2: 'Pending', 3: 'Done'};

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
    })

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
</script>