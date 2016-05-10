var ADMIN = {
    icheck: function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    },

    selectMedia: function () {
        $('#show-media').empty();
        $.ajax({
            type: 'post',
            url: '/admin/media/1',
            data: {
                _token: $('input[name=_token]').val()
            },
            success: function (response) {
                $.each(response, function (index, value) {
                    var ele = $('<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 box-media">')
                        .append($('<div class="media-item">')
                            .append($('<a href="javascript:void(0)">')
                                .append('<img src="/public/' + value.thumbnail + '" alt="" class="img-responsive img-bordered-sm">')));
                    $('#show-media').append(ele);
                });
            }
        });
        $('#select-media').modal('show');
    },

    dropzoneInit: function () {
        Dropzone.options.uploadMedia = {
            paramName: "image",
            maxFilesize: 8,
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            dictFileTooBig: 'Dung lượng ảnh quá lớn ({{filesize}}Mb). Tối đa {{maxFilesize}}Mb.',
            dictRemoveFile: 'Hủy',
            dictCancelUpload: 'Dừng',
            init: function () {
                this.on("success", function (file, img) {
                    this.removeFile(file);

                });
            }
        };
    },
};

$(document).ready(function () {
    ADMIN.icheck();
    ADMIN.dropzoneInit();
});