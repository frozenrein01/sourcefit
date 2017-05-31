var app = angular.module('myApp', ["ngRoute"]);


app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        "templateUrl" 	: "app/views/home.html",
        "controller" 	: "homeController",
    })
    .when("/home", {
        "templateUrl" 	: "app/views/home.html",
        "controller" 	: "homeController",
    })
    .when("/new", {
        "templateUrl" 	: "app/views/new.html",
        "controller" 	: "newController",
    });
});