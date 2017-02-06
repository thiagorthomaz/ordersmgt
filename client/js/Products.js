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
      controller: 'ModalNewProductCtrl',
      scope : $scope
    });
  };
  
  

  
});


app.controller("ModalNewProductCtrl", function($scope, ProductsAPI, $uibModalInstance){
  
  $scope.close = function(){ $uibModalInstance .close(); }
  
  
  $scope.save = function(product){ 
    
    
    if (!product || !product.name){ $scope.name_empty = true; } else { $scope.name_empty = false; }
    if (!product || !product.unitPrice){ $scope.unitPrice_empty = true; } else { $scope.unitPrice_empty = false; }
    if (!product || !product.description){ $scope.description_empty = true; } else { $scope.description_empty = false; }

    if (!$scope.name_empty && !$scope.unitPrice_empty && !$scope.description_empty) {
      ProductsAPI.post(product, function(result){
        if (result.content && result.content.Product) {
          $scope.$parent.products.push(result.content.Product);
          $uibModalInstance.close();
        }
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