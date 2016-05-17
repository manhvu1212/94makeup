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
    }
};

$(document).ready(function () {
    ADMIN.icheck();
    ADMIN.dropzoneInit();
});

/**
 *
 * start angular js
 */

var APP = angular.module('94makeupBackend', []);

APP.factory("interceptors", [function () {
    return {
        'request': function (request) {
            if (request.beforeSend)
                request.beforeSend();
            return request;
        },

        'response': function (response) {
            if (response.config.complete)
                response.config.complete(response);
            return response;
        }
    };
}]);

APP.config(["$httpProvider", function ($httpProvider) {
    $httpProvider.interceptors.push('interceptors');
}]);

APP.directive('whenElementScrollEnds', function () {
    return {
        restrict: "A",
        link: function (scope, element, attr) {
            var raw = element[0];
            element.bind('scroll', (function () {
                if (raw.scrollTop + raw.offsetHeight > raw.scrollHeight - 150) {
                    scope.$apply(attr.whenElementScrollEnds);
                }
            }));
        }
    };
});

APP.directive('whenWindowsScrollEnds', function ($window) {
    return {
        restrict: "A",
        link: function (scope, element, attr) {
            angular.element($window).bind('scroll', function () {
                var windowHeight = "innerHeight" in window ? window.innerHeight : document.documentElement.offsetHeight;
                var body = document.body;
                var html = document.documentElement;
                var docHeight = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
                var windowBottom = windowHeight + window.pageYOffset;
                if (windowBottom > docHeight - 150) {
                    scope.$apply(attr.whenWindowsScrollEnds);
                }
            })
        }
    }
});

APP.directive('dropzone', function () {
    return function (scope, element, attrs) {
        var config = {
            url: '/admin/media/add',
            maxFilesize: 8,
            paramName: "image",
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            dictFileTooBig: 'Dung lượng ảnh quá lớn ({{filesize}}Mb). Tối đa {{maxFilesize}}Mb.',
            dictRemoveFile: 'Hủy',
            dictCancelUpload: 'Dừng',
        };
        dropzone = new Dropzone(element[0], config);
        angular.forEach(scope[attrs.dropzone].eventHandlers, function (handler, event) {
            dropzone.on(event, handler);
        });
    }
});

APP.controller('MainCtrl', function ($timeout, $scope, $http) {
    $scope.media = [];
    $scope.newMedia = [];
    $scope.mediaSelected = [];
    $scope.mediaInserted = [{
        'thumbnail': 'glammy/images/upload-empty.png'
    }];
    $scope.paging = 1;
    $scope.year = '';
    $scope.month = '';
    $scope.loading = false;
    $scope.maximumMedia = 1;

    $scope.openMediaPopup = function (number) {
        $('#select-media').modal('show').on('hidden.bs.modal', function (e) {
            $scope.mediaSelected = [];
            $('input[name=check]').iCheck('uncheck');
        });
        ;
        $scope.maximumMedia = number;
        $scope.loadMoreMedia();
    };

    $scope.loadMoreMedia = function (year, month) {
        if (!$scope.loading && $scope.paging != 0) {
            if (year != undefined && month != undefined) {
                $scope.year = year;
                $scope.month = month;
            }
            var url = '/admin/media/' + $scope.paging;
            if ($scope.year != '' && $scope.month != '') {
                url += '/' + $scope.year + '/' + $scope.month;
            }
            $http({
                method: 'post',
                url: url,
                beforeSend: function () {
                    $scope.loading = true;
                },
                complete: function () {
                    $scope.loading = false;
                }
            }).success(function (response) {
                if (response.length > 0) {
                    $scope.media = $scope.media.concat(response);
                    $scope.paging++;
                    $timeout(function () {
                        ADMIN.icheck();
                        if (typeof MEDIA !== 'undefined') {
                            MEDIA.checkAll();
                            MEDIA.unCheckAll();
                        }
                    });
                } else {
                    $scope.paging = 0;
                }
            });
        }
    };

    $scope.selectMedia = function ($event, img) {
        var idx = $scope.mediaSelected.indexOf(img);
        if (idx === -1) {
            $http({
                method: 'post',
                url: '/admin/media/edit/' + img.id,
            }).success(function (response) {
                img.nameAuthor = response;
            });

            img.created_at = new Date(img.created_at);
            $scope.mediaSelected.unshift(img);
            var idUncheck = $scope.media.indexOf($scope.mediaSelected[$scope.maximumMedia]);
            $scope.mediaSelected.splice($scope.maximumMedia, 1);

            $($event.currentTarget.querySelector('input')).iCheck('check');
            $('input[value=' + idUncheck + ']').iCheck('uncheck');
            $('#editMedia').modal('show')
                .on('hidden.bs.modal', function (e) {
                    $scope.mediaSelected.splice(0, 1);
                });
        } else {
            $scope.mediaSelected.splice(idx, 1);
            $($event.currentTarget.querySelector('input')).iCheck('uncheck');
        }
    };

    $scope.uploadImagePopup = {
        'eventHandlers': {
            'success': function (file, response) {
                this.removeFile(file);
                $scope.media.unshift(response);
                $scope.newMedia.unshift(response);
                $scope.mediaSelected.unshift(response);
                ;
                $scope.$apply();
                ADMIN.icheck();
                if (typeof MEDIA !== 'undefined') {
                    MEDIA.checkAll();
                    MEDIA.unCheckAll();
                }
            }
        }
    };

    $scope.saveMediaSelected = function () {
        $http({
            method: 'post',
            url: '/admin/media/save/' + $scope.mediaSelected.id,
            data: {
                'alt': $scope.mediaSelected.alt,
                'description': $scope.mediaSelected.description
            },
            beforeSend: function () {
                $scope.loading = true;
            },
            complete: function () {
                $scope.loading = false;
            }
        });
    };

    $scope.insertImage = function () {
        $scope.mediaInserted = $scope.mediaSelected;
        $('#select-media').modal('hide');
    };
});
