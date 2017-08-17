var ArrivalApp = angular.module('arrivalApp', ['ngRoute']);

ArrivalApp.config(function($routeProvider){
    $routeProvider
        .when('/', {
            templateUrl: 'templates/stepOne.html',
            controller: 'stepOneController'
        })
        .when('/stepTwo', {
            templateUrl: 'templates/stepTwo.html',
            controller: 'stepTwoController'
        });
});
ArrivalApp.factory('arrivalOrderData', function (){
   return {
       deliveryPerson: {name: "", mobile:''},
       kids:[]
   }
});

ArrivalApp.service('getKids', function ($http){
    return function (mobile){
        if (mobile)
            return $http.get('/kids/' + mobile);
    };
});

ArrivalApp.controller('stepOneController', function ($scope, $location, arrivalOrderData) {
    $scope.nextAction = function (){
        if (! $scope.deliverPersonForm.$valid)
            return;
        arrivalOrderData.deliveryPerson.name = $scope.name ;
        arrivalOrderData.deliveryPerson.mobile = $scope.mobile;
        $location.path('/stepTwo');
    }
});


ArrivalApp.controller('stepTwoController', function ($scope, $http, arrivalOrderData, getKids) {
    $scope.kids = [];
    $scope.kidName = "";
    $scope.kidLastName = "";

    $scope.kidNotes = "";

    if(arrivalOrderData.deliveryPerson.mobile){

        getKids(arrivalOrderData.deliveryPerson.mobile)
            .then(function(response){
                arrivalOrderData.kids = response.data;
                $scope.kids = response.data;
            });
    }

    $scope.removeKid = function (kid){
        $scope.kids.splice($scope.kids.indexOf(kid), 1);
    };

    $scope.editKid = function (kid){
    //    not implemented yet
    };

    $scope.saveKid = function (){
        if (! $scope.kidForm.$valid)
            return;
        $scope.kids.push({name: $scope.kidName, notes:$scope.kidNotes});
        $scope.kidName = "";
        $scope.kidNotes = "";
    };

    $scope.confirm = function (){
        //todo validate data, show success of failure
        var save = $http.post('/save', arrivalOrderData);
    };

});



