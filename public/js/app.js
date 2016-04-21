var APP = angular.module('94makeup', ['ezfb']);

APP.config(function (ezfbProvider) {
    ezfbProvider.setInitParams({
        appId: '1587610674899891',
        status: true,
        version: 'v2.6'
    });
    ezfbProvider.setLocale('vi_VN');
});

APP.controller('MainCtrl', function ($scope, ezfb, $window, $location, $timeout) {

    updateLoginStatus(updateApiMe);

    $scope.login = function () {
        ezfb.login(function (res) {
            if (res.authResponse) {
                updateLoginStatus(updateApiMe);
            }
        }, {scope: 'email,user_friends,user_birthday'});
    };

    $scope.logout = function () {
        ezfb.logout(function () {
            updateLoginStatus(updateApiMe);
        });
    };

    $scope.clickLogin = function() {
        if (angular.isUndefined($scope.loginStatus) || $scope.loginStatus.status != 'connected') {
            $scope.login();
        }
    }

    var autoToJSON = ['loginStatus', 'apiMe'];
    angular.forEach(autoToJSON, function (varName) {
        $scope.$watch(varName, function (val) {
            $scope[varName + 'JSON'] = JSON.stringify(val, null, 2);
        }, true);
    });

    /**
     * Update loginStatus result
     */
    function updateLoginStatus(more) {

        ezfb.getLoginStatus(function (res) {
            $scope.loginStatus = res;

            (more || angular.noop)();
        });
    }

    /**
     * Update api('/me') result
     */
    function updateApiMe() {
        ezfb.api('/me?fields=birthday,name', function (res) {
            $scope.apiMe = res;
            $scope.apiMe['birthday'] = new Date($scope.apiMe['birthday']).getTime();
        });
        ezfb.api('/me/picture?height=320&width=320', function (res) {
            $scope.apiMe['avatar'] = res['data']['url'];
        });
    }
});