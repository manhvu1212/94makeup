var ADMIN = {
    icheck: function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    },

    dropzoneInit: function () {
        Dropzone.autoDiscover = false;
    },
};

$(document).ready(function () {
    ADMIN.icheck();
    ADMIN.dropzoneInit();
});