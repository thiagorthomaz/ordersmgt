app.controller("ProductsCtrl", function($scope, ProductsAPI, $uibModal){

  ProductsAPI.all({}, function(result){
    
    if (result.content && result.content.Product){
      $scope.products = result.content.Product;
    } else {
      $scope.products = [];
    }
    
  });
  
  $scope.newProduct = function(){
    var modalInstance = $uibModal.open({
      templateUrl: 'partials/modals/new_product.html',
      controller: 'ModalNewProductCtrl'
    });
  };
  
  

  
});


app.controller("ModalNewProductCtrl", function($scope, ProductsAPI, $uibModalInstance){
  
  $scope.close = function(){ $uibModalInstance .close(); }
  
  
  $scope.save = function(product){ 
    
    
    if (!product || !product.name){ $scope.name_empty = true; } else { $scope.name_empty = false; }
    if (!product || !product.price){ $scope.price_empty = true; } else { $scope.price_empty = false; }
    if (!product || !product.description){ $scope.description_empty = true; } else { $scope.description_empty = false; }

    if (!$scope.name_empty && !$scope.price_empty && !$scope.description_empty) {
      ProductsAPI.post(product, function(result){
      
      });
    }
    
    
    
    
  };
  
  
  
});

app.factory('ProductsAPI', ['$resource', 'config', function ($resource, config) {
    return $resource(config.baseUrl, {}, {
      all: {method: 'GET', url: config.baseUrl + "/?Products.all", cache: false, isArray: false},
      post: {method: 'POST', url: config.baseUrl + "/?Products.post", cache: false, isArray: false}
      
    });
  }
]);