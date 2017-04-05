<?php

namespace app\controller;


/**
 * Description of Orders
 *
 * @author thiago
 */
class Orders  extends \app\controller\Controller {
 
  public function post() {
    
    $tab_order = new \app\model\Order();
    $tab_order_dao = new \app\model\OrderDAO();
    $tab_order_detail = new \app\model\OrderDetail();

    $params = $this->request->getAllParams();
    
    $customer = $params['customer'];
    $product = $params['product'];
    $quantity = $params['quantity'];
    $required_date = $params['required_date'];
    $shipped_date = $params['shipped_date'];
    $discount = $params['discount'];
    
    $tab_order_detail->setId_product($product['id']);
    $tab_order_detail->setQuantity($quantity);
    $tab_order_detail->setUnit_price($product['unit_price']);
    $tab_order_detail->setDiscount($discount);
    
    $tab_order->setId_customer($customer['id']);
    $tab_order->setOrder_date(date("Y-m-d H:i:s"));
    $tab_order->setRequired_date($required_date);
    $tab_order->setShipped_date($shipped_date);
    
    $tab_order_dao->beginTransaction();
    
    if (!$this->saveOrderDetail($tab_order_detail)) {
      return $this->responseError();
    }
    
    $id_order_details = $tab_order_detail->getId();
    $tab_order->setId_order_details($id_order_details);
    
    if ($tab_order_dao->insert($tab_order)) {

      $tab_order_dao->commit();
      $success = new \app\view\SuccessView();
      $success->setMessange("Order saved!");
      return $success;
      
    } else {

      $tab_order_dao->rollBack();
      $rs = $tab_order_dao->getResultset();

      $this->string_msg_error = $rs->getError_message();
      return $this->responseError();
      
    }

  }
  
  private function saveOrderDetail(\app\model\OrderDetail $tab_order_detail){
    $tab_order_detail_dao = new \app\model\OrderDetailDAO();

    if (!$tab_order_detail_dao->insert($tab_order_detail)) {
      
      $tab_order_detail_dao->rollBack();
      $rs = $tab_order_detail_dao->getResultset();

      $this->string_msg_error = $rs->getError_message();
      
      return false;
      
    }
    
    return true;
    
  }
  
  public function all() {

    $dao = new \app\model\OrderDAO();
    $orders = $dao->selectAll(100, $dao->getModel());
    
    foreach ($orders as $o){
      $purchase = new \app\model\Purchase($o);
      $this->addResponseContent($purchase, true);
    }

    return $this->getResponse();
    
  }
  
  
}
