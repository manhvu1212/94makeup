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
        link: function (scope, element, attrs) {
            var raw = element[0];
            element.bind('scroll', (function () {
                if (raw.scrollTop + raw.offsetHeight > raw.scrollHeight - 100) {
                    scope.$apply(attrs.whenElementScrollEnds);
                }
            }));
        }
    };
});

APP.directive('whenWindowsScrollEnds', function ($window) {
    return {
        restrict: "A",
        link: function (scope, element, attrs) {
            var raw = angular.element($window);
            angular.element($window).bind('scroll', function() {
                console.log(raw.scrollHeight);
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

APP.controller('MainCtrl', function ($scope, $http) {
    $scope.media = [];
    $scope.newMedia = [];
    $scope.imageSelected = [];
    $scope.paging = 1;
    $scope.loading = false;

    $scope.showMediaPopup = function () {
        $('#select-media').modal('show');
        $scope.loadMoreMedia();
    };

    $scope.loadMoreMedia = function () {
        if (!$scope.loading && $scope.paging != 0) {
            $http({
                method: 'post',
                url: '/admin/media/' + $scope.paging,
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
                } else {
                    $scope.paging = 0;
                }

            });
        }
    };

    $scope.selectImage = function (img) {
        $scope.imageSelected = img;
    };

    $scope.uploadImagePopup = {
        'eventHandlers': {
            'success': function (file, response) {
                this.removeFile(file);
                $scope.media.unshift(response);
                $scope.newMedia.unshift(response);
                $scope.imageSelected = response;
                $scope.$apply();
            }
        }
    }
});
