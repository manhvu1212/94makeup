APP.controller('BlogCategory', function($scope, $timeout) {
    $scope.imageCategory = $scope.mediaInserted[0];

    $scope.$watch('mediaInserted', function() {
        $scope.imageCategory = $scope.mediaInserted[0];
    });

    $scope.removeImageCategory = function() {
        $scope.imageCategory = {
            'thumbnail': 'glammy/images/upload-empty.png'
        };
    }
});