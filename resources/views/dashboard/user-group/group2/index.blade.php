<script>
    $(document).on('click', ".add-group2", function(e) {
        $('.alert-light-danger').addClass('d-none');
        $(".modal-header").addClass("bg-primary")
        $(".modal-header").removeClass("bg-warning")
        $('.modal-header #group2-modal-header').text('Tambah Jurusan Baru');
        $("#group2_name").val("");
        $('#add-group2-modal').modal('show');
        $(document).off('click', '.save-group2').on('click', '.save-group2', function() {
            createUpdateGroup2();
        });
    });
    $(document).on('click', ".edit-group2", function(e) {
        $('.alert-light-danger').addClass('d-none');
        var id = $(this).data('id');
        $("#group2_name").val("");
        $('#add-group2-modal').modal('show');
        $.ajax({
            url: 'group2/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $(".modal-header").removeClass("bg-primary")
                $(".modal-header").addClass("bg-warning")
                $('.modal-header #group2-modal-header').text('Edit Jurusan');
                $('#group2_name').val(response.result.group2_name);
                $(document).off('click', '.save-group2').on('click', '.save-group2', function() {
                    createUpdateGroup2(id);
                });
            }
        });
    });

    function createUpdateGroup2(id = '') {
        if (id == '') {
            var type_ = "POST";
            var url_ = 'group2/add';
        } else {
            var type_ = "PUT";
            var url_ = 'group2/' + id;
        }
        $.ajax({
            url: url_,
            type: type_,
            data: {
                group2_name: $('#group2_name').val(),
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
                    $('#add-group2-modal').modal('hide');
                    $("#tb_group2").DataTable().ajax.reload();
                    toastSuccess(response.msg)
                }
            }
        });
    }
    $(document).on('click', ".set-group2", function(e) {
        var id = $(this).data('id');
        $.ajax({
            url: 'group2/set/' + id,
            type: "PUT",
            success: function(response) {
                $("#tb_group2").DataTable().ajax.reload(null, false);
                toastSuccess(response.msg)
            }
        });
    });
    $(document).on('click', ".delete-group2", function(e) {
        var id = $(this).data('id');
        $('#modal-delete').modal('show');
        $('.delete-message').text('Data Jurusan ' + id + ' akan hilang dari database. Yakin Hapus ?');
        $(document).off('click', '.delete-data').on('click', '.delete-data', function() {
            $.ajax({
                url: 'group2/delete/' + id,
                type: "DELETE",
                success: function(response) {
                    if (response.errors) {
                        toastError(response.errors)
                    } else {
                        $('#modal-delete').modal('hide');
                        $("#tb_group2").DataTable().ajax.reload(null, false);
                        toastSuccess(response.msg)
                    }
                }
            });
        });
    });
</script>
