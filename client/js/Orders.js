app.controller("OrdersCtrl", function ($scope, OrdersAPI, $uibModal) {


  $scope.atualizarLista = function () {
    OrdersAPI.all({}, function (result) {

      if (result.content && result.content.Purchase) {
        $scope.purchases = result.content.Purchase;
      } else {
        $scope.purchases = [];
      }

    });
  }

  $scope.atualizarLista();
  
  $scope.newOrder = function () {
    var modalInstance = $uibModal.open({
      templateUrl: 'partials/modals/order.html',
      controller: 'ModalOrderCtrl',
      scope: $scope,
      resolve : {
        ProductUpdated : new Object()
      }
    });

  }

});


app.controller("OrderDetailCtrl", function ($scope, $stateParams, $uibModal, ProductsAPI, CustomersAPI, OrdersAPI) {

  var order_id = $stateParams.order_id;
  $scope.order_id = order_id;

  function update() {

    OrdersAPI.get({order_id : order_id}, function(result){

      var _purchase = result.content.Purchase;
      $scope.customer = _purchase.customer;
      $scope.order = _purchase.order;
      $scope.order.required_date = new Date(_purchase.order.required_date);
      $scope.order.shipped_date = new Date(_purchase.order.shipped_date);
      $scope.order_detail = _purchase.order_detail;

    });
    
  }
  
  update();
  
  $scope.update = update;
  
  $scope.product_list = new Array();
  
  ProductsAPI.all(function(result){
    
    if (result.content && result.content.Product) {
      $scope.product_list = result.content.Product;
    }
    
  });
  
  $scope.addProduct = function(_order_detail_){
    
    var modalInstance = $uibModal.open({
      templateUrl: 'partials/modals/product.html',
      controller: 'ModalOrderAddProductCtrl',
      scope : $scope,
      resolve : {
        Order : $scope.order,
        OrderDetail : _order_detail_
      }
    });
  };
  
  
  $scope.getProductName = function(id){
    var _list = $scope.product_list;
    for (var i in _list) {
      var _p = _list[i];
      if (_p.id == id) {
        return _p.name;
      }      
    }
    return id;
  }
  
  $scope.removeProduct = function(_order_detail_) {
    
    OrdersAPI.deleteDetail({detail_id : _order_detail_.id}, function(_result_){      
      if (_result_.type == "success") {
        update();
      }
    });
    
  }
  

});

app.controller("ModalOrderAddProductCtrl", function ($scope, $uibModalInstance, Order, OrderDetail, OrdersAPI) {
  
  
  if (OrderDetail) {
    Product = {};
    Product.id = OrderDetail.id;
    Product.product_id = OrderDetail.id_product;
    Product.discount = OrderDetail.discount;
    Product.quantity = OrderDetail.quantity;
    $scope.Product = Product;
  }
  
  $scope.product_list = $scope.$parent.product_list;

  $scope.close = function (p) {
    $uibModalInstance.close();
  }
  
  function getUnirPrice(product_id){
    
    for (var i in $scope.product_list) {
      var _p = $scope.product_list[i];
      console.log(_p);
      if (_p.id = product_id) {
        return _p.unit_price;
      }
    }
    
  }
  
  $scope.save = function(Product) {
    Product.order_id = Order.id;
    Product.unit_price = getUnirPrice(Product.product_id);
    
    OrdersAPI.saveProduct({OrderDetail: Product}, function(result){
      if (result.type = "success") {
        $scope.$parent.update();
        $scope.close();
      }
    }); 
  }

});

app.controller("ModalOrderCtrl", function ($scope, $uibModalInstance, CustomersAPI, OrdersAPI) {

  CustomersAPI.all(function (result) {
    var customers = result.content.Customer;
    $scope.customer_list = customers;
  });
  
  $scope.close = function (p) {
    $uibModalInstance.close();
  }
  
  
  $scope.saveOrder = function(Order){
    
    OrdersAPI.saveOrder(Order, function(result){
      if (result.content && result.content.Order) {
        $scope.$parent.atualizarLista();
        $scope.close();
      }
    });
  }

});

app.factory('OrdersAPI', ['$resource', 'config', function ($resource, config) {
    return $resource(config.baseUrl, {}, {
      all: {method: 'GET', url: config.baseUrl + "/?Orders.all", cache: false, isArray: false},
      post: {method: 'POST', url: config.baseUrl + "/?Orders.post", cache: false, isArray: false},
      saveOrder: {method: 'POST', url: config.baseUrl + "/?Orders.saveOrder", cache: false, isArray: false},
      saveProduct: {method: 'POST', url: config.baseUrl + "/?Orders.saveProduct", cache: false, isArray: false},
      productsFromOrder: {method: 'GET', url: config.baseUrl + "/?Orders.productsFromOrder", cache: false, isArray: false},
      deleteDetail: {method: 'GET', url: config.baseUrl + "/?Orders.deleteDetail", cache: false, isArray: false},
      get: {method: 'GET', url: config.baseUrl + "/?Orders.get", cache: false, isArray: false}

    });
  }
]);