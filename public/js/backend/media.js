var MEDIA = {
    openUploadMedia: function () {
        $('#formUploadMedia').show();
    },

    closeUploadMedia: function () {
        $('#formUploadMedia').hide();
    },

    dropzoneInit: function () {
        Dropzone.options.formUploadMedia = {
            paramName: "images",
            maxFilesize: 8,
            acceptedFiles: 'image/*',
            dictFileTooBig: 'Dung lượng ảnh quá lớn ({{filesize}}Mb). Tối đa {{maxFilesize}}Mb.'
        };
    }
};

$(document).ready(function () {
    MEDIA.dropzoneInit();
});