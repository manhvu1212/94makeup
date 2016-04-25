var APP = angular.module('94makeup', ['ezfb']);

APP.config(function (ezfbProvider) {
    ezfbProvider.setInitParams({
        appId: appId,
        status: true,
        version: appVer
    });
    ezfbProvider.setLocale('vi_VN');
});

APP.controller('MainCtrl', function ($scope, ezfb, $window, $location, $timeout, $http) {

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
            $scope.clickWait = false;
        });
    };

    $scope.clickLogin = function () {
        if ((angular.isUndefined($scope.loginStatus) || $scope.loginStatus.status != 'connected') && (angular.isUndefined(!$scope.clickWait) || !$scope.clickWait)) {
            $scope.clickWait = true;
            $scope.login();
        }
    };

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
            $scope.apiMe['birthday'] = new Date($scope.apiMe['birthday']);
            $scope.apiMe['dayDiff'] = getDateDiff($scope.apiMe['birthday']);
            $scope.apiMe['age'] = (new Date).getFullYear() - $scope.apiMe['birthday'].getFullYear();

            ezfb.api('/me/picture?height=320&width=320', function (res) {
                if (!angular.isUndefined(res['data'])) {
                    $scope.apiMe['avatar'] = res['data']['url'];
                }
            });
        });
    }

    function getDateDiff(date) {
        var dateNow = new Date();
        dateNow.setHours(0, 0, 0, 0);
        var dateAnniversary = new Date(
            date.getDate().toString() + '/' +
            (date.getMonth() + 1).toString() + '/' +
            dateNow.getFullYear().toString()
        );
        if (dateAnniversary < dateNow) {
            dateAnniversary.setFullYear(dateAnniversary.getFullYear() + 1);
        }
        return Math.ceil((dateAnniversary - dateNow) / 1000 / 3600 / 24);
    }
});