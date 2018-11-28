(function () {
    'use strict';

    var pollControllers = angular.module('pollControllers', []);
    var baseServicesUrl = "http://csse-studweb3.canterbury.ac.nz/~som20/365/polls/index.php/services/"

    var colors = [
        "red", "pink", "deep-purple",
        "blue","teal", "deep-orange"
    ];

    var getColor = function(id) {
        return colors[id % colors.length];
    };

    /**
    Takes a single integer value r and returns an ordered array of integers from [0, r]
    */
    var toRange = function(r) {
        rArray = [];
        for(var i = 0; i < r; i++){
            rArray.push(i);
        }
        return rArray;
    };

    /**
    Poll List controller
    */
    var pollListController = function ($scope, $http, $location) {
        $scope.getColor = getColor;
        $scope.polls = [];
        $http({
            method: 'GET',
            url: 'index.php/services/polls'
        }).then(function successCallback(response) {
            $scope.polls = response.data;
        }, function errorCallback(response) {
            $location.path("/404");
        });
    };

    /** 404 controller
    */
    var four04Countroller = function ($scope) {}

    /** About Controller
    */
    var aboutController = function ($scope) {}

    /** Poll Details Controller
    */
    var pollDetailsController = function ($scope, $http, $routeParams, $location) {

        var pollId = $routeParams.pollId;

        $scope.poll = undefined;
        $scope.vote = undefined;
        $scope.getColor = getColor;

        $http({
            method: 'GET',
            url: 'index.php/services/polls/' + pollId
        }).then(function successCallback(response){
            $scope.poll = response.data;
        }, function errorCallback(response){
            $location.path("/404");
        });

        $scope.saveVote = function(){
            if ($scope.vote != undefined) {
                $http({
                    method: 'POST',
                    url: 'index.php/services/votes/' + $scope.poll.id + '/' + $scope.vote
                }).then(function successCallback (response) {
                    $location.path("/polls");
                }, function errorCallback(){
                    // Do nothing
                });
            } else {
                alert("No option selected");
            }
        };
    };

    /** Poll Results Controller
    */
    var pollResultsController = function ($scope, $http, $routeParams, $location) {

        var pollId = $routeParams.pollId;

        $scope.poll = undefined;
        $scope.results = undefined;
        $scope.toRange = toRange;
        $scope.getColor = getColor;
        $scope.total = 0;

        var updateResponseCounts = function(response) {
            $scope.results = [];
            $scope.total = 0;
            for (var i = 0; i < response.data.votes.length; i++) {
                let result = {};
                result.text = $scope.poll.choices[i];
                result.count = response.data.votes[i];
                $scope.total += response.data.votes[i];
                $scope.results.push(result);
            }
        }

        var getResponses = function() {
            $http({
                method: 'GET',
                url: 'index.php/services/votes/' + pollId
            }).then(function successCallback(response){
                updateResponseCounts(response);
            }, function errorCallback(response){
                $location.path("/404");
            });
        }

        getResponses();

        $http({
            method: 'GET',
            url: 'index.php/services/polls/' + pollId
        }).then(function successCallback(response) {
            $scope.poll = response.data;
        }, function errorCallback(response){
            $location.path("/404");
        });

        $scope.resetVotes = function () {
            $http({
                method: 'DELETE',
                url: 'index.php/services/votes/' + $scope.poll.id
            }).then(function successCallback (response) {
                getResponses();
            }, function errorCallback (response) {
                $location.path("/404");
            });
        };
    }

    pollControllers.controller('PollListController', ['$scope','$http','$location', pollListController]);
    pollControllers.controller('PollDetailsController', ['$scope','$http','$routeParams','$location', pollDetailsController]);
    pollControllers.controller('PollResultsController', ['$scope', '$http', '$routeParams','$location', pollResultsController]);
    pollControllers.controller('AboutController', ['$scope', aboutController]);
    pollControllers.controller('Four04Controller', ['$scope', four04Countroller]);
}());
