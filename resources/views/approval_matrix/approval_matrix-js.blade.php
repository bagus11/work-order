<script>

    // initiating
        getCallback('getApprovalMatrix', null, function(response){
            swal.close()
            mappingTable(response.data,'approval_table')
        })
    // initiating

    // Add Approval
        $('#btn_add_approval').on('click', function(){
            $('#addApprover').modal('show');
            getActiveItems('getAspek', null,'select_aspect', 'Aspect')
        })
        onChange('select_aspect','aspect')
        onChange('select_module','module')
        onChange('select_data_type','data_type')

        $('#select_aspect').on('change', function(){ 
            getActiveItems('moduleFilter', {'aspect' : $('#select_aspect').val()}, 'select_module', 'Module')
        })

        $('#select_module').on('change', function(){
            getActiveItems('systemFilter', {'module' : $('#select_module').val()} , 'select_data_type', 'Data Type')
        })
    // Add Approval
    
    // Edit Approval
        $('#approval_table').on('click', '.edit', function(){
            var approval = $(this).data('approval')
            var aspect = $(this).data('aspect')
            var module = $(this).data('module')
            var step = $(this).data('step')
            var type = $(this).data('type')
            $('#approval_code_label').html(': ' + approval)
            $('#aspect_label').html(': ' + aspect)
            $('#module_label').html(': ' + module)
            $('#data_type_label').html(': ' + type)
            $('#edit_step').val(step)
            $('#approval_code').val(approval)
        })

        $('#btn_save_approver').on('click', function(){
            var data ={
                'approval_code' : $('#approval_code').val(),
                'edit_step' : $('#edit_step').val(),
            }
            postCallback('updateApprovalMatrix', data, function(response){
                swal.close()
                toastr['success'](response.meta.message)
                $('#editApprovalModal').modal('hide')
                 getCallbackNoSwal('getApprovalMatrix', null, function(response){
                    swal.close()
                    mappingTable(response.data,'approval_table')
                })

            })
        })
    // Edit Approval

    // Edit Approver
        $('#approval_table').on('click', '.user', function(){
            var step = $(this).data('step')
            var approval_code = $(this).data('approval')
             $('#approval_code').val(approval_code)
            $('#approver_step').val(step)
            getCallbackNoSwal('getApproverDetail', {'step' : step,'approval_code': approval_code}, function(response){
                mappingStepApprover(step,response.data)
            })
        })
    // Edit Approver

    // Update Approver
        $('#btn_update_approver').on('click', function(){
            var steps = [];
            var isValid = true;

            // looping setiap baris di tabel
            $('#approver_step_table tbody tr').each(function(){
                var step = $(this).find('.stepArray').val();
                var approver_id = $(this).find('.select_approver').val();

                if(step === '' || step == 0){
                    isValid = false;
                    toastr['error']('Step tidak boleh kosong atau 0');
                    return false; // break dari each
                }

                if(approver_id === '' || approver_id == 0){
                    isValid = false;
                    toastr['error']('Approver tidak boleh kosong');
                    return false;
                }

                steps.push({
                    step: step,
                    user_id: approver_id
                });
            });

            if(!isValid) return; // stop eksekusi kalau invalid

            var data = {
                'approval_code' : $('#approval_code').val(),
                'step'          : steps
            };

            postCallback('updateApproverMatrixDetail', data, function(response){
                swal.close()
                toastr['success'](response.meta.message)
                $('#updateApprovalModal').modal('hide')
                getCallbackNoSwal('getApprovalMatrix', null, function(response){
                    mappingTable(response.data,'approval_table')
                })
            });
        });
    // Update Approver

    // Save Approval
        $('#btn_save_approval').on('click', function(){
            var data ={
                'aspect' : $('#aspect').val(),
                'module' : $('#module').val(),
                'data_type' : $('#data_type').val(),
                'step' : $('#step').val(),
            }
            postCallback('addApprovalMatrix',data, function(response){
                swal.close()
                toastr['success'](response.meta.message)
                $('#addApprover').modal('hide')
            })
        })
    // Save Approval

    // Function
         function mappingTable(response,table){
            var data =''
            $('#'+ table).DataTable().clear();
            $('#'+ table).DataTable().destroy();
            var data=''
                  for (i = 0; i < response.length; i++) {
                    data += `
                        <tr style="text-align: center; vertical-align: middle;">
                            <td style="text-align:center">${response[i].approval_code}</td>
                            <td style="text-align:center">${response[i].step}</td>
                            <td style="text-align:center">${response[i].aspect_relation.name}</td>
                            <td style="text-align:center">${response[i].module_relation.name}</td>
                            <td style="text-align:center">${response[i].data_type_relation.name}</td>
                            <td style="text-align:center">
                                <button title="Edit Approval" 
                                        class="edit btn btn-sm btn-info rounded"  
                                        data-type="${response[i].data_type}"  
                                        data-module="${response[i].module}"  
                                        data-aspect="${response[i].aspect}"  
                                        data-step="${response[i].step}"  
                                        data-approval="${response[i].approval_code}" 
                                        data-id="${response[i]['id']}" 
                                        data-toggle="modal" 
                                        data-target="#editApprovalModal">
                                    <i class="fas fa-solid fa-edit"></i>
                                </button>
                                <button title="Edit Approval User" 
                                        class="user btn btn-sm btn-success rounded"  
                                        data-type="${response[i].data_type}"  
                                        data-module="${response[i].module}"  
                                        data-aspect="${response[i].aspect}"  
                                        data-step="${response[i].step}"  
                                        data-approval="${response[i].approval_code}" 
                                        data-details="${response[i]['details']}" 
                                        data-toggle="modal" 
                                        data-target="#updateApprovalModal">
                                    <i class="fas fa-solid fa-user"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                }

            $(`#${table}> tbody:first`).html(data);
            $('#'+ table).DataTable({
                scrollX  : true,
            }).columns.adjust()
        }

        function mappingStepApprover(step,response){
            var data = ''
            let prevStep = null; // simpan step sebelumnya

            $('#approver_step_table').DataTable().clear();
            $('#approver_step_table').DataTable().destroy();
            var loop = response.length > 0 ? response.length : step;
            for(i = 0; i < loop ; i++){
                var selectTitle = 'select_approver_' + i;
               
                    data += `
                        <tr>
                            <td style="width:10%; text-align:center;">
                                <input class="form-control stepArray" style="text-align: center;font-size:12px" type="number" value="${response[i]?.step || 0}">    
                            </td>
                            <td style="width:80%">
                                <select name="${selectTitle}" class="select2 select_approver" style="font-size:9px;" id="${selectTitle}">
                                    <option></option>
                                </select>
                            </td>
                            <td style="width:10%; text-align:center;">
                               <button type="button" class="btn btn-sm btn-danger removeRow">-</button>
                            </td>
                        </tr>
                    `;
                    getApproval(response[i] == null ? '' : response[i].user_id, selectTitle);
                
            }

            $('#approver_step_table > tbody:first').html(data);
            $('#approver_step_table').DataTable({
                scrollX  : false,
            }).columns.adjust();

            $('.select2').select2();
            $(".select2").select2({ dropdownCssClass: "myFont" });
        }

        // Special Case
            $('#btnAdd').on('click', function(e){
                e.preventDefault()
                
                var index = $('#approver_step_table tbody tr').length // buat ID unik
                var selectTitle = 'select_approver_' + index

                var newRow = `
                    <tr>
                        <td style="width:10%; text-align:center;">
                             <input class="form-control stepArray" style="text-align: center;font-size:12px" type="number" value="">    
                        </td>
                        <td style="width:80%">
                            <select name="${selectTitle}" class="select2 select_approver" style="font-size:9px;" id="${selectTitle}">
                                <option></option>
                            </select>
                        </td>
                        <td style="width:10%; text-align:center;">
                            <button type="button" class="btn btn-sm btn-danger removeRow">-</button>
                        </td>
                    </tr>
                `
                $('#approver_step_table tbody').append(newRow)

                // inisialisasi select2 baru
                getApproval('',selectTitle)
                $('#'+selectTitle).select2({ dropdownCssClass: "myFont" })
            })
            // tombol - untuk hapus row
            $(document).on('click', '.removeRow', function(){
                $(this).closest('tr').remove()
            })
           // simpan value lama sebelum berubah
                $(document).on('focus', '.stepArray', function(){
                    $(this).data('old', $(this).val());
                });

                $(document).on('change', '.stepArray', function(){
                    var value = parseInt($(this).val());
                    var stepper = parseInt($('#approver_step').val());
                    var oldValue = $(this).data('old'); // ambil value lama

                    if(value > stepper){
                        // kalau lebih besar dari stepper, balikin ke sebelumnya
                        $(this).val(oldValue);
                        toastr.warning("Value tidak boleh lebih besar dari stepper");
                    }if (value == 0 || value < 0){
                        $(this).val(oldValue);
                        toastr.warning("Value tidak boleh minus / 0");
                    }
                     else {
                        // update value lama biar nyimpen yang valid terakhir
                        $(this).data('old', value);
                    }
                });
        // Special Case
        function getApproval(response,title){
            // getActiveItems('getUser',null,title,'Approver')wkwkw
            getCallbackNoSwal('getUser',null, function(res){
                $('#'+title).empty()
                $('#'+title).append('<option value ="">Choose Approver </option>');
                $.each(res.data,function(i,data){
                    $('#'+title).append('<option data-name="'+ data.name +'" value="'+data.id+'">' + data.name +'</option>');
                });
                if(response){
                    $('#'+title).val(response)
                    var test = $('#'+title).val(response)
                    $('#'+title).trigger('change')
                }
            })
           
        }
    // Function
</script>