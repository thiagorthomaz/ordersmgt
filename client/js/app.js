
var app = angular.module("ordermgt", ['ngResource', 'ui.router', 'ui.bootstrap', 'ui.utils.masks']);


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
    controller: 'OrdersCtrl',
    templateUrl: 'partials/orders.html'
  };
  
  var orderDetailState = {
    name: 'default.detail',
    url: '/order/detail/:order_id',
    controller: 'OrderDetailCtrl',
    templateUrl: 'partials/order_detail.html'
  };
  
  
  var customersState = {
    name: 'default.customers',
    url: '/customers',
    controller: 'CustomersCtrl',
    templateUrl: 'partials/customers.html'
  };
  
  var customerDetailState = {
    name: 'default.customer_detail',
    url: '/customers/:id',
    controller: 'CustomerDetailCtrl',
    templateUrl: 'partials/customer_detail.html'
  };
  
  var productsState = {
    name: 'default.products',
    url: '/products',
    controller: 'ProductsCtrl',
    templateUrl: 'partials/products.html'
  };

  $stateProvider.state(defaultState);
  $stateProvider.state(homeState);
  $stateProvider.state(ordersState);
  $stateProvider.state(customersState);
  $stateProvider.state(productsState);
  $stateProvider.state(orderDetailState);
  $stateProvider.state(customerDetailState);
  
 
 
});
