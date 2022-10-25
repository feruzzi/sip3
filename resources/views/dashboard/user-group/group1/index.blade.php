<script>
    $(document).on('click', ".add-group1", function(e) {
        $('.alert-light-danger').addClass('d-none');
        $(".modal-header").addClass("bg-primary")
        $(".modal-header").removeClass("bg-warning")
        $('.modal-header #group1-modal-header').text('Tambah Angkatan Baru');
        $("#group1_name").val("");
        $('#add-group1-modal').modal('show');
        $(document).off('click', '.save-group1').on('click', '.save-group1', function() {
            createUpdateGroup1();
        });
    });
    $(document).on('click', ".edit-group1", function(e) {
        $('.alert-light-danger').addClass('d-none');
        var id = $(this).data('id');
        $("#group1_name").val("");
        $('#add-group1-modal').modal('show');
        $.ajax({
            url: 'group1/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $(".modal-header").removeClass("bg-primary")
                $(".modal-header").addClass("bg-warning")
                $('.modal-header #group1-modal-header').text('Edit Angkatan');
                console.log(response.result);
                $('#group1_name').val(response.result.group1_name);
                $(document).off('click', '.save-group1').on('click', '.save-group1', function() {
                    createUpdateGroup1(id);
                });
            }
        });
    });

    function createUpdateGroup1(id = '') {
        if (id == '') {
            var type_ = "POST";
            var url_ = 'group1/add';
        } else {
            var type_ = "PUT";
            var url_ = 'group1/' + id;
        }
        $.ajax({
            url: url_,
            type: type_,
            data: {
                group1_name: $('#group1_name').val(),
            },
            success: function(response) {
                if (response.errors) {
                    $('.alert-light-danger').removeClass('d-none');
                    $('.alert-light-danger').html("<ul>");
                    $.each(response.errors, function(key, value) {
                        $('.alert-light-danger').find('ul').append("<li>" + value +
                            "</li>");
                    });
                    $('.alert-light-danger').append("</ul>");
                    toastError(response.msg)
                } else {
                    console.log(response);
                    $('#add-group1-modal').modal('hide');
                    $("#tb_group1").DataTable().ajax.reload();
                    toastSuccess(response.msg)
                }
            }
        });
    }
    $(document).on('click', ".set-group1", function(e) {
        var id = $(this).data('id');
        $.ajax({
            url: 'group1/set/' + id,
            type: "PUT",
            // data: {
            //     username: $('#username').val()
            // },
            success: function(response) {
                console.log(response);
                $("#tb_group1").DataTable().ajax.reload(null, false);
                toastSuccess(response.msg)
            }
        });
    });
    $(document).on('click', ".delete-group1", function(e) {
        var id = $(this).data('id');
        $('#modal-delete').modal('show');
        $('.delete-message').text('Data Angkatan ' + id + ' akan hilang dari database. Yakin Hapus ?');
        $(document).off('click', '.delete-data').on('click', '.delete-data', function() {
            $.ajax({
                url: 'group1/delete/' + id,
                type: "DELETE",
                // data: {
                //     username: $('#username').val()
                // },
                success: function(response) {
                    if (response.errors) {
                        toastError(response.errors)
                    } else {
                        console.log(response);
                        $('#modal-delete').modal('hide');
                        $("#tb_group1").DataTable().ajax.reload(null, false);
                        toastSuccess(response.msg)
                    }
                }
            });
        });
    });
</script>
