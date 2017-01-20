
var app = angular.module("ordermgt", ['ui.router', 'ui.bootstrap']);


app.config(function($stateProvider, $urlRouterProvider) {
  

  
  $urlRouterProvider.otherwise("/default/home");
  
  var defaultState = {
    name: 'default',
    url: '/default',
    abstract : true,
    views: {
      default: {
        templateUrl: "partials/default.html"
      }
    }
  };
  
  var homeState = {
    name: 'default.home',
    url: '/home',
    templateUrl: 'partials/home.html'
  };
  
  var ordersState = {
    name: 'default.orders',
    url: '/orders',
    templateUrl: 'partials/orders.html'
  };
  
  
  var customersState = {
    name: 'default.customers',
    url: '/customers',
    templateUrl: 'partials/customers.html'
  };
  
  var productsState = {
    name: 'default.products',
    url: '/products',
    templateUrl: 'partials/products.html'
  };

  $stateProvider.state(defaultState);
  $stateProvider.state(homeState);
  $stateProvider.state(ordersState);
  $stateProvider.state(customersState);
  $stateProvider.state(productsState);
  
 
 
});