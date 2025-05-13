<script>
     const tableMasterAsset = $('#card_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `getCard`,
            type: 'GET',
        },
        columns: [
            {
                data: 'user_relation.nik',
                name: 'user_relation.nik',
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
                data: 'title',
                name: 'title',
                render: function (data) {
                    return data ? data : '-';
                }
            },
        ]
    });


    $('#card_table tbody').on('click','tr', function(){
        $('#detailCardModal').modal('show')
        const row = tableMasterAsset.row(this).data();
        
        $('#label_name').html(' : ' + row.name)
        $('#label_nik').html(' : ' + row.user_relation.nik)
        $('#label_departement').html(' : ' + row.user_relation.department_relation.name)
        $('#label_location').html(' : ' + row.user_relation.location_relation.name)
        $('#label_title').html(' : ' + row.title)
        $('#nik').val(row.nik)

    })

    $('#generate_card').on('click', function(){
        var nik = $("#nik").val()
        window.open(`generateCard/${nik}/card`,'_blank');
    })
</script>