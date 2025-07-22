<script>
   // Fungsi ambil parameter filter
function getFilterParams() {
    let location = $('#location_filter').val() || '';
    let period   = $('#year_filter').val() || ''; // Format: YYYY-MM

    let year = '';
    let month = '';

    if (period) {
        let parts = period.split('-'); // [YYYY, MM]
        year = parts[0];
        month = parts[1];
    }

    return { location: location, year: year, month: month };
}

// Load pertama kali dengan filter awal
$(document).ready(function() {
    let params = getFilterParams();
    getCallback('getOPX', params, function(response) {
        swal.close();
        mapping(response.data);
    });
});

// Supaya klik di dalam dropdown tidak menutup menu
$(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
});

// Event klik tombol Filter
$('#btn_filter').off().on('click', function () {
    let params = getFilterParams();

    getCallback('getOPX', params, function (response) {
        swal.close();
        mapping(response.data); // Update tabel OPX
    });
});

    getActiveItems('get_kantor', null, 'location_filter','Location')
    $('#btn_add_opx').on('click', function(){
        Swal.fire({
            title: "<strong>Peringatan</strong>",
            icon: "info",
            html: `
                Nilai Harus diinputkan manual, untuk menghindari error pada saat inputkan nilai, silahkan gunakan format angka dengan benar
            `,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonText: `
                <i class="fa fa-check"></i>
            `,
            confirmButtonAriaLabel: false,

            });
        getActiveItems('getActiveCategoryOPX', null, 'select_category','category')
        getActiveItems('get_kantor', null, 'select_location','Location')
        $('.product_label').prop('hidden', true)
    })
    $('#price').on('keydown', function (e) {
        if (e.ctrlKey && (e.key === 'v' || e.key === 'V')) {
            e.preventDefault();
            toastr.warning('Paste tidak diizinkan pada field ini!');
        }
    });
    $('#pph').on('keydown', function (e) {
        if (e.ctrlKey && (e.key === 'v' || e.key === 'V')) {
            e.preventDefault();
            toastr.warning('Paste tidak diizinkan pada field ini!');
        }
    });
    $('#ppn').on('keydown', function (e) {
        if (e.ctrlKey && (e.key === 'v' || e.key === 'V')) {
            e.preventDefault();
            toastr.warning('Paste tidak diizinkan pada field ini!');
        }
    });

    onChange('select_category','category')
    onChange('select_product','product')
    onChange('select_location','location')
    $('#select_category').on('change', function(){
        var select_category = $('#select_category').val()
        if(select_category == 1){
            $('.product_label').prop('hidden', false)
            var data ={
                'category' : select_category
            }
            getActiveItems('getProductFilter',data,'select_product','Product')
        }else{
            $('.product_label').prop('hidden', true)
        }
    })
    $('#editISModal').on('hidden.bs.modal', function () {
            $('#POModal').css('z-index', 1041);
        });
    $(".amount").on({
        keyup: function() {
        formatCurrency($(this));
        },
        blur: function() { 
        formatCurrency($(this), "blur");
        }
    });
    $('#btn_save_opx').on('click', function(){
        var price_string = $('#price').val()
        var price = parseFloat(price_string.replace(/,/g, ''));
        var pph_string = $('#pph').val()
        var pph = parseFloat(pph_string.replace(/,/g, ''));
        var ppn_string = $('#ppn').val()
        var ppn = parseFloat(ppn_string.replace(/,/g, ''));

        var data ={
            'location'  : $('#location').val(),
            'category'  : $('#category').val(),
            'product'  : $('#product').val(),
            'date'  : $('#date').val(),
            'description'  : $('#description').val(),
            'price'  : price,
            'pph'  : pph,
            'ppn'  : ppn,
        }
        postCallback('addOPX', data, function(response){
            swal.close()
            $('#name').val('')
            $('#description').val('')
            $('#location').val('')
            $('#product').val('')
            $('#category').val('')
            $('#price').val('')
            $('#pph').val('')
            $('#ppn').val('')
            toastr['success'](response.meta.message)
               var params = getFilterParams();
                getCallbackNoSwal('getOPX', params, function(response) {
                    mapping(response.data);
                });
        })

    })
    var table; // Declare the table variable in a broader scope
    $(document).on('click','.editPO', function(){
        var id = $(this).data('id')
        $('#po_id').val(id)
        var data ={
            'id':id
        }
        getCallback('getPOOPX',data, function(response){
            swal.close()
            mappingPOTable(response.data)
        })
    })
    $('#btn_add_po').on('click', function(){
        var data ={
            'po' : $('#po').val(),
            'pr' : $('#pr').val(),
            'id' : $('#po_id').val(),
        }
        $('#btn_add_po').prop('disabled', true);
        postCallbackNoSwal('addPOOPX', data,function(response){
            toastr['success'](response.meta.message)
            $('#btn_add_po').prop('disabled', false);
            $('#po').val('')
            $('#pr').val('')
            var data_test = {
                'id':$('#po_id').val()
            }
            getCallbackNoSwal('getPOOPX',data, function(response){
                swal.close()
                mappingPOTable(response.data)
            })
        })
    })
    $('#btn_add_is').on('click', function(){
        var data ={
            'po_id' : $('#is_id').val(),
            'is' : $('#is').val(),
            'opx_id' : $('#po_id').val(),
        }
        postCallbackNoSwal('addISOPX', data,function(response){
            toastr['success'](response.message)
            $('#is').val('')
            var data_test = {
                'id':$('#is_id').val()
            }
            getCallbackNoSwal('getISOPX',data_test, function(response){
                swal.close()
                mappingISTable(response.data)
            })
        })
    })

    $('#po_table').on('click', '.addIS', function(){
        var id = $(this).data('id')
        $('#is_id').val(id)
        var data ={
            'id' :id
        }
        getCallback('getISOPX',data, function(response){
            swal.close()
            mappingISTable(response.data)
        })
        
    })
    $(document).on('change','.is_change', function(){
        var id = $(this).data('id')
        var is = $(this).val()
        var data={
            'id' : id,
            'is' : is,
        }
        postCallbackNoSwal('updateISOPX',data, function(response){
            toastr['success'](response.message)
            var data_test = {
                'id':$('#is_id').val()
            }
            getCallbackNoSwal('getISOPX',data_test, function(response){
                swal.close()
                mappingISTable(response.data)
            })
        })

    })
    $(document).on('change','.po_change', function(){
        var id = $(this).data('id')
        var po = $(this).val()
        var data={
            'id' : id,
            'po' : po,
        }
        postCallbackNoSwal('updatePOOPX',data, function(response){
            toastr['success'](response.message)
            var data_test = {
                'id':$('#po_id').val()
            }
            getCallbackNoSwal('getPOOPX',data_test, function(response){
                swal.close()
                mappingPOTable(response.data)
            })
        })

    })
    $(document).on('change','.pr_change', function(){
        var id = $(this).data('id')
        var pr = $(this).val()
        var data={
            'id' : id,
            'pr' : pr,
        }
        postCallbackNoSwal('updatePROPX',data, function(response){
            toastr['success'](response.message)
            var data_test = {
                'id':$('#po_id').val()
            }
            getCallbackNoSwal('getPOOPX',data_test, function(response){
                swal.close()
                mappingPOTable(response.data)
            })
        })

    })
