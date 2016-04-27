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
                                .append($('<img src="' + img.thumbnail + '" alt="' + img.title + '" class="img-responsive img-bordered-sm">'))
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

    deleteMultiple: function () {
        $('input:checkbox:checked').each(function() {
            $.ajax({
                type: 'post',
                url: '/admin/media/delete/' + $(this).val(),
                success: function(res) {
                    $(this).parents('.box-media').remove();
                }
            });
        });
    }
};

$(document).ready(function () {
    MEDIA.dropzoneInit();
});