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
            init: function () {
                this.on("success", function (file) {
                    this.removeFile(file);
                });
            }
        };
    }
};

$(document).ready(function () {
    MEDIA.dropzoneInit();
});