function mapping(response) {
    var data = '';
    $('#opx_table').DataTable().clear();
    $('#opx_table').DataTable().destroy();

    for (i = 0; i < response.length; i++) {
        var extend = response[i].category == 1 ? 'details-control' : '';
        var buttonPO = response[i].category == 1 ? '' : 
            `<button type="button" class="btn editPO btn-sm btn-warning" data-toggle="modal" data-target="#POModal" title="Edit PO" data-name="${response[i].name}" data-id="${response[i].id}" data-type="${response[i].type}">
                <i class="fas fa-edit"></i>
            </button>`;
        var buttonInfo = response[i].category != 0 ? 
            `<button type="button" class="btn info btn-sm btn-info" data-id="${response[i].id}" title="Detail OPX">
                <i class="fas fa-info-circle"></i>
            </button>` : '';
        data += `
            <tr>
                <td class=${extend} data-id="${response[i].id}"></td>
                <td style="text-align:left">${response[i].category_relation.name}</td>
                <td style="text-align:left">${response[i].location_relation.name}</td>
                <td style="text-align:right">${formatRupiah(response[i].sumPrice)}</td>
                <td style="text-align:center">
                    ${buttonInfo}
                    ${buttonPO}
                </td>
            </tr>`;
    }

    $('#opx_table > tbody:first').html(data);

    var table = $('#opx_table').DataTable({
        scrollX: true,
        scrollY: true,
        scrollCollapse: true,
        autoWidth: true
    }).columns.adjust();

    // Event untuk detail-control
    $('#opx_table tbody').off('click', 'td.details-control').on('click', 'td.details-control', function () {
        var tr = $(this).closest("tr");
        var row = table.row(tr);
        var id = $(this).data('id');
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            detail_log(id, table);
            tr.addClass('shown');
        }
    });

    // Event untuk .info
    $('#opx_table tbody').off('click', '.info').on('click', '.info', function () {
        var id = $(this).data('id');
        getDetailOPX(id);
    });
}

