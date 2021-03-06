

app.controller("CustomersCtrl", function($scope, CustomersAPI, $uibModal){

  function update(){
    CustomersAPI.all({}, function(result){

      if (result.content && result.content.Customer){
        
        var _customers = result.content.Customer;
        
        for (var i in _customers) {
          _customers[i].birthday = new Date(_customers[i].birthday);
        }

        $scope.customers = _customers;
      } else {
        $scope.customers = [];
      }

    });  
  }
  
  $scope.update = update;
  update();
  
  $scope.newCustomer = function(_Customer_){
    if (!_Customer_) {
      var _Customer_ = {};
    }
    var modalInstance = $uibModal.open({
      templateUrl: 'partials/modals/new_customer.html',
      controller: 'ModalNewCustomerCtrl',
      scope : $scope,
      resolve : {
        Customer : _Customer_
      }
    });
  };
  
});


app.controller("ModalNewCustomerCtrl", function($scope, CustomersAPI, $uibModalInstance, Customer){
  
  $scope.close = function(){ $uibModalInstance.close(); }
  
  if (Customer.id)  {
    $scope.Customer = Customer;
    $scope.Customer.birthday = new Date(Customer.birthday);
  }
  
  $scope.save = function(customer){ 
    
    console.log(customer);

    if (!customer || !customer.name){ $scope.name_empty = true; } else { $scope.name_empty = false; }
    
    if (!$scope.name_empty) {
      CustomersAPI.post(customer, function(result){
         if (result.content && result.content.Customer) {
           $scope.$parent.update();
           //$scope.$parent.customers.push(result.content.Customer);
           $uibModalInstance.close();
         }
      });
    }
    
  };
  
  
  
});

app.factory('CustomersAPI', ['$resource', 'config', function ($resource, config) {
    return $resource(config.baseUrl, {}, {
      get: {method: 'GET', url: config.baseUrl + "/?Customers.get", cache: false, isArray: false},
      all: {method: 'GET', url: config.baseUrl + "/?Customers.all", cache: false, isArray: false},
      post: {method: 'POST', url: config.baseUrl + "/?Customers.post", cache: false, isArray: false} 
    });
  }
]);



app.controller("CustomerDetailCtrl", function($scope, $stateParams, CustomersAPI, $uibModal){
  
  CustomersAPI.get($stateParams , function(result){
    console.log(result);
    $scope.customer = result.content.Customer;
    
  });

});
