<script>
    let detailRows = [];

    // Initialize DataTable for master asset
    const tableMasterAsset = $('#master_asset').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `getMasterAsset`,
            type: 'GET',
        },
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `${row.is_active == 1 ?'Active' :'Inactive'}`;
                }
            },
            { data: 'asset_code', name: 'asset_code' },
            { data: 'category', name: 'category' },
            { data: 'brand', name: 'brand' },
            {
                data: 'type',
                name: 'type',
                render: function (data) {
                    switch (data) {
                        case 1: return 'Parent';
                        case 2: return 'Child';
                        default: return 'Unknown';
                    }
                }
            },
            {
                data: 'parent_code',
                name: 'parent_code',
                render: function (data) {
                    return data && data.trim() !== '' ? data : '-';
                }
            },
            {
                data: 'user_relation.departement.name',
                name: 'user_relation.departement.name',
                render: function (data) {
                    return data ? data : '-';
                }
            },
            {
                data: 'user_relation.location_relation.name',
                name: 'user_relation.location_relation.name',
                render: function (data) {
                    return data ? data : '-';
                }
            },
            {
                data: 'user_relation.name',
                name: 'user_relation.name',
                render: function (data) {
                    return data ? data : '-';
                }
            },
            {
                data: 'nik',
                name: 'nik',
                render: function (data) {
                    return data ? data : '-';
                }
            }
        ]
    });

    // Reinitialize DataTable when switching tabs
    $('#custom-tabs-four-home-tab').on('click', function () {
        $('#master_asset').DataTable().ajax.reload();
    });

    $('#custom-tabs-four-profile-tab').on('click', function () {
        $('#master_asset_user').DataTable().clear().destroy();

        const tableUser = $('#master_asset_user').DataTable({
        rowId: 'id', // Ensure a valid and unique ID exists in your dataset
        processing: true,
        serverSide: true,
        ajax: {
            url: `getMasterAssetUser`,
            type: 'GET',
        },
        columns: [
            {
                class: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            { data: 'nik', name: 'nik' },
            { data: 'user_relation.name', name: 'user_relation.name' },
            {
                data: 'user_relation.departement.name',
                name: 'user_relation.departement.name',
                render: function (data) {
                    return data ? data : '-';
                }
            },
            {
                data: 'user_relation.location_relation.name',
                name: 'user_relation.location_relation.name',
                render: function (data) {
                    return data ? data : '-';
                }
            }
        ]
    });


        // Handle click for detail rows
        $('#master_asset_user').on('click', 'td.dt-control', function () {
            let tr = $(this).closest('tr');
            let row = tableUser.row(tr);

            if (row.child.isShown()) {
                tr.removeClass('details');
                row.child.hide();
            } else {
                tr.addClass('details');
                let nik = row.data().nik;
                $.ajax({
                    url: 'mappingAssetUser',
                    method: 'GET',
                    data: { nik: nik },
                    success: function (response) {
                        row.child(format(response.data)).show();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching details:', error);
                    }
                });
            }
        });


        // Redraw open detail rows after table redraw
        tableUser.on('draw', function () {
            detailRows.forEach(id => {
                let rowElement = $(`#${CSS.escape(id)}`);
                if (rowElement.length) {
                    rowElement.find('td.dt-control').trigger('click');
                }
            });
        });

    });

    // Detail Asset Tab 1
    $('#master_asset tbody').on('click', 'tr', function (e) {
        const row = tableMasterAsset.row(this).data();

        if ($(e.target).hasClass('row-checkbox')) {
            var data ={
                'is_active' : row.is_active,
                'asset_code' : row.asset_code
            }
           postCallback('updateStatusMasterAsset', data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            tableMasterAsset.ajax.reload();
           })
            
        }else{
            $('#detailMasterAssetModal').modal('show')
            var data = {
                'asset_code' : row.asset_code
            }
            if(row.type == 1){
                getCallbackNoSwal('mappingAssetChild', data, function(response){
                    swal.close()
                    $('#asset_child_table').DataTable().clear();
                    $('#asset_child_table').DataTable().destroy();
    
                    var data =''
                    for(i = 0 ; i < response.data.length; i ++ ){
                        data += `
                            <tr>
                                <td>${response.data[i].asset_code}</td>
                                <td>${response.data[i].category}</td>
                                <td>${response.data[i].brand}</td>
                            </tr>
                        `
                    }
                    $('#asset_child_table > tbody:first').html(data);
                    $('#asset_child_table').DataTable({
                        scrollX  : true,
                        scrollY  :220
                    }).columns.adjust()
                })
                $('#label_detail_type').html(': ' + row.spec_relation.type)
                $('#label_cd').html(row.spec_relation.cd == 0? ': -' :': ' + row.spec_relation.cd)
                $('#label_ip').html(': ' + row.spec_relation.ip_address)
                $('#label_mac').html(': ' + row.spec_relation.mac_address)
                $('#label_protection').html(': ' + row.spec_relation.protection)
                $('#label_processor').html(': ' + row.spec_relation.processor)
                $('#label_ram').html(': ' + row.spec_relation.ram + ' GB')
                $('#label_storage').html(': ' + row.spec_relation.storage + ' GB')
                $('.specification_container').prop('hidden', false)
            }else{
                $('.specification_container').prop('hidden', true)
            }
            $('#assetTitle').html(row.asset_code)
            $('#label_asset_code').html(": " + row.asset_code)
            $('#label_category').html(": " +row.category)
            $('#label_brand').html(": " + row.brand)
            $('#label_type').html(row.type == 1 ?': Parent' : ': Child' )
            $('#label_parent_code').html(row.parent_code == '' ? ': -' : ": " + row.parent_code)
            $('#label_pic').html(row.user_relation == null ?': -' :': '+row.user_relation.name)
            $('#label_location').html(row.user_relation.location_relation == null ?': -' :': ' + row.user_relation.location_relation.name)
            $('#label_is_active').html(row.is_active == 1 ?': active' : ': inactive')
        }
  
            $('#asset_history_table').DataTable().clear();
            $('#asset_history_table').DataTable().destroy();
            history_relation = row.history_relation
            console.log(history_relation)
            var dataAssetHistory =''
            for(i = 0 ; i < history_relation.length; i ++ ){
                const d = new Date(history_relation[i].created_at)
                const date = d.toISOString().split('T')[0];
                const time = d.toTimeString().split(' ')[0];
                dataAssetHistory += `
                    <tr>
                        <td>${date} + ${time}</td>
                        <td>${history_relation[i].creator_relation.name}</td>
                        <td>${history_relation[i].category}</td>
                        <td>${history_relation[i].brand}</td>
                        <td>${history_relation[i].type == 1 ? 'parent' : 'child'}</td>
                        <td>${history_relation[i].user_relation.name}</td>
                        <td>${history_relation[i].is_active == 1 ?'Active' : 'Inactive'}</td>
                        <td>${history_relation[i].remark}</td>
                    </tr>
                `
            }
            $('#asset_history_table > tbody:first').html(dataAssetHistory);
            $('#asset_history_table').DataTable({
                scrollX  : true,
                scrollY  :220
            }).columns.adjust()
        
    });
    // Detail Asset Tab 1
    // Format function for detail rows
    function format(response) {
        if (Array.isArray(response)) {
            let tableContent = `
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                             <th style="text-align:center">Asset Code</th>
                             <th style="text-align:center">Category</th>
                             <th style="text-align:center">Brand</th>
                             <th style="text-align:center">Type</th>
                             <th style="text-align:center">Parent Code</th>
                        </tr>
                    </thead>
                    <tbody>`;

            response.forEach(item => {
                tableContent += `
                    <tr>
                        <td>${item.asset_code}</td>
                        <td>${item.category || '-'}</td>
                        <td>${item.brand || '-'}</td>
                        <td>${item.type == 1 ?'Parent' : 'Child'}</td>
                        <td>${item.parent_code =='' ? '-' : item.parent_code}</td>
                    </tr>`;
            });

            tableContent += '</tbody></table>';
            return tableContent;
        } else {
            return 'No data available.';
        }
    }


    $('#btn_add_master_asset').on('click', function(){
        $('.parent_container').prop('hidden', true)
        $('#category_id').val('')
        $('#brand_id').val('')
        $('#type_id').val('')
        $('#parent_id').val('')
        $('#pic_id').val('')
        $('#select_category').val('').trigger('change')
        $('#select_brand').val('').trigger('change')
        $('#select_type').val('').trigger('change')
        $('#select_parent').val('').trigger('change')
        $('#select_pic').val('').trigger('change')
        $('.message_error').html('')
        getActiveItems('getAssetCategory', null, 'select_category','Category')
        getActiveItems('get_kantor', null, 'select_location','Location')
        getActiveItems('getAssetBrand', null, 'select_brand','Brand')
  
        getActiveItems('getUser', null, 'select_pic', 'PIC')
    })

    $('#select_type').on('change', function(){
        var select_type = $('#select_type').val()
        if(select_type == 2){
            getCallbackNoSwal('getActiveParent', null, function(response){
            $('#select_parent').append(`
               <option value="">Choose Parent</option>
            `)
                    for(i = 0; i < response.data.length; i ++){
                        $('#select_parent').append( `
                                <option value="${response.data[i].asset_code}">${response.data[i].asset_code}</option>
                        `)
                    }
        })
            $('.parent_container').prop('hidden',false)

        }else{
            $('.parent_container').prop('hidden',true)
        }
    })
    onChange('select_location', 'location_id')
    onChange('select_category', 'category_id')
    onChange('select_brand', 'brand_id')
    onChange('select_type', 'type_id')
    onChange('select_parent', 'parent_id')
    onChange('select_pic', 'pic_id')
    $('#btn_save_master_asset').on('click', function(){
        var data = {
            'pic_id' : $('#pic_id').val(),
            'type_id' : $('#type_id').val(),
            'category_id' : $('#category_id').val(),
            'join_date' : $('#join_date').val(),
            'location_id' : $('#location_id').val(),
            'brand_id' : $('#brand_id').val(),
            'parent_id' : $('#parent_id').val(),
        }
        postCallback('addMasterAsset', data, function(response){
            swal.close()
            toastr['success'](response.meta.message)
            var type = $('#type_id').val()
            if(type == 1){
                Swal.fire({
                    title: "<strong>Information</strong>",
                    icon: "info",
                    html: `
                        After this, please update Asset Specification<
                    `,
                    showCloseButton: true,
                    focusConfirm: true,
                });
            }

        })
    })
</script>