function getDetailOPX(id) {
    $('#opx_log_table').DataTable().clear();
    $('#opx_log_table').DataTable().destroy();
    getCallback('detailOPX', { 'id': id }, function (response) {
       swal.close();
    if (response.detail) {
        $('#opx_category').text(response.detail.category_relation?.name || '-');
        $('#opx_location').text(response.detail.location_relation?.name || '-');
        $('#opx_created_by').text(response.detail.user?.name || '-');
        $('#opx_created').text(formatDate(response.detail.start_date));

        // Isi log table
        var logRows = '';
        var totalLogPrice = 0, totalPPN = 0, totalDPH = 0, totalPPH = 0;

        if (response.log && response.log.length > 0) {
            $.each(response.log, function (index, item) {
                let price = parseInt(item.price || 0);
                let ppn   = parseInt(item.ppn || 0);
                let dph   = parseInt(item.dph || 0);
                let pph   = parseInt(item.pph || 0);

                totalLogPrice += price;
                totalPPN += ppn;
                totalDPH += dph;
                totalPPH += pph;

                logRows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.category_relation?.name || '-'}</td>
                        <td>${item.product_relation?.name || '-'}</td>
                        <td>${item.note || '-'}</td>
                        <td>Rp ${price.toLocaleString('id-ID')}</td>
                        <td>Rp ${ppn.toLocaleString('id-ID')}</td>
                        <td>Rp ${dph.toLocaleString('id-ID')}</td>
                        <td>Rp ${pph.toLocaleString('id-ID')}</td>
                        <td>${formatDate(item.start_date)}</td>
                    </tr>
                `;
            });
        } else {
            logRows = `<tr><td colspan="9" class="text-center">No Data</td></tr>`;
        }

        $('#opx_log_table tbody').html(logRows);
        // Inisialisasi DataTable dengan scroll horizontal
        $('#opx_log_table').DataTable({
            scrollX: true,
            autoWidth: false,
            paging: false,
            searching: false,
            info: false,
            ordering: false,
            columnDefs: [
                { width: "40px", targets: 0 },  // Kolom #
                { width: "150px", targets: 1 }, // Category
                { width: "150px", targets: 2 }, // Product
                { width: "150px", targets: 3 }, // Description
                { width: "120px", targets: 4 }, // Price
                { width: "80px", targets: 5 },  // PPN
                { width: "80px", targets: 6 },  // DPH
                { width: "80px", targets: 7 },  // PPH
                { width: "130px", targets: 8 }, // Created At
            ]
        }).columns.adjust();

        $('#opx_log_total_price').text(`Rp ${totalLogPrice.toLocaleString('id-ID')}`);
        $('#opx_log_total_ppn').text(`Rp ${totalPPN.toLocaleString('id-ID')}`);
        $('#opx_log_total_dph').text(`Rp ${totalDPH.toLocaleString('id-ID')}`);
        $('#opx_log_total_pph').text(`Rp ${totalPPH.toLocaleString('id-ID')}`);

        $('#infoOPXModal').modal('show');
        } else {
            toastr.error('Data not found');
        }
    });
}
$('#infoOPXModal').on('shown.bs.modal', function () {
     
    $('#opx_log_table').DataTable().columns.adjust();
});

function getChildOPX(id) {
    $('#opx_log_table').DataTable().clear();
    $('#opx_log_table').DataTable().destroy();
   getCallback('childOPXDetail', { 'id': id }, function (response) {
    swal.close();
    if (response.detail) {
        $('#opx_category').text(response.detail.category_relation?.name || '-');
        $('#opx_location').text(response.detail.location_relation?.name || '-');
        $('#opx_created_by').text(response.detail.user?.name || '-');
        $('#opx_created').text(formatDate(response.detail.start_date));

        // Isi log table
        var logRows = '';
        var totalLogPrice = 0, totalPPN = 0, totalDPH = 0, totalPPH = 0;

        if (response.log && response.log.length > 0) {
            $.each(response.log, function (index, item) {
                let price = parseInt(item.price || 0);
                let ppn   = parseInt(item.ppn || 0);
                let dph   = parseInt(item.dph || 0);
                let pph   = parseInt(item.pph || 0);

                totalLogPrice += price;
                totalPPN += ppn;
                totalDPH += dph;
                totalPPH += pph;

                logRows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.category_relation?.name || '-'}</td>
                        <td>${item.product_relation?.name || '-'}</td>
                        <td>${item.note || '-'}</td>
                        <td>Rp ${price.toLocaleString('id-ID')}</td>
                        <td>Rp ${ppn.toLocaleString('id-ID')}</td>
                        <td>Rp ${dph.toLocaleString('id-ID')}</td>
                        <td>Rp ${pph.toLocaleString('id-ID')}</td>
                        <td>${formatDate(item.start_date)}</td>
                    </tr>
                `;
            });
        } else {
            logRows = `<tr><td colspan="9" class="text-center">No Data</td></tr>`;
        }

        $('#opx_log_table tbody').html(logRows);

        // Destroy DataTable jika sudah ada
       // Destroy DataTable jika sudah ada
        // Inisialisasi DataTable dengan scroll horizontal
        $('#opx_log_table').DataTable({
            scrollX: true,
            autoWidth: false,
            paging: false,
            searching: false,
            info: false,
            ordering: false,
            columnDefs: [
              { width: "40px", targets: 0 },  // Kolom #
                { width: "150px", targets: 1 }, // Category
                { width: "150px", targets: 2 }, // Product
                { width: "150px", targets: 3 }, // Description
                { width: "120px", targets: 4 }, // Price
                { width: "80px", targets: 5 },  // PPN
                { width: "80px", targets: 6 },  // DPH
                { width: "80px", targets: 7 },  // PPH
                { width: "130px", targets: 8 }, // Created At
            ]
        }).columns.adjust();


        $('#opx_log_total_price').text(`Rp ${totalLogPrice.toLocaleString('id-ID')}`);
        $('#opx_log_total_ppn').text(`Rp ${totalPPN.toLocaleString('id-ID')}`);
        $('#opx_log_total_dph').text(`Rp ${totalDPH.toLocaleString('id-ID')}`);
        $('#opx_log_total_pph').text(`Rp ${totalPPH.toLocaleString('id-ID')}`);

        $('#infoOPXModal').modal('show');
    } else {
        toastr.error('Data not found');
    }
});

}

