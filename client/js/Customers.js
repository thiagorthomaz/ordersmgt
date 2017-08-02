

app.controller("CustomersCtrl", function($scope, CustomersAPI, $uibModal){

  function update(){
    CustomersAPI.all({}, function(result){

      if (result.content && result.content.Customer){
        $scope.customers = result.content.Customer;
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

    if (!customer || !customer.name){ $scope.name_empty = true; } else { $scope.name_empty = false; }
    if (!customer || !customer.email){ $scope.email_empty = true; } else { $scope.email_empty = false; }
    if (!customer || !customer.phone){ $scope.phone_empty = true; } else { $scope.phone_empty = false; }

    if (!$scope.name_empty && !$scope.email_empty && !$scope.phone_empty) {
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
      all: {method: 'GET', url: config.baseUrl + "/?Customers.all", cache: false, isArray: false},
      post: {method: 'POST', url: config.baseUrl + "/?Customers.post", cache: false, isArray: false}
      
    });
  }
]);