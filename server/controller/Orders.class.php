<?php

namespace app\controller;

/**
 * Description of Orders
 *
 * @author thiago
 */
class Orders extends \app\controller\Controller {



  public function post() {
    
  }

  public function all() {

    $dao = new \app\model\OrderDAO();
    $orders = $dao->selectAll(100, $dao->getModel());

    foreach ($orders as $o) {
      $purchase = new \app\model\Purchase($o);
      $this->addResponseContent($purchase, true);
    }

    return $this->getResponse();
  }

  public function get() {

    $order_id = $this->request->getParams("order_id");
    $data_model = new \app\model\Order();
    $data_model->setId($order_id);

    $purchase = new \app\model\Purchase($data_model);

    $this->addResponseContent($purchase);

    return $this->getResponse();
  }

  
  public function saveOrder(){
    
    $id = $this->request->getParams("id");
    $customer = $this->request->getParams("customer");
    $paid = $this->request->getParams("paid");
    $required_date = $this->request->getParams("required_date");
    $shipped_date = $this->request->getParams("shipped_date");
    
    if (is_null($required_date)) {
      $required_date = date("Y-m-d H:i:s");
    }
    
    $order_dao = new \app\model\OrderDAO();
    $order = new \app\model\Order();
    
    $order->setId($id);
    $order->setId_customer($customer['id']);
    $order->setRequired_date($this->formatDate($required_date, "Y-m-d H:i:s"));
    $order->setShipped_date($this->formatDate($shipped_date, "Y-m-d H:i:s"));
    $order->setPaid($paid);
    $order->setOrder_date(date("Y-m-d H:i:s"));

    if (!is_null($id)) {
      $criteria = array('id' => $id);
      $saved = $order_dao->update($order, $criteria);
    } else {
      $saved = $order_dao->insert($order);
    }
    
    if ($saved) {
      $this->addResponseContent($order);
      return $this->getResponse();
    } else {
      $rs = $order_dao->getResultset();
      $error_msg = $rs->getError_message();
      
      $error = new \app\view\ErrorView();
      $error->setMessange("Failed to save the order! " . $error_msg);
      return $error;
    }
    
  }
  
  
  public function saveProduct(){
    
    $order_detail = new \app\model\OrderDetail();
    $order_detail_dao = new \app\model\OrderDetailDAO();
    $param_order_detail = $this->request->getParams("OrderDetail");
    
    if (isset($param_order_detail['id'])) {
      $id = $param_order_detail['id'];  
    } else {
      $id= null;
    }
    
    $discount = $param_order_detail['discount'];
    $quantity = $param_order_detail['quantity'];
    $product_id = $param_order_detail['product_id'];
    $order_id = $param_order_detail['order_id'];
    $unit_price = $param_order_detail['unit_price'];
    
    
    $order_detail->setDiscount($discount);
    $order_detail->setQuantity($quantity);
    $order_detail->setId_product($product_id);
    $order_detail->setId_orders($order_id);
    $order_detail->setUnit_price($unit_price);
    
    if (!is_null($id)) {
      $criteria = array('id' => $id);
      $order_detail->setId($id);
      $saved = $order_detail_dao->update($order_detail, $criteria);
    } else {
      $saved = $order_detail_dao->insert($order_detail);
    }
    
    if (!$saved) {
      $rs = $order_detail_dao->getResultset();
      $msg = $rs->getError_message();
      $error = new \app\view\ErrorView();
      $error->setMessange("Failed " . $error);
    } else {
      $success = new \app\view\SuccessView();
      $success->setMessange("Product inserted.");
      return $success;
    }

  }
  
  public function deleteDetail() {
    
    $detail_id = $this->request->getParams("detail_id");
    $detail_dao = new \app\model\OrderDetailDAO();
    $order = $detail_dao->getModel();
    $order->setId($detail_id);
    $found = $detail_dao->select($order);
    
    $deleted = false;
    
    if (isset($found[0])) {
      $order = $found[0];
      $deleted = $detail_dao->delete($order);
    }
    
    if (!$deleted) {
      $rs = $order_detail_dao->getResultset();
      $msg = $rs->getError_message();
      $error = new \app\view\ErrorView();
      $error->setMessange("Failed " . $error);
    } else {
      $success = new \app\view\SuccessView();
      $success->setMessange("Product deleted.");
      return $success;
    }
    
    
  }
  
  public function productsFromOrder(){
    
    $id_order = $this->request->getParams("order_id");
    
    $product_dao = new \app\model\ProductsDAO();
    $products = $product_dao->findByOrderId($id_order);
    
    foreach ($products as $p) {
      $this->addResponseContent($p, true);
    }

    return $this->getResponse();

  }
  
}
