app.controller("OrdersCtrl", function($scope, OrdersAPI, $uibModal){

  
  
  
  $scope.atualizarLista = function() {
    OrdersAPI.all({}, function(result){

      if (result.content && result.content.Purchase){
        $scope.purchases = result.content.Purchase;
      } else {
        $scope.purchases = [];
      }

    });  
  }
  
  $scope.newOrder = function(){
    var modalInstance = $uibModal.open({
      templateUrl: 'partials/modals/new_order.html',
      controller: 'ModalNewOrderCtrl',
      scope : $scope
    });
  };
  
  
  $scope.atualizarLista();
  
});


app.controller("ModalNewOrderCtrl", function($scope, ProductsAPI, CustomersAPI, OrdersAPI, $uibModalInstance){
  
  $scope.close = function(){ $uibModalInstance .close(); }
  
  $scope.Order = {};
  $scope.Order.required_date = new Date();
  $scope.Order.shipped_date = new Date();
  
  CustomersAPI.all(function(result){
    var customers = result.content.Customer;
    $scope.customer_list = customers;
  });
  
  ProductsAPI.all(function(result){
    var products = result.content.Product;
    $scope.product_list = products;
  });
  
  
  $scope.save = function(order){ 
    
    OrdersAPI.post(order, function(result) {
      if (result.type == "success") {
        
        $scope.$parent.atualizarLista();
      }
      
    });
    
  };  
  
});

app.factory('OrdersAPI', ['$resource', 'config', function ($resource, config) {
    return $resource(config.baseUrl, {}, {
      all: {method: 'GET', url: config.baseUrl + "/?Orders.all", cache: false, isArray: false},
      post: {method: 'POST', url: config.baseUrl + "/?Orders.post", cache: false, isArray: false}
      
    });
  }
]);