var MEDIA = {
    checkAll: function () {
        $('input[name=check-all]').on('ifChecked', function () {
            $('input[name=check]').iCheck('check');
        });
    },

    unCheckAll: function () {
        $('input[name=check-all]').on('ifUnchecked', function () {
            $('input[name=check]').iCheck('uncheck');
        });
    }
};

APP.controller('MediaCtrl', function ($scope, $http) {
    $scope.showDropzone = false;

    $scope.deleteMultiple = function () {
        $.confirm({
            title: 'Xác nhận!',
            content: 'Xóa tất cả ảnh đã chọn?',
            confirmButton: 'Xóa',
            cancelButton: 'Không',
            theme: 'material',
            confirm: function () {
                $('input[name=check]:checkbox:checked').each(function () {
                    var idx = $(this).val();
                    var image = $scope.media[idx];
                    $http({
                        method: 'post',
                        url: '/admin/media/delete/' + image.id
                    }).success(function (response) {
                        $scope.media.splice(idx, 1);
                    });
                });
                $('input[name=check-all]').iCheck('uncheck');
            }
        });
    }

});