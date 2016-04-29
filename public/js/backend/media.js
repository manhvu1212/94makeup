var MEDIA = {
    openUploadMedia: function () {
        $('#formUploadMedia').show();
    },

    closeUploadMedia: function () {
        $('#formUploadMedia').hide();
    },

    dropzoneInit: function () {
        Dropzone.options.formUploadMedia = {
            paramName: "image",
            maxFilesize: 8,
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            dictFileTooBig: 'Dung lượng ảnh quá lớn ({{filesize}}Mb). Tối đa {{maxFilesize}}Mb.',
            dictRemoveFile: 'Hủy',
            dictCancelUpload: 'Dừng',
            init: function () {
                this.on("success", function (file, response) {
                    this.removeFile(file);
                    var img = jQuery.parseJSON(response);
                    var ele = $('<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 box-media box-media-new">')
                        .append($('<div class="media-item">')
                            .append($('<input type="checkbox" name="check" value="' + img.id + '">'))
                            .append($('<a href="#">')
                                .append($('<img src="/public/' + img.thumbnail + '" alt="' + img.title + '" class="img-responsive img-bordered-sm">'))
                            )
                        );
                    $('#media').prepend(ele);
                    ele.find('input').iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_square-blue',
                        increaseArea: '20%'
                    });
                    setTimeout(function () {
                        ele.removeClass('box-media-new');
                    }, 8000);
                });
            }
        };
    },

    checkAll: function () {
        $('input[name=check-all]').on('ifChecked', function () {
            $('input[name=check]').iCheck('check');
        });
    },

    unCheckAll: function () {
        $('input[name=check-all]').on('ifUnchecked', function () {
            $('input[name=check]').iCheck('uncheck');
        });
    },

    deleteMultiple: function () {
        $.confirm({
            title: 'Xác nhận!',
            content: 'Xóa tất cả ảnh đã chọn?',
            confirmButton: 'Xóa',
            cancelButton: 'Không',
            theme: 'material',
            confirm: function () {
                $('input[name=check]:checkbox:checked').each(function () {
                    var ele = $(this);
                    $.ajax({
                        type: 'post',
                        url: '/admin/media/delete/' + $(this).val(),
                        dataType: 'json',
                        data: {
                            _token: $('input[name=_token]').val()
                        },
                        success: function (res) {
                            ele.parents('.box-media').remove();
                        }
                    });
                });
            },
            cancel: function () {

            }
        });
    },

    edit: function(url) {
        $('#editMedia').modal('show');
        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            data: {
                _token: $('input[name=_token]').val()
            },
            success: function (res) {
                console.log(res);
            }
        });
    }
};

$(document).ready(function () {
    MEDIA.dropzoneInit();
    MEDIA.checkAll();
    MEDIA.unCheckAll();
});