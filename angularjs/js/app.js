(function () {
    'use strict';

    var pollApp = angular.module('pollApp', [
        'ngRoute',
        'pollControllers'
    ]);

    pollApp.config(['$routeProvider',
        function ($routeProvider) {
            $routeProvider.when('/polls', {
                templateUrl: 'angularjs/partials/poll-list.html',
                controller: 'PollListController'
            }).when('/polls/:pollId', {
                templateUrl: 'angularjs/partials/poll-detail.html',
                controller: 'PollDetailsController'
            }).when('/admin/polls', {
                templateUrl: 'angularjs/partials/admin/poll-list.html',
                controller: 'PollListController'
            }).when('/admin/polls/:pollId', {
                templateUrl: 'angularjs/partials/admin/poll-detail.html',
                controller: 'PollResultsController'
            }).when('/about', {
                templateUrl: 'angularjs/partials/about.html',
                controller: 'AboutController'
            }).when('/404', {
                templateUrl: 'angularjs/partials/404.html',
                controller: 'Four04Controller'
            }).otherwise({
                redirectTo: '/polls'
            });
        }
    ]);

}());
