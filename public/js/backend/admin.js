var ADMIN = {
    allowLoadMoreMedia: true,

    icheck: function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    },

    selectBtnMedia: function () {
        $('#select-media').modal('show');
        if(ADMIN.allowLoadMoreMedia) {
            ADMIN.loadMoreMedia();
            ADMIN.closeMediaPopup();
        }
        ADMIN.allowLoadMoreMedia = true;
    },

    closeMediaPopup: function() {
        $('#select-media').on('hidden.bs.modal', function () {
            ADMIN.allowLoadMoreMedia = false;
        })
    },

    scrollLoadMoreMediaPopup: function() {
        $('.show-media').scroll(function () {
            if($('#show-media').offset().top + $('#show-media').height() < $('.show-media').height() + 200 && ADMIN.allowLoadMoreMedia) {
                ADMIN.loadMoreMedia();
            }
        });
    },

    loadMoreMedia: function() {
        var loadMore = $('#loadMoreMediaPopup');
        var paging = loadMore.data('paging');

        var url = '/admin/media/' + paging;

        $.ajax({
            type: 'post',
            url: url,
            data: {
                _token: $('input[name=_token]').val()
            },
            beforeSend: function () {
                ADMIN.allowLoadMoreMedia = false;
                loadMore.attr('disabled', 'disabled');
                loadMore.find('i').hide();
                loadMore.find('img').show();
            },
            success: function (response) {
                if(response.length > 0) {
                    $.each(response, function (index, value) {
                        var ele = $('<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 box-media">')
                            .append($('<div class="media-item">')
                                .append($('<a href="javascript:ADMIN.showMediaDetail()">')
                                    .append('<img src="/public/' + value.thumbnail + '" alt="" class="img-responsive img-bordered-sm">')));
                        ele.find('img').load(function () {
                            $('#show-media').append(ele.hide().fadeIn(2000));
                        });
                    });
                    loadMore.data('paging', paging + 1);
                } else {
                    loadMore.remove();
                    ADMIN.allowLoadMoreMedia = false;
                }

            },
            complete: function() {
                if($('#loadMoreMediaPopup').length > 0) {
                    ADMIN.allowLoadMoreMedia = true;
                    loadMore.removeAttr('disabled');
                    loadMore.find('i').show();
                    loadMore.find('img').hide();
                }
            }
        });
    },

    showMediaDetail: function() {
        console.log(1);
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

$(window).load(function(){
    ADMIN.scrollLoadMoreMediaPopup();
});