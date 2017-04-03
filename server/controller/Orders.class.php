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
    $tab_order_detail_dao = new \app\model\OrderDetailDAO();
    
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
    print_r($tab_order);
    $tab_order_dao->beginTransaction();

    if (!$tab_order_detail_dao->insert($tab_order_detail)) {
      
      $tab_order_dao->rollBack();
      $rs = $tab_order_detail_dao->getResultset();
      
      
      $rs_msg = $rs->getError_message();
      
      $message = new \app\view\ErrorView();
      $message->setMessange($rs_msg);
      return $message;

    }
    
    $id_order_details = $tab_order_detail->getId();
    $tab_order->setId_order_details($id_order_details);
    
    if ($tab_order_dao->insert($tab_order)) {

      $tab_order_dao->commit();
      
      echo "ok";
      
    } else {
      
      $tab_order_dao->rollBack();
      $rs = $tab_order_dao->getResultset();
      
      
      $rs_msg = $rs->getError_message();
      
      $message = new \app\view\ErrorView();
      $message->setMessange($rs_msg);
      return $message;
      
    }
    
    
    
    print_r($tab_order_detail);
    //print_r($params);
    
    exit;
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