function mappingPOTable(response){
    var data =''
        $('#po_table').DataTable().clear();
        $('#po_table').DataTable().destroy();
        for(i = 0; i < response.length; i++){
                const d = new Date(response[i].created_at);
                const date = d.toISOString().split('T')[0];
                const time = d.toTimeString().split(' ')[0];
            data += `
                <tr>
                    <td style="text-align:center">${date} ${time}</td>
                    <td style="width:20% !important"><input type="text" style="font-size:10px" class="pr_change form-control" data-id="${response[i].id}" value="${response[i].pr}"></td>
                      <td style="width:20% !important"><input type="text" style="font-size:10px" class="po_change form-control" data-id="${response[i].id}" value="${response[i].po}"></td>
                    <td>${response[i].user_relation.name}</td>
                    <td style="text-align:center">
                        <button  type="button" class="btn addIS btn-sm btn-info" data-toggle="modal" data-target="#editISModal" data-id="${response[i].id}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                    
                </tr>
            `;
        }
        $('#po_table > tbody:first').html(data);
        $('#po_table').DataTable({
            // scrollX  : true,
            language: {
            'paginate': {
            'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
            'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
            }
        },
            ordering : false
        }).columns.adjust()
}

function mappingISTable(response){
    var data =''
        $('#is_table').DataTable().clear();
        $('#is_table').DataTable().destroy();
        for(i = 0; i < response.length; i++){
                const d = new Date(response[i].created_at);
                const date = d.toISOString().split('T')[0];
                const time = d.toTimeString().split(' ')[0];
            data += `
                <tr>
                    <td style="width : 40% !important"><input style="font-size:10px !important" class="form-control is_change" data-is="${response[i].is}" data-id="${response[i].id}" value="${response[i].is}" ></td>
                    <td>${response[i].user_relation.name}</td>
                    
                </tr>
            `;
        }
        $('#is_table > tbody:first').html(data);
        $('#is_table').DataTable({
            // scrollX  : true,
            language: {
            'paginate': {
            'previous': '<span class="prev-icon"><i class="fa-solid fa-arrow-left"></i></span>',
            'next': '<span class="next-icon"><i class="fa-solid fa-arrow-right"></i></span>'
            }
        },
            ordering : false
        }).columns.adjust()
}
function detail_log(id, table) {
    var data = {
        'id': id
    };

    getCallbackNoSwal('getDetervative', data, function (response) {
        let detailRows = '';

        for (i = 0; i < response.data.length; i++) {
            detailRows += `
                <tr class="table-light">
                    <td style="text-align:center">${i + 1}</td>
                    <td style="text-align:center">${response.data[i].start_date}</td>
                    <td style="text-align:center;">${response.data[i].product_name}</td>
                    <td style="text-align:center;">${formatRupiah(response.data[i].sumPrice)}</td>
                    <td style="text-align:center">
                        <button class="btn btn-sm btn-info detervative" type="button" data-id="${response.data[i].id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn editPO btn-sm btn-warning" data-toggle="modal" data-target="#POModal" title="Edit PO" data-name="${response.data[i].name}" data-id="${response.data[i].id}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>`;
        }

        let detailTable = `
            <table class="table_detail datatable-bordered">
                <thead>
                    <tr>
                        <th style="text-align:center">No</th>
                        <th style="text-align:center">Date</th>
                        <th style="text-align:center">Product</th>
                        <th style="text-align:center">Price</th>
                        <th style="text-align:center">Action</th>
                    </tr>
                </thead>
                <tbody class="table-bordered">${detailRows}</tbody>
            </table>`;

        var tr = $(`td[data-id="${id}"]`).closest('tr');
        var dataTableRow = table.row(tr);

        if (dataTableRow.child.isShown()) {
            dataTableRow.child.hide();
            tr.removeClass('shown');
        } else {
            dataTableRow.child(detailTable).show();
            tr.addClass('shown');
        }

        $(document).ready(function () {
            $('.table_detail').DataTable({
                "destroy": true,
                "autoWidth": false,
                "searching": false,
                "aaSorting": false,
                "paging": false,
                "scrollX": true
            }).columns.adjust();
        });
    });
}
$(document).on('click', '.detervative', function() {

    var id = $(this).data('id');
    getChildOPX(id);
});
$('#btn_export_excel').off().on('click', function() {
    let location = $('#location_filter').val() || '';
    let period   = $('#year_filter').val(); // Format YYYY-MM
    let year = '', month = '';
    if (period) {
        let parts = period.split('-');
        year = parts[0];
        month = parts[1];
    }
    let base = window.location.origin;
    alert(base);
    return false;
    let url = `${base}/export-excel?location=${location}&year=${year}&month=${month}`;
    window.location.href = url;
});


</script>