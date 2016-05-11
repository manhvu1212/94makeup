var MEDIA = {
    allowCallLoadMore: true,

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
                this.on("success", function (file, img) {
                    this.removeFile(file);
                    var ele = $('<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 box-media box-media-new">')
                        .append($('<div class="media-item">')
                            .append($('<input type="checkbox" name="check" value="' + img.id + '">'))
                            .append($('<a href="javascript:void(0)" data-id="' + img.id + '">')
                                .append($('<img src="/public/' + img.thumbnail + '" alt="' + img.filename + '" class="img-responsive img-bordered-sm">'))
                            )
                        );
                    ele.find('img').load(function () {
                        $('#box-media').prepend(ele);
                        ele.find('input').iCheck({
                            checkboxClass: 'icheckbox_square-blue',
                            radioClass: 'iradio_square-blue',
                            increaseArea: '20%'
                        });
                        setTimeout(function () {
                            ele.removeClass('box-media-new');
                        }, 8000);
                        ele.find('a').bind('click', function () {
                            MEDIA.edit(img.id);
                        });
                    });
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
                $('input[name=check-all]').iCheck('uncheck');
            },
            cancel: function () {

            }
        });
    },

    edit: function (id) {
        $('#imgRender').empty();
        $('#infoRender').empty();
        var url = '/admin/media/edit/' + id;
        $('#editMedia').modal('show');
        $.ajax({
            type: 'post',
            url: url,
            data: {
                _token: $('input[name=_token]').val()
            },
            success: function (img) {
                $('#imgRender').append($('<img src="/public/' + img.full + '" class="img-responsive">'));
                $('#infoRender').parents('form').attr('action', "/admin/media/save/" + img.id);
                $('#infoRender').append($('<div class="box-body">')
                    .append($('<div class="form-group">')
                        .append($('<label class="col-sm-3 control-label">Tên file</label>'))
                        .append($('<div class="col-sm-9">')
                            .append($('<input type="text" name="filename" value="' + img.filename + '" class="form-control">'))
                        )
                    )
                    .append($('<div class="form-group">')
                        .append($('<label class="col-sm-3 control-label">Văn bản thay thế</label>'))
                        .append($('<div class="col-sm-9">')
                            .append($('<input type="text" name="alt" value="' + (img.alt == null ? "" : img.alt) + '" class="form-control">'))
                        )
                    )
                    .append($('<div class="form-group">')
                        .append($('<label class="col-sm-3 control-label">Chú thích</label>'))
                        .append($('<div class="col-sm-9">')
                            .append($('<textarea class="form-control" name="description" rows="3" maxlength="255">')
                                .val((img.description == null ? "" : img.description))
                            )
                        )
                    )
                    .append($('<div class="form-group">')
                        .append($('<label class="col-sm-3 control-label">Tải lên bởi</label>'))
                        .append($('<div class="col-sm-9">')
                            .append($('<label class="control-label">' + img.nameAuthor + '</label>'))
                        )
                    )
                    .append($('<button type="submit" class="btn btn-flat btn-warning pull-right">Save</button>'))
                );
            }
        });
    },

    autoload: function () {
        var wHeight = $(window).height();
        $(window).scroll(function () {
            if ($('.load-more').length > 0 && MEDIA.allowCallLoadMore) {
                var loadPosition = $('.load-more').offset().top;
                if ($(window).scrollTop() + 50 > loadPosition - wHeight) {
                    MEDIA.loadMoreMedia();
                }
            }
        });
    },

    loadMoreMedia: function () {
        var loadMore = $('.load-more');
        var paging = loadMore.data('paging');
        var year = loadMore.data('year');
        var month = loadMore.data('month');

        var url = '/admin/media/' + paging;
        if (year != '' && month != '') {
            url += '/' + year + '/' + month;
        }

        $.ajax({
            type: 'post',
            url: url,
            data: {
                _token: $('input[name=_token]').val()
            },
            beforeSend: function() {
                MEDIA.allowCallLoadMore = false;
                loadMore.attr('disabled', 'disabled');
                loadMore.find('i').hide();
                loadMore.find('img').show();
            },
            success: function (response) {
                if (response.length == 0) {
                    loadMore.remove();
                } else {
                    $.each(response, function (index, img) {
                        var ele = $('<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 box-media">')
                            .append($('<div class="media-item">')
                                .append($('<input type="checkbox" name="check" value="' + img.id + '">'))
                                .append($('<a href="javascript:void(0)" data-id="' + img.id + '">')
                                    .append($('<img src="/public/' + img.thumbnail + '" alt="' + img.filename + '" class="img-responsive img-bordered-sm">'))
                                )
                            );
                        ele.find('img').load(function () {
                            $('#box-media').append(ele);
                            ele.find('input').iCheck({
                                checkboxClass: 'icheckbox_square-blue',
                                radioClass: 'iradio_square-blue',
                                increaseArea: '20%'
                            });
                            ele.find('a').bind('click', function () {
                                MEDIA.edit(img.id);
                            });
                        });
                    });
                }
                loadMore.data('paging', paging + 1);
            },
            complete: function() {
                MEDIA.allowCallLoadMore = true;
                loadMore.removeAttr('disabled');
                loadMore.find('i').show();
                loadMore.find('img').hide();

            }
        });
    }
};

$(document).ready(function () {
    MEDIA.dropzoneInit();
    MEDIA.checkAll();
    MEDIA.unCheckAll();
    $('.media-item a').bind('click', function () {
        MEDIA.edit($(this).data('id'));
    });
});

$(window).load(function () {
    MEDIA.autoload();
});
