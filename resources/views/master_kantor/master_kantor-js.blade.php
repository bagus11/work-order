<script>
    get_kantor()
    $('#add_kantor').on('click', function(){
        get_province()
    })
    $('#select_province').on('change', function(){
        var select_province = $('#select_province').val()
        $('#id_province').val(select_province);
        get_regency()
    })
    $('#select_province_update').on('change', function(){
        var select_province_update = $('#select_province_update').val()
        $('#id_province_update').val(select_province_update);
        get_regency_update()
    })
    $('#select_regency').on('change', function(){
        var select_regency = $('#select_regency').val()
        $('#id_regency').val(select_regency);
        get_district()
    })
    $('#select_regency_update').on('change', function(){
        var select_regency_update = $('#select_regency_update').val()
        $('#id_regency_update').val(select_regency_update);
        get_district_update()
    })
    $('#select_district').on('change', function(){
        var select_district = $('#select_district').val()
        $('#id_district').val(select_district);
        get_village()
    })
    $('#select_district_update').on('change', function(){
        var select_district_update = $('#select_district_update').val()
        $('#id_district_update').val(select_district_update);
        get_village_update()
    })
    $('#select_village').on('change', function(){
        var select_village = $('#select_village').val()
        $('#id_village').val(select_village);
        get_postal_code()
    })
    $('#select_village_update').on('change', function(){
        var select_village_update = $('#select_village_update').val()
        $('#id_village_update').val(select_village_update);
        get_postal_code_update()
    })
    $('#select_office_type').on('change', function(){
        var select_office_type = $('#select_office_type').val()
        $('#office_type').val(select_office_type);
    })
    $('#btn_save_office').on('click', function(){
        save_kantor()
    })
    $('#kantor_table').on('click', '.editKantor', function(e) {
            $('#editKantorModal').show();
            var id =$(this).data('id')
            e.preventDefault()       
                $.ajax({
                    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('detail_kantor')}}",
                type: "get",
                dataType: 'json',
                async: true,
                data: {
                    'id': id
                },
                success: function(response) {                   
                    $('#office_id').val(id)
                    $('#office_name_update').val(response.detail.name)
                    $('#select_office_type_update').empty()
                    $('#office_type_update').val(response.detail.office_type)
                    $('#select_office_type_update').append('<option value="'+response.detail.office_type+'">'+response.detail.office_type+'</option>')
                    $('#select_office_type_update').append('<option value="Pusat">Pusat</option>')
                    $('#select_office_type_update').append('<option value="Cabang">Cabang</option>')
                    $('#id_province_update').val(response.detail.id_prov)
                    $('#select_province_update').empty()
                    $('#select_province_update').append('<option value="'+response.detail.id_prov+'">'+response.detail.province_name+'</option>')
                    $.each(response.get_province,function(i,data){
                        $('#select_province_update').append('<option value="'+data.id+'">' + data.provinsi +'</option>');
                    });
                    $('#select_regency_update').empty()
                    $('#select_regency_update').append('<option value="'+response.detail.id_city+'">'+response.detail.regency_name+'</option>')
                    $('#select_regency_update').append('<option value="">Pilih provinsi terlebih dahulu</option>')
                    $('#id_regency_update').val(response.detail.id_city)
                    $('#select_district_update').empty()
                    $('#select_district_update').append('<option value="'+response.detail.id_district+'">'+response.detail.district_name+'</option>')
                    $('#select_district_update').append('<option value="">Pilih kabupaten terlebih dahulu</option>')
                    $('#id_district_update').val(response.detail.id_district)
                    $('#select_village_update').empty()
                    $('#select_village_update').append('<option value="'+response.detail.id_village+'">'+response.detail.village_name+'</option>')
                    $('#select_village_update').append('<option value="">Pilih kecamatan terlebih dahulu</option>')
                    $('#id_village_update').val(response.detail.id_village)
                    $('#postal_code_update').val(response.detail.postal_code)
                    $('#office_address_update').val(response.detail.address)
                },
                error: function(xhr, status, error) {
                   
                    toastr['error']('gagal mengambil data, silakan hubungi ITMAN');
                }
            });
          
           
    });
    $('#kantor_table').on('change', '.is_checked', function(e) {
            $('.is_checked').prop('disabled',true)
            e.preventDefault();
            var status = $(this).data('status')
            var data ={
                    'id': $(this).data('id'),     
                    'flg_aktif': $(this).data('flg_aktif'),     
            }
            
                $.ajax({
                    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('update_status_kantor')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
               
                success: function(response) {
                    $('.is_checked').prop('disabled',false)
                    toastr['success'](response.message);
                    get_kantor()
                },
                error: function(xhr, status, error) {
                   
                    toastr['error']('gagal mengambil data, silakan hubungi ITMAN');
                }
            });
          
           
    });
    $('#btn_update_office').on('click', function(){
        update_kantor()
    })
    function get_kantor(){
        $('#kantor_table').DataTable().clear();
        $('#kantor_table').DataTable().destroy();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_kantor')}}",
            type: "get",
            dataType: 'json',
            async: true,
            data:{
                'select_aspek':$('#select_aspek').val(),
                'select_departement':$('#select_departement').val(),
            },
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                var data_array =[]
                data_array.push(response)

                var data=''
                for(i = 0; i < response.data.length; i++ )
                {
                    data += `<tr style="text-align: center;">
                                <td style="text-align: center;"> <input type="checkbox" id="check" name="check" class="is_checked" style="border-radius: 5px !important;" value="${response.data[i]['id']}"  data-flg_aktif="${response.data[i]['flg_aktif']}" data-id="${response.data[i]['id']}" ${response.data[i]['flg_aktif'] == 1 ?'checked':'' }></td>
                                <td style="text-align: center;">${response.data[i]['flg_aktif']==1?'Active':'inactive'}</td>
                                <td style="width:25%;text-align:center;">${response.data[i]['id']==null?'':response.data[i]['id']}</td>
                                <td style="width:25%;text-align:left;">${response.data[i]['name']==null?'':response.data[i]['name']}</td>
                                <td style="width:25%;text-align:left;">${response.data[i]['city']==null?'':response.data[i]['city']}</td>
                                <td style="width:25%;text-align:center">
                                        <button title="Detail" class="editKantor btn btn-primary rounded"data-id="${response.data[i]['id']}" data-toggle="modal" data-target="#editMasterKantor">
                                            <i class="fas fa-solid fa-eye"></i>
                                        </button> 
                                </td>
                            </tr>
                            `;
                }
                    $('#kantor_table > tbody:first').html(data);
                    $('#kantor_table').DataTable({
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
    function get_province(){
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('get_province')}}",
                type: "get",
                dataType: 'json',
                async: true,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('#select_province').empty();
                    $('#select_province').append('<option value ="">Pilih Provinsi</option>');
                    $('#select_regency').empty();
                    $('#select_regency').append('<option value ="">Pilih Provinsi terlebih dahulu</option>');
                    $('#select_district').empty();
                    $('#select_district').append('<option value ="">Pilih Kabupaten terlebih dahulu</option>');
                    $('#select_village').empty();
                    $('#select_village').append('<option value ="">Pilih Kecamatan terlebih dahulu</option>');
                    $('#postal_code').val('');
                    $('#id_province').val('');
                    $('#id_regency').val('');
                    $('#id_district').val('');
                    $('#id_village').val('');
                    $.each(response.get_province,function(i,data){
                        $('#select_province').append('<option value="'+data.id+'">' + data.provinsi +'</option>');
                    });
                    
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function get_regency(){
    $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_regency')}}",
            type: "get",
            data:{
                'id_province':$('#id_province').val()
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_regency').empty();
                $('#select_regency').append('<option value ="">Pilih Kabupaten</option>');
                $.each(response.get_regency,function(i,data){
                    $('#select_regency').append('<option value="'+data.id+'">' + data.kabupaten_kota +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function get_regency_update(){
    $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_regency')}}",
            type: "get",
            data:{
                'id_province':$('#id_province_update').val()
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_regency_update').empty();
                $('#select_regency_update').append('<option value ="">Pilih Kabupaten</option>');
                $.each(response.get_regency,function(i,data){
                    $('#select_regency_update').append('<option value="'+data.id+'">' + data.kabupaten_kota +'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function get_district(){
    $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_district')}}",
            type: "get",
            data:{
                'id_regency':$('#id_regency').val()
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_district').empty();
                $('#select_district').append('<option value ="">Pilih Kecamatan</option>');
                $.each(response.get_district,function(i,data){
                    $('#select_district').append('<option value="'+data.id+'">' + data.kecamatan+'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function get_district_update(){
    $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_district')}}",
            type: "get",
            data:{
                'id_regency':$('#id_regency_update').val()
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_district_update').empty();
                $('#select_district_update').append('<option value ="">Pilih Kecamatan</option>');
                $.each(response.get_district,function(i,data){
                    $('#select_district_update').append('<option value="'+data.id+'">' + data.kecamatan+'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    
    function get_village(){
    $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_village')}}",
            type: "get",
            data:{
                'id_district':$('#id_district').val()
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_village').empty();
                $('#select_village').append('<option value ="">Pilih Kelurahan</option>');
                $.each(response.get_village,function(i,data){
                    $('#select_village').append('<option value="'+data.id+'">' + data.kelurahan+'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function get_village_update(){
    $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_village')}}",
            type: "get",
            data:{
                'id_district':$('#id_district_update').val()
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#select_village_update').empty();
                $('#select_village_update').append('<option value ="">Pilih Kelurahan</option>');
                $.each(response.get_village,function(i,data){
                    $('#select_village_update').append('<option value="'+data.id+'">' + data.kelurahan+'</option>');
                });
                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function get_postal_code(){
    $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_postal_code')}}",
            type: "get",
            data:{
                'id_village':$('#id_village').val()
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#postal_code').val(response.get_postal_code.kd_pos)                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    function get_postal_code_update(){
    $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get_postal_code')}}",
            type: "get",
            data:{
                'id_village':$('#id_village_update').val()
            },
            dataType: 'json',
            async: true,
            beforeSend: function() {
                SwalLoading('Please wait ...');
            },
            success: function(response) {
                swal.close();
                $('#postal_code_update').val(response.get_postal_code.kd_pos)                
            },
            error: function(xhr, status, error) {
                swal.close();
                toastr['error']('Failed to get data, please contact ICT Developer');
            }
        });
    }
    
    function save_kantor(){
        data={
        'id_province':$('#id_province').val(),
        'id_regency':$('#id_regency').val(),
        'id_district':$('#id_district').val(),
        'id_village':$('#id_village').val(),
        'postal_code':$('#postal_code').val(),
        'office_name':$('#office_name').val(),
        'office_address':$('#office_address').val(),
        'office_type':$('#office_type').val(),
        }
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('save_kantor')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('.message_error').html('')
                    if(response.status==422)
                    {
                        $.each(response.message, (key, val) => 
                        {
                           $('span.'+key+'_error').text(val[0])
                        });
                        return false;
                    }else{
                        toastr['success'](response.message);
                        window.location = "{{route('master_kantor')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }
    function update_kantor(){
        data={
        'id_province_update':$('#id_province_update').val(),
        'id_regency_update':$('#id_regency_update').val(),
        'id_district_update':$('#id_district_update').val(),
        'id_village_update':$('#id_village_update').val(),
        'postal_code_update':$('#postal_code_update').val(),
        'office_name_update':$('#office_name_update').val(),
        'office_address_update':$('#office_address_update').val(),
        'office_type_update':$('#office_type_update').val(),
        'office_id':$('#office_id').val(),
        }
        $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('update_kantor')}}",
                type: "post",
                dataType: 'json',
                async: true,
                data: data,
                beforeSend: function() {
                    SwalLoading('Please wait ...');
                },
                success: function(response) {
                    swal.close();
                    $('.message_error').html('')
                    if(response.status==422)
                    {
                        $.each(response.message, (key, val) => 
                        {
                           $('span.'+key+'_error').text(val[0])
                        });
                        return false;
                    }else{
                        toastr['success'](response.message);
                        window.location = "{{route('master_kantor')}}";
                    }
                },
                error: function(xhr, status, error) {
                    swal.close();
                    toastr['error']('Failed to get data, please contact ICT Developer');
                }
            });
    }

</script>