app.controller("OrdersCtrl", function($scope, OrdersAPI, $uibModal){

  OrdersAPI.all({}, function(result){
    
    if (result.content && result.content.Product){
      $scope.products = result.content.Product;
    } else {
      $scope.products = [];
    }
    
  });
  
  $scope.newOrder = function(){
    var modalInstance = $uibModal.open({
      templateUrl: 'partials/modals/new_order.html',
      controller: 'ModalNewOrderCtrl',
      scope : $scope
    });
  };
  
});


app.controller("ModalNewOrderCtrl", function($scope, ProductsAPI, CustomersAPI, OrdersAPI, $uibModalInstance){
  
  $scope.close = function(){ $uibModalInstance .close(); }
  
  
  CustomersAPI.all(function(result){
    var customers = result.content.Customer;
    $scope.customer_list = customers;
  });
  
  ProductsAPI.all(function(result){
    var products = result.content.Product;
    $scope.product_list = products;
  });
  
  
  $scope.save = function(order){ 
    console.log("Save");    
    
  };  
  
});

app.factory('OrdersAPI', ['$resource', 'config', function ($resource, config) {
    return $resource(config.baseUrl, {}, {
      all: {method: 'GET', url: config.baseUrl + "/?Orders.all", cache: false, isArray: false},
      post: {method: 'POST', url: config.baseUrl + "/?Orders.post", cache: false, isArray: false}
      
    });
  }
]);