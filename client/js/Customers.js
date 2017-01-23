

app.controller("CustomersCtrl", function($scope, CustomersAPI, $uibModal){

  CustomersAPI.all({}, function(result){
    
    if (result.content && result.content.Customer){
      $scope.customers = result.content.Customer;
    } else {
      $scope.customers = [];
    }
    
  });
  
  $scope.newCustomer = function(){
    var modalInstance = $uibModal.open({
      templateUrl: 'partials/modals/new_customer.html',
      controller: 'ModalNewCustomerCtrl'
    });
  };
  
  

  
});


app.controller("ModalNewCustomerCtrl", function($scope, CustomersAPI, $uibModalInstance){
  
  $scope.close = function(){ $uibModalInstance .close(); }
  
  
  $scope.save = function(customer){ 
    
    console.log(customer);
    
    CustomersAPI.post(customer, function(result){
      
    });
    
  };
  
  
  
});

app.factory('CustomersAPI', ['$resource', 'config', function ($resource, config) {
    return $resource(config.baseUrl, {}, {
      all: {method: 'GET', url: config.baseUrl + "/?Customers.all", cache: false, isArray: false},
      post: {method: 'POST', url: config.baseUrl + "/?Customers.post", cache: false, isArray: false}
      
    });
  }
]);