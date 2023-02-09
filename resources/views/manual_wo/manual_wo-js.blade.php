<script>
    getDepartementName('get_departement_name','select_request_for','Departement')
    $('#select_request_for').on('change', function(){
        getSelect('get_categories_id',{'initial':$('#select_request_for').val()},'select_categories', 'Categories')
    })
   $('#select_categories').on('change', function(){
    getSelect('get_problem_type_name',{'id': $('#select_categories').val()},'select_problem_type', 'Problem Type')
   })
    getSelect('get_username',null,'select_username', 'User')
    onChange('select_request_type', 'request_type')
    onChange('select_request_for', 'request_for')
    onChange('select_categories','categories')
    onChange('select_problem_type','problem_type')
    onChange('select_username','username')

    $('#btnSaveManualWO').on('click', function(){
        var data ={
            'request_type':$('#request_type').val(),
            'request_for':$('#request_for').val(),
            'categories':$('#categories').val(),
            'problem_type':$('#problem_type').val(),
            'username':$('#username').val(),
            'add_info':$('#add_info').val(),
            'subject':$('#subject').val(),
        }

        store('manual_wo',data,'work_order_list')
    })
</script>