app.controller("OrdersCtrl", function ($scope, OrdersAPI, $uibModal) {


  $scope.atualizarLista = function () {
    OrdersAPI.all({}, function (result) {

      if (result.content && result.content.Purchase) {
        for (var i in result.content.Purchase) {
          result.content.Purchase[i].order.order_date = new Date(result.content.Purchase[i].order.order_date);
          result.content.Purchase[i].order.required_date = new Date(result.content.Purchase[i].order.required_date);
          result.content.Purchase[i].order.shipped_date = new Date(result.content.Purchase[i].order.shipped_date);

        }
        $scope.purchases = result.content.Purchase;

      } else {
        $scope.purchases = [];
      }

    });
  }

  $scope.atualizarLista();

  $scope.newOrder = function (_order_) {
    if (!_order_) {
      _order_ = {};
    }
    var modalInstance = $uibModal.open({
      templateUrl: 'partials/modals/order.html',
      controller: 'ModalOrderCtrl',
      scope: $scope,
      resolve: {
        OrderToUpdate: _order_
      }
    });

  }

});


app.controller("OrderDetailCtrl", function ($scope, $stateParams, $uibModal, ProductsAPI, CustomersAPI, OrdersAPI) {

  var order_id = $stateParams.order_id;
  $scope.order_id = order_id;

  function update() {

    OrdersAPI.get({order_id: order_id}, function (result) {

      var _purchase = result.content.Purchase;
      $scope.purchase = _purchase;
      $scope.customer = _purchase.customer;
      
      for (var ia in _purchase.adjustments) {
        _purchase.adjustments[ia].date = new Date(_purchase.adjustments[ia].date);
      }
      
      $scope.adjustments = _purchase.adjustments;
      
      $scope.order = _purchase.order;
      $scope.order.required_date = new Date(_purchase.order.required_date);

      if (_purchase.order.shipped_date) {
        $scope.order.shipped_date = new Date(_purchase.order.shipped_date);
      }

      $scope.order_detail = _purchase.order_detail;

    });

  }

  update();

  $scope.update = update;

  $scope.product_list = new Array();

  ProductsAPI.all(function (result) {

    if (result.content && result.content.Product) {
      $scope.product_list = result.content.Product;
    }

  });

  $scope.addProduct = function (_order_detail_) {

    var modalInstance = $uibModal.open({
      templateUrl: 'partials/modals/product.html',
      controller: 'ModalOrderAddProductCtrl',
      scope: $scope,
      resolve: {
        Order: $scope.order,
        OrderDetail: _order_detail_
      }
    });
  };
  
  $scope.openAdjustment = function () {

    var modalInstance = $uibModal.open({
      templateUrl: 'partials/modals/order_adjustment.html',
      controller: 'ModalOrderAdjustmentCtrl',
      scope: $scope,
      resolve: {
        Order: $scope.order,
        Purchase : $scope.purchase
      }
    });
  };
  
  
  $scope.deleteAdjustment = function(_adjustment_, i){

    OrdersAPI.deleteAdjustment({id : _adjustment_.id}, function(result) {
      if (result.type = "success") {
        $scope.update();
      }
    });
    
  }


  $scope.getProductName = function (id) {
    var _list = $scope.product_list;
    for (var i in _list) {
      var _p = _list[i];
      if (_p.id == id) {
        return _p.name;
      }
    }
    return id;
  }

  $scope.removeProduct = function (_order_detail_) {

    OrdersAPI.deleteDetail({detail_id: _order_detail_.id}, function (_result_) {
      if (_result_.type == "success") {
        update();
      }
    });

  }


});

app.controller("ModalOrderAddProductCtrl", function ($scope, $uibModalInstance, Order, OrderDetail, OrdersAPI) {

console.log(Order);

  Product = {};
  Product.order_id = Order.id;
  $scope.Product = Product;
  
  if (OrderDetail) {  
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

  $scope.save = function (Product) {
console.log(Product);
    OrdersAPI.saveProduct({OrderDetail: Product}, function (result) {

      if (result.type == "error") {
        $scope.message = result.message;
      }


      if (result.type == "success") {
        $scope.$parent.update();
        $scope.close();
      }
    });
  }

});

app.controller("ModalOrderCtrl", function ($scope, $uibModalInstance, CustomersAPI, OrdersAPI, OrderToUpdate) {



  if (OrderToUpdate.id) {
    $scope.Order = OrderToUpdate;
    if ($scope.Order.paid == "1") {
      $scope.Order.paid = true;
    } else {
      $scope.Order.paid = false;
    }
  }

  CustomersAPI.all(function (result) {
    var customers = result.content.Customer;
    $scope.customer_list = customers;

    if (OrderToUpdate.id) {
      for (var i in customers) {
        if (customers[i].id == OrderToUpdate.id_customer) {
          $scope.Order.customer = customers[i];
          break;
        }
      }

    }

  });

  $scope.close = function (p) {
    $uibModalInstance.close();
  }


  $scope.saveOrder = function (Order) {

    OrdersAPI.saveOrder(Order, function (result) {
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
      saveAdjustment: {method: 'POST', url: config.baseUrl + "/?Orders.saveAdjustment", cache: false, isArray: false},
      productsFromOrder: {method: 'GET', url: config.baseUrl + "/?Orders.productsFromOrder", cache: false, isArray: false},
      deleteDetail: {method: 'GET', url: config.baseUrl + "/?Orders.deleteDetail", cache: false, isArray: false},
      deleteAdjustment: {method: 'GET', url: config.baseUrl + "/?Orders.deleteAdjustment", cache: false, isArray: false},
      get: {method: 'GET', url: config.baseUrl + "/?Orders.get", cache: false, isArray: false}

    });
  }
]);


app.controller("ModalOrderAdjustmentCtrl", function($scope, $uibModalInstance, OrdersAPI, Order, Purchase){


  $scope.Adjustment = {};
  $scope.Adjustment.order_id = Order.id;
  $scope.Adjustment.amount = 0;
  $scope.Adjustment.change = true;
  $scope.Adjustment.date = new Date();

  $scope.save = function(_Adjustment){
    OrdersAPI.saveAdjustment(_Adjustment, function(result) {

      if (result.type == "success") {
        $scope.$parent.update();
        $uibModalInstance.close();
      }

    });
    
  }
  
  $scope.close = function(){
    $uibModalInstance.close();
  }
  
  $scope.calculateChange = function(credit){
    if (credit > Purchase.total_order) {
      $scope.Adjustment.change = credit - Purchase.total_order;
    } else {
      $scope.Adjustment.change = 0.0;
    }
  }


});