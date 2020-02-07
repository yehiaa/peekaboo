var ArrivalApp = angular.module('arrivalApp', ['ngRoute', 'ivh.treeview']);

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
       kids:[],
       setDefault: function () {
           this.kids = [];
           this.deliveryPerson = {name: "", mobile:''};
       },
       validate: function () {
           if (this.kids && this.kids.length > 0 && this.deliveryPerson.name && this.deliveryPerson.mobile)
                return true;
            return false ;
       },
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


ArrivalApp.controller('stepTwoController', function ($scope, $http, $location,
                                                     ivhTreeviewMgr, arrivalOrderData, 
                                                     getKids) {

    $scope.productCategories = JSON.parse(JSON.stringify(productCategories));
    $scope.kids = [];
    $scope.selectedProductCategoryIds = [];
    $scope.kidName = "";
    $scope.items = [
        {id:1,label:'Individual Activity (75)', price: 75},
        {id:2,label:'2 Activities package (150)', price: 150},
        {id:3,label:'4 Activities package (250)', price: 250},
        {id:4,label:'6 Activities package (350)', price: 350}];

    $scope.selectedItem = $scope.items[0];
    $scope.message = "Confirm & save";
    $scope.kidNotes = "";


    var addToSelected = function (item) {
        var index = $scope.selectedProductCategoryIds.indexOf(item.id);
        if (index === -1) $scope.selectedProductCategoryIds.push(item.id);
        if (item.children.length > 0) {
            item.children.forEach(function (childItem) {
                addToSelected(childItem);
            });
        }
    }

    var removeFromSelected = function (item) {
        var index = $scope.selectedProductCategoryIds.indexOf(item.id);
        if (index !== -1) $scope.selectedProductCategoryIds.splice(index, 1);
        if (item.children.length > 0) {
            item.children.forEach(function (childItem) {
                removeFromSelected(childItem);
            });
        }
    }

    $scope.selectChangeCallback = function (node) {
        if (node.selected) {
            addToSelected(node);
        }else{
            removeFromSelected(node);
        }
    }


    $scope.removeKid = function (kid){
        $scope.kids.splice($scope.kids.indexOf(kid), 1);
    };

    $scope.editKid = function (kid){
    //    not implemented yet
    };


    $scope.$watch('kids', function () {
        $scope.totalPrice = 0;
        $scope.kids.forEach(function (kid) {
            $scope.totalPrice += kid.itemPrice;
        })
    })

    $scope.saveKid = function (){
        if (! $scope.kidForm.$valid)
            return;

        var kid = {
            name: $scope.kidName, 
            notes: $scope.kidNotes,
            item: $scope.selectedItem.id,
            itemName: $scope.selectedItem.label,
            itemPrice: $scope.selectedItem.price,
            allowedCategoriesIds: $scope.selectedProductCategoryIds};
        
        $scope.kids.push(kid);

        arrivalOrderData.kids = $scope.kids;

        $scope.kidName = "";
        $scope.kidNotes = "";
        $scope.selectedItem = $scope.items[0];
        $scope.itemName = "";
        $scope.selectedProductCategoryIds = [];
        $scope.productCategories = JSON.parse(JSON.stringify(productCategories));
    };

    $scope.activateConfirm = function () {
        return arrivalOrderData.validate();
    }

    $scope.confirm = function (){
        //todo validate data, show success or failure

        if (! arrivalOrderData.validate()) {
            $scope.message = "Invalid data ...";
            return ;
        }

        var save = $http.post('/save', arrivalOrderData);
        save.then(function (result) {
            $location.path('/');
            arrivalOrderData.setDefault();
        });
    };

});




